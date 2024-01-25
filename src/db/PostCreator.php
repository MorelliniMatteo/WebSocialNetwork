<?php

include_once('database.php');

class PostCreator {
    private $database;

    public function __construct() {
        $this->database = new Database();
    }

    public function createPost($userID, $mediaURL, $caption, $categoryID) {
        // Validate input (you should perform more comprehensive validation)
        if (empty($userID) || empty($mediaURL) || empty($caption) || empty($categoryID)) {
            return "Please fill in all required fields.";
        }

        // Insert post data into the database
        $result = $this->database->insertPost($userID, $mediaURL, $caption, $categoryID);

        if ($result) {
            return "Post creation successful!";
        } else {
            return "Post creation failed. Please try again later.";
        }
    }
}



?>
