<?php

/**
 * EventController.php
 */
class EventController extends ControllerAbstract
{
    private $eventModel;
    private $view;


    public function __construct($eventModel, $view)
    {
        parent::__construct();
        $this->eventModel = $eventModel;
        $this->view = $view;

    }

    public function listAllEvents()
    {
        $events = $this->eventModel->listAllEvents();
        $this->view->setEvents($events);
        $this->view->createEventsPage();
    }

    public function showUserEvents($userId)
    {
        $events = $this->eventModel->getEventsForUser($userId);
        //... create HTML output for the user-specific event list
    }

    public function addUserEvent($userId, $eventId)
    {
        $this->eventModel->linkUserWithEvent($userId, $eventId);
        //... create HTML output for successfully linking user to the event
    }

    public function updateEvent($eventId, $eventDetails)
    {
        $this->eventModel->updateEventById($eventDetails);
        //... create HTML output for successful event update
    }

    public function deleteEvent($eventId)
    {
        $this->eventModel->deleteEventById($eventId);
        //... create HTML output for successful event deletion
    }

    // Define createHtmlOutput method that will produce the final HTML response
    public function createHtmlOutput()
    {
        $view = Factory::buildObject('EventView');
        $listAllEvents = $this->eventModel->listAllEvents();
        $view->setEvents($listAllEvents);
        $view->createEventsPage();
        $this->html_output = $view->getHtmlOutput();
        echo $this->html_output;

    }

    // Implement additional methods to create HTML outputs for each specific action if necessary
}
