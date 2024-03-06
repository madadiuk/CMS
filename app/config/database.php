<?php

// Database configuration settings
define('DB_HOST', 'localhost');
define('DB_NAME', 'cryptoshow_db');
define('DB_USER', 'cryptoshowuser');
define('DB_PASSWORD', 'cryptoshowpass');

// Data Source Name
define('DB_DSN', 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4');

// Get a PDO instance
function getDatabaseConnection() {
    try {
        $pdo = new PDO(DB_DSN, DB_USER, DB_PASSWORD);
        // Set the PDO error mode to exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("Database connection failed: " . $e->getMessage());
    }
}
