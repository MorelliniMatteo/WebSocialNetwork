<?php

include_once('database.php');

class MessageCreator {
    private $database;

    public function __construct() {
        $this->database = new Database();
    }

    public function createMessage($senderID, $receiverID, $messageText) {
        // Validate input (you should perform more comprehensive validation)
        if (empty($senderID) || empty($receiverID) || empty($messageText)) {
            return "Please fill in all required fields.";
        }

        // Insert message data into the database
        $result = $this->database->insertMessage($senderID, $receiverID, $messageText);

        if ($result) {
            return "Message creation successful!";
        } else {
            return "Message creation failed. Please try again later.";
        }
    }
}



?>
