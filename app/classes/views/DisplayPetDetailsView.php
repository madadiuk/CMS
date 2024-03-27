<?php
  /**
   * DisplayPetDetailsView.php  * Sessions: PHP web application to demonstrate how databases
   * are accessed securely
   *
   *
   * @author M Madadi
   * @copyright De Montfort University
   *
   * @package petshow
   */

  class DisplayPetDetailsView extends WebPageTemplateView
  {
    private $pet_details;

    public function __construct()
    {
      $this->pet_details = array();
    }

    public function __destruct() {}

    public function createOutputPage()
    {
      $this->setPageTitle();
      $this->createRelevantOutput();
      $this->createWebPage();
    }

    public function getHtmlOutput()
    {
      return $this->html_page_output;
    }

    public function setPetDetails(array $pet_details)
    {
      $this->pet_details = $pet_details;
    }

    private function setPageTitle()
    {
      $this->page_title = 'Display pet details';
    }

    private function createRelevantOutput()
    {
      if (isset($this->pet_details['sanitised-pet-name']))
      {
        if (!$this->pet_details['sanitised-pet-name'])
        {
          $this->createErrorMessage();
        }
        else
        {
          $this->displayPetDetails();
        }
      }
    }

    private function createErrorMessage()
    {
      $this->html_page_content = <<< NAMEERRORPAGE
<div id="lg-form-container">
<p class="error">Ooops - there was a problem with the pet name you selected/entered</p>
</div>
NAMEERRORPAGE;
    }

    private function displayPetDetails()
    {
      $stock_values = '';
      $address = APP_ROOT_PATH;
      $pet_name = $this->pet_details['sanitised-pet-name'];
      $pet_details = $this->pet_details['pet-details'];
      $owner_id = $pet_details['owner_initials'];
      $pet_type = $pet_details['pet_type'];
      $pet_sex = $pet_details['pet_sex'];
      $pet_dob = $this->convertDateFormat($pet_details['pet_dob']);
      $pet_description = $pet_details['pet_description'];
      $pet_picture_source = PETPICS_PATH . $pet_details['pet_pic_source'];
      // if animal has died, display date of death
      $if_dead = '';
      if ($pet_details['pet_is_alive'] == 'N')
      {
        $reformatted_date = $this->convertDateFormat($pet_details['pet_do_death']);
        $if_dead .= '<tr><td>Date of death :</td>';
        $if_dead .= '<td>' . $reformatted_date .'</td></tr>';
      }
      $this->html_page_content = <<< VIEWPETDETAILS
<div id="lg-form-container">
<h2>Pet details for $pet_name</h2>
<table border="1">
<tr><td>Owner's ID :</td><td>$owner_id</td></tr>
<tr><td>Animal Type :</td><td>$pet_type</td></tr>
<tr><td>Sex of animal :</td><td>$pet_sex</td></tr>
<tr><td>Date of birth :</td><td>$pet_dob</td></tr>
<tr><td>Comment :</td><td>$pet_description</td></tr>
<tr><td>Picture source :</td><td>$pet_picture_source</td></tr>
$if_dead
<tr><td>Pet's Picture :</td>
<td>
<img src="$pet_picture_source" alt="pet's picture" title="pet's picture" />
</td>
</tr>
</table>
</div>
VIEWPETDETAILS;
    }

    private function convertDateFormat($date_to_convert)
    {
      return date('d/n/Y', strtotime($date_to_convert));
    }
  }
