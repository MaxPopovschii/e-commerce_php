<?php


require_once __DIR__ . '/../models/Order.php';

class OrderController
{
    private $filePath = __DIR__ . '/../data/orders.json';

    private function getDb() {
        $cfg = require __DIR__ . '/../config/config.php';
        $db = @new mysqli($cfg['db_host'], $cfg['db_user'], $cfg['db_pass'], $cfg['db_name']);
        return $db->connect_errno ? null : $db;
    }

    public function index()
    {
        $db = $this->getDb();
        if ($db) {
            $user_id = $_SESSION['user']['id'];
            $stmt = $db->prepare("SELECT * FROM orders WHERE user_id = ?");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $orders = [];
            while ($row = $result->fetch_assoc()) {
                $orders[] = $row;
            }
        } else {
            $orders = [];
            foreach (Order::allFromFile($this->filePath) as $o) {
                if ($o->user_id == $_SESSION['user']['id']) {
                    $orders[] = [
                        'id' => $o->id,
                        'total' => $o->total,
                        'status' => $o->status,
                        'created_at' => $o->created_at
                    ];
                }
            }
        }
        require __DIR__ . '/../views/orders/index.php';
    }

    // create, show, update, destroy: aggiungi logica simile per file
}