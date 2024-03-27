<?php

/**
 * EventModel.php
 */
class EventModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function getAllEvents()
    {
        $query = SqlQuery::queryRetrieveAllEvents();
        $this->database->safeQuery($query, []);
        return $this->database->safeFetchAllResults();
    }

    public function linkUserWithEvent($userId, $eventId)
    {
        $query = SqlQuery::queryLinkUserWithEvent();
        $params = [':fk_user_id' => $userId, ':fk_event_id' => $eventId];
        $this->database->safeQuery($query, $params);
    }

    public function getEventsForUser($userId)
    {
        $query = SqlQuery::queryRetrieveEventsForUser();
        $params = [':user_id' => $userId];
        $this->database->safeQuery($query, $params);
        return $this->database->safeFetchAllResults();
    }

    public function updateEventById($eventDetails)
    {
        $query = SqlQuery::queryUpdateEventById();
        $this->database->safeQuery($query, $eventDetails);
    }

    public function deleteEventById($eventId)
    {
        $query = SqlQuery::queryDeleteEventById();
        $params = [':event_id' => $eventId];
        $this->database->safeQuery($query, $params);
    }
}
