<?php

include('../db/database.php');


$senderID = $_POST['senderID'];
$currentUserID = $_POST['currentUserID'];
$database = new Database();


$messages = $database->getMessages($senderID, $currentUserID);


echo json_encode($messages);
?>
