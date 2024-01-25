<?php

include_once('database.php');

class NotificationCreator {
    private $database;

    public function __construct() {
        $this->database = new Database();
    }

    public function createNotification($userID, $notificationText) {
        // Validate input (you should perform more comprehensive validation)
        if (empty($userID) || empty($notificationText)) {
            return "Please fill in all required fields.";
        }

        // Insert notification data into the database
        $result = $this->database->insertNotification($userID, $notificationText);

        if ($result) {
            return "Notification creation successful!";
        } else {
            return "Notification creation failed. Please try again later.";
        }
    }
}


?>
