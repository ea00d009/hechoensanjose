<?php
/**
 * ==============================================================================
 * CORE: Database (Patrón Singleton)
 * ==============================================================================
 */
class Database {
    private static $instance = null;

    private function __construct() {}
    private function __clone() {}

    public static function getConnection(): PDO {
        if (self::$instance === null) {
            require_once __DIR__ . '/../config/db.php';
            self::$instance = getDBConnection();
        }
        return self::$instance;
    }
}
