<?php
namespace App\Config;
// app/config/database.php (database configuration settings)
// Database configuration settings
const DB_HOST = 'cms-mysql';
const DB_NAME = 'cms';
const DB_USER = 'root';
const DB_PASSWORD = 'secret';

// Data Source Name
const DB_DSN = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';

/**
 * Get a PDO instance.
 *
 * @return \PDO
 */
function getDatabaseConnection() {
    try {
        // Note the leading backslash before PDO to fetch it from the global namespace
        $pdo = new \PDO(DB_DSN, DB_USER, DB_PASSWORD);
        // Set the PDO error mode to exception
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (\PDOException $e) { // Note the leading backslash before PDOException
        die("Database connection failed: " . $e->getMessage());
    }
}