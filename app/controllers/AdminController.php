<?php
require_once "../app/core/Controller.php";
require_once "../app/core/Middleware.php";
require_once "../app/models/User.php";
require_once "../app/models/Job.php";

class AdminController extends Controller {

    public function index() {

        Middleware::role("admin");

        $users = (new User())->all();
        $jobs  = (new Job())->getAll();

        $this->view("admin/index",[
            'users'=>$users,
            'jobs'=>$jobs
        ]);
    }

    public function deleteUser() {

        Middleware::role("admin");

        (new User())->delete($_GET['id']);

        header("Location: index.php?action=admin");
    }

    public function deleteJob() {

        Middleware::role("admin");

        (new Job())->delete($_GET['id']);

        header("Location: index.php?action=admin");
    }
}