<?php
include_once('../db/database.php');
include_once('viewFullPost.php');

// Assume the user is logged in and you have the user ID
$loggedInUserID = 4; //Replace with the actual logged-in user ID

$database = new Database();

$userData = $database->getUserByID($loggedInUserID);

$posts = $database->getPostFromFollowing($loggedInUserID, 0);

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <header>
         <ul>
             <li><img class="logo" src="../img/logo-senza-sfondo.png" alt="logo"></li>
             <li><a href="notifications.php"><img class="icon" src="../icon/notifications.svg" alt="notifications"></a></li>
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
    <main>
         <form>
             <input type="text" id="Search" placeholder="Search for your artists" title="search bar">
         </form>
         <div class="posts-container">
            <?php if (!empty($posts)) : ?>
                <?php foreach ($posts as $post) : ?>
                    <?php viewPostHTML($post, $userData, $database); ?>
                <?php endforeach; ?>
            <?php else : echo "No more posts available from following."; endif; ?>
        </div>
        <div class="space">
            <p>space</p>
        </div>
    </main>
    
    <?php include_once("Nav.php"); ?>
    
    <script src="../js/post.js"></script>
    <script src="../js/menuTheme.js"></script>
    <script src="../js/infinityScroll.js"></script>
 </body>
</html>