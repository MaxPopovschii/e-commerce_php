<?php

class Backup
{
    public $filename;
    public $created_at;

    public function __construct($filename, $created_at)
    {
        $this->filename = $filename;
        $this->created_at = $created_at;
    }
}