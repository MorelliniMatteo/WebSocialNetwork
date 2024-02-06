<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verifica se l'utente è autenticato
if (!isset($_SESSION['user_id'])) {
    // Utente non autenticato, potresti reindirizzarlo alla pagina di login
    header('Location: login.php');
    exit();
}

// Ottieni l'ID dell'utente dalla sessione
$loggedInUserID = $_SESSION['user_id'];

include_once('../db/database.php');

$database = new Database();

// Fetch user data
$userData = $database->getUserByID($loggedInUserID);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>ArtHub - Home Page</title>
    <meta charset="UTF-8">
    <link href="../css/home.css" type="text/css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/post.css">
    <link rel="stylesheet" href="../css/Notification.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <header>
         <ul>
             <li><img class="logo" src="../img/logo-senza-sfondo.png" alt="logo"></li>
             <li>
                <div class="notification-container">
                    <button id="notificationBtn"><img class="icon" src="../icon/notifications.svg" alt="notifications"></button>
                    <div class="notification-dropdown" id="notificationDropdown"></div>
                </div>
                <div id="toastBox"></div>
             </li>
             <li><img class="icon menu" src="../icon/menu.svg" alt="menu"></li>
         </ul>
         <aside class="menu-content">
            <img src="../icon/sun.svg" alt="sun" class="icon theme">
            <div>
                <input type="checkbox" class="checkbox" id="checkbox" title="change theme">
                <label for="checkbox" class="label">
                    <span class="ball"></span>
                </label>
            </div>
            <img src="../icon/moon.svg" alt="moon" class="icon theme">
         </aside>
    </header>
    <main class="home">
         <form>
             <input type="text" id="Search" placeholder="Search for your artists" title="search bar">
         </form>
         <div class="posts-container"></div>
        <div class="space">
            <p>space</p>
        </div>
    </main>
    
    <?php include_once("Nav.php"); ?>
    
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="../js/post.js"></script>
    <script src="../js/menuTheme.js"></script>
    <script src="../js/infinityScroll.js"></script>
    <script src="../js/Notification.js"></script>
 </body>
</html>