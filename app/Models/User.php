<?php
namespace App\Models;

use PDO;
use App\Database; // Supponiamo che tu abbia una classe Database per la connessione
use Exception;

class User {
    public $id;
    public $name;
    public $email;
    public $password;
    public $created_at;

    private static $table = 'users';

    public function __construct($data = []) {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    public static function all() {
        $db = Database::getConnection();
        $stmt = $db->query("SELECT * FROM " . self::$table);
        return $stmt->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public static function find($id) {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM " . self::$table . " WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetchObject(self::class);
    }

    public function save() {
        $db = Database::getConnection();
        if ($this->id) {
            $stmt = $db->prepare("UPDATE " . self::$table . " SET name = ?, email = ?, password = ? WHERE id = ?");
            $stmt->execute([$this->name, $this->email, $this->password, $this->id]);
        } else {
            $stmt = $db->prepare("INSERT INTO " . self::$table . " (name, email, password) VALUES (?, ?, ?)");
            $stmt->execute([$this->name, $this->email, $this->password]);
            $this->id = $db->lastInsertId();
        }
    }

    public function delete() {
        if (!$this->id) {
            throw new Exception("L'utente non esiste.");
        }
        $db = Database::getConnection();
        $stmt = $db->prepare("DELETE FROM " . self::$table . " WHERE id = ?");
        $stmt->execute([$this->id]);
    }

    public static function findByEmail($email) {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM " . self::$table . " WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetchObject(self::class);
    }

    public function setPassword($password) {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    public function verifyPassword($password) {
        return password_verify($password, $this->password);
    }
}
