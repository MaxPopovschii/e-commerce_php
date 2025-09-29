<?php

require_once __DIR__ . '/../models/Wishlist.php';

class WishlistController
{
    private $filePath = __DIR__ . '/../data/wishlist.json';

    private function getDb() {
        $cfg = require __DIR__ . '/../config/config.php';
        $db = @new mysqli($cfg['db_host'], $cfg['db_user'], $cfg['db_pass'], $cfg['db_name']);
        return $db->connect_errno ? null : $db;
    }

    public function index()
    {
        $db = $this->getDb();
        $user_id = $_SESSION['user']['id'];
        if ($db) {
            $stmt = $db->prepare("SELECT product_id FROM wishlist WHERE user_id = ?");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $products = [];
            while ($row = $result->fetch_assoc()) {
                $products[] = $row['product_id'];
            }
        } else {
            $products = [];
            foreach (Wishlist::allFromFile($this->filePath) as $w) {
                if ($w->user_id == $user_id) {
                    $products = $w->product_ids;
                    break;
                }
            }
        }
        require __DIR__ . '/../views/wishlist/index.php';
    }

    public function add($product_id)
    {
        if (!isset($_SESSION['user'])) {
            header('Location: ?page=users&action=login');
            exit;
        }
        $db = $this->getDb();
        $user_id = $_SESSION['user']['id'];
        if ($db) {
            $stmt = $db->prepare("INSERT IGNORE INTO wishlist (user_id, product_id) VALUES (?, ?)");
            $stmt->bind_param("ii", $user_id, $product_id);
            $stmt->execute();
        } else {
            $wishlist = null;
            $wishlists = Wishlist::allFromFile($this->filePath);
            foreach ($wishlists as $w) {
                if ($w->user_id == $user_id) {
                    $wishlist = $w;
                    break;
                }
            }
            if (!$wishlist) {
                $wishlist = new Wishlist();
                $wishlist->user_id = $user_id;
                $wishlist->product_ids = [];
                $wishlists[] = $wishlist;
            }
            if (!in_array($product_id, $wishlist->product_ids)) {
                $wishlist->product_ids[] = $product_id;
            }
            file_put_contents($this->filePath, json_encode($wishlists));
        }
        header('Location: ?page=wishlist');
        exit;
    }

    public function remove($product_id)
    {
        if (!isset($_SESSION['user'])) {
            header('Location: ?page=users&action=login');
            exit;
        }
        $db = $this->getDb();
        $user_id = $_SESSION['user']['id'];
        if ($db) {
            $stmt = $db->prepare("DELETE FROM wishlist WHERE user_id = ? AND product_id = ?");
            $stmt->bind_param("ii", $user_id, $product_id);
            $stmt->execute();
        } else {
            $wishlists = Wishlist::allFromFile($this->filePath);
            foreach ($wishlists as $index => $w) {
                if ($w->user_id == $user_id) {
                    $wishlist = $w;
                    unset($wishlists[$index]);
                    break;
                }
            }
            if (isset($wishlist)) {
                $wishlist->product_ids = array_values(array_diff($wishlist->product_ids, [$product_id]));
                if (!empty($wishlist->product_ids)) {
                    $wishlists[] = $wishlist;
                }
                file_put_contents($this->filePath, json_encode($wishlists));
            }
        }
        header('Location: ?page=wishlist');
        exit;
    }
}