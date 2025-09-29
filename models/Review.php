<?php

class Review
{
    public $id;
    public $product_id;
    public $user_id;
    public $rating;
    public $comment;
    public $created_at;

    public function __construct($id, $product_id, $user_id, $rating, $comment, $created_at)
    {
        $this->id = $id;
        $this->product_id = $product_id;
        $this->user_id = $user_id;
        $this->rating = $rating;
        $this->comment = $comment;
        $this->created_at = $created_at;
    }
}