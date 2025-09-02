<?php

class BookController
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
        // List all books
        $db = $this->getDb();
        $result = $db->query("SELECT * FROM books");
        if (!$result) {
            $this->respond(false, $db->error);
            return;
        }
        $books = $result->fetch_all(MYSQLI_ASSOC);
        $this->respond(true, "Lista libri", $books);
    }

    public function show($id)
    {
        // Show details for a single book
        $db = $this->getDb();
        $stmt = $db->prepare("SELECT * FROM books WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $book = $result->fetch_assoc();
        if ($book) {
            $this->respond(true, "Libro trovato", $book);
        } else {
            $this->respond(false, "Libro non trovato");
        }
    }

    public function store($data)
    {
        // Save a new book
        if (!isset($data['title'], $data['author'], $data['year'])) {
            $this->respond(false, "Dati mancanti");
            return;
        }
        $db = $this->getDb();
        $stmt = $db->prepare("INSERT INTO books (title, author, year) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $data['title'], $data['author'], $data['year']);
        if ($stmt->execute()) {
            $this->respond(true, "Libro aggiunto", ['id' => $stmt->insert_id]);
        } else {
            $this->respond(false, $stmt->error);
        }
    }

    public function update($id, $data)
    {
        // Update book details
        if (!isset($data['title'], $data['author'], $data['year'])) {
            $this->respond(false, "Dati mancanti");
            return;
        }
        $db = $this->getDb();
        $stmt = $db->prepare("UPDATE books SET title = ?, author = ?, year = ? WHERE id = ?");
        $stmt->bind_param("ssii", $data['title'], $data['author'], $data['year'], $id);
        if ($stmt->execute()) {
            $this->respond(true, "Libro aggiornato");
        } else {
            $this->respond(false, $stmt->error);
        }
    }

    public function destroy($id)
    {
        // Delete a book
        $db = $this->getDb();
        $stmt = $db->prepare("DELETE FROM books WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $this->respond(true, "Libro eliminato");
        } else {
            $this->respond(false, $stmt->error);
        }
    }
}
