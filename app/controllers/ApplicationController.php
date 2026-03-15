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
     * Affiche les candidatures pour une offre (pour le recruteur)
     */
    public function index() {
        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?action=login");
            exit;
        }
        
        // Récupérer l'ID de l'offre
        $job_id = $_GET['job_id'] ?? 0;
        
        if (!$job_id) {
            $_SESSION['error'] = "ID d'offre manquant";
            header("Location: index.php?action=dashboard");
            exit;
        }
        
        // Vérifier que l'offre appartient bien au recruteur connecté
        $jobModel = new Job();
        $job = $jobModel->find($job_id);
        
        if (!$job || $job['recruiter_id'] != $_SESSION['user']['id']) {
            $_SESSION['error'] = "Accès non autorisé à ces candidatures";
            header("Location: index.php?action=dashboard");
            exit;
        }
        
        // Récupérer les candidatures pour cette offre - CORRECTION ICI
        $applications = $this->applicationModel->getJobApplications($job_id);
        
        $data = [
            'job' => $job,
            'applications' => $applications
        ];
        
        $this->view('applications/index', $data);
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
        
        $job_id = $_GET['job_id'] ?? 0;
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cv = $_POST['cv'] ?? '';
            
            if ($this->applicationModel->apply($job_id, $_SESSION['user']['id'], $cv)) {
                $_SESSION['success'] = "Candidature envoyée avec succès";
            } else {
                $_SESSION['error'] = "Erreur lors de l'envoi de la candidature";
            }
            
            header("Location: index.php?action=job&id=" . $job_id);
            exit;
        }
        
        // Afficher le formulaire de candidature
        $jobModel = new Job();
        $job = $jobModel->find($job_id);
        
        $data = [
            'job' => $job
        ];
        
        $this->view('applications/apply', $data);
    }
    
    /**
     * Mes candidatures (pour le candidat)
     */
    public function myApplications() {
        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?action=login");
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
        // Vérifier si l'utilisateur est connecté et est recruteur
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'recruiter') {
            header("Location: index.php?action=login");
            exit;
        }
        
        $id = $_GET['id'] ?? 0;
        $status = $_GET['status'] ?? '';
        $job_id = $_GET['job_id'] ?? 0;
        
        if ($id && $status) {
            $this->applicationModel->updateStatus($id, $status);
            $_SESSION['success'] = "Statut mis à jour";
        }
        
        header("Location: index.php?action=applications&job_id=" . $job_id);
        exit;
    }
}