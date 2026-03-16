<?php

class Router {

    public static function route($action) {

        switch ($action) {

            /* ========= HOME ========= */
            case "home":
                require "../app/controllers/HomeController.php";
                (new HomeController())->index();
                break;

            /* ========= AUTH ========= */
            case "register":
                require "../app/controllers/AuthController.php";
                (new AuthController())->register();
                break;

            case "login":
                require "../app/controllers/AuthController.php";
                (new AuthController())->login();
                break;

            case "logout":
                session_destroy();
                header("Location: index.php?action=home");
                exit;
                break;

            /* ========= DASHBOARD ========= */
            case "dashboard":
                require "../app/controllers/DashboardController.php";
                (new DashboardController())->index();
                break;

            /* ========= JOBS ========= */
            case "jobs":
                require "../app/controllers/JobController.php";
                (new JobController())->index();
                break;

            case "createJob":
                require "../app/controllers/JobController.php";
                (new JobController())->create();
                break;

            case "editJob":
                require "../app/controllers/JobController.php";
                (new JobController())->edit();
                break;

            case "deleteJob":
                require "../app/controllers/JobController.php";
                (new JobController())->delete();
                break;

            case "job":
                require "../app/controllers/JobController.php";
                (new JobController())->show();
                break;

            /* ========= APPLICATIONS ========= */
            case "apply":
                require "../app/controllers/ApplicationController.php";
                (new ApplicationController())->apply();
                break;

            case "myApplications":
                require "../app/controllers/ApplicationController.php";
                (new ApplicationController())->myApplications();
                break;

            case "applications":
                require "../app/controllers/ApplicationController.php";
                (new ApplicationController())->index();
                break;

            case "updateStatus":
                require "../app/controllers/ApplicationController.php";
                (new ApplicationController())->updateStatus();
                break;

            case "download-ultra":
                require "../app/controllers/ApplicationController.php";
                (new ApplicationController())->downloadUltraSimple();
                break;

            case "viewApplication":
                require "../app/controllers/ApplicationController.php";
                (new ApplicationController())->viewApplication();
                break;

            case "deleteApplication":
                require "../app/controllers/ApplicationController.php";
                (new ApplicationController())->delete();
                break;
                

            /* ========= ADMIN ========= */
            case "admin":
                require "../app/controllers/AdminController.php";
                (new AdminController())->index();
                break;

            case "admin-dashboard":
                require "../app/controllers/AdminController.php";
                (new AdminController())->dashboard();
                break;

            case "deleteUser":
                require "../app/controllers/AdminController.php";
                (new AdminController())->deleteUser();
                break;

            case "deleteJobAdmin":
                require "../app/controllers/AdminController.php";
                (new AdminController())->deleteJob();
                break;

            case "admin-edit-user":
                require "../app/controllers/AdminController.php";
                (new AdminController())->editUser();
                break;

            case "admin-edit-job":
                require "../app/controllers/AdminController.php";
                (new AdminController())->editJob();
                break;

            case "admin-add-user":
                require "../app/controllers/AdminController.php";
                (new AdminController())->addUser();
                break;

            case "admin-add-job":
                require "../app/controllers/AdminController.php";
                (new AdminController())->addJob();
                break;

            /* ========= DEFAULT 404 ========= */
            default:
                require "../app/controllers/ErrorController.php";
                (new ErrorController())->index();
        }
    }
}