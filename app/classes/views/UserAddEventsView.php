<?php
/**
 * UserEventsView.php
 *
 * UserEventsView class for the user events page view
 * Sessions: PHP web application to demonstrate how to access a database securely
 * This class provides the HTML content for the user events page
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
 * Represents the view for adding events by the user.
 */
class UserAddEventsView extends UserTemplateView
{
    /**
     * Constructs a new UserAddEventsView object.
     */
    public function __construct()
    {
        parent::__construct();
    }
    /** @var array Stores the user's event data. */
    private $userAddEvent= []; // Declare the property
    /**
     * Sets the user's event data.
     *
     * @param array $userAddEvent User's event data.
     */
    public function setUserAddEvent($userAddEvent) {
        $this->userAddEvent = $userAddEvent;
    }
    /**
     * Orchestrates the creation of the user event addition page.
     */
    public function createUserAddEventPage()
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
     * Sets the page title.
     */
    private function setPageTitle()
    {
        $this->page_title = 'CryptoShow System | New Event';
    }
    /**
     * Creates the page content.
     */
    protected function createPageContent() {
        $message = '';
        if (isset($_SESSION['profile_message'])) {
            $message .= "<div class='notification success'>" . $_SESSION['profile_message'] . "</div>";
            unset($_SESSION['profile_message']); // Clear the message after displaying
        }

        if (isset($_SESSION['profile_errors'])) {
            foreach ($_SESSION['profile_errors'] as $error) {
                $message .= "<div class='notification error'>" . $error . "</div>";
            }
            unset($_SESSION['profile_errors']); // Clear the errors after displaying
        }

        $this->html_page_content = <<<HTMLCONTENT
    <style>
        .add-event-form-container {
            max-width: 600px;
            padding: 2rem;
            margin: 2rem auto;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 8px;
            background-color: #fff;
        }
        
        .form-group {
            margin-bottom: 1rem;
        }
        
        .label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--dl-color-primary-500);
        }
        
        .form-control {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        
        .btn-primary {
            background-color: var(--dl-color-primary-500);
            color: white;
            padding: 1rem 1.5rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        
        .btn-primary:hover {
            background-color: var(--dl-color-primary-700);
        }
    </style>
         $message
HTMLCONTENT;

        $userEventAddSection = $this->generateUserAddEventSection();

        $this->html_page_content .= $userEventAddSection; // Append the dynamic events section

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
     * Generates the HTML code for the user event addition section.
     *
     * @return string HTML code for the user event addition section.
     */
    private function generateUserAddEventSection(): string {
        // CSRF protection token
        $csrfToken = $this->generateCsrfToken();
        $formHtml = <<<HTML
    <div class='add-event-form-container' style='margin-top: 20px;'>
        <form method='post' action='/processAddUserEvent' class='events-form' style='width: 100%; max-width: 600px; margin: auto;'>
            <input type='hidden' name='csrf_token' value='{$csrfToken}'>
            <div class='form-group'>
                <label for='eventName'>Event Name:</label>
                <input type='text' id='eventName' name='event_name' required class='form-control'>
            </div>
            <div class='form-group'>
                <label for='eventDate'>Event Date:</label>
                <input type='date' id='eventDate' name='event_date' required class='form-control'>
            </div>
            <div class='form-group'>
                <label for='eventVenue'>Venue:</label>
                <input type='text' id='eventVenue' name='event_venue' required class='form-control'>
            </div>
            <button type='submit' class='btn btn-primary'>Add Event</button>
        </form>
    </div>
HTML;
        return $formHtml;
    }

    /**
     * Generates a CSRF token for the form.
     *
     * @return string CSRF token.
     */
    private function generateCsrfToken(): string
    {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
}
