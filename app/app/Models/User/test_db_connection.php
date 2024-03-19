<?php
require_once __DIR__ . '/../../../Autoloader.php';

use App\Models\UserModel;

// Attempt to instantiate the UserModel which should connect to the database
$userModel = new UserModel();

// If no exceptions are thrown, it's a good indicator that your connection is valid.
echo "Database connection established successfully.";