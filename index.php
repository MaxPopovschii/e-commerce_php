<?php
require __DIR__ . '/vendor/autoload.php';

use App\Controllers\UserController;
use App\Controllers\ProductController;

// Recupera il percorso richiesto
$request = $_GET['route'] ?? '';

// Routing semplice
switch ($request) {
    case '':
        require __DIR__ . '/app/Views/home.html'; 
        break;

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
        require __DIR__ . '/app/Views/errors/404.html';
        break;
}
