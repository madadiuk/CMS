<?php
/**
 * IndexController.php
 *
 * Sessions: PHP web application to demonstrate how databases
 * are accessed securely
 *
 *
 * @author CF Ingrams - cfi@dmu.ac.uk
 * @copyright De Montfort University
 *
 * @package petshow
 */
//var_dump(get_included_files());
class IndexController extends ControllerAbstract
{
    private $eventModel;
    private $userModel;
    private $deviceModel;

    public function __construct($eventModel, $userModel, $deviceModel) {
        parent::__construct();
        $this->eventModel = $eventModel;
        $this->userModel = $userModel;
        $this->deviceModel = $deviceModel;
    }
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
    private function fetchLastThreeEvents() {
        return $this->eventModel->getLastThreeEvents();

    }
}
