<?php

/**
 * UserModel.php
 */

/**
 * Represents a model for managing user-related data in the database.
 */
class UserModel
{
    /**
     * @var DatabaseWrapper The database wrapper instance for executing queries.
     */
    private $database;
    /**
     * Initializes the UserModel with a DatabaseWrapper instance.
     *
     * @param DatabaseWrapper $database The database wrapper instance.
     */
    public function __construct($database)
    {
        $this->database = $database;
    }
    /**
     * Retrieves the last five users registered in the system.
     *
     * @return array Array of user records.
     */
    public function getLastFiveUsers() {
        $query = "SELECT user_nickname, user_device_count FROM registered_user ORDER BY user_registered_timestamp DESC LIMIT 5";

        // Adjusted to use safeQuery
        $this->database->safeQuery($query);
        return $this->database->safeFetchAllResults();
    }
    /**
     * Retrieves a user from the database by their email address.
     *
     * @param string $email The email address of the user.
     * @return array|null The user record if found, otherwise null.
     */
    public function getUserByEmail($email)
    {
        $query = SqlQuery::queryGetUserByEmail();
        $params = [':user_email' => $email];
        $this->database->safeQuery($query, $params);
        return $this->database->safeFetchArray();
    }
    /**
     * Inserts a new user into the database.
     *
     * @param array $userDetails Details of the user to be inserted.
     * @return int|false The ID of the newly inserted user, or false if the user already exists.
     */
    public function insertNewUser($userDetails) {
        // First, check if the email already exists
        $existingUser = $this->getUserByEmail($userDetails[':user_email']);

        if ($existingUser) {
            // Email already exists, so return a specific indicator or false
            return false; // Or another indicator of your choice
        }

        // If no existing user is found, proceed to insert the new user
        $query = SqlQuery::queryInsertNewUser();
        $this->database->safeQuery($query, $userDetails);
        return $this->database->lastInsertedId();
    }
    /**
     * Checks if a user with the given nickname already exists in the database.
     *
     * @param string $nickname The nickname to check.
     * @return bool True if the nickname already exists, false otherwise.
     */
    public function getUserByNickname($nickname): bool
    {
        $query = "SELECT COUNT(*) as count FROM registered_user WHERE user_nickname = :user_nickname";
        $params = [':user_nickname' => $nickname];
        $this->database->safeQuery($query, $params);
        $result = $this->database->safeFetchArray();
        return $result['count'] > 0;
    }
    /**
     * Retrieves a user from the database by their ID.
     *
     * @param int $userId The ID of the user to retrieve.
     * @return array|null The user record if found, otherwise null.
     */
    public function getUserById($userId)
    {
        $query = "SELECT * FROM registered_user WHERE user_id = :user_id";
        $params = [':user_id' => $userId];
        $this->database->safeQuery($query, $params);
//        echo "User ID: $userId"; exit();
        //return the value of the user_id column from the database; but not fetching the result

        return $this->database->safeFetchArray();
//        echo "User ID: $userId"; exit();
    }
    /**
     * Updates user information in the database.
     *
     * @param array $userData Details of the user to be updated.
     * @return bool True if the update was successful, false otherwise.
     */
    public function updateUser($userData) {
        $params = [
            ':nickname' => $userData['user_nickname'],
            ':email' => $userData['user_email'],
            ':user_id' => $_SESSION['user_id']
        ];

        // Only update the password if a new one is provided
        $passwordSql = '';
        if (!empty($userData['user_password'])) {
            $hashed_password = password_hash($userData['user_password'], PASSWORD_DEFAULT);
            $passwordSql = ', user_hashed_password = :hashed_password';
            $params[':hashed_password'] = $hashed_password;
//            echo "Password: $hashed_password"; exit();
        }

        $query = "UPDATE registered_user SET user_nickname = :nickname, user_email = :email" . $passwordSql . " WHERE user_id = :user_id";
        return $this->database->safeQuery($query, $params);
    }
    /**
     * Deletes a user and related data from the database.
     *
     * @param int $userId The ID of the user to delete.
     * @return bool True if the deletion was successful, false otherwise.
     */
    public function deleteUserAndRelatedData($userId): bool
    {
        try {
            $this->database->beginTransaction();

            // Assuming you have tables for events and devices related to the user
            $this->database->safeQuery("DELETE FROM crypto_device WHERE fk_user_id = :user_id", [':user_id' => $userId]);
            $this->database->safeQuery("DELETE FROM user_event WHERE fk_user_id = :user_id", [':user_id' => $userId]);
            $this->database->safeQuery("DELETE FROM registered_user WHERE user_id = :user_id", [':user_id' => $userId]);

            $this->database->commit();
            return true;
        } catch (Exception $e) {
            $this->database->rollBack();
            return false;
        }
    }

    /**
     * @param $userId
     * @return int|mixed
     * Get the count of devices owned by a user
     * @param $userId
     */
    public function getUserDeviceCount($userId) {
        $query = "SELECT COUNT(*) as device_count FROM crypto_device WHERE fk_user_id = :user_id AND crypto_device_record_visible = TRUE";
        $params = [':user_id' => $userId];
        $this->database->safeQuery($query, $params);
        $result = $this->database->safeFetchArray();
        return $result['device_count'] ?? 0;
    }

    /**
     * @param $userId
     * @return int|mixed
     * Get the count of events owned by a user
     */
    public function getUserEventCount($userId) {
        $query = "SELECT COUNT(*) as event_count FROM event WHERE user_id = :user_id";
        $params = [':user_id' => $userId];
        $this->database->safeQuery($query, $params);
        $result = $this->database->safeFetchArray();
        return $result['event_count'] ?? 0;
    }


}
