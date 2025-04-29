<?php

// Load models first
require_once __DIR__ . '/app/config/Database.php';
require_once __DIR__ . '/app/Models/User.php';
require_once __DIR__ . '/app/Models/Product.php';

// Then load controllers
require_once __DIR__ . '/app/Controllers/UserController.php';
require_once __DIR__ . '/app/Controllers/ProductController.php';

// Define constants for view paths
define('VIEW_HOME', __DIR__ . '/app/Views/home.html');
define('VIEW_404', __DIR__ . '/app/Views/errors/404.html');

// Set error handling
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Set JSON response headers
header('Content-Type: application/json');

// Use the full namespace for controllers
use App\Controllers\UserController;
use App\Controllers\ProductController;

try {
    // Get and sanitize route and ID from URL
    $request = isset($_GET['route']) ? htmlspecialchars($_GET['route']) : '';
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    // Handle routing
    switch ($request) {
        case '':
            header('Content-Type: text/html');
            require VIEW_HOME;
            break;

        case 'users':
            $controller = new UserController();
            $controller->index();
            break;

        case 'users/show':
            $controller = new UserController();
            if ($id) {
                $controller->show($id);
            } else {
                throw new Exception("ID mancante");
            }
            break;

        case 'products':
            $controller = new ProductController();
            $controller->index();
            break;

        case 'products/show':
            $controller = new ProductController();
            if ($id) {
                $controller->show($id);
            } else {
                throw new Exception("ID mancante");
            }
            break;

        default:
            header('Content-Type: text/html');
            http_response_code(404);
            require VIEW_404;
            break;
    }
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}
