<?php
/** ErrorController class
 *
 *	FrontEnd controller class for all error message processing
 *
 * @package petshow
 */

class ErrorController extends ControllerAbstract
{
    private $error_type;

    public function createHtmlOutput()
    {
        $error_message = $this->processErrorModel();
        $this->html_output = $this->createOutputView($error_message);
    }

    public function setErrorType($error_type)
    {
        $this->error_type = $error_type;
    }

    public function processErrorModel()
    {
        $database = Factory::createDatabaseWrapper();
        $model = Factory::buildObject('ErrorModel');

        $model->setDatabaseHandle($database);
        $model->setErrorType($this->error_type);
        $model->selectErrorMessage();
        $model->logErrorMessage();
        $error_message = $model->getErrorMessage();
        return $error_message;
    }

    public function createOutputView($error_message)
    {
        $view = Factory::buildObject('ErrorView');
        $view->setErrorMessage($error_message);
        $view->createErrorMessage();
        $html_output = $view->getHtmlOutput();

        return $html_output;
    }
}
