<?php

include_once('../db/database.php');

// Get data from the AJAX request
$senderID = $_POST['senderID'];
$receiverID = $_POST['receiverID'];

$messageText = isset($_POST['messageText']) ? trim($_POST['messageText']) : '';


$database = new Database();
$result = $database->insertMessage($senderID, $receiverID, $messageText);


$response = [];

if ($result) {
    $response['success'] = true;
} else {
    $response['success'] = false;
    $response['error'] = 'Error inserting message into the database';
}

echo json_encode($response);