<?php

class Product
{
    public $id;
    public $name;
    public $category;
    public $price;

    public function __construct($id, $name, $category, $price)
    {
        $this->id = $id;
        $this->name = $name;
        $this->category = $category;
        $this->price = $price;
    }

    public static function allFromFile($filepath)
    {
        if (!file_exists($filepath)) return [];
        $json = file_get_contents($filepath);
        $data = json_decode($json, true) ?? [];
        $products = [];
        foreach ($data as $row) {
            $products[] = new Product($row['id'], $row['name'], $row['category'], $row['price']);
        }
        return $products;
    }

    public static function saveAllToFile($filepath, $products)
    {
        $data = [];
        foreach ($products as $p) {
            $data[] = [
                'id' => $p->id,
                'name' => $p->name,
                'category' => $p->category,
                'price' => $p->price
            ];
        }
        file_put_contents($filepath, json_encode($data, JSON_PRETTY_PRINT));
    }
}