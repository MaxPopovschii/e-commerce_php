<?php

require_once __DIR__ . '/../controllers/productscontroller.php';
require_once __DIR__ . '/../models/Product.php';

// Routing semplice
$controller = new ProductController();

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $controller->show($_GET['id']);
} else {
    $controller->index();
}