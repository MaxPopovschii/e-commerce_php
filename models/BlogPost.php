<?php

class BlogPost
{
    public $id;
    public $title;
    public $content;
    public $author;
    public $created_at;

    public function __construct($id, $title, $content, $author, $created_at)
    {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
        $this->author = $author;
        $this->created_at = $created_at;
    }
}