<?php
// Include your database connection or initialization code here
include_once('../db/database.php');

// Check if the notification ID is provided in the POST request
if (isset($_POST['notificationID'])) {
    $notificationID = $_POST['notificationID'];

    // Create an instance of the Database class
    $database = new Database();

    // Attempt to remove the notification
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
