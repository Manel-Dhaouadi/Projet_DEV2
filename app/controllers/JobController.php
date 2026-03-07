<?php
require_once "../app/core/Controller.php";
require_once "../app/models/Job.php";
require_once "../app/models/Category.php";
require_once "../app/models/User.php";

class JobController extends Controller {
    
    private $jobModel;
    private $categoryModel;

    public function __construct() {
        $this->jobModel = new Job();
        $this->categoryModel = new Category();
    }

    public function index() {
        $filters = [
            'keyword' => $_GET['keyword'] ?? '',
            'type' => $_GET['type'] ?? '',
            'city' => $_GET['city'] ?? '',
            'category' => $_GET['category'] ?? ''
        ];

        $jobs = $this->jobModel->search($filters);
        
        $data = [
            'jobs' => $jobs,
            'categories' => $this->categoryModel->getAllWithCount(),
            'filters' => $filters,
            'totalJobs' => count($jobs)
        ];

        $this->view('jobs/index', $data);
    }

    public function create() {
        // Vérifier si l'utilisateur est connecté et est recruteur
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
                'category_id' => $_POST['category_id'] ?? null,
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

        $data = [
            'categories' => $this->categoryModel->getCategories()
        ];

        $this->view('jobs/create', $data);
    }

    public function edit() {
        // Vérifier si l'utilisateur est connecté et est recruteur
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
                'category_id' => $_POST['category_id'] ?? null
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
            'job' => $job,
            'categories' => $this->categoryModel->getCategories()
        ];

        $this->view('jobs/edit', $data);
    }

    public function delete() {
        // Vérifier si l'utilisateur est connecté et est recruteur
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
        
        $category = null;
        if (!empty($job['category_id'])) {
            $category = $this->categoryModel->find($job['category_id']);
        }

        $data = [
            'job' => $job,
            'company' => $company,
            'category' => $category
        ];

        $this->view('jobs/show', $data);
    }
}