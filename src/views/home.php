<?php
include_once('../models/database.php');

// Assume the user is logged in and you have the user ID
$loggedInUserID = 2; //Replace with the actual logged-in user ID

$database = new Database();

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <header>
         <ul>
             <li><img class="logo" src="../img/logo-senza-sfondo.png" alt="logo"></li>
             <li><a href="#"><img class="icon" src="../icon/notifications.svg" alt="notifications"></a></li>
             <li><a href="#" onclick="changeTheme"><img class="icon menu" src="../icon/menu.svg" alt="menu"></a></li>
         </ul>
         <aside class="menu-content">
            <img src="../icon/sun.svg" alt="sun" class="icon theme">
            <div>
                <input type="checkbox" class="checkbox" id="checkbox">
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
         <div class="post-container" id="Audemars_Piguet">
            <div class="post">
                <header>
                    <img src="../img/ProfileImg.png" alt="User Avatar">
                    <a href="#" aria-label="View user profile">Audemars Piguet</a>
                </header>
                <img src="../img/audemars_piguet.jpg" alt="Post Image">
                <p>The temporary exhibition, "Simply Complicated," highlights the skill and watchmaking expertise of the Code 11.59 by Audemars Piguet Universelle.</p>
                <section>
                    <h1>interaction</h1>
                    <img class="icon likeButton" src="../icon/like-empty.svg" alt="like button" onclick="changeLike()">
                    <img class="icon commentButton" src="../icon/comment-empty.svg" alt="comment button" onclick="changeComment(/*passare l'id del post*/)">
                    <img class="icon shareButton" src="../icon/share.svg" alt="comment button" onclick="share()">                
                </section>
            </div>
            <aside class="comments">
                <h2>Commenti</h2>
                <p class="description">The temporary exhibition, "Simply Complicated," highlights the skill and watchmaking expertise of the Code 11.59 by Audemars Piguet Universelle.</p>
                <p>primo commento</p>
                <p>secondo commento</p>
                <input type="text" placeholder="aggiungi un commento" title="add comment">
            </aside>
        </div>
        <div class="space">
            <p>space</p>
        </div>
    </main>

    <?php include_once("Nav.php"); ?>
    
    <script src="../js/post.js"></script>
    <script src="../js/home.js"></script>
 </body>
</html>


<!DOCTYPE html>
<html>
    <head>
            <meta charset="utf-8">
            <title>jQuery Infinite Scroll</title>
    </head>
    <body>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script type="text/javascript">
            var start = 0;
            var working = false;
            $(document).ready(function() {
                $.ajax({
                    type: "GET",
                    url: "data.php?start="+start,
                    processData: false,
                    contentType: "application/json",
                    data: '',
                    success: function(r) {
                        r = JSON.parse(r)
                        for (var i = 0; i < r.length; i++) {
                                $('body').append("<div><h1>"+r[i].videoName+"</h1><h2>Video Views: "+r[i].videoViews+"</h2></div>")
                        }
                        start += 5;
                    },
                    error: function(r) {
                        console.log("Something went wrong!");
                    }
                })
            })
            $(window).scroll(function() {
                if ($(this).scrollTop() + 1 >= $('body').height() - $(window).height()) {
                    if (working == false) {
                        working = true;
                        $.ajax({
                            type: "GET",
                            url: "data.php?start="+start,
                            processData: false,
                            contentType: "application/json",
                            data: '',
                            success: function(r) {
                                r = JSON.parse(r)
                                for (var i = 0; i < r.length; i++) {
                                        $('body').append("<div><h1>"+r[i].videoName+"</h1><h2>Video Views: "+r[i].videoViews+"</h2></div>")
                                }
                                start += 5;
                                setTimeout(function() {
                                        working = false;
                                }, 4000)
                            },
                            error: function(r) {
                                console.log("Something went wrong!");
                            }
                        });
                    }
                }
            })
        </script>
    </body>
</html>