<?php
/**
 * IndexView.php
 *
 * Sessions: PHP web application to demonstrate how databases
 * are accessed securely
 *
 *
 * @author M Madadi
 * @copyright De Montfort University
 *
 * @package petshow
 */
class IndexView extends WebPageTemplateView
{

    public function __construct()
    {
        parent::__construct();
    }

    public function __destruct(){}

    public function createForm()
    {
        $this->setPageTitle();
        $this->createPageBody();
        $this->createWebPage();
    }

    public function getHtmlOutput()
    {
        return $this->html_page_output;
    }

    private function setPageTitle()
    {
        $this->page_title = 'CryptoShow System Index Page';
    }

    private function createPageBody()
    {
        $address = APP_ROOT_PATH;
        $info_text = 'Application will allow you to select a pet\'s name, and to view the details of the pet.';
        $page_heading = 'CryptoShow demonstration';
        $this->html_page_content = <<< HTMLFORM
<h2>$page_heading</h2>
<p>$info_text</p>
<form action="$address" method="post">
<p class="curr_page"></p>
<fieldset>
<legend>Select option</legend>
<br />
<button name="route" value="show_pet_names">Show Pet Names</button>
<br />
<br />
<button name="route" value="display_pet_details">Display Pet Details</button>
</fieldset>
</form>
HTMLFORM;
    }
}
