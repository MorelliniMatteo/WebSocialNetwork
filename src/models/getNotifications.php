<?php


include_once('../db/database.php');


$database = new Database();
$notifications = $database->getNotifications(1); 


// Return notifications as JSON
echo json_encode($notifications);
?>
