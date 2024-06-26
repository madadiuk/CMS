<?php
/**
 * IndexView.php
 *
 * Sessions: PHP web application to demonstrate how databases
 * are accessed securely
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
 * Represents the view for adding a new device.
 */
class AddDeviceView extends UserTemplateView
{
    /**
     * Constructs a new AddDeviceView object.
     */
    public function __construct()
    {
        parent::__construct();
    }
    private $AddDevices = []; // Declare the property

    /**
     * Sets the data related to adding devices.
     *
     * @param array $AddDevices Data related to adding devices.
     */
    public function setAddDevices($AddDevices) {
        $this->AddDevices = $AddDevices; // Correct variable name
    }
    /**
     * Orchestrates the creation of the add device page.
     * It sets the page title, creates the web page layout, generates page content, and adds the footer.
     */
    public function createAddDevicesPage()
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
     * Sets the page title to 'CryptoShow System | add new Device'.
     */
    private function setPageTitle()
    {
        $this->page_title = 'CryptoShow System | add new Device';
    }
    /**
     * Creates the main content of the page.
     * It generates the HTML content for the add device form and appends it to the page content.
     */
    protected function createPageContent() {
        $addDeviceForm = $this->generateAddDevicesSection();

        $this->html_page_content = <<<HTMLCONTENT
<style>
            .add-device-form-container {
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

            @media (max-width: 768px) {
                .add-device-form-container {
                    padding: 1rem;
                    margin: 1rem;
                }

                .form-control {
                    padding: 0.5rem;
                }

                .btn-primary {
                    padding: 0.8rem 1rem;
                }
            }
        </style>
        <div class="add-device-form-container">
            <h1>Add a New Device</h1>


HTMLCONTENT;
// Dynamically create the section for the last three events
        $devicesAddSection = $this->generateAddDevicesSection();

        $this->html_page_content .= $devicesAddSection; // Append the dynamic devices section


        $moreStaticContent = <<<HTMLCONTENT
            
        <div class="home-section-separator"></div>
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
     * Generates the HTML content for the add device form.
     *
     * @return string HTML content for the add device form.
     */
    private function generateAddDevicesSection(): string
    {
        $csrfToken = $_SESSION['csrf_token'];  // Retrieve the token from the session
//        print_r($csrfToken);exit();
        // Form for adding a new device
        return <<<HTML
        <form action="/processAddDevice" method="post" enctype="multipart/form-data" class="form-container">
        <input type="hidden" name="csrf_token" value="{$csrfToken}">  <!-- Include the CSRF token here -->
        <div class="form-group">
            <label for="deviceName">Device Name:</label>
            <input type="text" id="deviceName" name="deviceName" required class="form-control">
        </div>
        <div class="form-group">
            <label for="deviceImage">Device Image:</label>
            <input type="file" id="deviceImage" name="deviceImage" required class="form-control">
        </div>
        <div class="form-group">
            <label for="deviceVisible">Visible to Public:</label>
            <input type="checkbox" id="deviceVisible" name="deviceVisible" class="form-check-input" checked>
            <label for="deviceVisible" class="form-check-label">Yes</label>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
        </div>
HTML;
    }

}