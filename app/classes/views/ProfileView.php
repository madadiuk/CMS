<?php
/**
 * ProfileView.php
 *
 *  User profile view
 *  This class is responsible for rendering the user profile page
 *
 *
 * @author M Madadi
 * @copyright De Montfort University
 *
 * @package CryptoShow system CMS
 */

if (!isset($_SESSION['user_id'])) {
    // User is not logged in.
    // Redirect them to the login page.
    header('Location: /login');
    exit;
}
/**
 * Represents the view for the user profile page.
 */
class ProfileView extends UserTemplateView
{
    /**
     * Constructs a new ProfileView object.
     */
    public function __construct()
    {
        parent::__construct();
    }
    /** @var array Stores the profile data. */
    private $profile = []; // Declare the property
    /**
     * Sets the profile data for the view.
     *
     * @param array $profile Profile data.
     */

    public function setProfile($profile) {
        $this->profile = $profile;
    }
    /**
     * Orchestrates the creation of the user profile page.
     * It sets the page title, generates page content, and constructs the final HTML output.
     */
    public function createProfilePage()
    {
        $this->setPageTitle();
        $this->createWebPage();
        $this->createPageContent();
        $this->createFooter();
    }
    /**
     * Retrieves the HTML output generated by the view.
     *
     * @return string HTML output generated by the view.
     */
    public function getHtmlOutput(): string
    {
        return $this->html_page_output;
    }
    /**
     * Sets the page title for the profile page.
     */
    private function setPageTitle()
    {
        $this->page_title = 'CryptoShow System | my profile';
    }
    /**
     * Creates the main content of the profile page.
     */
    protected function createPageContent() {
        $message = '';
        if (isset($_SESSION['profile_message'])) {
            $message .= "<div class='success'>" . $_SESSION['profile_message'] . "</div>";
            unset($_SESSION['profile_message']); // Clear the message after displaying
        }

        if (isset($_SESSION['profile_errors'])) {
            foreach ($_SESSION['profile_errors'] as $error) {
                $message .= "<div class='error'>" . $error . "</div>";
            }
            unset($_SESSION['profile_errors']); // Clear the errors after displaying
        }

        $this->html_page_content = <<<HTMLCONTENT
<style>
        .success {
            color: green;
            border: 1px solid #ddd;
            background-color: #f4fff4;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
        }
        .error {
            color: red;
            font-weight: bold;
            border: 1px solid #ddd;
            background-color: #fff4f4;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
        }
        .delete-button {
            background-color: red;
            color: white;
            margin-top: 20px;
            border: none;
            cursor: pointer;
        }
    </style>
         $message
HTMLCONTENT;

        $profileSection = $this->generateProfileSection();

        $this->html_page_content .= $profileSection; // Append the dynamic events section

        $moreStaticContent = <<<HTMLCONTENT
          
        </div>
      

HTMLCONTENT;
        $this->html_page_content  .= $moreStaticContent;
        $moreStaticContent = <<<HTMLCONTENT

HTMLCONTENT;
        $this->html_page_content  .= $moreStaticContent;

        $moreStaticContent = <<<HTMLCONTENT
        <div class="home-section-separator"></div>
HTMLCONTENT;
        $this->html_page_content  .= $moreStaticContent;
        $this->html_page_output .= $this->html_page_content;

    }

    /**
     * Generates the HTML code for displaying the profile section.
     *
     * @return string HTML code for displaying the profile section.
     */
    private function generateProfileSection(): string
    {
        $profileHtml = "<div class='profile-details-container' style='padding: 20px; display: flex; flex-direction: column; align-items: center;'>";
        $profileHtml .= "<h2 class='Section-Heading'>Profile Details</h2>";

        // Responsive container for profile details
        $profileHtml .= "<div class='home-content-container6' style='width: 100%; margin-top: 20px;'>";
        $profileHtml .= "<div class='list'>";

        // Display current profile details (Read-only)
        $profileHtml .= "<div class='list-item'><strong>Name:</strong> " . htmlspecialchars($this->profile['user_name']) . "</div>";
        $profileHtml .= "<div class='list-item'><strong>User name:</strong> " . htmlspecialchars($this->profile['user_nickname']) . "</div>";
        $profileHtml .= "<div class='list-item'><strong>Number of Devices:</strong> " . htmlspecialchars($this->profile['user_device_count']) . "</div>";
        $profileHtml .= "<div class='list-item'><strong>Number of Events:</strong> " . htmlspecialchars($this->profile['user_event_count']) . "</div>";  // Display the count of events
        $profileHtml .= "<div class='list-item'><strong>Email:</strong> " . htmlspecialchars($this->profile['user_email']) . "</div>";
        $profileHtml .= "<form action='/delete_profile' method='post'>";
        $profileHtml .= "<button type='submit' class='button delete-button' onclick='return confirm(\"Are you sure you want to delete your profile? This action cannot be undone.\");'>Delete Profile</button>";
        $profileHtml .= "</form>";
        $profileHtml .= "</div>"; // End of list container
        // Additional padding for separation before the form
        $profileHtml .= "<div style='padding-top: 20px; width: 100%;'></div>";

        // Edit form for profile details
        $profileHtml .= "<form action='/process_profile_update' method='post' style='width: 100%; margin-top: 20px;'>";
        $profileHtml .= "<input type='hidden' name='csrf_token' value='" . $this->generateCsrfToken() . "'>";

        // Input fields with responsive styling
        $profileHtml .= "<div class='input-container' style='margin-bottom: 10px; display: flex; flex-direction: column;'>";
        $profileHtml .= "<label for='user_nickname'>Username:</label>";
        $profileHtml .= "<input class='input' id='user_nickname' name='user_nickname' type='text' value='" . htmlspecialchars($this->profile['user_nickname']) . "' required></div>";

        $profileHtml .= "<div class='input-container' style='margin-bottom: 10px; display: flex; flex-direction: column;'>";
        $profileHtml .= "<label for='user_email'>Email:</label>";
        $profileHtml .= "<input class='input' id='user_email' name='user_email' type='email' value='" . htmlspecialchars($this->profile['user_email']) . "' required></div>";

        $profileHtml .= "<div class='input-container' style='margin-bottom: 10px; display: flex; flex-direction: column;'>";
        $profileHtml .= "<label for='user_password'>New Password (leave blank if not changing):</label>";
        $profileHtml .= "<input class='input' id='user_password' name='user_password' type='password'></div>";

        $profileHtml .= "<button type='submit' class='button'>Update Profile</button>";
        $profileHtml .= "</form>";
        $profileHtml .= "</div>"; // End of profile details container

        return $profileHtml;
    }

    /**
     * Generates a CSRF token for form submission.
     *
     * @throws \Random\RandomException If an error occurs during token generation.
     * @return string Generated CSRF token.
     */
    private function generateCsrfToken(): string
    {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

}
