<?php
namespace App\Models;

use Config\Database;
use Exception;

class Product {
    public ?int $id = null;
    public string $name = '';
    public string $description = '';
    public float $price = 0.0;
    public ?string $created_at = null;

    private static string $table = 'products';

    public function __construct(array $data = []) {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key) && $value !== null) {
                $this->$key = $value;
            }
        }
    }

    /**
     * Restituisce tutti i prodotti.
     * @return Product[]
     */
    public static function all(): array {
        $db = Database::getConnection();
        $query = "SELECT * FROM " . self::$table;
        $result = $db->query($query);

        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = new self($row);
        }
        return $products;
    }

    /**
     * Trova un prodotto per ID.
     */
    public static function find(int $id): ?Product {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM " . self::$table . " WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();

        return $data ? new self($data) : null;
    }

    /**
     * Salva o aggiorna il prodotto.
     */
    public function save(): void {
        $db = Database::getConnection();

        if ($this->id) {
            $stmt = $db->prepare("UPDATE " . self::$table . " SET name = ?, description = ?, price = ? WHERE id = ?");
            $stmt->bind_param('ssdi', $this->name, $this->description, $this->price, $this->id);
            $stmt->execute();
        } else {
            $stmt = $db->prepare("INSERT INTO " . self::$table . " (name, description, price) VALUES (?, ?, ?)");
            $stmt->bind_param('ssd', $this->name, $this->description, $this->price);
            $stmt->execute();
            $this->id = (int) $db->insert_id;
        }
    }

    /**
     * Elimina il prodotto.
     */
    public function delete(): void {
        if (!$this->id) {
            throw new Exception("Il prodotto non esiste.");
        }

        $db = Database::getConnection();
        $stmt = $db->prepare("DELETE FROM " . self::$table . " WHERE id = ?");
        $stmt->bind_param('i', $this->id);
        $stmt->execute();
    }
}
