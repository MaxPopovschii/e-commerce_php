<?php


class Order
{
    public $id;
    public $user_id;
    public $total;
    public $status;
    public $created_at;

    public function __construct($id, $user_id, $total, $status, $created_at)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->total = $total;
        $this->status = $status;
        $this->created_at = $created_at;
    }

    public static function allFromFile($filepath)
    {
        if (!file_exists($filepath)) return [];
        $json = file_get_contents($filepath);
        $data = json_decode($json, true) ?? [];
        $orders = [];
        foreach ($data as $row) {
            $orders[] = new Order($row['id'], $row['user_id'], $row['total'], $row['status'], $row['created_at']);
        }
        return $orders;
    }

    public static function saveAllToFile($filepath, $orders)
    {
        $data = [];
        foreach ($orders as $o) {
            $data[] = [
                'id' => $o->id,
                'user_id' => $o->user_id,
                'total' => $o->total,
                'status' => $o->status,
                'created_at' => $o->created_at
            ];
        }
        file_put_contents($filepath, json_encode($data, JSON_PRETTY_PRINT));
    }
}