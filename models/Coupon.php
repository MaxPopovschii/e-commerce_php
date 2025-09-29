<?php

class Coupon
{
    public $id;
    public $code;
    public $discount; // percentuale o valore fisso
    public $active;

    public function __construct($id, $code, $discount, $active = true)
    {
        $this->id = $id;
        $this->code = $code;
        $this->discount = $discount;
        $this->active = $active;
    }
}