<?php

require_once __DIR__ . '/../config/Database.php';

use Exception;

class User {
    public ?int $id = null;
    public string $name = '';
    public string $email = '';
    private string $password = '';
    public ?string $created_at = null;

    private static string $table = 'users';

    public function __construct(array $data = []) {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key) && $value !== null) {
                if ($key === 'password' && !empty($value)) {
                    $this->setPassword($value);
                } else {
                    $this->$key = $value;
                }
            }
        }
    }

    /**
     * Restituisce tutti gli utenti
     * @return User[]
     * @throws Exception
     */
    public static function all(): array {
        try {
            $db = Database::getConnection();
            $query = "SELECT * FROM " . self::$table;
            $result = $db->query($query);

            if (!$result) {
                throw new Exception("Errore durante il recupero degli utenti: " . $db->error);
            }

            $users = [];
            while ($row = $result->fetch_assoc()) {
                $users[] = new self($row);
            }
            return $users;
        } catch (Exception $e) {
            throw new Exception("Errore nel recupero degli utenti: " . $e->getMessage());
        }
    }

    /**
     * Trova un utente per ID
     * @param int $id
     * @return User|null
     * @throws Exception
     */
    public static function find(int $id): ?User {
        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("SELECT * FROM " . self::$table . " WHERE id = ?");
            
            if (!$stmt) {
                throw new Exception("Errore nella preparazione della query: " . $db->error);
            }

            $stmt->bind_param('i', $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $data = $result->fetch_assoc();

            return $data ? new self($data) : null;
        } catch (Exception $e) {
            throw new Exception("Errore nel recupero dell'utente: " . $e->getMessage());
        }
    }

    /**
     * Salva o aggiorna l'utente
     * @throws Exception
     */
    public function save(): void {
        try {
            $db = Database::getConnection();

            if ($this->id) {
                $stmt = $db->prepare("UPDATE " . self::$table . " SET name = ?, email = ? WHERE id = ?");
                if (!$stmt) {
                    throw new Exception("Errore nella preparazione della query di aggiornamento");
                }
                $stmt->bind_param('ssi', $this->name, $this->email, $this->id);
            } else {
                $stmt = $db->prepare("INSERT INTO " . self::$table . " (name, email, password) VALUES (?, ?, ?)");
                if (!$stmt) {
                    throw new Exception("Errore nella preparazione della query di inserimento");
                }
                $stmt->bind_param('sss', $this->name, $this->email, $this->password);
            }

            if (!$stmt->execute()) {
                throw new Exception("Errore nell'esecuzione della query: " . $stmt->error);
            }

            if (!$this->id) {
                $this->id = $db->insert_id;
            }
        } catch (Exception $e) {
            throw new Exception("Errore nel salvataggio dell'utente: " . $e->getMessage());
        }
    }

    /**
     * Elimina l'utente
     * @throws Exception
     */
    public function delete(): void {
        try {
            if (!$this->id) {
                throw new Exception("Impossibile eliminare un utente senza ID");
            }

            $db = Database::getConnection();
            $stmt = $db->prepare("DELETE FROM " . self::$table . " WHERE id = ?");
            
            if (!$stmt) {
                throw new Exception("Errore nella preparazione della query di eliminazione");
            }

            $stmt->bind_param('i', $this->id);
            
            if (!$stmt->execute()) {
                throw new Exception("Errore nell'eliminazione dell'utente: " . $stmt->error);
            }
        } catch (Exception $e) {
            throw new Exception("Errore nell'eliminazione dell'utente: " . $e->getMessage());
        }
    }

    /**
     * Trova un utente per email
     * @param string $email
     * @return User|null
     * @throws Exception
     */
    public static function findByEmail(string $email): ?User {
        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("SELECT * FROM " . self::$table . " WHERE email = ?");
            
            if (!$stmt) {
                throw new Exception("Errore nella preparazione della query");
            }

            $stmt->bind_param('s', $email);
            $stmt->execute();
            $result = $stmt->get_result();
            $data = $result->fetch_assoc();

            return $data ? new self($data) : null;
        } catch (Exception $e) {
            throw new Exception("Errore nel recupero dell'utente: " . $e->getMessage());
        }
    }

    /**
     * Imposta la password hashata
     * @param string $password
     */
    public function setPassword(string $password): void {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * Verifica una password in chiaro rispetto all’hash salvato
     * @param string $password
     * @return bool
     */
    public function verifyPassword(string $password): bool {
        return password_verify($password, $this->password);
    }

    /**
     * Converte l'utente in un array
     * @return array
     */
    public function toArray(): array {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'created_at' => $this->created_at
        ];
    }
}
