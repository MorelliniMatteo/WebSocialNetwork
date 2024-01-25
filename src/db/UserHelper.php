<?php

include_once('database.php');

class UserHelper {
    private $database;

    public function __construct() {
        $this->database = new Database();
    }

    public function registerUser($username, $password, $email, $bio) {
        // Validate input (you should perform more comprehensive validation)
        if (empty($username) || empty($password) || empty($email)) {
            return "Please fill in all required fields.";
        }

        // Check if the username or email already exists
        $existingUser = $this->database->getUserByUsername($username);
        $existingEmail = $this->database->getUserByEmail($email);

        if ($existingUser || $existingEmail) {
            return "Username or email already exists. Please choose a different one.";
        }

        // Hash the password (you should use password_hash() in a real-world scenario)
        $hashedPassword = md5($password);

        // Insert user data into the database
        $result = $this->database->insertUser($username, $hashedPassword, $email, $bio);

        if ($result) {
            return "Registration successful!";
        } else {
            return "Registration failed. Please try again later.";
        }
    }

    public function isRegisteredUser($username, $password) {
        // Validate input (you should perform more comprehensive validation)
        if (empty($username) || empty($password)) {
            return false;
        }

        // Retrieve user data from the database
        $userData = $this->database->getUserByUsername($username);

        // Check if the user exists and the password is correct
        if ($userData && md5($password) === $userData['Password']) {
            return true;
        }

        return false;
    }

    public function updateUserData($userID, $newUsername, $newEmail, $newBio) {
        // Validate input (you should perform more comprehensive validation)
        if (empty($newUsername) || empty($newEmail)) {
            return false;
        }

        // Check if the new username or email already exists
        $existingUser = $this->database->getUserByUsername($newUsername);
        $existingEmail = $this->database->getUserByEmail($newEmail);

        if ($existingUser && $userID !== $existingUser['UserID']) {
            return false; // Username already exists
        }

        if ($existingEmail && $userID !== $existingEmail['UserID']) {
            return false; // Email already exists
        }

        // Update user data in the database
        $result = $this->database->updateUser($userID, $newUsername, $newEmail, $newBio);

        return $result;
    }

    public function getUserByID($userID) {
        // Retrieve user data from the database by user ID
        $userData = $this->database->getUserByID($userID);

        return $userData;
    }
}

?>
