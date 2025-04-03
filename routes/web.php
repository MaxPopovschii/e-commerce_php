<?php
require '../vendor/autoload.php'; // Se usi Composer

use App\Controllers\UserController;
use App\Controllers\ProductController;

// Recupera il percorso richiesto
$request = $_GET['route'] ?? '';

// Routing semplice
switch ($request) {
    case 'users':
        $controller = new UserController();
        $controller->index();
        break;
    case 'users/show':
        $id = $_GET['id'] ?? null;
        $controller = new UserController();
        if ($id) {
            $controller->show($id);
        } else {
            echo json_encode(["success" => false, "message" => "ID mancante"]);
        }
        break;
    case 'products':
        $controller = new ProductController();
        $controller->index();
        break;
    case 'products/show':
        $id = $_GET['id'] ?? null;
        $controller = new ProductController();
        if ($id) {
            $controller->show($id);
        } else {
            echo json_encode(["success" => false, "message" => "ID mancante"]);
        }
        break;
    default:
        http_response_code(404);
        require '../views/errors/404.html';
        break;
}
?>
