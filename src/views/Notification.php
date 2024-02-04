<?php

session_start();

include_once('../db/database.php');

$database = new Database();

// Verifica se l'utente è autenticato
if (!isset($_SESSION['user_id'])) {
    // Utente non autenticato, potresti reindirizzarlo alla pagina di login
    header('Location: login.php');
    exit();
}

// Ottieni l'ID dell'utente dalla sessione
$userID = $_SESSION['user_id'];

echo $userID;

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
        <span class="user-ID" id="userID"><?php echo $userID; ?></span>
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