<?php
/**
 * Router.php
 *
 * @author CF Ingrams - cfi@dmu.ac.uk
 * @copyright De Montfort University
 *
 * @package petshow
 */

class Router
{
    private $html_output;

    public function __construct()
    {
        $this->html_output = '';
    }

    public function __destruct(){}

    public function routing()
    {
        $html_output = '';

        $selected_route = $this->setRouteName();
//        var_dump($selected_route);
        $route_exists = $this->validateRouteName($selected_route);

        if ($route_exists == true)
        {
            $html_output = $this->selectController($selected_route);
        }
        $this->html_output = $this->processOutput($html_output);
    }

    /**
     * Set the default route to be index
     *
     * Read the name of the selected route from the magic global POST array and overwrite the default if necessary
     *
     * @return mixed|string
     */
    private function setRouteName()
    {
        $selected_route = 'index';
        if (isset($_POST['route']))
        {
            $selected_route = $_POST['route'];
        }
        return $selected_route;
    }

    /**
     * Check to see that the route name passed from the client is valid.
     * If not valid, chances are that a user is attempting something malicious.
     * In which case, kill the app's execution.
     */
    private function validateRouteName($selected_route)
    {
        $route_exists = false;
        $validate = Factory::buildObject('Validate');
        $route_exists = $validate->validateRoute($selected_route);
        return $route_exists;
    }

    public function selectController($selected_route)
    {
        switch ($selected_route)
        {
            case 'list_all_events':
                $databaseWrapper = Factory::createDatabaseWrapper();
                $eventModel = new EventModel($databaseWrapper);
                $view = new EventView(); // Assuming you have this view ready
                $controller = new EventController($eventModel, $view);
                $controller->listAllEvents();
                break;
            case 'list_all_devices':
                $databaseWrapper = Factory::createDatabaseWrapper();
                $deviceModel = new DeviceModel($databaseWrapper);
                $view = new DeviceView(); // Assuming you have this view ready
                $controller = new DeviceController($deviceModel, $view);
                $controller->listAllDevices();
                break;
            case 'Show_device_names':
                $controller = Factory::buildObject('DeviceController');
                break;
            case 'display_event_details':
                $controller = Factory::buildObject('EventController');
                break;
            case 'index':
            default:
            // Instantiate DatabaseWrapper, EventModel, and UserModel for the IndexController
            $databaseWrapper = Factory::createDatabaseWrapper();
            $eventModel = new EventModel($databaseWrapper);
            $userModel = new UserModel($databaseWrapper); // Assuming you have a UserModel class and it's constructed similarly
            $deviceModel = new DeviceModel($databaseWrapper); // Assuming you have a DeviceModel class and it's constructed similarly

            // Manually instantiate the IndexController with both EventModel and UserModel dependencies
            $controller = new IndexController($eventModel, $userModel, $deviceModel); // Now passing both required arguments

            break;
        }

        $controller->createHtmlOutput();

        return $controller->getHtmlOutput();
    }

    private function processOutput(string $html_output)
    {
        $processed_html_output = '';
        $process_output = Factory::buildObject('ProcessOutput');
        $processed_html_output = $process_output->assembleOutput($html_output);
        return $processed_html_output;
    }

    public function getHtmlOutput()
    {
        return $this->html_output;
    }
}
