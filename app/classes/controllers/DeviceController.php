<?php

/**
 * DeviceController.php
 */
class DeviceController extends ControllerAbstract
{
    private $deviceModel;
    private $view;

    public function __construct($deviceModel, $view)
    {
        parent::__construct();
        $this->deviceModel = $deviceModel;
        $this->view = $view;
    }
    public function listAllDevices()
    {
        $devices = $this->deviceModel->listAllDevices();
        $this->view->setDevices($devices);
        $this->view->createDevicesPage();
    }

    public function listUserDevices($userId)
    {
        $devices = $this->deviceModel->getDevicesByUserId($userId);
        //... create HTML output for displaying the list of devices
    }

    public function addDevice($userId, $deviceDetails)
    {
        $this->deviceModel->insertNewDevice($deviceDetails);
        //... create HTML output for successful device addition or display error
    }

    public function updateDevice($userId, $deviceId, $deviceDetails)
    {
        $this->deviceModel->updateDeviceById($deviceDetails);
        //... create HTML output for successful device update or display error
    }

    public function deleteDevice($userId, $deviceId)
    {
        $this->deviceModel->deleteDeviceById($deviceId, $userId);
        //... create HTML output for successful device deletion or display error
    }

    public function createHtmlOutput()
    {
        $view = Factory::buildObject('DeviceView');
        $listAllDevices = $this->deviceModel->listAllDevices();
        $view->setDevices($listAllDevices);
        $view->createDevicesPage();
        $this->html_output = $view->getHtmlOutput();
        echo $this->html_output;
    }

    // Add other methods as needed for creating HTML output for each action
}
