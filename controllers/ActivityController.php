<?php

require_once __DIR__ . '/../models/ActivityLog.php';

class ActivityLogController
{
    private function getDb() {
        $cfg = require __DIR__ . '/../config/config.php';
        return new mysqli($cfg['db_host'], $cfg['db_user'], $cfg['db_pass'], $cfg['db_name']);
    }

    public function index()
    {
        $db = $this->getDb();
        $result = $db->query("SELECT l.*, u.username FROM activity_log l LEFT JOIN users u ON l.user_id = u.id ORDER BY l.created_at DESC LIMIT 100");
        $logs = [];
        while ($row = $result->fetch_assoc()) {
            $logs[] = $row;
        }
        require __DIR__ . '/../views/activitylog/index.php';
    }

    public static function log($user_id, $action, $details)
    {
        $cfg = require __DIR__ . '/../config/config.php';
        $db = new mysqli($cfg['db_host'], $cfg['db_user'], $cfg['db_pass'], $cfg['db_name']);
        $stmt = $db->prepare("INSERT INTO activity_log (user_id, action, details) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $user_id, $action, $details);
        $stmt->execute();
    }
}