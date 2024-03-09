<?php
// app/migrate.php (the migration script)
require_once __DIR__ . '/Autoloader.php';

use App\Models\UserModel;

// Create an instance of UserModel which will handle table creation
$userModel = new UserModel();

// Call the method to create the table if it doesn't exist
$userModel->ensureTableExists();

echo "Migration completed successfully.\n";
