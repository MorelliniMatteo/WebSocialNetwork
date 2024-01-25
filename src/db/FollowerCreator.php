<?php

include_once('database.php');

class FollowerCreator {
    private $database;

    public function __construct() {
        $this->database = new Database();
    }

    public function createFollower($followerUserID, $followingUserID) {
        // Validate input (you should perform more comprehensive validation)
        if (empty($followerUserID) || empty($followingUserID)) {
            return "Please fill in all required fields.";
        }

        // Insert follower data into the database
        $result = $this->database->insertFollower($followerUserID, $followingUserID);

        if ($result) {
            return "Follower creation successful!";
        } else {
            return "Follower creation failed. Please try again later.";
        }
    }
}

?>
