<?php

/**
 * DeviceController.php
 */
/**
 * Manages device-related actions and interactions between the model and view layers for device management within the application.
 */
class DeviceController extends ControllerAbstract
{
    private $deviceModel;
    private $view;
    /**
     * Constructs the DeviceController with necessary dependencies.
     * @param $deviceModel The model handling device data operations.
     * @param $view The view rendering the device UI.
     */
    public function __construct($deviceModel, $view)
    {
        parent::__construct();
        $this->deviceModel = $deviceModel;
        $this->view = $view;
    }
    /**
     * Retrieves all devices and directs the view to render the devices page.
     */
    public function listAllDevices()
    {
        $devices = $this->deviceModel->listAllDevices();
        $this->view->setDevices($devices);
        $this->view->createDevicesPage();
        echo $this->view->getHtmlOutput(); // Directly output the HTML from the view
    }
    /**
     * Retrieves devices specific to a user and directs the view to render these devices.
     * @param $userId The unique identifier for the user whose devices are to be listed.
     */
    public function listUserDevices($userId)
    {
        $devices = $this->deviceModel->getDevicesByUserId($userId);
        $this->view->setUserDevice($devices);
        $this->view->createUserDevicePage();
        echo $this->view->getHtmlOutput(); // Directly output the HTML from the view
    }
    /**
     * Displays the form to add a new device using the view component.
     */
    public function showAddDeviceForm()
    {
        $view = new AddDeviceView();
        $view->createAddDevicesPage();
        echo $view->getHtmlOutput();
    }
    /**
     * Handles the submission of the new device form, validating and processing the uploaded device image and data.
     */
    public function processAddDevice()
    {
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            die('CSRF token validation failed.');
        }

        if ($_FILES['deviceImage']['error'] == 0) {
            $allowed = ['jpg', 'jpeg'];
            $fileExtension = pathinfo($_FILES['deviceImage']['name'], PATHINFO_EXTENSION);

            if (!in_array(strtolower($fileExtension), $allowed)) {
                die('Invalid file type. Only JPG files are allowed.');
            }

            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($finfo, $_FILES['deviceImage']['tmp_name']);
            finfo_close($finfo);

            if ($mimeType !== 'image/jpeg') {
                die('Invalid file type. Only JPG files are allowed.');
            }

            $deviceVisible = isset($_POST['deviceVisible']) ? true : false;

            // Define the path to store uploaded files using MEDIA_PATH
            $mediaPath = MEDIA_PATH;  // This should be a server path

            $newFileName = uniqid() . '.' . $fileExtension;
            $newFilePath =  $mediaPath . 'img/' . $newFileName;
//            echo "MEDIA_PATH is set to: " . MEDIA_PATH . "<br>";
//            echo "Attempting to save to: " . $newFilePath . "<br>";

            if (move_uploaded_file($_FILES['deviceImage']['tmp_name'], $newFilePath)) {
                $deviceDetails = [
                    'fk_user_id' => $_SESSION['user_id'],
                    'crypto_device_name' => $_POST['deviceName'],
                    'crypto_device_image_name' => 'img/'.  $newFileName,
                    'crypto_device_record_visible' => $deviceVisible
                ];

                $this->deviceModel->insertNewDevice($deviceDetails);
                $_SESSION['success_message'] = "Device added successfully!"; // Store success message
                header("Location: /listDevices"); // Redirect to device list page
                exit;
            } else {
                echo "Failed to upload file.";
            }
        } else {
            echo "Error in file upload.";
        }
    }
    /**
     * Displays the form to edit a device using the view component.
     * @param $deviceId The unique identifier for the device to be edited.
     */
    public function showEditDeviceForm($deviceId)
    {
        $device = $this->deviceModel->getDeviceById($deviceId);
        if ($device) {
            $this->view->setEditDevices($device);
            $this->view->createEditDevicesPage();
            echo $this->view->getHtmlOutput();
        } else {
            // Redirect or show an error
            echo "Device not found.";
        }
    }

    /**
     * Processes the submission of the edit device form, updating the device data in the database.
     * @param $deviceId The unique identifier for the device to be edited.
     * @param $postData The data submitted via the edit device form.
     */
    public function processEditDevice($deviceId, $postData) {
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            die('CSRF token validation failed.');
        }

        $currentDevice = $this->deviceModel->getDeviceById($deviceId);
        if (!$currentDevice) {
            echo "Device not found.";
            return;
        }

        $newFileName = $currentDevice['crypto_device_image_name']; // Default to current image
        if ($_FILES['deviceImage']['error'] == 0) {
            $allowed = ['jpg', 'jpeg'];
            $fileExtension = pathinfo($_FILES['deviceImage']['name'], PATHINFO_EXTENSION);

            if (!in_array(strtolower($fileExtension), $allowed)) {
                die('Invalid file type. Only JPG files are allowed.');
            }

            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($finfo, $_FILES['deviceImage']['tmp_name']);
            finfo_close($finfo);

            if ($mimeType !== 'image/jpeg') {
                die('Invalid file type. Only JPG files are allowed.');
            }

            // Define the path to store uploaded files using MEDIA_PATH
            $mediaPath = MEDIA_PATH; // This should be a server path
            $newFileName = 'img/' . uniqid() . '.' . $fileExtension;
            $newFilePath = $mediaPath . $newFileName;

            if (!move_uploaded_file($_FILES['deviceImage']['tmp_name'], $newFilePath)) {
                echo "Failed to upload file.";
                return;
            }
        }

        $deviceDetails = [
            'crypto_device_name' => $_POST['deviceName'],
            'crypto_device_image_name' => $newFileName,
            'crypto_device_record_visible' => isset($_POST['deviceVisible']) ? 1 : 0,
            'crypto_device_id' => $deviceId
        ];

        $this->deviceModel->updateDeviceById($deviceId, $deviceDetails);
        $_SESSION['success_message'] = "Device updated successfully!";
        header("Location: /listDevices");
        exit;
    }


    /**
     * Deletes a specific device owned by a user.
     * @param $userId The ID of the user who owns the device.
     * @param $deviceId The ID of the device to delete.
     */
    public function deleteDevice($deviceId) {
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            $_SESSION['error_message'] = 'CSRF token mismatch.';
            header('Location: /listDevices');
            exit;
        }

        $this->deviceModel->deleteDeviceById($deviceId);
        $_SESSION['success_message'] = 'Device deleted successfully.';
        header('Location: /listDevices');
        exit;
    }


    /**
     * Generates and sets the HTML output for the view based on the controller's actions.
     */
    public function createHtmlOutput()
    {
        //... create HTML output based on the controller's actions
    }

}
