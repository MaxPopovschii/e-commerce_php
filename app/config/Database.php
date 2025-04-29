<?php
namespace App\Config;
use mysqli;
use Exception;

class Database {
    private static ?mysqli $connection = null;

    /**
     * Restituisce una connessione singleton al database.
     * @return mysqli
     * @throws Exception
     */
    public static function getConnection(): mysqli {
        if (self::$connection === null) {
            $host = getenv('DB_HOST') ?: 'localhost';
            $dbName = getenv('DB_NAME') ?: 'ecofootprint';
            $username = getenv('DB_USER') ?: 'max';
            $password = getenv('DB_PASSWORD') ?: 'Dom200598!';

            try {
                self::$connection = new mysqli($host, $username, $password, $dbName);

                if (self::$connection->connect_error) {
                    throw new Exception("Errore di connessione al database: " . self::$connection->connect_error);
                }

                // Imposta la codifica UTF-8
                self::$connection->set_charset("utf8");
            } catch (mysqli_sql_exception $e) {
                throw new Exception("Errore durante la connessione al database: " . $e->getMessage());
            }
        }

        return self::$connection;
    }
}
