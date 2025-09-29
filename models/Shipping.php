<?php

class Shipping
{
    public $id;
    public $name;
    public $price;
    public $estimated_days;

    public function __construct($id, $name, $price, $estimated_days)
    {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->estimated_days = $estimated_days;
    }
}