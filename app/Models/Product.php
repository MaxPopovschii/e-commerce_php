<?php
namespace App\Models;

use PDO;
use App\Database;
use Exception;

class Product {
    public $id;
    public $name;
    public $description;
    public $price;
    public $created_at;

    private static $table = 'products';

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
            $stmt = $db->prepare("UPDATE " . self::$table . " SET name = ?, description = ?, price = ? WHERE id = ?");
            $stmt->execute([$this->name, $this->description, $this->price, $this->id]);
        } else {
            $stmt = $db->prepare("INSERT INTO " . self::$table . " (name, description, price) VALUES (?, ?, ?)");
            $stmt->execute([$this->name, $this->description, $this->price]);
            $this->id = $db->lastInsertId();
        }
    }

    public function delete() {
        if (!$this->id) {
            throw new Exception("Il prodotto non esiste.");
        }
        $db = Database::getConnection();
        $stmt = $db->prepare("DELETE FROM " . self::$table . " WHERE id = ?");
        $stmt->execute([$this->id]);
    }
}
?>