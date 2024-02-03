<?php
// Include your database class or connection logic
include('../db/database.php');

// Get parameters from the AJAX request
$senderID = $_POST['senderID'];
$currentUserID = $_POST['currentUserID'];
$database = new Database();

// Fetch messages based on the sender and current user IDs
$messages = $database->getMessages($senderID, $currentUserID);

// Return messages as JSON
echo json_encode($messages);
?>
