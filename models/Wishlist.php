<?php


class Wishlist
{
    public $user_id;
    public $product_ids;

    public function __construct($user_id, $product_ids = [])
    {
        $this->user_id = $user_id;
        $this->product_ids = $product_ids;
    }

    public static function allFromFile($filepath)
    {
        if (!file_exists($filepath)) return [];
        $json = file_get_contents($filepath);
        $data = json_decode($json, true) ?? [];
        $wishlists = [];
        foreach ($data as $row) {
            $wishlists[] = new Wishlist($row['user_id'], $row['product_ids']);
        }
        return $wishlists;
    }

    public static function saveAllToFile($filepath, $wishlists)
    {
        $data = [];
        foreach ($wishlists as $w) {
            $data[] = [
                'user_id' => $w->user_id,
                'product_ids' => $w->product_ids
            ];
        }
        file_put_contents($filepath, json_encode($data, JSON_PRETTY_PRINT));
    }
}