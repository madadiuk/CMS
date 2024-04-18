<?php
/**
 * DeviceModel.php
 */

/**
 * Represents a model for managing device-related data in the database.
 */
class DeviceModel
{
    /**
     * @var DatabaseWrapper The database wrapper instance for executing queries.
     */
    private $database;
    /**
     * Initializes the DeviceModel with a DatabaseWrapper instance.
     *
     * @param DatabaseWrapper $databaseWrapper The database wrapper instance.
     */
    public function __construct($databaseWrapper)
    {
        $this->database = $databaseWrapper;
    }
    /**
     * Retrieves all devices from the database.
     *
     * @return array Array of device records.
     */
    public function listAllDevices()
    {
        // Include only visible devices in the results
        $query = "SELECT * FROM crypto_device WHERE crypto_device_record_visible = TRUE ORDER BY crypto_device_id DESC";
        $this->database->safeQuery($query);
        return $this->database->safeFetchAllResults();
    }
    /**
     * Retrieves devices associated with a specific user ID.
     *
     * @param int $userId The ID of the user.
     * @return array Array of device records.
     */
    public function getDevicesByUserId($userId)
    {
        $query = "SELECT * FROM crypto_device WHERE fk_user_id = :user_id ORDER BY crypto_device_registered_timestamp DESC";
        $params = [':user_id' => $userId];
        $this->database->safeQuery($query, $params);
        return $this->database->safeFetchAllResults();
    }
    /**
     * Inserts a new device record into the database.
     *
     * @param array $deviceDetails Details of the device to be inserted.
     */
    public function insertNewDevice($deviceDetails)
    {
        $query = "INSERT INTO crypto_device (fk_user_id, crypto_device_name, crypto_device_image_name, crypto_device_record_visible) VALUES (:fk_user_id, :crypto_device_name, :crypto_device_image_name, :crypto_device_record_visible)";
        $this->database->safeQuery($query, $deviceDetails);
    }
    /**
     * Updates an existing device record in the database.
     *
     * @param int $deviceId The ID of the device to be updated.
     * @param array $deviceDetails Details of the device to be updated.
     */
    public function updateDeviceById($deviceId, $deviceDetails) {
        $query = "UPDATE crypto_device SET crypto_device_name = :crypto_device_name, crypto_device_image_name = :crypto_device_image_name, crypto_device_record_visible = :crypto_device_record_visible WHERE crypto_device_id = :crypto_device_id";
        $params = [
            ':crypto_device_id' => $deviceDetails['crypto_device_id'],
            ':crypto_device_name' => $deviceDetails['crypto_device_name'],
            ':crypto_device_image_name' => $deviceDetails['crypto_device_image_name'],
            ':crypto_device_record_visible' => $deviceDetails['crypto_device_record_visible']
        ];
        $this->database->safeQuery($query, $params);
    }

    /**
     * Deletes a device record from the database by its ID.
     *
     * @param int $deviceId The ID of the device to be deleted.
     */
    public function deleteDeviceById($deviceId) {
        $query = "DELETE FROM crypto_device WHERE crypto_device_id = :device_id";
        $params = [':device_id' => $deviceId];
        $this->database->safeQuery($query, $params);
    }

    /**
     * Retrieves the last four devices added to the database.
     *
     * @return array Array of device records.
     */
    public function getLastFourDevices() {
        $query = "SELECT crypto_device_id, crypto_device_name, crypto_device_image_name, crypto_device_record_visible, crypto_device_registered_timestamp  FROM crypto_device ORDER BY crypto_device_id DESC LIMIT 4";
        $this->database->safeQuery($query);
        return $this->database->safeFetchAllResults();
    }
    public function getDeviceById($deviceId)
    {
        $query = "SELECT * FROM crypto_device WHERE crypto_device_id = :device_id";
        $params = [':device_id' => $deviceId];
        $this->database->safeQuery($query, $params);
        return $this->database->safeFetchArray();
    }

}
