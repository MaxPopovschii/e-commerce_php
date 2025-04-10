<?php
namespace Config;

class Database {
    private static $host;
    private static $dbName;
    private static $username;
    private static $password;
    private static $connection = null;

    public static function loadEnv() {
        // Carica le variabili d'ambiente
        self::$host = getenv('DB_HOST');
        self::$dbName = getenv('DB_NAME');
        self::$username = getenv('DB_USER');
        self::$password = getenv('DB_PASSWORD');

    }

    public static function getConnection() {
        if (self::$connection === null) {
            self::loadEnv();

            self::$connection = new \mysqli(self::$host, self::$username, self::$password, self::$dbName);

            if (self::$connection->connect_error) {
                die("Errore di connessione al database: " . self::$connection->connect_error);
            }

            self::$connection->set_charset("utf8");
        }
        return self::$connection;
    }
}
