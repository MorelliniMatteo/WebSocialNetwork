<?php
include_once('../db/database.php');

// Assume the user is logged in and you have the user ID
$loggedInUserID = 1; //Replace with the actual logged-in user ID

$database = new Database();

$userData = $database->getUserByID($loggedInUserID);

$posts = $database->getPostFromFollowing($loggedInUserID);

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
             <li><a href="#"><img class="icon" src="../icon/notifications.svg" alt="notifications"></a></li>
             <li><a href="#"><img class="icon menu" src="../icon/menu.svg" alt="menu"></a></li>
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
         <?php if (!empty($posts)) : ?>
            <?php foreach ($posts as $post) : ?>
                <div class="post-container" id="<?php $post['PostID']; ?>">
                    <div class="post">
                        <header>
                            <img src="../img/ProfileImg.png" alt="User Avatar">
                            <a href="#" label="View user profile"><?php echo $post['UserID']; ?></a>
                        </header>
                        <img src="<?php echo $post['MediaURL']; ?>" alt="Post Image">
                        <p><?php echo $post['Caption']; ?></p>
                        <section>
                            <h1>interaction</h1>
                            <img class="icon likeButton" src="../icon/like-empty.svg" alt="like button" onclick="changeLike()">
                            <img class="icon commentButton" src="../icon/comment-empty.svg" alt="comment button" onclick="changeComment(/*passare l'id del post*/)">
                            <img class="icon shareButton" src="../icon/share.svg" alt="comment button" onclick="share()">               
                        </section>
                    </div>
                    <aside class="comments">
                        <h2>Commenti</h2>
                        <p class="description">The temporary exhibition.</p>
                        <p>first comment</p>
                        <p>second comment</p>
                        <input type="text" placeholder="aggiungi un commento" title="add comment">
                    </aside>
                </div>
            <?php endforeach; ?>
        <?php else : echo "Nessun post disponibile dai seguiti."; endif; ?>
        <div class="space">
            <p>space</p>
        </div>
    </main>
    
    <?php include_once("Nav.php"); ?>
    
    <script src="../js/post.js"></script>
    <script src="../js/home.js"></script>
 </body>
</html>