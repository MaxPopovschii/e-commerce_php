<?php
namespace App;

use PDO;
use PDOException;

class Database {
    private static $host = 'localhost';
    private static $dbName = '';
    private static $username = 'root';
    private static $password = '';
    private static $connection = null;

    public static function getConnection() {
        if (self::$connection === null) {
            try {
                self::$connection = new PDO(
                    "mysql:host=" . self::$host . ";dbname=" . self::$dbName . ";charset=utf8",
                    self::$username,
                    self::$password,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES => false,
                    ]
                );
            } catch (PDOException $e) {
                die("Errore di connessione al database: " . $e->getMessage());
            }
        }
        return self::$connection;
    }
}
