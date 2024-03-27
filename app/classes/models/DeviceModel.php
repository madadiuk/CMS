<?php
/**
 * DeviceModel.php
 */

class DeviceModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
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
}
