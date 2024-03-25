<?php
  /**
   * @package petshow
   */
  class ListPetNamesView extends WebPageTemplateView
  {
    private $pet_names_list;

    public function __construct()
    {
      $this->pet_names_list = array();
    }

    public function __destruct() {}

    public function createForm()
    {
      $this->setPageTitle();
      $this->selectPetForm();
      $this->createWebPage();
    }

    public function getHtmlOutput()
    {
      return $this->html_page_output;
    }

    public function setPetNames(array $pet_names_list)
    {
      $this->pet_names_list = $pet_names_list;
    }

    private function setPageTitle()
    {
      $this->page_title = 'List pet names';
    }

    private function selectPetForm()
    {
      $address = APP_ROOT_PATH;
      $pet_names_option_list = $this->createPetnamesOptionList();
      $this->html_page_content = <<< SELECTCOMPANYFORM
<div id="lg-form-container">
<h2>Select a Pet</h2>
<h3>Select pet's name to view its details</h3>
<form method="post" action="$address">
<select name="pet-name">
$pet_names_option_list
</select>
<p class="text_right">
<button name="route" value="display_pet_details">Display Pet Details</button>
</p>
</form>
</div>
SELECTCOMPANYFORM;
    }

    private function createPetnamesOptionList()
    {
      $pet_names_option_list = '';
      $pet_names_option_list .= '<option value="0"><-- please select --></option>';
      foreach ($this->pet_names_list as $pet_name_option => $pet_name)
      {
        $pet_names_option_list .= '<option value="' . $pet_name_option . '">' . $pet_name . '</option>';
      }
      return $pet_names_option_list;
    }
  }
