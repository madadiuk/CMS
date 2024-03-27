<?php
/**
 * UserController.php
 */

class UserController extends ControllerAbstract
{
    private $userModel;

    // This method acts as a constructor.
    public function __construct(UserModel $userModel)
    {
        parent::__construct(); // Call the parent constructor
        $this->userModel = $userModel;
    }

    // Example method for user registration
    public function registerUser($userData)
    {
        // Assume $userData contains all necessary user data
        $registrationResult = $this->userModel->insertNewUser($userData);

        if ($registrationResult) {
            // Registration successful
            $this->createSuccessHtmlOutput();
        } else {
            // Registration failed
            $this->createErrorHtmlOutput();
        }
    }

    // Example method for user login
    public function loginUser($email, $password)
    {
        $user = $this->userModel->getUserByEmail($email);

        if ($user && password_verify($password, $user['user_hashed_password'])) {
            // Login successful
            $this->createLoginSuccessHtmlOutput($user);
        } else {
            // Login failed
            $this->createLoginErrorHtmlOutput();
        }
    }

    protected function createHtmlOutput()
    {
        // Implementation depends on the specific action (e.g., registration, login)
    }

    private function createSuccessHtmlOutput()
    {
        // Create HTML output for successful registration
    }

    private function createErrorHtmlOutput()
    {
        // Create HTML output for failed registration
    }

    private function createLoginSuccessHtmlOutput($user)
    {
        // Create HTML output for successful login, possibly including user-specific data
    }

    private function createLoginErrorHtmlOutput()
    {
        // Create HTML output for failed login
    }
}
