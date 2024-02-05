<?php  
include_once("../db/database.php");

// Assume the user is logged in and you have the user ID
$loggedInUserID = 1; //Replace with the actual logged-in user ID

$database = new Database();

$userData = $database->getUserByID($loggedInUserID);

// $posts = $database->getRandomPosts();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>ArtHub - Explore</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/explore.css">
</head>
<body>
    <header>
         <ul>
             <li><img class="logo" src="../img/logo-senza-sfondo.png" alt="logo"></li>
             <li><a href="Notification.php"><img class="icon" src="../icon/notifications.svg" alt="notifications"></a></li>
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
    <main class="explore">
        <form>
            <input type="text" id="Search" placeholder="Search for your arts" title="search bar">
        </form>
        <div class="posts-container"></div>
        <div class="space"></div>
   </main>

   <?php include_once("Nav.php"); ?>

   <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
   <script src="../js/menuTheme.js"></script>
   <script src="../js/infinityScroll.js"></script>
</body>
</html>