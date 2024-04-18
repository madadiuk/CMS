<?php
/**
 * Validation.php
 *  This class is used to validate user input
 *  It is used in the UserController class
 *  to validate user registration data before inserting into the database
 *  M Madadi
 * De Montfort University
 *
 */

/**
 * Represents a validator for user input.
 * Used primarily for user registration data validation.
 */
class Validation
{
    /**
     * Checks if the provided username is valid.
     *
     * @param string $username The username to validate.
     * @return string An error message if validation fails, otherwise an empty string.
     */
    public function isUsernameValid($username): string
    {
        if (empty($username)) {
            return 'Username is required';
        } else if (strlen($username) < 5 || strlen($username) > 20) {
            return 'Username must be between 5 and 20 characters';
        }
        return '';
    }
    /**
     * Checks if the provided full name is valid.
     *
     * @param string $fullName The full name to validate.
     * @return string An error message if validation fails, otherwise an empty string.
     */
    public function isFullNameValid($fullName): string
    {
        if (empty($fullName)) {
            return 'Full name is required';
        } else if (strlen($fullName) < 5 || strlen($fullName) > 50) {
            return 'Full name must be between 5 and 50 characters';
        }
        return '';
    }
    /**
     * Checks if the provided email address is valid.
     *
     * @param string $email The email address to validate.
     * @return string An error message if validation fails, otherwise an empty string.
     */
    public function isEmailValid($email): string
    {
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return 'Valid email is required';
        }
        return '';
    }
    /**
     * Checks if the provided password is valid.
     *
     * @param string $password The password to validate.
     * @return string An error message if validation fails, otherwise an empty string.
     */
    public function isPasswordValid($password): string
    {
        if (empty($password)) {
            return 'Password is required';
        } else if (strlen($password) < 8) {
            return 'Password must be at least 8 characters long';
        } else if (!preg_match('/[A-Z]/', $password)) {
            return 'Password must include at least one uppercase letter';
        } else if (!preg_match('/[a-z]/', $password)) {
            return 'Password must include at least one lowercase letter';
        } else if (!preg_match('/[0-9]/', $password)) {
            return 'Password must include at least one number';
        }
        return '';
    }
    /**
     * Validates user profile data.
     *
     * @param array $data An array containing user profile data.
     * @return array An array of error messages for any validation failures.
     */
    public function validateUserProfile($data): array
    {
        $validation = new Validation();
        $errors = [];
        if ($error = $validation->isUsernameValid($data['user_nickname'])) {
            $errors[] = $error;
        }
        if ($error = $validation->isEmailValid($data['user_email'])) {
            $errors[] = $error;
        }
        if (!empty($data['user_password']) && $error = $validation->isPasswordValid($data['user_password'])) {
            $errors[] = $error;
        }
        return $errors;
    }


}
