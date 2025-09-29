<?php

require_once __DIR__ . '/../models/BlogPost.php';

class BlogController
{
    private function getDb() {
        $cfg = require __DIR__ . '/../config/config.php';
        return new mysqli($cfg['db_host'], $cfg['db_user'], $cfg['db_pass'], $cfg['db_name']);
    }

    public function index()
    {
        $db = $this->getDb();
        $result = $db->query("SELECT * FROM blog_posts ORDER BY created_at DESC");
        $posts = [];
        while ($row = $result->fetch_assoc()) {
            $posts[] = $row;
        }
        require __DIR__ . '/../views/blog/index.php';
    }

    public function show($id)
    {
        $db = $this->getDb();
        $stmt = $db->prepare("SELECT * FROM blog_posts WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $post = $result->fetch_assoc();
        require __DIR__ . '/../views/blog/show.php';
    }
}