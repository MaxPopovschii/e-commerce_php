<?php
namespace App\Controllers;

use App\Models\Product;
use Exception;

class ProductController {
    public function index() {
        try {
            $products = Product::all();
            echo json_encode(["success" => true, "data" => $products]);
        } catch (Exception $e) {
            echo json_encode(["success" => false, "message" => $e->getMessage()]);
        }
    }

    public function show($id) {
        try {
            $product = Product::find($id);
            if ($product) {
                echo json_encode(["success" => true, "data" => $product]);
            } else {
                echo json_encode(["success" => false, "message" => "Prodotto non trovato"]);
            }
        } catch (Exception $e) {
            echo json_encode(["success" => false, "message" => $e->getMessage()]);
        }
    }

    public function store($data) {
        try {
            if (!isset($data['name']) || !isset($data['description']) || !isset($data['price'])) {
                throw new Exception("Dati mancanti");
            }
            
            $product = new Product($data);
            $product->save();
            
            echo json_encode(["success" => true, "message" => "Prodotto creato con successo", "data" => $product]);
        } catch (Exception $e) {
            echo json_encode(["success" => false, "message" => $e->getMessage()]);
        }
    }
}
?>