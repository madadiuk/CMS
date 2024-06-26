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

/**
 * Represents the view for displaying devices.
 */
class DeviceView extends WebPageTemplateView
{
    /**
     * Constructs a new DeviceView object.
     */
    public function __construct()
    {
        parent::__construct();
    }
    private $devices = []; // Declare the property

    /**
     * Sets the data related to devices.
     *
     * @param array $devices Data related to devices.
     */
    public function setDevices($devices) {
        $this->devices = $devices; // Correct variable name
    }
    /**
     * Orchestrates the creation of the devices page.
     * It sets the page title, creates the web page layout, generates page content, and adds the footer.
     */
    public function createDevicesPage()
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
     * Sets the page title to 'CryptoShow System | Devices'.
     */
    private function setPageTitle()
    {
        $this->page_title = 'CryptoShow System | Devices';
    }
    /**
     * Creates the main content of the page.
     * It generates the HTML content for displaying devices and appends it to the page content.
     */
    protected function createPageContent() {

        $this->html_page_content = <<<HTMLCONTENT
        <div id="devices" class="home-devices">
          <div class="home-heading-container2">
            <h1 class="home-text11 Section-Heading">Devices</h1>
            <span class="home-text12 Section-Text">
              The list of devices they are registered in the system.
            </span>
          </div>
         <div class="home-cards-container2">
                  
HTMLCONTENT;
// Dynamically create the section for the last three events
        $devicesSection = $this->generateDevicesSection();

        // Insert the dynamically created events HTML into the main page content
        // Let's replace the static events section placeholder with dynamic content
        $this->html_page_content .= $devicesSection; // Append the dynamic devices section


        $moreStaticContent = <<<HTMLCONTENT
            </div>
          <button type="button" class="home-button button">pagination</button>
        </div>
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
    private function generateDevicesSection(): string {
        $devicesHtml = "<div class=\"home-cards-container\" style='display: flex; flex-wrap: wrap; justify-content: space-between; gap: 10px;'>";
        $media_path = APP_ROOT_PATH;
        foreach ($this->devices as $device) {
            $deviceName = htmlspecialchars($device['crypto_device_name']);
            $deviceImage = htmlspecialchars($device['crypto_device_image_name']);
            $deviceTimestamp = htmlspecialchars($device['crypto_device_registered_timestamp']);

            $devicesHtml .= <<<HTML
            <div class="home-card">
              <img
                alt="Device Image"
                src="{$media_path}media/{$deviceImage}"
                class="home-image2"
              />
              <div class="home-content-container2">
                <span class="home-text17 SmallCard-Heading">{$deviceName}</span>
                <span class="Anchor">Registered: {$deviceTimestamp}</span>
              </div>
            </div>
HTML;
        }
        $devicesHtml .= "</div>"; // Close the .home-cards-container
        return $devicesHtml;
    }

}