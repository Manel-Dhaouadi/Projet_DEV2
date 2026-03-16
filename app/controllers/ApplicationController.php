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
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?action=login");
            exit;
        }
        
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
        
        $jobModel = new Job();
        $job = $jobModel->find($job_id);
        
        if (!$job) {
            $_SESSION['error'] = "Offre non trouvée";
            header("Location: index.php?action=jobs");
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $cv_content = "";
            $cv_type = "text";
            
            if (!empty($_POST['cv_link'])) {
                $cv_content = $_POST['cv_link'];
                $cv_type = "url";
            }
            
            if (isset($_FILES['cv_file']) && $_FILES['cv_file']['error'] === UPLOAD_ERR_OK) {
                $file = $_FILES['cv_file'];
                
                $fileType = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                if ($fileType != 'pdf') {
                    $_SESSION['error'] = "Seuls les fichiers PDF sont acceptés";
                    header("Location: index.php?action=apply&job_id=" . $job_id);
                    exit;
                }
                
                if ($file['size'] > 5 * 1024 * 1024) {
                    $_SESSION['error'] = "Le fichier ne doit pas dépasser 5 Mo";
                    header("Location: index.php?action=apply&job_id=" . $job_id);
                    exit;
                }
                
                $cv_content = file_get_contents($file['tmp_name']);
                
                if (substr($cv_content, 0, 4) !== '%PDF') {
                    $_SESSION['error'] = "Le fichier n'est pas un PDF valide";
                    header("Location: index.php?action=apply&job_id=" . $job_id);
                    exit;
                }
                
                $cv_content = base64_encode($cv_content);
                $cv_type = "pdf";
            }
            
            if (empty($cv_content)) {
                $_SESSION['error'] = "Veuillez fournir votre CV (lien ou fichier)";
                header("Location: index.php?action=apply&job_id=" . $job_id);
                exit;
            }
            
            $result = $this->applicationModel->apply($job_id, $_SESSION['user']['id'], $cv_content, $cv_type);
            
            if ($result) {
                $_SESSION['success'] = "✅ Candidature envoyée avec succès !";
                header("Location: index.php?action=dashboard");
                exit;
            } else {
                $_SESSION['error'] = "❌ Erreur lors de l'envoi de la candidature";
                header("Location: index.php?action=apply&job_id=" . $job_id);
                exit;
            }
        }
        
        $data = [
            'job' => $job
        ];
        
        $this->view('applications/apply', $data);
    }
    
    /**
     * Télécharger le CV d'un candidat
     */
    public function downloadUltraSimple() {
        $id = $_GET['id'] ?? 0;
        
        if (!$id) {
            $_SESSION['error'] = "ID de candidature manquant";
            header("Location: index.php?action=dashboard");
            exit;
        }
        
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'recruiter') {
            header("Location: index.php?action=login");
            exit;
        }
        
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
        
        if ($application['recruiter_id'] != $_SESSION['user']['id']) {
            $_SESSION['error'] = "Accès non autorisé";
            header("Location: index.php?action=dashboard");
            exit;
        }
        
        $pdf_content = base64_decode($application['cv']);
        
        $temp_dir = __DIR__ . '/../../public/temp/';
        if (!file_exists($temp_dir)) {
            mkdir($temp_dir, 0777, true);
        }
        
        $candidate_name = preg_replace('/[^a-zA-Z0-9]/', '_', $application['candidate_name'] ?? 'candidat');
        $temp_file = $temp_dir . 'cv_' . $id . '_' . $candidate_name . '.pdf';
        file_put_contents($temp_file, $pdf_content);
        
        $file_url = '/Projet_DEV2/public/temp/cv_' . $id . '_' . $candidate_name . '.pdf';
        header("Location: " . $file_url);
        exit;
    }

    /**
     * Affiche les candidatures pour une offre (pour le recruteur)
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
     * Affiche toutes les candidatures du candidat connecté
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
     * Mettre à jour le statut d'une candidature
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
            $_SESSION['success'] = "✅ Statut mis à jour avec succès";
        }
        
        header("Location: index.php?action=applications&job_id=" . $job_id);
        exit;
    }
    
    /**
     * Supprimer une candidature (pour le recruteur) - RESTE SUR LA MÊME PAGE
     */
    public function delete() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'recruiter') {
            header("Location: index.php?action=login");
            exit;
        }
        
        $id = $_GET['id'] ?? 0;
        $from = $_GET['from'] ?? 'dashboard'; 
        
        if (!$id) {
            $_SESSION['error'] = "ID de candidature manquant";
            header("Location: index.php?action=dashboard");
            exit;
        }
        
        // Récupérer l'ID de l'offre pour la redirection
        $conn = $this->applicationModel->getConnection();
        $sql = "SELECT a.*, j.recruiter_id, a.job_id 
                FROM applications a 
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
        
        // Vérifier que le recruteur a le droit de supprimer cette candidature
        if ($application['recruiter_id'] != $_SESSION['user']['id']) {
            $_SESSION['error'] = "Vous n'êtes pas autorisé à supprimer cette candidature";
            header("Location: index.php?action=dashboard");
            exit;
        }
        
        $job_id = $application['job_id'];
        
        // Supprimer la candidature
        $sql = "DELETE FROM applications WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute([$id]);
        
        if ($result) {
            $_SESSION['success'] = "✅ Candidature supprimée avec succès";
        } else {
            $_SESSION['error'] = "❌ Erreur lors de la suppression";
        }
        
        // Redirection selon la provenance - RESTE SUR LA MÊME PAGE
        if ($from === 'applications') {
            header("Location: index.php?action=applications&job_id=" . $job_id);
        } else {
            header("Location: index.php?action=dashboard");
        }
        exit;
    }
    
    /**
     * Afficher les détails d'une candidature
     */
    public function viewApplication() {
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