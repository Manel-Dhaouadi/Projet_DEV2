<?php
require_once "../app/core/Controller.php";
require_once "../app/models/User.php";

class AuthController extends Controller {

    public function register() {

        if($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Vérifier que tous les champs existent
            $data = [
                'name' => $_POST['name'] ?? '',
                'email' => $_POST['email'] ?? '',
                'password' => password_hash($_POST['password'] ?? '', PASSWORD_DEFAULT),
                'role' => $_POST['role'] ?? 'candidate', // Valeur par défaut si non défini
                'city' => $_POST['city'] ?? '',
                'phone' => $_POST['phone'] ?? '' // Ajout du champ phone
            ];

            $user = new User();
            $user->create($data);

            header("Location: index.php?action=login");
            exit;
        }

        $this->view("auth/register");
    }

    public function login() {

        if($_SERVER['REQUEST_METHOD'] == 'POST') {

            $userModel = new User();
            $user = $userModel->findByEmail($_POST['email'] ?? '');

            if($user && password_verify($_POST['password'] ?? '', $user['password'])) {

                $_SESSION['user'] = $user;
                header("Location: index.php?action=dashboard");
                exit;
            }
            
            // Si erreur de connexion
            $_SESSION['error'] = "Email ou mot de passe incorrect";
            header("Location: index.php?action=login");
            exit;
        }

        $this->view("auth/login");
    }
}