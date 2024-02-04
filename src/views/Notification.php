<?php

include_once('../db/database.php');

$database = new Database();

$userID = 2;

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/Notification.css">


</head>
<body>

    <header class="header">
        <span class="user-id" id="userId">1</span>
    </header>

    <div class="notification-container">
        <button id="notificationBtn"><img class="icon" src="../icon/notifications.svg" alt="notifications"></button>
        <div class="notification-dropdown" id="notificationDropdown"></div>
    </div>

    <div id="toastBox"></div>

    
</body>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="../js/Notification.js"></script>
</html>