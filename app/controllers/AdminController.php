<?php
require_once "../app/core/Controller.php";
require_once "../app/models/User.php";
require_once "../app/models/Job.php";

class AdminController extends Controller {

    public function __construct() {
        // Vérifier si l'utilisateur est admin
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header("Location: index.php?action=login");
            exit;
        }
    }

    // ========== PAGE ADMIN SIMPLE ==========
    public function index() {
        $userModel = new User();
        $jobModel = new Job();
        
        $data = [
            'users' => $userModel->getAllUsers(),
            'jobs' => $jobModel->getAllJobs(),
            'stats' => [
                'totalUsers' => $userModel->countUsers(),
                'totalRecruiters' => $userModel->countByRole('recruiter'),
                'totalCandidates' => $userModel->countByRole('candidate'),
                'totalJobs' => $jobModel->count()
            ]
        ];
        
        $this->view("admin/index", $data);
    }

    // ========== DASHBOARD ADMIN COMPLET ==========
    public function dashboard() {
        $userModel = new User();
        $jobModel = new Job();
        
        $data = [
            'users' => $userModel->getAllUsers(),
            'jobs' => $jobModel->getAllJobs(),
            'stats' => [
                'totalUsers' => $userModel->countUsers(),
                'totalRecruiters' => $userModel->countByRole('recruiter'),
                'totalCandidates' => $userModel->countByRole('candidate'),
                'totalJobs' => $jobModel->count()
            ]
        ];
        
        $this->view("dashboard/admin", $data);
    }

    // ========== AJOUTER UN UTILISATEUR ==========
    public function addUser() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userModel = new User();
            
            // Vérifier si l'email existe déjà
            $existingUser = $userModel->findByEmail($_POST['email'] ?? '');
            if ($existingUser) {
                $_SESSION['error'] = "Cet email est déjà utilisé";
                header("Location: index.php?action=admin-add-user");
                exit;
            }
            
            $data = [
                'name' => $_POST['name'] ?? '',
                'email' => $_POST['email'] ?? '',
                'password' => password_hash($_POST['password'] ?? '123456', PASSWORD_DEFAULT),
                'role' => $_POST['role'] ?? 'candidate',
                'city' => $_POST['city'] ?? '',
                'phone' => $_POST['phone'] ?? ''
            ];

            if ($userModel->create($data)) {
                $_SESSION['success'] = "Utilisateur ajouté avec succès";
            } else {
                $_SESSION['error'] = "Erreur lors de l'ajout";
            }
            
            header("Location: index.php?action=admin-dashboard");
            exit;
        }
        
        $this->view("admin/add-user");
    }

    // ========== MODIFIER UN UTILISATEUR ==========
    public function editUser() {
        $id = $_GET['id'] ?? 0;
        $userModel = new User();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'] ?? '',
                'email' => $_POST['email'] ?? '',
                'role' => $_POST['role'] ?? '',
                'city' => $_POST['city'] ?? '',
                'phone' => $_POST['phone'] ?? ''
            ];

            // Vérifier si l'email existe déjà (sauf pour l'utilisateur actuel)
            $existingUser = $userModel->findByEmail($data['email']);
            if ($existingUser && $existingUser['id'] != $id) {
                $_SESSION['error'] = "Cet email est déjà utilisé par un autre utilisateur";
                header("Location: index.php?action=admin-edit-user&id=$id");
                exit;
            }

            // Ne pas modifier le rôle de l'admin connecté
            if ($id == $_SESSION['user']['id'] && $data['role'] !== $_SESSION['user']['role']) {
                $_SESSION['error'] = "Vous ne pouvez pas changer votre propre rôle";
            } else {
                if ($userModel->update($id, $data)) {
                    $_SESSION['success'] = "Utilisateur modifié avec succès";
                    
                    // Si l'utilisateur modifié est celui connecté, mettre à jour la session
                    if ($id == $_SESSION['user']['id']) {
                        $updatedUser = $userModel->find($id);
                        $_SESSION['user'] = $updatedUser;
                    }
                } else {
                    $_SESSION['error'] = "Erreur lors de la modification";
                }
            }
            
            header("Location: index.php?action=admin-dashboard");
            exit;
        }
        
        $user = $userModel->find($id);
        if (!$user) {
            $_SESSION['error'] = "Utilisateur non trouvé";
            header("Location: index.php?action=admin-dashboard");
            exit;
        }
        
        $this->view("admin/edit-user", ['user' => $user]);
    }

    // ========== AJOUTER UNE OFFRE ==========
    public function addJob() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $jobModel = new Job();
            
            $data = [
                'recruiter_id' => $_POST['recruiter_id'] ?? null,
                'title' => $_POST['title'] ?? '',
                'description' => $_POST['description'] ?? '',
                'type' => $_POST['type'] ?? '',
                'city' => $_POST['city'] ?? '',
                'deadline' => $_POST['deadline'] ?? '',
                'salary' => $_POST['salary'] ?? '',
                'featured' => isset($_POST['featured']) ? 1 : 0,
                'created_at' => date('Y-m-d H:i:s')
            ];

            if ($jobModel->create($data)) {
                $_SESSION['success'] = "Offre ajoutée avec succès";
            } else {
                $_SESSION['error'] = "Erreur lors de l'ajout de l'offre";
            }
            
            header("Location: index.php?action=admin-dashboard");
            exit;
        }
        
        // Récupérer la liste des recruteurs pour le formulaire
        $userModel = new User();
        $recruiters = $userModel->getRecruiters();
        
        $this->view("admin/add-job", ['recruiters' => $recruiters]);
    }

    // ========== MODIFIER UNE OFFRE ==========
    public function editJob() {
        $id = $_GET['id'] ?? 0;
        $jobModel = new Job();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'title' => $_POST['title'] ?? '',
                'description' => $_POST['description'] ?? '',
                'type' => $_POST['type'] ?? '',
                'city' => $_POST['city'] ?? '',
                'deadline' => $_POST['deadline'] ?? '',
                'salary' => $_POST['salary'] ?? '',
                'featured' => isset($_POST['featured']) ? 1 : 0
            ];

            if ($jobModel->update($id, $data)) {
                $_SESSION['success'] = "Offre modifiée avec succès";
            } else {
                $_SESSION['error'] = "Erreur lors de la modification";
            }
            
            header("Location: index.php?action=admin-dashboard");
            exit;
        }
        
        $job = $jobModel->find($id);
        if (!$job) {
            $_SESSION['error'] = "Offre non trouvée";
            header("Location: index.php?action=admin-dashboard");
            exit;
        }
        
        $this->view("admin/edit-job", ['job' => $job]);
    }

    // ========== SUPPRIMER UN UTILISATEUR ==========
    public function deleteUser() {
        $id = $_GET['id'] ?? 0;
        $userModel = new User();
        
        // Empêcher l'admin de se supprimer lui-même
        if ($id == $_SESSION['user']['id']) {
            $_SESSION['error'] = "Vous ne pouvez pas supprimer votre propre compte";
        } else {
            $user = $userModel->find($id);
            if ($user) {
                $userModel->delete($id);
                $_SESSION['success'] = "Utilisateur supprimé avec succès";
            } else {
                $_SESSION['error'] = "Utilisateur non trouvé";
            }
        }
        
        header("Location: index.php?action=admin-dashboard");
        exit;
    }

    // ========== SUPPRIMER UNE OFFRE ==========
    public function deleteJob() {
        $id = $_GET['id'] ?? 0;
        $jobModel = new Job();
        
        $job = $jobModel->find($id);
        if ($job) {
            $jobModel->delete($id);
            $_SESSION['success'] = "Offre supprimée avec succès";
        } else {
            $_SESSION['error'] = "Offre non trouvée";
        }
        
        header("Location: index.php?action=admin-dashboard");
        exit;
    }
}