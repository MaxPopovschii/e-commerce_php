<?php

class ProductController
{
    private function getDb() {
        return new mysqli('192.168.1.100', 'max', 'Dom200598!', 'ecofootprint');
    }

    private function respond($success, $message = '', $data = null) {
        header('Content-Type: application/json');
        echo json_encode([
            'success' => $success,
            'message' => $message,
            'data' => $data
        ]);
    }

    public function index()
    {
        // Lista tutti i prodotti tecnologici
        $db = $this->getDb();
        $result = $db->query("SELECT * FROM products");
        if (!$result) {
            $this->respond(false, $db->error);
            return;
        }
        $products = $result->fetch_all(MYSQLI_ASSOC);
        $this->respond(true, "Lista prodotti", $products);
    }

    public function show($id)
    {
        // Mostra dettagli di un prodotto
        $db = $this->getDb();
        $stmt = $db->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();
        if ($product) {
            $this->respond(true, "Prodotto trovato", $product);
        } else {
            $this->respond(false, "Prodotto non trovato");
        }
    }

    public function store($data)
    {
        // Aggiungi nuovo prodotto
        if (!isset($data['name'], $data['category'], $data['price'])) {
            $this->respond(false, "Dati mancanti");
            return;
        }
        $db = $this->getDb();
        $stmt = $db->prepare("INSERT INTO products (name, category, price) VALUES (?, ?, ?)");
        $stmt->bind_param("ssd", $data['name'], $data['category'], $data['price']);
        if ($stmt->execute()) {
            $this->respond(true, "Prodotto aggiunto", ['id' => $stmt->insert_id]);
        } else {
            $this->respond(false, $stmt->error);
        }
    }

    public function update($id, $data)
    {
        // Aggiorna prodotto
        if (!isset($data['name'], $data['category'], $data['price'])) {
            $this->respond(false, "Dati mancanti");
            return;
        }
        $db = $this->getDb();
        $stmt = $db->prepare("UPDATE products SET name = ?, category = ?, price = ? WHERE id = ?");
        $stmt->bind_param("ssdi", $data['name'], $data['category'], $data['price'], $id);
        if ($stmt->execute()) {
            $this->respond(true, "Prodotto aggiornato");
        } else {
            $this->respond(false, $stmt->error);
        }
    }

    public function destroy($id)
    {
        // Elimina prodotto
        $db = $this->getDb();
        $stmt = $db->prepare("DELETE FROM products WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $this->respond(true, "Prodotto eliminato");
        } else {
            $this->respond(false, $stmt->error);
        }
    }
}