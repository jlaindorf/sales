<?php
require_once '../config.php';
require_once '../controllers/PaymentController.php';

$method = $_SERVER['REQUEST_METHOD'];
$controller = new PaymentController();

if ($method === 'POST') {
    $controller->createOne();
} else if ($method === 'GET' && !isset($_GET['id'])) {
    $controller->listAll();
} else if($method === 'GET' && $_GET['id']) {
    $controller->listOne();
}
else if ($method === 'DELETE') {
    $controller->deleteOne();
}
else if ($method === 'PUT') {
    $controller->updateOne();
}