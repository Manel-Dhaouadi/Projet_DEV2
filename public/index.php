<?php
session_start();

require_once "../app/core/Router.php";

$action = $_GET['action'] ?? 'home';

Router::route($action);