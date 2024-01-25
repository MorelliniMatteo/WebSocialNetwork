<?php

include_once('database.php');

class CommentCreator {
    private $database;

    public function __construct() {
        $this->database = new Database();
    }

    public function createComment($postID, $userID, $commentText) {
        // Validate input (you should perform more comprehensive validation)
        if (empty($postID) || empty($userID) || empty($commentText)) {
            return "Please fill in all required fields.";
        }

        // Insert comment data into the database
        $result = $this->database->insertComment($postID, $userID, $commentText);

        if ($result) {
            return "Comment creation successful!";
        } else {
            return "Comment creation failed. Please try again later.";
        }
    }
}


?>
