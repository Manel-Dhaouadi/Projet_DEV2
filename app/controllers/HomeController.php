<?php
require_once "../app/core/Controller.php";
require_once "../app/models/Job.php";

class HomeController extends Controller {
    
    private $jobModel;

    public function __construct() {
        $this->jobModel = new Job();
    }

    public function index() {
        $data = [
            'metaDescription' => 'Trouvez votre prochain emploi, stage ou alternance en Tunisie',
            'stats' => $this->getStats(),
            'featuredJobs' => $this->jobModel->getFeatured(3),
            'recentJobs' => $this->jobModel->getRecent(6),
            'pageTitle' => 'Accueil - Projet_DEV2'
        ];

        $this->view("home", $data);
    }

    private function getStats() {
        return [
            'jobs' => $this->jobModel->count() ?: 1500,
            'companies' => $this->jobModel->countCompanies() ?: 2500,
            'candidates' => $this->jobModel->countCandidates() ?: 10000,
            'satisfaction' => 98
        ];
    }
}