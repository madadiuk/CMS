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
