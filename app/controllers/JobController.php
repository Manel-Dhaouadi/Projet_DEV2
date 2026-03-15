<?php
require_once "../app/core/Controller.php";
require_once "../app/models/Job.php";
require_once "../app/models/User.php";

class JobController extends Controller {
    
    private $jobModel;

    public function __construct() {
        $this->jobModel = new Job();
    }

    public function index() {
        $filters = [
            'keyword' => $_GET['keyword'] ?? '',
            'type' => $_GET['type'] ?? '',
            'city' => $_GET['city'] ?? ''
        ];

        // Récupérer TOUTES les offres avec les filtres (sans pagination)
        $jobs = $this->jobModel->getAllJobsFiltered($filters);
        
        $data = [
            'jobs' => $jobs,
            'filters' => $filters,
            'totalJobs' => count($jobs)
        ];

        $this->view('jobs/index', $data);
    }

    public function create() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'recruiter') {
            $_SESSION['error'] = "Accès non autorisé";
            header("Location: index.php?action=login");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'recruiter_id' => $_SESSION['user']['id'],
                'title' => $_POST['title'] ?? '',
                'description' => $_POST['description'] ?? '',
                'type' => $_POST['type'] ?? '',
                'city' => $_POST['city'] ?? '',
                'deadline' => $_POST['deadline'] ?? '',
                'salary' => $_POST['salary'] ?? '',
                'featured' => 0,
                'created_at' => date('Y-m-d H:i:s')
            ];

            if ($this->jobModel->create($data)) {
                $_SESSION['success'] = 'Offre publiée avec succès';
                header("Location: index.php?action=dashboard");
                exit;
            } else {
                $_SESSION['error'] = 'Erreur lors de la publication';
            }
        }

        $this->view('jobs/create');
    }

public function edit() {
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'recruiter') {
        $_SESSION['error'] = "Accès non autorisé";
        header("Location: index.php?action=login");
        exit;
    }

    $id = $_GET['id'] ?? 0;
    $job = $this->jobModel->find($id);

    if (!$job || $job['recruiter_id'] != $_SESSION['user']['id']) {
        $_SESSION['error'] = 'Offre non trouvée';
        header("Location: index.php?action=dashboard");
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = [
            'title' => $_POST['title'] ?? '',
            'description' => $_POST['description'] ?? '',
            'type' => $_POST['type'] ?? '',
            'city' => $_POST['city'] ?? '',
            'deadline' => $_POST['deadline'] ?? '',
            'salary' => $_POST['salary'] ?? '',
            'featured' => isset($_POST['featured']) ? 1 : 0  // Ajout de featured
        ];

        if ($this->jobModel->update($id, $data)) {
            $_SESSION['success'] = 'Offre modifiée avec succès';
            header("Location: index.php?action=dashboard");
            exit;
        } else {
            $_SESSION['error'] = 'Erreur lors de la modification';
        }
    }

    $data = [
        'job' => $job
    ];

    $this->view('jobs/edit', $data);
}

    public function delete() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'recruiter') {
            $_SESSION['error'] = "Accès non autorisé";
            header("Location: index.php?action=login");
            exit;
        }

        $id = $_GET['id'] ?? 0;
        $job = $this->jobModel->find($id);

        if ($job && $job['recruiter_id'] == $_SESSION['user']['id']) {
            $this->jobModel->delete($id);
            $_SESSION['success'] = 'Offre supprimée';
        }

        header("Location: index.php?action=dashboard");
        exit;
    }

    public function show() {
        $id = $_GET['id'] ?? 0;
        $job = $this->jobModel->find($id);

        if (!$job) {
            $_SESSION['error'] = 'Offre non trouvée';
            header("Location: index.php?action=jobs");
            exit;
        }

        $userModel = new User();
        $company = $userModel->find($job['recruiter_id']);

        $data = [
            'job' => $job,
            'company' => $company
        ];

        $this->view('jobs/show', $data);
    }
}