<?php

class AdminController
{
    private function getDb() {
        $cfg = require __DIR__ . '/../config/config.php';
        return new mysqli($cfg['db_host'], $cfg['db_user'], $cfg['db_pass'], $cfg['db_name']);
    }

    private function isAdmin() {
        return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
    }

    public function dashboard()
    {
        if (!$this->isAdmin()) {
            header('Location: ?page=users&action=login');
            exit;
        }
        require __DIR__ . '/../views/admin/dashboard.php';
    }

    public function products()
    {
        if (!$this->isAdmin()) {
            header('Location: ?page=users&action=login');
            exit;
        }
        $db = $this->getDb();
        $result = $db->query("SELECT * FROM products");
        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
        require __DIR__ . '/../views/admin/products.php';
    }

    public function orders()
    {
        if (!$this->isAdmin()) {
            header('Location: ?page=users&action=login');
            exit;
        }
        $db = $this->getDb();
        $result = $db->query("SELECT o.*, u.username FROM orders o JOIN users u ON o.user_id = u.id");
        $orders = [];
        while ($row = $result->fetch_assoc()) {
            $orders[] = $row;
        }
        require __DIR__ . '/../views/admin/orders.php';
    }

    public function users()
    {
        if (!$this->isAdmin()) {
            header('Location: ?page=users&action=login');
            exit;
        }
        $db = $this->getDb();
        $result = $db->query("SELECT * FROM users");
        $users = [];
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
        require __DIR__ . '/../views/admin/users.php';
    }
}