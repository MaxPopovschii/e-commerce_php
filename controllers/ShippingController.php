<?php

require_once __DIR__ . '/../models/Shipping.php';

class ShippingController
{
    private function getDb() {
        $cfg = require __DIR__ . '/../config/config.php';
        return new mysqli($cfg['db_host'], $cfg['db_user'], $cfg['db_pass'], $cfg['db_name']);
    }

    public function index()
    {
        $db = $this->getDb();
        $result = $db->query("SELECT * FROM shipping_methods");
        $methods = [];
        while ($row = $result->fetch_assoc()) {
            $methods[] = $row;
        }
        require __DIR__ . '/../views/shipping/index.php';
    }

    public function select($id)
    {
        session_start();
        $db = $this->getDb();
        $stmt = $db->prepare("SELECT * FROM shipping_methods WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $method = $result->fetch_assoc();
        if ($method) {
            $_SESSION['shipping'] = $method;
        }
        header('Location: ?page=cart');
        exit;
    }
}