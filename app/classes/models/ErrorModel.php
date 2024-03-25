<?php
/**
 * ErrorModel.php  * Sessions: PHP web application to demonstrate how databases
 * are accessed securely
 *
 *
 * @author CF Ingrams - cfi@dmu.ac.uk
 * @copyright De Montfort University
 *
 * @package petshow
 */

class ErrorModel
{
    private $database;
    private $error_type;
    private $output_error_message;

    public function __construct()
    {
        $this->database = null;
        $this->error_type = '';
        $this->output_error_message = '';
    }

    public function __destruct(){}

    public function getErrorMessage()
    {
        return $this->output_error_message;
    }

    public function setDatabase($database)
    {
        $this->database = $database;
    }

    public function setErrorType($error_type)
    {
        $this->error_type = $error_type;
    }

    public function selectErrorMessage()
    {
        switch ($this->error_type)
        {
            case 'route-not-found-error':
                $error_message = 'I think you are trying it on ...';
                break;
            case 'class-not-found-error':
            case 'file-not-found-error':
            default:
                $error_message = 'Ooops - there was an internal error - please try again later';
                break;
        }
        $this->output_error_message = $error_message;
    }

    public function logErrorMessage()
    {
        $user_id = '';
        $number_of_inserted_messages = 0;
        $sql_query_string = SqlQuery::queryGetErrorLoggingQueryString();
        $sql_parameters = array(':logmessage' => $this->error_type);
        $this->database->safeQuery($sql_query_string, $sql_parameters);
        $number_of_inserted_messages = $this->database->countRows();
    }
}
