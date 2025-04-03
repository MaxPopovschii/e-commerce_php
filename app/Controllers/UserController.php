<?php
namespace App\Controllers;

use App\Models\User;
use Exception;

class UserController {
    public function index() {
        try {
            $users = User::all();
            echo json_encode(["success" => true, "data" => $users]);
        } catch (Exception $e) {
            echo json_encode(["success" => false, "message" => $e->getMessage()]);
        }
    }

    public function show($id) {
        try {
            $user = User::find($id);
            if ($user) {
                echo json_encode(["success" => true, "data" => $user]);
            } else {
                echo json_encode(["success" => false, "message" => "Utente non trovato"]);
            }
        } catch (Exception $e) {
            echo json_encode(["success" => false, "message" => $e->getMessage()]);
        }
    }

    public function store($data) {
        try {
            if (!isset($data['name']) || !isset($data['email']) || !isset($data['password'])) {
                throw new Exception("Dati mancanti");
            }
            
            $user = new User($data);
            $user->setPassword($data['password']); // Hash della password
            $user->save();
            
            echo json_encode(["success" => true, "message" => "Utente creato con successo", "data" => $user]);
        } catch (Exception $e) {
            echo json_encode(["success" => false, "message" => $e->getMessage()]);
        }
    }
}
