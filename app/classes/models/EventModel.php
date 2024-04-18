<?php

/**
 * EventModel.php
 */
/**
 * Represents a model for managing event-related data in the database.
 */
class EventModel
{
    /**
     * @var DatabaseWrapper The database wrapper instance for executing queries.
     */
    private $database;
    /**
     * Initializes the EventModel with a DatabaseWrapper instance.
     *
     * @param DatabaseWrapper $databaseWrapper The database wrapper instance.
     */
    public function __construct($databaseWrapper)
    {
        $this->database = $databaseWrapper;
    }
    /**
     * Retrieves all events from the database.
     *
     * @return array Array of event records.
     */
    public function listAllEvents()
    {
        $query = "SELECT * FROM event ORDER BY event_date DESC";
        $this->database->safeQuery($query);
        return $this->database->safeFetchAllResults();
    }
    /**
     * Retrieves all events from the database using a specific query.
     *
     * @return array Array of event records.
     */
    public function getAllEvents()
    {
        $query = SqlQuery::queryRetrieveAllEvents();
        $this->database->safeQuery($query, []);
        return $this->database->safeFetchAllResults();
    }
    /**
     * Retrieves the last three events added to the database.
     *
     * @return array Array of event records.
     */
    public function getLastThreeEvents() {
        $sql_query = SqlQuery::queryRetrieveLastThreeEvents(); // You'll need to implement this method in SqlQuery
        // Assume $database is your DatabaseWrapper instance injected into this model
        $this->database->safeQuery($sql_query);
        return $this->database->safeFetchAllResults();
    }
    /**
     * Links a user with an event in the database.
     *
     * @param int $userId The ID of the user.
     * @param int $eventId The ID of the event.
     */
    public function linkUserWithEvent($userId, $eventId)
    {
        $query = SqlQuery::queryLinkUserWithEvent();
        $params = [':fk_user_id' => $userId, ':fk_event_id' => $eventId];
        $this->database->safeQuery($query, $params);
    }
    /**
     * Retrieves events associated with a specific user ID.
     *
     * @param int $userId The ID of the user.
     * @return array Array of event records.
     */
    public function getEventsForUser($userId)
    {
        // This query should fetch events where the user_id matches the given userId
        $query = "SELECT * FROM event WHERE user_id = :userId ORDER BY event_date DESC";
        $params = [':userId' => $userId];
        $this->database->safeQuery($query, $params);
        return $this->database->safeFetchAllResults();
    }
    /**
     * Deletes an event record from the database by its ID.
     *
     * @param int $eventId The ID of the event to be deleted.
     */
    public function deleteEventById($eventId)
    {
        $query = "DELETE FROM event WHERE event_id = :eventId";
        $params = [':eventId' => $eventId];
        $this->database->safeQuery($query, $params);
    }
    /**
     * Inserts a new event record into the database.
     *
     * @param array $eventDetails Details of the event to be inserted.
     */
    public function addUserEvent($eventDetails) {
        $query = "INSERT INTO event (user_id, event_name, event_date, event_venue) VALUES (:user_id, :event_name, :event_date, :event_venue)";
        $params = [
            ':user_id' => $eventDetails['user_id'],
            ':event_name' => $eventDetails['event_name'],
            ':event_date' => $eventDetails['event_date'],
            ':event_venue' => $eventDetails['event_venue']
        ];
        $this->database->safeQuery($query, $params);
    }
    /**
     * Retrieves an event record from the database by its ID.
     *
     * @param int $eventId The ID of the event to retrieve.
     * @return array|null The event record if found, otherwise null.
     */
    public function getEventById($eventId) {
        $query = "SELECT * FROM event WHERE event_id = :eventId LIMIT 1";
        $params = [':eventId' => $eventId];
        $this->database->safeQuery($query, $params);
        return $this->database->safeFetchArray();;
//        return $this->database->safeFetchRow();
    }
    /**
     * Updates an existing event record in the database.
     *
     * @param int $eventId The ID of the event to be updated.
     * @param array $eventDetails Details of the event to be updated.
     * @param int $userId The ID of the user performing the update.
     * @return bool True if the update was successful, false otherwise.
     */
    public function updateEventById($eventId, $eventDetails, $userId)
    {
        // Verify the event belongs to the user
        $event = $this->getEventById($eventId);
        if ($event['user_id'] != $userId) {
            return false; // Prevent update if the user does not own the event
        }

        $query = "UPDATE event SET event_name = :event_name, event_date = :event_date, event_venue = :event_venue WHERE event_id = :event_id AND user_id = :user_id";
        $params = [
            ':event_name' => $eventDetails['event_name'],
            ':event_date' => $eventDetails['event_date'],
            ':event_venue' => $eventDetails['event_venue'],
            ':event_id' => $eventId,
            ':user_id' => $userId
        ];
        $this->database->safeQuery($query, $params);
        return true;
    }

    /**
     * Retrieves the database instance associated with this model.
     *
     * @return DatabaseWrapper The database wrapper instance.
     */
    public function getDatabase() {
        return $this->database;
    }
}
