<?php

namespace App\Models;

use App\Config; // This will use the namespace where your getDatabaseConnection function is located

class UserModel {
    protected $pdo;

    public function __construct() {
        // Use the getDatabaseConnection function instead of creating a new PDO instance directly
        $this->pdo = Config\getDatabaseConnection();
    }

    public function ensureTableExists() {
        $sql = "
        CREATE TABLE IF NOT EXISTS `users` (
            `user_id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            `user_name` VARCHAR(100) NOT NULL,
            `user_email` VARCHAR(255) UNIQUE NOT NULL,
            `user_password` VARCHAR(255) NOT NULL,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ";

        try {
            $this->pdo->exec($sql);
            echo "Table `users` created successfully.";
        } catch (\PDOException $e) {
            die("Could not create table `users`: " . $e->getMessage());
        }
    }

    // Example CRUD operation: Add a new user
    public function addUser($userName, $userEmail, $userPassword) {
        $sql = "INSERT INTO `users` (`user_name`, `user_email`, `user_password`) VALUES (?, ?, ?)";

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$userName, $userEmail, $userPassword]);
            return $this->pdo->lastInsertId();
        } catch (\PDOException $e) {
            die("Could not add new user: " . $e->getMessage());
        }
    }

    // Other CRUD operations here...
    public function getUserById($userId) {
        $sql = "SELECT * FROM `users` WHERE `user_id` = ?";
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$userId]);
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            die("Could not retrieve user: " . $e->getMessage());
        }
    }

    public function updateUser($userId, $userName, $userEmail, $userPassword) {
        $sql = "UPDATE `users` SET `user_name` = ?, `user_email` = ?, `user_password` = ? WHERE `user_id` = ?";
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$userName, $userEmail, $userPassword, $userId]);
            return $stmt->rowCount(); // Return the number of affected rows
        } catch (\PDOException $e) {
            die("Could not update user: " . $e->getMessage());
        }
    }

    public function deleteUser($userId) {
        $sql = "DELETE FROM `users` WHERE `user_id` = ?";
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$userId]);
            return $stmt->rowCount(); // Return the number of affected rows
        } catch (\PDOException $e) {
            die("Could not delete user: " . $e->getMessage());
        }
    }

    public function getAllUsers() {
        $sql = "SELECT * FROM `users`";
        try {
            $stmt = $this->pdo->query($sql);
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            die("Could not retrieve users: " . $e->getMessage());
        }
    }

}
