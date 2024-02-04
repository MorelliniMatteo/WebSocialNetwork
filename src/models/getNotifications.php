<?php


include_once('../db/database.php');


$userID = $_GET['userID'];

$database = new Database();
$notifications = $database->getNotifications($userID); 


// Return notifications as JSON
echo json_encode($notifications);
?>
