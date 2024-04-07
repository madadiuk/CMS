<?php
/**
 * DeviceModel.php
 */

class DeviceModel
{
    private $database;

    public function __construct($databaseWrapper)
    {
        $this->database = $databaseWrapper;
    }
    public function listAllDevices()
    {
        $query = "SELECT * FROM crypto_device ORDER BY crypto_device_id DESC";
        $this->database->safeQuery($query);
        return $this->database->safeFetchAllResults();
    }

    public function getDevicesByUserId($userId)
    {
        $query = SqlQuery::queryRetrieveDevicesByUserId();
        $params = [':user_id' => $userId];
        $this->database->safeQuery($query, $params);
        return $this->database->safeFetchAllResults();
    }

    public function insertNewDevice($deviceDetails)
    {
        $query = SqlQuery::queryInsertNewDevice();
        $this->database->safeQuery($query, $deviceDetails);
    }

    public function updateDeviceById($deviceDetails)
    {
        $query = SqlQuery::queryUpdateDeviceById();
        $this->database->safeQuery($query, $deviceDetails);
    }

    public function deleteDeviceById($deviceId, $userId)
    {
        $query = SqlQuery::queryDeleteDeviceById();
        $params = [':crypto_device_id' => $deviceId, ':fk_user_id' => $userId];
        $this->database->safeQuery($query, $params);
    }
    public function getLastFourDevices() {
        $query = "SELECT crypto_device_id, crypto_device_name, crypto_device_image_name, crypto_device_record_visible, crypto_device_registered_timestamp  FROM crypto_device ORDER BY crypto_device_id DESC LIMIT 4";
        $this->database->safeQuery($query);
        return $this->database->safeFetchAllResults();
    }
}
