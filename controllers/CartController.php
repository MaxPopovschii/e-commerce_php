<?php

require_once __DIR__ . '/../models/Cart.php';

class CartController
{
    public function index()
    {
        session_start();
        $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : new Cart();
        require __DIR__ . '/../views/cart/index.php';
    }

    public function add($id)
    {
        session_start();
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = new Cart();
        }
        $_SESSION['cart']->add($id);
        header('Location: ?page=cart');
        exit;
    }

    public function remove($id)
    {
        session_start();
        if (isset($_SESSION['cart'])) {
            $_SESSION['cart']->remove($id);
        }
        header('Location: ?page=cart');
        exit;
    }

    public function clear()
    {
        session_start();
        if (isset($_SESSION['cart'])) {
            $_SESSION['cart']->clear();
        }
        header('Location: ?page=cart');
        exit;
    }
}