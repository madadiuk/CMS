<?php
/**
 * @package petshow
 */
class ListPetNamesController extends ControllerAbstract
{
    public function createHtmlOutput()
    {
        $database = Factory::createDatabaseWrapper();
        $model = Factory::buildObject('ListPetNamesModel');
        $view = Factory::buildObject('ListPetNamesView');

        $model->setDatabaseHandle($database);
        $model->createPetNamesList();
        $pet_names = $model->getPetNames();

        $view->setPetNames($pet_names);
        $view->createForm();
        $this->html_output = $view->getHtmlOutput();
    }
}
