<?php
/**
 * SqlQuery.php
 * PHP web application to demonstrate how databases are accessed securely
 *
 *This class groups together all the SQL queries that are used within the application
 *
 * @author CF Ingrams - cfi@dmu.ac.uk
 * @copyright De Montfort University
 *
 * @package petshow
 */

class SqlQuery
{

    public function __construct(){}

    public function __destruct(){}

    public static function queryGetPetNames()
    {
        $sql_query_string  = 'SELECT pet_name';
        $sql_query_string .= ' FROM pet';
        return $sql_query_string;
    }

    public static function queryGetPetDetails()
    {
        $sql_query_string  = 'SELECT pet.pet_index, pet_name, owner_initials, pet_type,';
        $sql_query_string .= ' pet_sex, pet_dob, pet_is_alive, pet_do_death,';
        $sql_query_string .= ' pet_pic_source, pet_description';
        $sql_query_string .= ' FROM pet, petpics';
        $sql_query_string .= ' WHERE pet_name = :petname';
        $sql_query_string .= ' AND pet.pet_index = petpics.pet_index';
        $sql_query_string .= ' LIMIT 1';
        return $sql_query_string;
    }

    public static function queryGetErrorLoggingQueryString()
    {
        $sql_query_string  = 'INSERT INTO error_log';
        $sql_query_string .= ' SET';
        $sql_query_string .= ' log_message = :logmessage';
        return $sql_query_string;
    }
}
