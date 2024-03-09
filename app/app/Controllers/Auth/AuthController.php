<?php

namespace App\Controllers\Auth;

use App\Models\UserModel;
use App\Helpers\ViewHelper; // Import the ViewHelper

class AuthController {
    public function register(): void
    {
        // Assume data is received from a form
        $userName = $_POST['username'] ?? null;
        $userEmail = $_POST['email'] ?? null;
        $userPassword = $_POST['password'] ?? null;

        if ($userName && $userEmail && $userPassword) {
            $userModel = new UserModel();
            $userId = $userModel->addUser($userName, $userEmail, $userPassword);

            // Use ViewHelper to render the view on successful registration
            ViewHelper::renderView('main/auth/register.php', ['success' => true, 'userId' => $userId]);
        } else {
            // Use ViewHelper to render the view with an error message if validation fails
            ViewHelper::renderView('main/auth/register.php', ['error' => 'Please provide all required fields.']);
        }
    }
}
