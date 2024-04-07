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

class IndexView extends WebPageTemplateView
{
    public function __construct()
    {
        parent::__construct();
    }
    private $data = [];

    // Assuming setData is already defined to accept data from the Controller
    public function setData($data) {
        $this->data = $data;
    }
    public function createForm()
    {
        $this->setPageTitle();
        $this->createWebPage();
        $this->createPageContent();
        $this->createFooter();
    }
    public function getHtmlOutput(): string
    {
        return $this->html_page_output;
    }
    private function setPageTitle()
    {
        $this->page_title = 'CryptoShow System | Home';
    }

    protected function createPageContent() {

        $this->html_page_content = <<<HTMLCONTENT
        <div id="resources" class="home-hero">
          <div class="home-content-container">
            <div class="home-hero-text">
              <h1 class="home-heading Section-Heading">What is Crypto show?</h1>
              <span class="home-text Section-Text">
                The crypto show is a place for you to bring your devices to many events we organize.
              </span>
              <button class="home-cta-btn1 Anchor button">START NOW</button>
            </div>
          </div>
        </div>
        <div id="events" class="home-events">
          <div class="home-heading-container">
            <h1 class="home-text01 Section-Heading">Events</h1>
            <span class="home-text02 Section-Text">
              We organize many events for you to bring your devices to. Here are the last three events we organized.
            </span>
          </div>
HTMLCONTENT;
// Dynamically create the section for the last three events
        $eventsSection = $this->generateEventsSection();

        // Insert the dynamically created events HTML into the main page content
        // Let's replace the static events section placeholder with dynamic content
        $this->html_page_content .= $eventsSection; // Append the dynamic events section
        $address = APP_ROOT_PATH;
        $usersSection = $this->generateUsersSection();
        $moreStaticContent = <<<HTMLCONTENT
     
        <form action="$address" method="post">
          <fieldset>
        <button name="route" value="list_all_events" class="home-button button"> More Events</button>
        </fieldset>
        </form>
        </div>
        <div class="home-section-separator"></div>
HTMLCONTENT;
        $this->html_page_content  .= $moreStaticContent;
        $this->html_page_content .= $usersSection;
        $moreStaticContent = <<<HTMLCONTENT

        <div class="home-section-separator1"></div>
        <div id="devices" class="home-devices">
          <div class="home-heading-container2">
            <h1 class="home-text11 Section-Heading">Devices</h1>
            <span class="home-text12 Section-Text">
              The section of devices that you can see last four devices that were added to the system.
              and you can find out more about them.
            </span>
          </div>
          <div class="home-cards-container2">
            <div class="home-left-section">
              <div class="home-video-container">
                        <iframe class="home-video" width="560" height="315" src="https://www.youtube.com/embed/2hTRFB2itLA" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                
              </div>
              <div class="home-content-container1">
                <span class="home-heading1 Card-Heading">
                  What is Crypto Show?
                </span>
                <span class="home-text13 Card-Text">
                  The Crypto show is a platform that allows you to bring your devices to many events we organize. In this video we explain how it works.
                </span>
                <span class="home-text14 Card-Text">
                  Our application is designed to be user-friendly and easy to use. We have a wide range of devices that you can use to access our services.
                </span>
              </div>
              <div class="home-info-container">
                <div class="home-stats-container">
                  <div class="home-messages-container">
                    <svg viewBox="0 0 1024 1024" class="home-icon16">
                      <path
                        d="M938.667 490.539v-21.205c0-0.725-0.043-1.621-0.085-2.475-5.803-99.755-47.488-190.336-112.768-258.176-68.352-71.125-162.731-117.419-268.843-123.264-0.64-0.043-1.493-0.085-2.304-0.085h-20.864c-59.947-0.683-122.965 13.227-181.931 43.008-52.181 26.539-97.749 63.531-133.931 108.203-56.405 69.675-89.899 158.037-89.941 253.653-0.597 54.4 10.795 111.36 35.157 165.419l-75.605 226.859c-2.816 8.363-3.072 17.835 0 26.965 7.467 22.357 31.616 34.432 53.973 26.965l226.731-75.563c49.493 22.485 105.984 35.243 165.376 35.115 58.539-0.384 115.84-13.141 168.149-36.949 81.579-37.163 151.040-101.248 193.707-186.667 27.477-53.291 43.307-115.84 43.136-181.803zM853.333 490.795c0.128 52.267-12.459 101.333-33.664 142.464-34.176 68.352-88.832 118.784-153.259 148.139-41.387 18.859-86.869 28.971-133.376 29.312-52.096 0.128-101.163-12.459-142.293-33.664-10.624-5.504-22.528-6.059-33.067-2.56l-162.261 54.101 54.101-162.261c3.755-11.221 2.56-22.912-2.389-32.725-23.552-46.72-34.304-96.213-33.792-142.464 0.043-76.331 26.411-145.877 70.912-200.917 28.629-35.328 64.768-64.725 106.283-85.76 46.592-23.552 96.085-34.304 142.336-33.792h19.456c83.712 4.565 158.037 41.003 212.011 97.109 51.285 53.376 84.139 124.416 89.003 202.837z"
                      ></path>
                    </svg>
                    <span class="Card-Text">123</span>
                  </div>
                  <div class="home-views-container">
                    <svg viewBox="0 0 1024 1024" class="home-icon18">
                      <path
                        d="M512 192c-223.318 0-416.882 130.042-512 320 95.118 189.958 288.682 320 512 320 223.312 0 416.876-130.042 512-320-95.116-189.958-288.688-320-512-320zM764.45 361.704c60.162 38.374 111.142 89.774 149.434 150.296-38.292 60.522-89.274 111.922-149.436 150.296-75.594 48.218-162.89 73.704-252.448 73.704-89.56 0-176.858-25.486-252.452-73.704-60.158-38.372-111.138-89.772-149.432-150.296 38.292-60.524 89.274-111.924 149.434-150.296 3.918-2.5 7.876-4.922 11.86-7.3-9.96 27.328-15.41 56.822-15.41 87.596 0 141.382 114.616 256 256 256 141.382 0 256-114.618 256-256 0-30.774-5.452-60.268-15.408-87.598 3.978 2.378 7.938 4.802 11.858 7.302v0zM512 416c0 53.020-42.98 96-96 96s-96-42.98-96-96 42.98-96 96-96 96 42.982 96 96z"
                      ></path>
                    </svg>
                    <span class="Card-Text">4567</span>
                  </div>
                </div>
              </div>
            </div>
                <div class="home-right-section">
HTMLCONTENT;
        $this->html_page_content  .= $moreStaticContent;

                // Dynamically create the section for the last four devices
                $devicesSection = $this->generateDevicesSection();

                // Insert the dynamically created devices HTML into the main page content
                $this->html_page_content .= $devicesSection;


        $moreStaticContent = <<<HTMLCONTENT
        </div>
        </div>
           <form action="$address" method="post">
                <fieldset>
                    <button name="route" value="list_all_devices" class="home-button button"> More Devices </button>
                </fieldset>
            </form>
        </div>
HTMLCONTENT;
        $this->html_page_content  .= $moreStaticContent;
        $this->html_page_output .= $this->html_page_content;

    }
    private function generateEventsSection(): string
    {
        $eventsHtml = "<div class='home-cards-container'>";
        if (!empty($this->data['events'])) {
            foreach ($this->data['events'] as $event) {
//                var_dump($event);
                $eventsHtml .= "<div class='home-event-card'>";
                $eventsHtml .= "<h3 class='home-text03 Card-Heading'>" . htmlspecialchars($event['event_name']) . "</h3>";
                $eventsHtml .= "<span class='home-text04 Card-Text'>" . htmlspecialchars($event['event_venue']) . "</span>";
                $eventsHtml .= "<span class='Card-Text'>" . htmlspecialchars($event['event_date']) . "</span>";
                $eventsHtml .= "<span class='Anchor'>Learn more</span>"; // Modify as needed
                $eventsHtml .= "</div>";
            }
        } else {
            $eventsHtml .= "<div class='home-event-card'>No events available at the moment.</div>";
        }
        $eventsHtml .= "</div>";
        return $eventsHtml;
    }
    private function generateUsersSection(): string {
        $usersHtml = "<div class='home-users'>
                      <div class='home-heading-container1'>
                        <h1 class='home-text09 Section-Heading'>Last Users</h1>
                      </div>
                      <div class='home-cards-container1'>";

        foreach ($this->data['users'] as $user) {
            $usersHtml .= "<div class='home-user-card'>
                         <div class='home-avatar-container'>
                           <!-- User Image -->
                           <img src='https://madadi.uk/user.png' alt='image' class='home-image6' />
                         </div>
                         <span class='home-name Card-Heading'>" . htmlspecialchars($user['user_nickname']) . "</span>
                         <span class='home-position Card-Text'>" . htmlspecialchars($user['user_device_count']) . " Devices</span>
                       </div>";
        }

        $usersHtml .= "</div></div>";
        return $usersHtml;
    }
    private function generateDevicesSection(): string {
        $devicesHtml = "";
        $media_path = MEDIA_PATH;
        foreach ($this->data['devices'] as $device) {
            $deviceName = htmlspecialchars($device['crypto_device_name']);
            $deviceImage = htmlspecialchars($device['crypto_device_image_name']);
            $deviceTimestamp = htmlspecialchars($device['crypto_device_registered_timestamp']);

            // Using the provided structure, adjusting for device details
            $devicesHtml .= <<<HTML
              <div class="home-card">
                <img
                  alt="Device Image"
                  src="{$media_path}/img/{$deviceImage}" // Adjust the path as necessary
                  class="home-image2"
                />
                <div class="home-content-container2">
                  <span class="home-text17 SmallCard-Heading">{$deviceName}</span>
                  <span class="Anchor">Registered: {$deviceTimestamp}</span>
                </div>
                
              </div>
HTML;
        }

        return $devicesHtml;
    }


}