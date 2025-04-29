<?php



use Exception;

class ProductController {
    private function respond($success, $message = '', $data = null) {
        echo json_encode([
            "success" => $success,
            "message" => $message,
            "data" => $data
        ]);
    }

    public function index() {
        try {
            $products = Product::all();
            $this->respond(true, "Prodotti recuperati con successo", $products);
        } catch (Exception $e) {
            $this->respond(false, $e->getMessage());
        }
    }

    public function show($id) {
        try {
            $product = Product::find($id);
            if ($product) {
                $this->respond(true, "Prodotto trovato", $product);
            } else {
                $this->respond(false, "Prodotto non trovato");
            }
        } catch (Exception $e) {
            $this->respond(false, $e->getMessage());
        }
    }

    public function store($data) {
        try {
            if (!isset($data['name']) || !isset($data['description']) || !isset($data['price'])) {
                throw new Exception("Dati mancanti");
            }
            
            $product = new Product($data);
            $product->save();
            
            $this->respond(true, "Prodotto creato con successo", $product);
        } catch (Exception $e) {
            $this->respond(false, $e->getMessage());
        }
    }
}
