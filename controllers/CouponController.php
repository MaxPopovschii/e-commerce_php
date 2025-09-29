<?php

require_once __DIR__ . '/../models/Coupon.php';

class CouponController
{
    private function getDb() {
        $cfg = require __DIR__ . '/../config/config.php';
        return new mysqli($cfg['db_host'], $cfg['db_user'], $cfg['db_pass'], $cfg['db_name']);
    }

    public function apply($code)
    {
        session_start();
        $db = $this->getDb();
        $stmt = $db->prepare("SELECT * FROM coupons WHERE code = ? AND active = 1");
        $stmt->bind_param("s", $code);
        $stmt->execute();
        $result = $stmt->get_result();
        $coupon = $result->fetch_assoc();
        if ($coupon) {
            $_SESSION['coupon'] = $coupon;
            $message = "Coupon applicato!";
        } else {
            $message = "Coupon non valido!";
        }
        require __DIR__ . '/../views/cart/index.php';
    }

    public function remove()
    {
        session_start();
        unset($_SESSION['coupon']);
        require __DIR__ . '/../views/cart/index.php';
    }
}