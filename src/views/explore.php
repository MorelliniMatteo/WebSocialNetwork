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
    <link rel="stylesheet" href="../css/post.css">
    <link rel="stylesheet" href="../css/explore.css">
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
            <input type="text" id="Search" placeholder="Search for your arts" title="search bar">
        </form>
        <div class="posts-container">
           <div class="post-img">
               <img src="../img/explore/pic_1.jpg" alt="Post Image">
           </div>
           <div class="post-img">
               <img src="../img/explore/pic_2.jpg" alt="Post Image">
           </div>
           <div class="post-img">
               <img src="../img/explore/pic_3.png" alt="Post Image">
           </div>
           <div class="post-img">
               <img src="../img/explore/pic_4.jpg" alt="Post Image">
           </div>
           <div class="post-img">
               <img src="../img/explore/pic_5.jpg" alt="Post Image">
           </div>
           <div class="post-img">
               <img src="../img/explore/pic_6.jpg" alt="Post Image">
           </div>
           <div class="post-img">
               <img src="../img/explore/pic_7.jpg" alt="Post Image">
           </div>
           <div class="post-img">
               <img src="../img/explore/pic_8.jpg" alt="Post Image">
           </div>
           <div class="post-img">
               <img src="../img/explore/pic_9.jpg" alt="Post Image">
           </div>
           <div class="post-img">
               <img src="../img/explore/pic_10.jpg" alt="Post Image">
           </div>
           <div class="post-img">
               <img src="../img/explore/pic_11.jpg" alt="Post Image">
           </div>
           <div class="post-img">
               <img src="../img/explore/pic_12.jpg" alt="Post Image">
           </div>
           <div class="post-img">
               <img src="../img/explore/pic_13.jpg" alt="Post Image">
           </div>
           <div class="post-img">
               <img src="../img/explore/pic_14.jpg" alt="Post Image">
           </div>
           <div class="post-img">
               <img src="../img/explore/pic_15.jpg" alt="Post Image">
           </div>
        </div>
   </main>

   <?php include_once("Nav.php"); ?>

   <script src="../js/home.js"></script>
</body>
</html>