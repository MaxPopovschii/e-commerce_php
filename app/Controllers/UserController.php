<?php
namespace App\Controllers;

use App\Config\Database;
use Exception;

class UserController {
    private function respond($success, $message = '', $data = null) {
        echo json_encode([
            "success" => $success,
            "message" => $message,
            "data" => $data
        ]);
    }

    public function index() {
        try {
            $db = Database::getConnection();
            $query = "SELECT * FROM users";
            $result = $db->query($query);

            if (!$result) {
                $this->respond(false, "Errore durante il recupero degli utenti: " . $db->error);
                //throw new Exception("Errore durante il recupero degli utenti: " . $db->error);
            }

            $users = $result->fetch_all(MYSQLI_ASSOC);
            $this->respond(true, "Utenti recuperati con successo", $users);
        } catch (Exception $e) {
            $this->respond(false, $e->getMessage());
        }
    }

    public function show($id) {
        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
            
            if (!$stmt) {
                throw new Exception("Errore nella preparazione della query: " . $db->error);
            }

            $stmt->bind_param('i', $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();

            if ($user) {
                $this->respond(true, "Utente trovato", $user);
            } else {
                $this->respond(false, "Utente non trovato");
            }
        } catch (Exception $e) {
            $this->respond(false, $e->getMessage());
        }
    }

    public function store($data) {
        try {
            if (!isset($data['name'], $data['email'], $data['password'])) {
                throw new Exception("Dati mancanti: nome, email o password");
            }

            $db = Database::getConnection();
            $stmt = $db->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            
            if (!$stmt) {
                throw new Exception("Errore nella preparazione della query: " . $db->error);
            }

            $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
            $stmt->bind_param('sss', $data['name'], $data['email'], $hashedPassword);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                $this->respond(true, "Utente creato con successo");
            } else {
                throw new Exception("Errore durante la creazione dell'utente");
            }
        } catch (Exception $e) {
            $this->respond(false, $e->getMessage());
        }
    }

    public function update($id, $data) {
        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
            
            if (!$stmt) {
                throw new Exception("Errore nella preparazione della query: " . $db->error);
            }

            $stmt->bind_param('i', $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();

            if (!$user) {
                throw new Exception("Utente non trovato");
            }

            $hashedPassword = isset($data['password']) ? 
                password_hash($data['password'], PASSWORD_DEFAULT) : 
                $user['password'];

            $stmt = $db->prepare("UPDATE users SET name = ?, email = ?, password = ? WHERE id = ?");
            if (!$stmt) {
                throw new Exception("Errore nella preparazione della query: " . $db->error);
            }

            $stmt->bind_param('sssi', $data['name'], $data['email'], $hashedPassword, $id);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                $this->respond(true, "Utente aggiornato con successo");
            } else {
                throw new Exception("Errore durante l'aggiornamento dell'utente");
            }
        } catch (Exception $e) {
            $this->respond(false, $e->getMessage());
        }
    }

    public function destroy($id) {
        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("DELETE FROM users WHERE id = ?");
            
            if (!$stmt) {
                throw new Exception("Errore nella preparazione della query: " . $db->error);
            }

            $stmt->bind_param('i', $id);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                $this->respond(true, "Utente eliminato con successo");
            } else {
                throw new Exception("Utente non trovato");
            }
        } catch (Exception $e) {
            $this->respond(false, $e->getMessage());
        }
    }
}