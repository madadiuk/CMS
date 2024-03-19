<?php

namespace App\Controllers;

use App\Models\UserModel;

class UserController {
    protected $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    public function createUser($userName, $userEmail, $userPassword) {
        // Assuming $userName, $userEmail, $userPassword are obtained from User input
        $userId = $this->userModel->addUser($userName, $userEmail, $userPassword);
        echo "User created successfully with ID: " . $userId;
        // Redirect or render a view as needed
    }

    public function showUser($userId) {
        // Assuming $userId is obtained from a URL parameter or form input
        $user = $this->userModel->getUserById($userId);
        // Pass $User to a view for rendering or return as JSON for API responses
    }

    public function updateUser($userId, $userName, $userEmail, $userPassword) {
        // Assuming these are obtained from User input
        $result = $this->userModel->updateUser($userId, $userName, $userEmail, $userPassword);
        echo "Updated $result User(s).";
        // Redirect or render a view as needed
    }

    public function deleteUser($userId) {
        // Assuming $userId is obtained from a URL parameter or form input
        $result = $this->userModel->deleteUser($userId);
        echo "Deleted $result User(s).";
        // Redirect or render a view as needed
    }

    public function listUsers() {
        $users = $this->userModel->getAllUsers();
        // Pass $users to a view for rendering or return as JSON for API responses
    }
}
