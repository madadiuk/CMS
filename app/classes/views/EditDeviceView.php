<?php
/**
 * EditDeviceView.php
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
 * Represents the view for editing a device.
 */
class EditDeviceView extends UserTemplateView
{
    /**
     * Constructs a new AddDeviceView object.
     */
    public function __construct()
    {
        parent::__construct();
    }
    private $EditDevices = []; // Declare the property

    /**
     * Sets the data related to adding devices.
     *
     * @param array $EditDevices Data related to adding devices.
     */
    public function setEditDevices($EditDevices) {
        $this->EditDevices = $EditDevices; // Correct variable name
    }
    /**
     * Orchestrates the creation of the add device page.
     * It sets the page title, creates the web page layout, generates page content, and adds the footer.
     */
    public function createEditDevicesPage()
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
        $this->page_title = 'CryptoShow System | Edit Device';
    }
    /**
     * Creates the main content of the page.
     * It generates the HTML content for the add device form and appends it to the page content.
     */
    protected function createPageContent() {
        $editDeviceForm = $this->generateEditDevicesSection();

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
        $devicesEditSection = $this->generateEditDevicesSection();

        $this->html_page_content .= $devicesEditSection; // Append the dynamic devices section


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
    private function generateEditDevicesSection(): string
    {
        $csrfToken = $_SESSION['csrf_token'];  // Retrieve the token from the session
        $deviceName = htmlspecialchars($this->EditDevices['crypto_device_name']);
        $deviceVisible = $this->EditDevices['crypto_device_record_visible'] ? 'checked' : '';
        $deviceImage = htmlspecialchars($this->EditDevices['crypto_device_image_name']);
        $media_path = APP_ROOT_PATH .'media/'. $deviceImage;

        return <<<HTML
    <form action="/processEditDevice" method="post" enctype="multipart/form-data" class="form-container">
    <input type="hidden" name="csrf_token" value="{$csrfToken}">
    <input type="hidden" name="deviceId" value="{$this->EditDevices['crypto_device_id']}">
    <div class="form-group">
        <label for="deviceName">Device Name:</label>
        <input type="text" id="deviceName" name="deviceName" required class="form-control" value="{$deviceName}">
    </div>
    <div class="form-group">
        <label for="deviceImage">Device Image (leave blank to keep current):</label>
        <input type="file" id="deviceImage" name="deviceImage" class="form-control">
        <img src="{$media_path}" alt="Current Device Image" style="max-width: 100%; margin-top: 10px; border-radius: 5px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
    </div>
    <div class="form-group">
        <label for="deviceVisible">Visible to Public:</label>
        <input type="checkbox" id="deviceVisible" name="deviceVisible" class="form-check-input" {$deviceVisible}>
        <label for="deviceVisible" class="form-check-label">Yes</label>
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
    </form>
    </div>
HTML;
    }


}