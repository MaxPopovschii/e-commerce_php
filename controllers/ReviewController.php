<?php

require_once __DIR__ . '/../models/Review.php';

class ReviewController
{
    private function getDb() {
        $cfg = require __DIR__ . '/../config/config.php';
        return new mysqli($cfg['db_host'], $cfg['db_user'], $cfg['db_pass'], $cfg['db_name']);
    }

    public function index($product_id)
    {
        $db = $this->getDb();
        $stmt = $db->prepare("SELECT r.*, u.username FROM reviews r JOIN users u ON r.user_id = u.id WHERE r.product_id = ?");
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $reviews = [];
        while ($row = $result->fetch_assoc()) {
            $reviews[] = $row;
        }
        require __DIR__ . '/../views/reviews/index.php';
    }

    public function create($product_id)
    {
        if (!isset($_SESSION['user'])) {
            header('Location: ?page=users&action=login');
            exit;
        }
        $error = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $db = $this->getDb();
            $user_id = $_SESSION['user']['id'];
            $rating = intval($_POST['rating']);
            $comment = $_POST['comment'];
            $stmt = $db->prepare("INSERT INTO reviews (product_id, user_id, rating, comment) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("iiis", $product_id, $user_id, $rating, $comment);
            if ($stmt->execute()) {
                header("Location: ?page=reviews&product_id=$product_id");
                exit;
            } else {
                $error = "Errore nell'inserimento della recensione";
            }
        }
        require __DIR__ . '/../views/reviews/create.php';
    }
}