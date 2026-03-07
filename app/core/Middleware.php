<?php

class Middleware {

    public static function auth() {
        if(!isset($_SESSION['user'])) {
            header("Location: index.php?action=login");
            exit;
        }
    }

    public static function role($role) {
        self::auth();
        if($_SESSION['user']['role'] !== $role) {
            die("Access Denied");
        }
    }
}