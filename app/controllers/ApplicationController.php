<?php
require_once "../app/core/Controller.php";
require_once "../app/models/Application.php";
require_once "../app/models/Job.php";

class ApplicationController extends Controller {
    
    private $applicationModel;
    
    public function __construct() {
        $this->applicationModel = new Application();
    }
    
    /**
     * Postuler à une offre (pour le candidat)
     */
    public function apply() {
        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?action=login");
            exit;
        }
        
        // Vérifier que c'est bien un candidat
        if ($_SESSION['user']['role'] !== 'candidate') {
            $_SESSION['error'] = "Seuls les candidats peuvent postuler";
            header("Location: index.php?action=jobs");
            exit;
        }
        
        $job_id = $_GET['job_id'] ?? 0;
        
        if ($job_id == 0) {
            $_SESSION['error'] = "ID d'offre invalide";
            header("Location: index.php?action=jobs");
            exit;
        }
        
        // Vérifier que l'offre existe
        $jobModel = new Job();
        $job = $jobModel->find($job_id);
        
        if (!$job) {
            $_SESSION['error'] = "Offre non trouvée";
            header("Location: index.php?action=jobs");
            exit;
        }
        
        // Traitement du formulaire
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $cv_content = "";
            $cv_type = "text";
            
            // OPTION 1: Lien texte
            if (!empty($_POST['cv_link'])) {
                $cv_content = $_POST['cv_link'];
                $cv_type = "url";
            }
            
            // OPTION 2: Upload de fichier
            if (isset($_FILES['cv_file']) && $_FILES['cv_file']['error'] === UPLOAD_ERR_OK) {
                $file = $_FILES['cv_file'];
                
                // Vérifier l'extension
                $fileType = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                if ($fileType != 'pdf') {
                    $_SESSION['error'] = "Seuls les fichiers PDF sont acceptés";
                    header("Location: index.php?action=apply&job_id=" . $job_id);
                    exit;
                }
                
                // Vérifier la taille
                if ($file['size'] > 5 * 1024 * 1024) {
                    $_SESSION['error'] = "Le fichier ne doit pas dépasser 5 Mo";
                    header("Location: index.php?action=apply&job_id=" . $job_id);
                    exit;
                }
                
                // Lire le contenu
                $cv_content = file_get_contents($file['tmp_name']);
                
                // Vérifier la signature PDF
                if (substr($cv_content, 0, 4) !== '%PDF') {
                    $_SESSION['error'] = "Le fichier n'est pas un PDF valide";
                    header("Location: index.php?action=apply&job_id=" . $job_id);
                    exit;
                }
                
                // Encoder en base64
                $cv_content = base64_encode($cv_content);
                $cv_type = "pdf";
            }
            
            // Vérifier qu'un CV a été fourni
            if (empty($cv_content)) {
                $_SESSION['error'] = "Veuillez fournir votre CV (lien ou fichier)";
                header("Location: index.php?action=apply&job_id=" . $job_id);
                exit;
            }
            
            // Vérifier les doublons
            $existingApplications = $this->applicationModel->getApplicationsByCandidate($_SESSION['user']['id']);
            foreach ($existingApplications as $app) {
                if ($app['job_id'] == $job_id) {
                    $_SESSION['error'] = "Vous avez déjà postulé à cette offre";
                    header("Location: index.php?action=job&id=" . $job_id);
                    exit;
                }
            }
            
            // Enregistrer
            $result = $this->applicationModel->apply($job_id, $_SESSION['user']['id'], $cv_content, $cv_type);
            
