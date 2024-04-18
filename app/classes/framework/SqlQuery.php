<?php
/**
 * SqlQuery.php
 * PHP web application to demonstrate how databases are accessed securely
 *
 *This class groups together all the SQL queries that are used within the application
 *
 * @author M Madadi
 * @copyright De Montfort University
 *
 * @package CryptoShow system CMS
 */

class SqlQuery
{

    public function __construct(){}

    public function __destruct(){}

    public static function queryGetUserByEmail(): string
    {
        return "SELECT user_id, user_hashed_password FROM registered_user WHERE user_email = :user_email;";
    }

    public static function queryInsertNewUser(): string
    {
        return "INSERT INTO registered_user (user_nickname, user_name, user_email, user_hashed_password, user_device_count, user_registered_timestamp)
                VALUES (:user_nickname, :user_name, :user_email, :user_hashed_password, :user_device_count, NOW());";
    }

    public static function queryRetrieveDevicesByUserId(): string
    {
        return "SELECT * FROM crypto_device WHERE fk_user_id = :user_id;";
    }

    public static function queryInsertNewDevice(): string
    {
        return "INSERT INTO crypto_device (fk_user_id, crypto_device_name, crypto_device_image_name, crypto_device_record_visible, crypto_device_registered_timestamp)
                VALUES (:fk_user_id, :crypto_device_name, :crypto_device_image_name, :crypto_device_record_visible, NOW());";
    }

    public static function queryRetrieveAllEvents(): string
    {
        return "SELECT * FROM event;";
    }

    public static function queryLinkUserWithEvent(): string
    {
        return "INSERT INTO user_event (fk_user_id, fk_event_id) VALUES (:fk_user_id, :fk_event_id);";
    }

    public static function queryRetrieveEventsForUser(): string
    {
        return "SELECT e.* FROM event e
                INNER JOIN user_event ue ON e.event_id = ue.fk_event_id
                WHERE ue.fk_user_id = :user_id;";
    }

    public static function queryUpdateDeviceById(): string
    {
        return "UPDATE crypto_device SET 
            crypto_device_name = :crypto_device_name, 
            crypto_device_image_name = :crypto_device_image_name, 
            crypto_device_record_visible = :crypto_device_record_visible
            WHERE crypto_device_id = :crypto_device_id AND fk_user_id = :fk_user_id;";
    }

    public static function queryDeleteDeviceById(): string
    {
        return "DELETE FROM crypto_device WHERE crypto_device_id = :crypto_device_id AND fk_user_id = :fk_user_id;";
    }

    public static function queryUpdateEventById(): string
    {
        return "UPDATE event SET 
            event_name = :event_name, 
            event_date = :event_date, 
            event_venue = :event_venue
            WHERE event_id = :event_id;";
    }

    public static function queryDeleteEventById() {
        return "DELETE FROM event WHERE event_id = :event_id;";
    }
    public static function queryRetrieveLastThreeEvents(): string {
        return "SELECT * FROM event WHERE event_date >= CURDATE() ORDER BY event_date ASC LIMIT 3;";
    }


}
