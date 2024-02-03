<?php

include_once('../db/database.php');


if (isset($_POST['notificationID'])) {
    $notificationID = $_POST['notificationID'];


    $database = new Database();


    $success = $database->removeNotification($notificationID);

    // Return response based on the success status
    if ($success) {
        echo json_encode(array('status' => 'success', 'message' => 'Notification removed successfully from php'));
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'Error removing notification from php'));
    }
} else {
    // Return an error response if notification ID is not provided
    echo json_encode(array('status' => 'error', 'message' => 'Notification ID not provided'));
}
?>
