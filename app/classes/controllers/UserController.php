<?php
/**
 * UserController.php
 */
/**
 * Manages user-related actions and interactions between the model and view layers for user management within the application.
 */
class UserController extends ControllerAbstract
{
    private $userModel;

    // This method acts as a constructor.
    private $view;
    /**
     * Constructs the UserController with necessary dependencies.
     * @param $userModel The model handling user data operations.
     * @param $view The view rendering the user interface.
     */
    public function __construct($userModel, $view)
    {
        parent::__construct(); // Call the parent constructor
        $this->userModel = $userModel;
        $this->view = $view;
    }
    /**
     * Displays the registration form using the view component.
     */
    public function showRegistrationForm()
    {
        // This method should instruct the view to display the registration form.
        $this->view->createRegisterPage();
        echo $this->view->getHtmlOutput(); // Assuming getHtmlOutput returns the HTML string.
    }
    /**
     * Displays the login form using the view component.
     */
    public function showLoginForm()
    {
        // This method should instruct the view to display the registration form.
        $this->view->createLoginPage();
        echo $this->view->getHtmlOutput(); // Assuming getHtmlOutput returns the HTML string.
    }

    /**
     * Registers a new user based on provided user data, handling validation and database insertion.
     * @param $userData Array containing user registration data.
     */
    public function registerUser($userData) {
        // Basic validation
        $errors = [];
        $validation = new Validation();

        // Define the validation methods for each field
        $validationRules = [
            'username' => 'isUsernameValid',
            'fullName' => 'isFullNameValid',
            'email' => 'isEmailValid',
            'password' => 'isPasswordValid',
        ];
        foreach ($validationRules as $field => $method) {
            if (isset($userData[$field])) {
                $error = $validation->$method($userData[$field]);
                if ($error) {
                    $errors[] = $error;
                }
            } else {
                $errors[] = "Field '{$field}' is missing.";
            }
        }
        // Check if the username already exists
        $usernameExists = $this->userModel->getUserByNickname($userData['username']);
        if ($usernameExists) {
            $errors[] = 'This username is already taken. Please choose another.';
            $this->redirectBackWithError($errors, $userData);
            return;
        }

        if (!empty($errors)) {
            // Assuming you have a method to handle redirecting back with errors
            $this->redirectBackWithError($errors, $userData);
            return;
        }

        $hashed_password = password_hash($userData['password'], PASSWORD_DEFAULT);
        $userDetails = [
            ':user_nickname' => $userData['username'],
            ':user_name' => $userData['fullName'],
            ':user_email' => $userData['email'],
            ':user_hashed_password' => $hashed_password,
            ':user_device_count' => 0
        ];

        // Insert the user into the database...
        $result = $this->userModel->insertNewUser($userDetails);

        if ($result === false) {
            // Email already exists, handle accordingly
            $errors[] = 'This email is already registered. Please use another email.';
            $this->redirectBackWithError($errors, $userData);
        } elseif ($result) {
            // Success, redirect to profile or another success page
            $_SESSION['user_id'] = $result;  // Set the user's ID in the session
            header('Location: /profile');
            exit;
        } else {
            // General error handling
            $errors[] = 'An error occurred during registration.';
            $this->redirectBackWithError($errors, $userData);
        }
    }

    /**
     * @param $errors
     * @param $formData
     * @return void Redirects back to the registration page with an error message and the form data.
     */
    private function redirectBackWithError($errors, $formData) {
        // Store errors and form data in session for re-population and display
        $_SESSION['registration_errors'] = $errors;
//        var_dump($_SESSION);
        $_SESSION['form_data'] = $formData;
        header('Location: /register');
        exit;
    }

    /**
     * @param $userData
     * @return void Redirects to the profile page if login is successful, otherwise redirects back to the login page with an error message.
     */
    public function loginUser($userData)
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $errors = [];
        $validation = new Validation();

        // Validate the input
        $emailError = $validation->isEmailValid($userData['email']);
        if (!empty($emailError)) {
            $errors[] = $emailError;
        }
        $passwordError = $validation->isPasswordValid($userData['password']);
        if (!empty($passwordError)) {
            $errors[] = $passwordError;
        }

        // Check for errors, if there are any, redirect back
        if (!empty($errors)) {
            $this->redirectBackWithErrorLogin($errors, $userData);
            return;
        }

        // Check if the user exists
        $user = $this->userModel->getUserByEmail($userData['email']);

        // Verify password and create session if correct
        if ($user && password_verify($userData['password'], $user['user_hashed_password'])) {
            $_SESSION['user_id'] = $user['user_id'];
            header('Location: /profile');
            exit;
        } else {
            // User does not exist or password is wrong
            $errors[] = 'Login failed: Incorrect email or password.';
            $this->redirectBackWithErrorLogin($errors, $userData);
        }
    }
    private function redirectBackWithErrorLogin($errors, $formData) {
        $_SESSION['login_errors'] = $errors;
        $_SESSION['form_data'] = $formData; // Preserving email only for security
        header('Location: /login');
        exit;
    }

    public function createHtmlOutput()
    {
        // This method should instruct the view to create the HTML output.
    }

    /**
     * Displays the user profile page using the view component, showing user details.
     */
    public function showProfile() {
        $userId = $_SESSION['user_id'];
        $userDetails = $this->userModel->getUserById($userId);
        if ($userDetails) {
            $deviceCount = $this->userModel->getUserDeviceCount($userId);  // Get the count of devices
            $eventCount = $this->userModel->getUserEventCount($userId);    // Get the count of events
            $userDetails['user_device_count'] = $deviceCount;
            $userDetails['user_event_count'] = $eventCount;
            $this->view->setProfile($userDetails);
            $this->view->createProfilePage();
            echo $this->view->getHtmlOutput();
        } else {
            echo 'User not found.';
        }
    }


    /**
     * @param $formData
     * @return void Updates the user profile based on the provided form data.
     */

    public function updateUserProfile($formData)
    {
        $validation = new Validation();
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        // Check CSRF token validity
        if (!isset($_SESSION['csrf_token']) || $_SESSION['csrf_token'] !== $formData['csrf_token']) {
            die('CSRF token mismatch.');
        }

        $errors = (new Validation())->validateUserProfile($formData);
        if (!empty($errors)) {
            $_SESSION['profile_errors'] = $errors;
            header('Location: /profile');
            exit;
        }

        $result = $this->userModel->updateUser($formData);
        if ($result) {
            $_SESSION['profile_message'] = 'Profile successfully updated.';
        } else {
            $_SESSION['profile_errors'] = ['Failed to update profile.'];
        }

        header('Location: /profile');
        exit;
    }

    /**
     * @return void Deletes the user profile and related data from the database.
     */
    public function deleteUserProfile()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $userId = $_SESSION['user_id'];
        if ($this->userModel->deleteUserAndRelatedData($userId)) {
            session_destroy();
            session_start(); // restart the session to set message
            $_SESSION['success_message'] = 'Your account has been successfully deleted.';
            header('Location: /login');
            exit;
        } else {
            $_SESSION['profile_errors'] = ['Failed to delete profile.'];
            header('Location: /profile');
            exit;
        }
    }

}
