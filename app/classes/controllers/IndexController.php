<?php
/**
 * IndexController.php
 *
 * Sessions: PHP web application to demonstrate how databases
 * are accessed securely
 *
 *
 * @author m Madadi
 * @copyright De Montfort University
 *
 * @package crypto show system
 */

/**
 * Manages the initial or index page of the web application by aggregating data across models and instructing the view to render the consolidated data.
 */
//var_dump(get_included_files());
class IndexController extends ControllerAbstract
{
    private $eventModel;
    private $userModel;
    private $deviceModel;
    /**
     * Constructs the IndexController with dependencies on the event, user, and device models.
     * @param $eventModel The model handling data operations related to events.
     * @param $userModel The model managing user data operations.
     * @param $deviceModel The model dealing with device data operations.
     */
    public function __construct($eventModel, $userModel, $deviceModel) {
        parent::__construct();
        $this->eventModel = $eventModel;
        $this->userModel = $userModel;
        $this->deviceModel = $deviceModel;
    }

    /**
     * Assembles and outputs the HTML content for the index page by fetching and setting relevant data into the view.
     * This includes the latest events, recent users, and devices.
     */
    public function createHtmlOutput()
    {
        $view = Factory::buildObject('IndexView');
        // Fetch the last three events
        $lastThreeEvents = $this->fetchLastThreeEvents();
        $lastFiveUsers = $this->userModel->getLastFiveUsers(); // Assuming userModel is accessible in IndexController
        $lastFourDevices = $this->deviceModel->getLastFourDevices(); // Assuming deviceModel is accessible in IndexController
        $view->setData([
            'events' => $lastThreeEvents,
            'users' => $lastFiveUsers,
            'devices' =>$lastFourDevices ,
        ]);
        $view->createForm();
        $this->html_output = $view->getHtmlOutput();
        echo $this->html_output;

    }
    /**
     * Fetches the latest three events to be displayed on the index page.
     * @return array An array of event data.
     */
    private function fetchLastThreeEvents() {
        return $this->eventModel->getLastThreeEvents();

    }
}
