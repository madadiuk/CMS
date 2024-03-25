<?php
  /**
   * DisplayPetDetailsModel.php  * Sessions: PHP web application to demonstrate how databases
   * are accessed securely
   *
   *
   * @author CF Ingrams - cfi@dmu.ac.uk
   * @copyright De Montfort University
   *
   * @package petshow
   */

  class DisplayPetDetailsModel
  {
    private $database_handle;
    private $database_connection_messages;
    private $pet_details;
    private $sanitised_pet_name;

    public function __construct()
    {
      $this->database_handle = null;
      $this->database_connection_messages = [];
      $this->pet_details = [];
      $this->sanitised_pet_name = '';
    }

    public function __destruct(){}

    public function setDatabaseHandle($database_handle)
    {
      $this->database_handle = $database_handle;
    }

    public function getPetDetails()
    {
      return $this->pet_details;
    }

    public function getDatabaseConnectionResult()
    {
      $this->database_connection_messages = $this->database_handle->getConnectionMessages();
    }

    public function setPetName(string $pet_name)
    {
      $this->sanitised_pet_name = $pet_name;
    }

    public function retrievePetDetails()
    {
      $sanitised_pet_name = $this->sanitised_pet_name;
      $sql_query_string = SqlQuery::queryGetPetDetails();
      $sql_query_parameters = array(':petname' => $sanitised_pet_name);
      $query_result = $this->database_handle->safeQuery($sql_query_string, $sql_query_parameters);
      $pet_count = $this->database_handle->countRows();
      if ($pet_count == 0)
      {
        $sanitised_pet_name = false;
      }
      else
      {
        $pet_details = $this->database_handle->safeFetchArray();
        $this->pet_details['sanitised-pet-name'] = $sanitised_pet_name;
        $this->pet_details['pet-details'] = $pet_details;
      }
    }
  }
