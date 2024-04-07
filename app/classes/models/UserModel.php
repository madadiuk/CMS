<?php

/**
 * UserModel.php
 */
class UserModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }
    public function getLastFiveUsers() {
        $query = "SELECT user_nickname, user_device_count FROM registered_user ORDER BY user_registered_timestamp DESC LIMIT 5";

        // Adjusted to use safeQuery
        $this->database->safeQuery($query);
        return $this->database->safeFetchAllResults();
    }


    public function getUserByEmail($email)
    {
        $query = SqlQuery::queryGetUserByEmail();
        $params = [':user_email' => $email];
        $this->database->safeQuery($query, $params);
        return $this->database->safeFetchArray();
    }

    public function insertNewUser($userDetails)
    {
        $query = SqlQuery::queryInsertNewUser();
        $this->database->safeQuery($query, $userDetails);
        return $this->database->lastInsertedId();
    }
}
