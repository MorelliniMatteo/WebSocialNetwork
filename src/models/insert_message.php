<?php
// insert_message.php

// Include your database connection logic
include_once('../db/database.php');

// Get data from the AJAX request
$senderID = $_POST['senderID'];
$receiverID = $_POST['receiverID'];
$messageText = $_POST['messageText'];

// Use your database class to insert the message into the database
$database = new Database();
$result = $database->insertMessage($senderID, $receiverID, $messageText);

// Prepare and send the response to the client
$response = [];

if ($result) {
    $response['success'] = true;
} else {
    $response['success'] = false;
    $response['error'] = 'Error inserting message into the database';
}

echo json_encode($response);