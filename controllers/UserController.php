<?php

require_once __DIR__ . '/../models/User.php';

class UserController
{
    private function getDb() {
        $cfg = require __DIR__ . '/../config/config.php';
        $db = @new mysqli($cfg['db_host'], $cfg['db_user'], $cfg['db_pass'], $cfg['db_name']);
        return $db->connect_errno ? null : $db;
    }

    private $filePath = __DIR__ . '/../data/users.json';

    public function index()
    {
        $db = $this->getDb();
        if ($db) {
            $result = $db->query("SELECT * FROM users");
            $users = [];
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
        } else {
            $users = [];
            foreach (User::allFromFile($this->filePath) as $u) {
                $users[] = [
                    'id' => $u->id,
                    'username' => $u->username,
                    'email' => $u->email,
                    'role' => $u->role
                ];
            }
        }
        require __DIR__ . '/../views/users/index.php';
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $db = $this->getDb();
            $username = $_POST['username'];
            $password = $_POST['password'];
            $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user'] = $user;
                header('Location: ?page=users&action=profile');
                exit;
            } else {
                $error = "Credenziali non valide";
            }
        }
        require __DIR__ . '/../views/users/login.php';
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $db = $this->getDb();
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $stmt = $db->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $email, $password);
            if ($stmt->execute()) {
                header('Location: ?page=users&action=login');
                exit;
            } else {
                $error = "Errore registrazione";
            }
        }
        require __DIR__ . '/../views/users/register.php';
    }

    public function profile()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: ?page=users&action=login');
            exit;
        }
        $user = $_SESSION['user'];
        require __DIR__ . '/../views/users/profile.php';
    }

    public function logout()
    {
        session_destroy();
        header('Location: ?page=users&action=login');
        exit;
    }
}