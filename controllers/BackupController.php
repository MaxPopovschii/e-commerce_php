<?php

require_once __DIR__ . '/../models/Backup.php';

class BackupController
{
    public function index()
    {
        $backupDir = __DIR__ . '/../backups/';
        $files = glob($backupDir . '*.sql');
        $backups = [];
        foreach ($files as $file) {
            $backups[] = new Backup(basename($file), date("Y-m-d H:i:s", filemtime($file)));
        }
        require __DIR__ . '/../views/backup/index.php';
    }

    public function create()
    {
        $cfg = require __DIR__ . '/../config/config.php';
        $filename = 'backup_' . date('Ymd_His') . '.sql';
        $backupDir = __DIR__ . '/../backups/';
        if (!is_dir($backupDir)) {
            mkdir($backupDir, 0755, true);
        }
        $cmd = sprintf(
            'mysqldump -h%s -u%s -p%s %s > %s',
            escapeshellarg($cfg['db_host']),
            escapeshellarg($cfg['db_user']),
            escapeshellarg($cfg['db_pass']),
            escapeshellarg($cfg['db_name']),
            escapeshellarg($backupDir . $filename)
        );
        system($cmd);
        header('Location: ?page=backup');
        exit;
    }

    public function download($filename)
    {
        $backupDir = __DIR__ . '/../backups/';
        $filepath = $backupDir . basename($filename);
        if (file_exists($filepath)) {
            header('Content-Type: application/sql');
            header('Content-Disposition: attachment; filename="' . basename($filepath) . '"');
            readfile($filepath);
            exit;
        } else {
            echo "File non trovato.";
        }
    }
}