            if ($result) {
                $_SESSION['success'] = "✅ Candidature envoyée avec succès !";
                header("Location: index.php?action=dashboard");
                exit;
            } else {
                $_SESSION['error'] = "❌ Erreur lors de l'envoi";
                header("Location: index.php?action=apply&job_id=" . $job_id);
                exit;
            }
        }
        
        // Afficher le formulaire
        $data = [
            'job' => $job
        ];
        
        $this->view('applications/apply', $data);
    }
    
    /**
     * Télécharger le CV
     */
    public function downloadUltraSimple() {
        // Vérifier les droits
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'recruiter') {
            header("Location: index.php?action=login");
            exit;
        }
        
        $id = $_GET['id'] ?? 0;
        
        if (!$id) {
            $_SESSION['error'] = "ID de candidature manquant";
            header("Location: index.php?action=dashboard");
            exit;
        }
        
        // Récupérer la candidature
        $conn = $this->applicationModel->getConnection();
        $sql = "SELECT a.*, j.recruiter_id, u.name as candidate_name 
                FROM applications a 
                JOIN jobs j ON a.job_id = j.id 
                JOIN users u ON a.user_id = u.id 
                WHERE a.id = ?";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id]);
        $application = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$application) {
            $_SESSION['error'] = "Candidature non trouvée";
            header("Location: index.php?action=dashboard");
            exit;
        }
        
        // Vérifier que le recruteur a le droit
        if ($application['recruiter_id'] != $_SESSION['user']['id']) {
            $_SESSION['error'] = "Accès non autorisé";
            header("Location: index.php?action=dashboard");
            exit;
        }
        
        // Vérifier le type
        if ($application['cv_type'] === 'pdf') {
            // Décoder le PDF
            $pdf_content = base64_decode($application['cv']);
            
            // Nettoyer les buffers
            while (ob_get_level()) {
                ob_end_clean();
            }
            
            // Envoyer le PDF
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="CV_' . $application['id'] . '.pdf"');
            header('Content-Length: ' . strlen($pdf_content));
            
            echo $pdf_content;
            exit;
        } elseif ($application['cv_type'] === 'url') {
            // Rediriger vers l'URL
            header("Location: " . $application['cv']);
            exit;
        } else {
            // Texte simple
            header('Content-Type: text/plain; charset=utf-8');
            header('Content-Disposition: attachment; filename="CV_' . $application['id'] . '.txt"');
            echo $application['cv'];
            exit;
        }
    }

    /**
     * Affiche les candidatures pour une offre (recruteur)
     */
    public function index() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'recruiter') {
            header("Location: index.php?action=login");
            exit;
        }
        
        $job_id = $_GET['job_id'] ?? 0;
        
        if (!$job_id) {
            $_SESSION['error'] = "ID d'offre manquant";
            header("Location: index.php?action=dashboard");
            exit;
        }
        
        $jobModel = new Job();
        $job = $jobModel->find($job_id);
        
        if (!$job || $job['recruiter_id'] != $_SESSION['user']['id']) {
            $_SESSION['error'] = "Accès non autorisé";
            header("Location: index.php?action=dashboard");
            exit;
        }
        
        $applications = $this->applicationModel->getJobApplications($job_id);
        
        $data = [
            'job' => $job,
            'applications' => $applications
        ];
        
        $this->view('applications/index', $data);
    }
    
    /**
     * Mes candidatures (candidat)
     */
    public function myApplications() {
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?action=login");
            exit;
        }
        
        if ($_SESSION['user']['role'] !== 'candidate') {
            $_SESSION['error'] = "Accès non autorisé";
            header("Location: index.php?action=dashboard");
            exit;
        }
        
        $applications = $this->applicationModel->getApplicationsByCandidate($_SESSION['user']['id']);
        
        $data = [
            'apps' => $applications
        ];
        
        $this->view('applications/myApplications', $data);
    }
    
    /**
     * Mettre à jour le statut
     */
    public function updateStatus() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'recruiter') {
            header("Location: index.php?action=login");
            exit;
        }
        
        $id = $_GET['id'] ?? 0;
        $status = $_GET['status'] ?? '';
        $job_id = $_GET['job_id'] ?? 0;
        
        if ($id && in_array($status, ['accepted', 'rejected'])) {
            $this->applicationModel->updateStatus($id, $status);
            $_SESSION['success'] = "✅ Statut mis à jour";
        }
        
        header("Location: index.php?action=applications&job_id=" . $job_id);
        exit;
    }
    
    /**
     * Supprimer une candidature
     */
    public function delete() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'recruiter') {
            header("Location: index.php?action=login");
            exit;
        }
        
        $id = $_GET['id'] ?? 0;
        $from = $_GET['from'] ?? 'dashboard';
        
        if (!$id) {
            $_SESSION['error'] = "ID manquant";
            header("Location: index.php?action=dashboard");
            exit;
        }
        
        $conn = $this->applicationModel->getConnection();
        $sql = "SELECT a.*, j.recruiter_id, a.job_id FROM applications a JOIN jobs j ON a.job_id = j.id WHERE a.id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id]);
        $application = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$application || $application['recruiter_id'] != $_SESSION['user']['id']) {
            $_SESSION['error'] = "Non autorisé";
            header("Location: index.php?action=dashboard");
            exit;
        }
        
        $sql = "DELETE FROM applications WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id]);
        
        $_SESSION['success'] = "✅ Candidature supprimée";
        
        if ($from === 'applications') {
            header("Location: index.php?action=applications&job_id=" . $application['job_id']);
        } else {
            header("Location: index.php?action=dashboard");
        }
        exit;
    }
    
    /**
     * Voir les détails d'une candidature
     */
    public function viewApplication() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'recruiter') {
            header("Location: index.php?action=login");
            exit;
        }
        
        $id = $_GET['id'] ?? 0;
        
        if (!$id) {
            $_SESSION['error'] = "ID manquant";
            header("Location: index.php?action=dashboard");
            exit;
        }
        
        $conn = $this->applicationModel->getConnection();
        $sql = "SELECT a.*, 
                       u.name as candidate_name, 
                       u.email, 
                       u.phone,
                       j.title as job_title,
                       j.id as job_id,
                       j.recruiter_id
                FROM applications a 
                JOIN users u ON a.user_id = u.id 
                JOIN jobs j ON a.job_id = j.id 
                WHERE a.id = ?";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id]);
        $application = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$application) {
            $_SESSION['error'] = "Candidature non trouvée";
            header("Location: index.php?action=dashboard");
            exit;
        }
        
        if ($application['recruiter_id'] != $_SESSION['user']['id']) {
            $_SESSION['error'] = "Accès non autorisé";
            header("Location: index.php?action=dashboard");
            exit;
        }
        
        $data = [
            'application' => $application
        ];
        
        $this->view('applications/view', $data);
    }
}