<?php

class Cart
{
    public $items = [];

    public function add($productId, $quantity = 1)
    {
        if (isset($this->items[$productId])) {
            $this->items[$productId] += $quantity;
        } else {
            $this->items[$productId] = $quantity;
        }
    }

    public function remove($productId)
    {
        unset($this->items[$productId]);
    }

    public function clear()
    {
        $this->items = [];
    }
}