<?php

/**
 * EventController.php
 */
/**
 * Manages event-related actions and interactions between the model and view layers for event management within the application.
 */
class EventController extends ControllerAbstract
{
    private $eventModel;
    private $view;

    /**
     * Constructs the EventController with necessary dependencies.
     * @param $eventModel The model handling event data operations.
     * @param $view The view rendering the event UI.
     */
    public function __construct($eventModel, $view)
    {
        parent::__construct();
        $this->eventModel = $eventModel;
        $this->view = $view;

    }
    /**
     * Retrieves all events and directs the view to render the events page.
     */
    public function listAllEvents()
    {
        $view = Factory::buildObject('EventView');
        $events = $this->eventModel->listAllEvents();
        $view->setEvents($events);
        $view->createEventsPage();
        $this->html_output =$view->getHtmlOutput(); // Return the output directly
        echo $this->html_output;

    }
    /**
     * Retrieves events specific to a user and directs the view to render these events.
     * @param $userId The unique identifier for the user whose events are to be listed.
     */
    public function showUserEvents($userId)
    {
        $view = Factory::buildObject('UserEventsView');  // Make sure this matches the correct class name
        $userEvent = $this->eventModel->getEventsForUser($userId);
        $view->setUserEvent($userEvent);
        $view->createUserEventPage();
        $this->html_output = $view->getHtmlOutput(); // Return the output directly
        echo $this->html_output;

    }
    /**
     * Handles the deletion of a specified event after validating the CSRF token.
     * @param $eventId The unique identifier for the event to be deleted.
     */
    public function deleteEvent($eventId)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $this->checkCsrfToken()) {
            // Check if eventId is properly passed and numeric
                $eventId = $_GET['id'];
                // Proceed with the deletion logic
                $this->eventModel->deleteEventById($eventId);
                $_SESSION['profile_message'] = "Event deleted successfully.";
                header("Location: /userEvents"); // Redirect to the events page
                exit;
        } else {
            // CSRF check failed or method was not POST
            $_SESSION['profile_errors'] = ['Invalid request. Please try again.'];
            header("Location: /userEvents");
            exit;
        }
    }

    private function checkCsrfToken(): bool
    {
        return isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token'];
    }
    /**
     * Displays the form to add a new event using the view component.
     */
    public function showAddEventForm()
    {
        $view = Factory::buildObject('UserAddEventsView'); // Use the correct View class for adding events
        $view->createUserAddEventPage(); // Method to create the add event page
        $this->html_output = $view->getHtmlOutput();
        echo $this->html_output;
    }
    /**
     * Handles the submission of the new event form, validating CSRF and processing the event data.
     * @param $postData Array containing the form data from the request.
     * @param $userId The ID of the user adding the event.
     */
    public function processAddUserEvent($postData, $userId)
    {
        if (isset($postData['csrf_token'], $postData['event_name'], $postData['event_date'], $postData['event_venue']) &&
            $this->checkCsrfToken($postData['csrf_token'])) {
            // Prepare data for insertion
            $eventDetails = [
                'user_id' => $userId,
                'event_name' => $postData['event_name'],
                'event_date' => $postData['event_date'],
                'event_venue' => $postData['event_venue'],
            ];
            try {
                $this->eventModel->addUserEvent($eventDetails);
                $_SESSION['profile_message'] = "Event added successfully.";
                header("Location: /userEvents"); // Redirect to a confirmation or events list page
            } catch (Exception $e) {
                $_SESSION['profile_errors'] = ['Failed to add event: ' . $e->getMessage()];
                header("Location: /addUserEvent"); // Redirect back to form on error
            }
        } else {
            $_SESSION['profile_errors'] = ['Invalid CSRF token. Please try again.'];
            header("Location: /addUserEvent");
        }
        exit;
    }
    /**
     * Displays the form to edit an existing event, pulling data for a specific event.
     * @param $eventId The ID of the event to be edited.
     */
    public function editEventForm($eventId) {
        $event = $this->eventModel->getEventById($eventId);
        if (!$event) {
            $_SESSION['profile_errors'] = ['Event not found.'];
            header("Location: /userEvents");
            exit;
        }
        // Pass the fetched event data to the view
        $view = Factory::buildObject('UserEditEventsView');
        $view->setUserEditEvent($event); // Make sure to pass the event data here
        $view->createUserEditEventPage();
        echo $view->getHtmlOutput();
    }
    /**
     * Updates an event's details after validating CSRF token and ensuring authorized access.
     * @param $eventId The ID of the event to update.
     * @param $postData Array containing the form data from the request.
     * @param $userId The ID of the user updating the event.
     */
    public function updateEventForm($eventId, $postData, $userId)
    {
        if (!$this->checkCsrfToken($postData['csrf_token'])) {
            $_SESSION['profile_errors'] = ['Invalid CSRF token. Please try again.'];
            header("Location: /editEvent/?id=" . $eventId);
            exit;
        }

        if ($this->eventModel->updateEventById($eventId, $postData, $userId)) {
            $_SESSION['profile_message'] = "Event updated successfully.";
        } else {
            $_SESSION['profile_errors'] = ['Failed to update event or unauthorized attempt.'];
        }
        header("Location: /userEvents"); // Redirect back to the user events page
        exit;
    }
    /**
     * Generates and sets the HTML output for the view based on the controller's actions.
     */
    public function createHtmlOutput()
    {
        // Return the HTML output
    }
}
