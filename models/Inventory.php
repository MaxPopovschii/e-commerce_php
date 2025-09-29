<?php

class Inventory
{
    public $product_id;
    public $quantity;

    public function __construct($product_id, $quantity)
    {
        $this->product_id = $product_id;
        $this->quantity = $quantity;
    }
}