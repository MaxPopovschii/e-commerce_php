<?php

require_once __DIR__ . '/../config/Database.php';

class Product {
    private $id;
    private $name;
    private $description;
    private $price;

    private static string $table = 'products';

    public function __construct($data = []) {
        $this->id = $data['id'] ?? null;
        $this->name = $data['name'] ?? '';
        $this->description = $data['description'] ?? '';
        $this->price = $data['price'] ?? 0.0;
    }

    /**
     * Restituisce tutti i prodotti.
     * @return array
     * @throws Exception
     */
    public static function all(): array {
        $db = Database::getConnection();
        $result = $db->query("SELECT * FROM " . self::$table);

        if (!$result) {
            throw new DatabaseException("Errore durante il recupero dei prodotti: " . $db->error);
        }

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Trova un prodotto per ID.
     * @param int $id
     * @return array|null
     * @throws Exception
     */
    public static function find($id): ?array {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM " . self::$table . " WHERE id = ?");

        if (!$stmt) {
            throw new DatabaseException("Errore nella preparazione della query: " . $db->error);
        }

        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    /**
     * Salva o aggiorna il prodotto.
     * @return bool
     * @throws Exception
     */
    public function save(): bool {
        $db = Database::getConnection();

        if ($this->id) {
            $stmt = $db->prepare("UPDATE " . self::$table . " SET name = ?, description = ?, price = ? WHERE id = ?");
            $stmt->bind_param("ssdi", $this->name, $this->description, $this->price, $this->id);
        } else {
            $stmt = $db->prepare("INSERT INTO " . self::$table . " (name, description, price) VALUES (?, ?, ?)");
            $stmt->bind_param("ssd", $this->name, $this->description, $this->price);
        }

        if (!$stmt) {
            throw new Exception("Errore nella preparazione della query: " . $db->error);
        }

        if (!$stmt->execute()) {
            throw new Exception("Errore durante il salvataggio: " . $stmt->error);
        }

        if (!$this->id) {
            $this->id = $stmt->insert_id;
        }

        return true;
    }

    /**
     * Elimina il prodotto.
     * @throws Exception
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
