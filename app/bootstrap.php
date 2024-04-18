<?php
/**
 * bootstrap.php
 *
 * Sessions: PHP web application to demonstrate how databases
 * are accessed securely
 *
 * Each route is hosted in its own directory. The __autoload function
 * iterates through an array of the directory names, looking for the required class.
 * If the class definition file is find, the class is then checked for correct instantiation.
 *
 * If there are any problems, the error class is instantiated for error processing
 * NB this could also be achieved by throwing an exception in a try-catch structure
 *
 * @author m Madadi
 * @copyright De Montfort University
 *
 * @package cryptoshow system
 */

include_once 'autoload.php';

include_once 'settings.php';

$router = Factory::buildObject('Router');
$router->routing();
$html_output = $router->getHtmlOutput();

echo $html_output;
