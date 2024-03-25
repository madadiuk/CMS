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
            case 'show_pet_names':
                $controller = Factory::buildObject('ListPetNamesController');
                break;
            case 'display_pet_details':
                $controller = Factory::buildObject('DisplayPetDetailsController');
                break;
            case 'index':
            default:
            $controller = Factory::buildObject('IndexController');
                break;
        }
        $controller->createHtmlOutput();
        $html_output = $controller->getHtmlOutput();
        return $html_output;
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
