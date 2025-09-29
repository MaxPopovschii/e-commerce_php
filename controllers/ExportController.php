<?php

class ExportController
{
    public function productsCsv()
    {
        $cfg = require __DIR__ . '/../config/config.php';
        $db = new mysqli($cfg['db_host'], $cfg['db_user'], $cfg['db_pass'], $cfg['db_name']);
        $result = $db->query("SELECT * FROM products");

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="products.csv"');

        $output = fopen('php://output', 'w');
        fputcsv($output, ['id', 'name', 'category', 'price']);
        while ($row = $result->fetch_assoc()) {
            fputcsv($output, $row);
        }
        fclose($output);
        exit;
    }

    public function ordersCsv()
    {
        $cfg = require __DIR__ . '/../config/config.php';
        $db = new mysqli($cfg['db_host'], $cfg['db_user'], $cfg['db_pass'], $cfg['db_name']);
        $result = $db->query("SELECT * FROM orders");

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="orders.csv"');

        $output = fopen('php://output', 'w');
        fputcsv($output, ['id', 'user_id', 'total', 'status', 'created_at']);
        while ($row = $result->fetch_assoc()) {
            fputcsv($output, $row);
        }
        fclose($output);
        exit;
    }
}