<?php
require_once "../app/core/Controller.php";
require_once "../app/models/Category.php";

class AdminController extends Controller {
    
    private $categoryModel;

    public function __construct() {
        // Vérifier si l'utilisateur est admin
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header("Location: index.php?action=login");
            exit;
        }
        
        $this->categoryModel = new Category();
    }

    public function categories() {
        $data = [
            'categories' => $this->categoryModel->getAllCategories()
        ];
        
        $this->view("admin/categories", $data);
    }

    public function addCategory() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'] ?? '',
                'icon' => $_POST['icon'] ?? 'fa-folder',
                'color' => $_POST['color'] ?? '#0a66c2'
            ];

            if ($this->categoryModel->create($data)) {
                $_SESSION['success'] = 'Catégorie ajoutée avec succès';
            } else {
                $_SESSION['error'] = 'Erreur lors de l\'ajout';
            }
            
            header("Location: index.php?action=admin-categories");
            exit;
        }
        
        $this->view("admin/add-category");
    }

    public function editCategory() {
        $id = $_GET['id'] ?? 0;
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'] ?? '',
                'icon' => $_POST['icon'] ?? 'fa-folder',
                'color' => $_POST['color'] ?? '#0a66c2'
            ];

            if ($this->categoryModel->update($id, $data)) {
                $_SESSION['success'] = 'Catégorie modifiée avec succès';
            } else {
                $_SESSION['error'] = 'Erreur lors de la modification';
            }
            
            header("Location: index.php?action=admin-categories");
            exit;
        }
        
        $data = [
            'category' => $this->categoryModel->find($id)
        ];
        
        $this->view("admin/edit-category", $data);
    }

    public function deleteCategory() {
        $id = $_GET['id'] ?? 0;
        
        if ($this->categoryModel->delete($id)) {
            $_SESSION['success'] = 'Catégorie supprimée';
        } else {
            $_SESSION['error'] = 'Erreur lors de la suppression';
        }
        
        header("Location: index.php?action=admin-categories");
        exit;
    }
}