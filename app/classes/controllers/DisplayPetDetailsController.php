<?php
/**
 * DisplayPetDetailsController.php
 *
 * Sessions: PHP web application to demonstrate how databases
 * are accessed securely
 *
 *
 * @author CF Ingrams - cfi@dmu.ac.uk
 * @copyright De Montfort University
 *
 * @package petshow
 */

class DisplayPetDetailsController extends ControllerAbstract
{

    public function createHtmlOutput()
    {
        $pet_details = [];

        $validated_petname = $this->validate();

        if ($validated_petname !== false)
        {
            $pet_details = $this->retrievePetDetails($validated_petname);
        }

        $this->html_output = $this->createView($pet_details);
    }

    private function validate()
    {
        $validate = Factory::buildObject('Validate');
        $tainted = $_POST;

        $validated_petname = $validate->validateString('pet-name', $tainted, 3, 10);

        return $validated_petname;
    }

    private function retrievePetDetails($validated_petname)
    {
        $database = Factory::createDatabaseWrapper();
        $model = Factory::buildObject('DisplayPetDetailsModel');

        $model->setDatabaseHandle($database);
        $model->getDatabaseConnectionResult();

        $model->setPetName($validated_petname);
        $model->retrievePetDetails();
        $pet_details = $model->getPetDetails();
        return $pet_details;
    }

    private function createView($pet_details)
    {
        $view = Factory::buildObject('DisplayPetDetailsView');
        $view->setPetDetails($pet_details);
        $view->createOutputPage();
        $html_output = $view->getHtmlOutput();

        return $html_output;
    }
}
