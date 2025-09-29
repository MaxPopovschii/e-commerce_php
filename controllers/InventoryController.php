<?php

require_once __DIR__ . '/../models/Inventory.php';

class InventoryController
{
    private function getDb() {
        $cfg = require __DIR__ . '/../config/config.php';
        return new mysqli($cfg['db_host'], $cfg['db_user'], $cfg['db_pass'], $cfg['db_name']);
    }

    public function index()
    {
        $db = $this->getDb();
        $result = $db->query("SELECT p.id, p.name, i.quantity FROM products p LEFT JOIN inventory i ON p.id = i.product_id");
        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
        require __DIR__ . '/../views/inventory/index.php';
    }

    public function update($product_id, $quantity)
    {
        $db = $this->getDb();
        $stmt = $db->prepare("REPLACE INTO inventory (product_id, quantity) VALUES (?, ?)");
        $stmt->bind_param("ii", $product_id, $quantity);
        $stmt->execute();
        header('Location: ?page=inventory');
        exit;
    }
}