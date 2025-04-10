<?php
namespace App\Models;

use Config\Database;
use Exception;

class User {
    public ?int $id = null;
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public ?string $created_at = null;

    private static string $table = 'users';

    public function __construct(array $data = []) {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key) && $value !== null) {
                $this->$key = $value;
            }
        }
    }

    /**
     * Restituisce tutti gli utenti
     * @return User[]
     */
    public static function all(): array {
        $db = Database::getConnection();
        $query = "SELECT * FROM " . self::$table;
        $result = $db->query($query);

        $users = [];
        while ($row = $result->fetch_assoc()) {
            $users[] = new self($row);
        }
        return $users;
    }

    /**
     * Trova un utente per ID
     */
    public static function find(int $id): ?User {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM " . self::$table . " WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();

        return $data ? new self($data) : null;
    }

    /**
     * Salva o aggiorna l'utente
     */
    public function save(): void {
        $db = Database::getConnection();

        if ($this->id) {
            $stmt = $db->prepare("UPDATE " . self::$table . " SET name = ?, email = ?, password = ? WHERE id = ?");
            $stmt->bind_param('sssi', $this->name, $this->email, $this->password, $this->id);
            $stmt->execute();
        } else {
            $stmt = $db->prepare("INSERT INTO " . self::$table . " (name, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param('sss', $this->name, $this->email, $this->password);
            $stmt->execute();
            $this->id = $db->insert_id;
        }
    }

    /**
     * Elimina l'utente
     */
    public function delete(): void {
        if (!$this->id) {
            throw new Exception("L'utente non esiste.");
        }

        $db = Database::getConnection();
        $stmt = $db->prepare("DELETE FROM " . self::$table . " WHERE id = ?");
        $stmt->bind_param('i', $this->id);
        $stmt->execute();
    }

    /**
     * Trova un utente per email
     */
    public static function findByEmail(string $email): ?User {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM " . self::$table . " WHERE email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();

        return $data ? new self($data) : null;
    }

    /**
     * Imposta la password hashata
     */
    public function setPassword(string $password): void {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * Verifica una password in chiaro rispetto all’hash salvato
     */
    public function verifyPassword(string $password): bool {
        return password_verify($password, $this->password);
    }
}
