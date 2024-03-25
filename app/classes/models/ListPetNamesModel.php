<?php
/**
 * @package petshow
 */
class ListPetNamesModel
{
 private $pet_names;
 private $database_handle;

 public function __construct()
 {
  $this->pet_names = [];
  $this->database_handle = null;
 }

 public function __destruct(){}

 public function setDatabaseHandle($obj_database_handle)
 {
  $this->database_handle = $obj_database_handle;
 }

 public function getPetNames()
 {
  return $this->pet_names;
 }

 public function createPetNamesList()
 {
  $pet_names_list = array();
  $sql_query_string = SqlQuery::queryGetPetNames();
  $sql_query_parameters = array();
  $this->database_handle->safeQuery($sql_query_string, $sql_query_parameters);
  $number_of_pets = $this->database_handle->countRows();

  if ($number_of_pets > 0)
  {
   while ($row = $this->database_handle->safeFetchArray())
   {
    $pet_name = $row['pet_name'];
    $pet_names_list[$pet_name] = $pet_name;
   }
  }
  $this->pet_names = $pet_names_list;
 }
}
