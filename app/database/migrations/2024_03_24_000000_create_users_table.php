<?php
namespace App\Database\Migrations;

// Use namespaces if applicable
class CreateUsersTable {
    public function up() {
        // SQL to create table
        $sql = "CREATE TABLE IF NOT EXISTS `users` (
                    `user_id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    `user_name` VARCHAR(100) NOT NULL,
                    `user_email` VARCHAR(255) UNIQUE NOT NULL,
                    `user_password` VARCHAR(255) NOT NULL,
                    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

        // Execute the SQL to create the table
        // Assume $db is an instance of PDO
        $db->exec($sql);
    }

    public function down() {
        // SQL to drop table
        $sql = "DROP TABLE IF EXISTS `users`;";

        // Execute the SQL to drop the table
        $db->exec($sql);
    }
}
