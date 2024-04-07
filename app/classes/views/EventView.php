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

class EventView extends WebPageTemplateView
{
    public function __construct()
    {
        parent::__construct();
    }
    private $events = []; // Declare the property

    // Assuming setData is already defined to accept data from the Controller
    public function setEvents($events) {
        $this->events = $events;
    }
    public function createEventsPage()
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
        $this->page_title = 'CryptoShow System | Events';
    }

    protected function createPageContent() {

        $this->html_page_content = <<<HTMLCONTENT
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


        $moreStaticContent = <<<HTMLCONTENT
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
    private function generateEventsSection(): string
    {
        $eventsHtml = "<div class='home-cards-container' style='display: flex; flex-wrap: wrap; justify-content: space-between; gap: 10px;'>";
        if (!empty($this->events)) { // Corrected to use $this->events
            foreach ($this->events as $event) {
                $eventsHtml .= "<div class='home-event-card'>";
                $eventsHtml .= "<h3 class='home-text03 Card-Heading'>" . htmlspecialchars($event['event_name']) . "</h3>";
                $eventsHtml .= "<span class='home-text04 Card-Text'>" . htmlspecialchars($event['event_venue']) . "</span>";
                $eventsHtml .= "<span class='Card-Text'>" . htmlspecialchars($event['event_date']) . "</span>";
                $eventsHtml .= "</div>";
            }
        } else {
            $eventsHtml .= "<div class='home-event-card'>No events available at the moment.</div>";
        }
        $eventsHtml .= "</div>";
        return $eventsHtml;
    }

}