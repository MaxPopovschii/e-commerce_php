<?php

require_once __DIR__ . '/../models/Product.php';

class ProductController
{
    private $filePath = __DIR__ . '/../data/products.json';

    private function getDb() {
        $cfg = require __DIR__ . '/../config/config.php';
        $db = @new mysqli($cfg['db_host'], $cfg['db_user'], $cfg['db_pass'], $cfg['db_name']);
        return $db->connect_errno ? null : $db;
    }

    public function index()
    {
        $db = $this->getDb();
        if ($db) {
            $result = $db->query("SELECT * FROM products");
            $products = [];
            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
        } else {
            $products = [];
            foreach (Product::allFromFile($this->filePath) as $p) {
                $products[] = [
                    'id' => $p->id,
                    'name' => $p->name,
                    'category' => $p->category,
                    'price' => $p->price
                ];
            }
        }
        require __DIR__ . '/../views/products/index.php';
    }

    public function show($id)
    {
        $db = $this->getDb();
        if ($db) {
            $stmt = $db->prepare("SELECT * FROM products WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $product = $result->fetch_assoc();
        } else {
            $product = null;
            foreach (Product::allFromFile($this->filePath) as $p) {
                if ($p->id == $id) {
                    $product = [
                        'id' => $p->id,
                        'name' => $p->name,
                        'category' => $p->category,
                        'price' => $p->price
                    ];
                    break;
                }
            }
        }
        require __DIR__ . '/../views/products/show.php';
    }

    public function store($data)
    {
        $db = $this->getDb();
        if ($db) {
            $stmt = $db->prepare("INSERT INTO products (name, category, price) VALUES (?, ?, ?)");
            $stmt->bind_param("ssd", $data['name'], $data['category'], $data['price']);
            $stmt->execute();
        } else {
            $products = Product::allFromFile($this->filePath);
            $id = count($products) ? max(array_column($products, 'id')) + 1 : 1;
            $products[] = new Product($id, $data['name'], $data['category'], $data['price']);
            Product::saveAllToFile($this->filePath, $products);
        }
        header('Location: ?page=products');
        exit;
    }

    public function destroy($id)
    {
        $db = $this->getDb();
        if ($db) {
            $stmt = $db->prepare("DELETE FROM products WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
        } else {
            $products = Product::allFromFile($this->filePath);
            $products = array_filter($products, function($p) use ($id) {
                return $p->id != $id;
            });
            Product::saveAllToFile($this->filePath, $products);
        }
        header('Location: ?page=products');
        exit;
    }
}