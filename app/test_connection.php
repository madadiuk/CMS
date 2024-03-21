<?php

require_once 'config/database.php'; // Adjust the path as necessary to match your project structure

use App\Config;

try {
    $pdo = Config\getDatabaseConnection();
    echo "Database connection established successfully.";
} catch (\PDOException $e) {
    echo "Failed to connect to the database: " . $e->getMessage();
}
