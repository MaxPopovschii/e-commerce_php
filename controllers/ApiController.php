<?php

class ApiController
{
    private function getDb() {
        $cfg = require __DIR__ . '/../config/config.php';
        return new mysqli($cfg['db_host'], $cfg['db_user'], $cfg['db_pass'], $cfg['db_name']);
    }

    private function respond($data, $status = 200) {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    public function products()
    {
        $db = $this->getDb();
        $result = $db->query("SELECT * FROM products");
        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
        $this->respond($products);
    }

    public function orders()
    {
        if (!isset($_SESSION['user'])) {
            $this->respond(['error' => 'Unauthorized'], 401);
        }
        $db = $this->getDb();
        $user_id = $_SESSION['user']['id'];
        $stmt = $db->prepare("SELECT * FROM orders WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $orders = [];
        while ($row = $result->fetch_assoc()) {
            $orders[] = $row;
        }
        $this->respond($orders);
    }

    public function users()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            $this->respond(['error' => 'Unauthorized'], 401);
        }
        $db = $this->getDb();
        $result = $db->query("SELECT id, username, email, role FROM users");
        $users = [];
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
        $this->respond($users);
    }
}