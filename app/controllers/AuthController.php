<?php
require_once "../app/core/Controller.php";
require_once "../app/models/User.php";

class AuthController extends Controller {

    public function register() {

        if($_SERVER['REQUEST_METHOD'] == 'POST') {

            $data = [
                'name'=>$_POST['name'],
                'email'=>$_POST['email'],
                'password'=>password_hash($_POST['password'], PASSWORD_DEFAULT),
                'role'=>$_POST['role'],
                'city'=>$_POST['city']
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
            $user = $userModel->findByEmail($_POST['email']);

            if($user && password_verify($_POST['password'],$user['password'])) {

                $_SESSION['user'] = $user;
                header("Location: index.php?action=dashboard");
                exit;
            }
        }

        $this->view("auth/login");
    }
}