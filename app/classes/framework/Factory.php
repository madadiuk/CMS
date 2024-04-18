<?php
/**
 * Factory.php
 * PHP web application to demonstrate how databases are accessed securely
 *
 * @author M MADADI
 * @copyright De Montfort University
 *
 * @package CryptoShow system CMS
 */
//require_once 'path_to_settings_file/settings.php';
//require_once   '../settings.php';
//var_dump(get_included_files());
class Factory
{
    public function __construct(){}

    public function __destruct(){}

    /**
     * build any object and return a resource handle to the object
     */
    public static function buildObject($class)
    {
        $object = new $class();
        return $object;
    }

    /**
     * @return mixed - returns a database wrapper object
     */
    public static function createDatabaseWrapper()
    {
        $database = Factory::buildObject('DatabaseWrapper');
        $connection_parameters = getPdoDatabaseConnectionDetails();
        $database->setConnectionSettings($connection_parameters);
        $database->connectToDatabase();
        return $database;
    }
}
