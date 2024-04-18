<?php
/**
 * Validate.php  * Sessions: PHP web application to demonstrate how databases
 * are accessed securely
 *
 *
 * @author M MADADI
 * @copyright De Montfort University
 *
 * @package CryptoShow system CMS
 */

/**
 * Represents a validator for route names and strings.
 */
class Validate
{
    /**
     * Constructs the Validate object.
     */
    public function __construct()
    {
    }
    /**
     * Destructs the Validate object.
     */
    public function __destruct()
    {
    }

    /**
     * Check that the route name from the browser is a valid route
     * If it is not, abandon the processing.
     * NB this is not a good way to achieve this error handling.
     *
     * @param $route
     * @return boolean
     */
    public function validateRoute($route)
    {

//        print_r($route);exit;
        $route_exists = false;
        $routes = [
            'index',
            'Show_device_names',
            'display_event_details',
            'events',
            'devices',
            'add_device',
            'add_event',
            'login',
            'logout',
            'register',
            'process_register',
            'process_login',
            'logout',
            'profile',
            'process_profile_update',
            'delete_profile',
            'userEvents',
            'deleteEvent', // Placeholder for dynamic route
            'addUserEvent', // Placeholder for dynamic route
            'processAddUserEvent',
            'editEvent', // Placeholder for dynamic route
            'processUpdateEvent',
            'listDevices',
            'addDevice',
            'processAddDevice',
            'editDevice',
            'processEditDevice',
            'deleteDevice'
        ];

        foreach ($routes as $pattern) {

            // Convert placeholders to regex
            $pattern = str_replace('{eventId}', '[0-9]+', $pattern);
            // Match the pattern against the route
            if (preg_match('#^' . $pattern . '$#', $route)) {
                $route_exists = true;
                break;
            }
        }

        if (!$route_exists) {
            die("Route $route is not valid.");
        }

        return $route_exists;
    }

    /**
     * Validates a string based on length constraints.
     *
     * @param string $datum_name The name of the datum to validate.
     * @param array $tainted The array containing the datum to be validated.
     * @param int|null $min_length The minimum allowed length of the string (optional).
     * @param int|null $max_length The maximum allowed length of the string (optional).
     * @return string|false The validated string if it meets the length constraints, false otherwise.
     */
    public function validateString(
        string $datum_name,
        array $tainted,
        int $min_length = null,
        int $max_length = null
    ) {
        $validated_string = false;
        if (!empty($tainted[$datum_name])) {
            $string_to_check = $tainted[$datum_name];
            $sanitised_string = filter_var(
                $string_to_check,
                FILTER_SANITIZE_SPECIAL_CHARS,
                FILTER_FLAG_NO_ENCODE_QUOTES
            );
            $sanitised_string_length = strlen($sanitised_string);
            if ($min_length <= $sanitised_string_length && $sanitised_string_length <= $max_length) {
                $validated_string = $sanitised_string;
            }
        }
        return $validated_string;
    }

}
