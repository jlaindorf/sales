<?php
require_once '../config.php';
require_once '../controllers/UserController.php';

$method = $_SERVER['REQUEST_METHOD'];
$controller = new UserController();

if ($method === 'POST') {
    $controller->login();
} 