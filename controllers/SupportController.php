<?php

require_once __DIR__ . '/../models/SupportTicket.php';

class SupportController
{
    private function getDb() {
        $cfg = require __DIR__ . '/../config/config.php';
        return new mysqli($cfg['db_host'], $cfg['db_user'], $cfg['db_pass'], $cfg['db_name']);
    }

    public function faq()
    {
        require __DIR__ . '/../views/support/faq.php';
    }

    public function index()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: ?page=users&action=login');
            exit;
        }
        $db = $this->getDb();
        $user_id = $_SESSION['user']['id'];
        $stmt = $db->prepare("SELECT * FROM support_tickets WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $tickets = [];
        while ($row = $result->fetch_assoc()) {
            $tickets[] = $row;
        }
        require __DIR__ . '/../views/support/index.php';
    }

    public function create()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: ?page=users&action=login');
            exit;
        }
        $error = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $db = $this->getDb();
            $user_id = $_SESSION['user']['id'];
            $subject = $_POST['subject'];
            $message = $_POST['message'];
            $stmt = $db->prepare("INSERT INTO support_tickets (user_id, subject, message, status) VALUES (?, ?, ?, 'open')");
            $stmt->bind_param("iss", $user_id, $subject, $message);
            if ($stmt->execute()) {
                header('Location: ?page=support');
                exit;
            } else {
                $error = "Errore nell'invio del ticket";
            }
        }
        require __DIR__ . '/../views/support/create.php';
    }
}