<!DOCTYPE html>
<html lang="it">
    <head>
        <title>ArtHub - Home Page</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
        <link href="../css/home.css" type="text/css" rel="stylesheet">
        <link rel="stylesheet" href="../css/navbar.css">
    </head>
    <body>
       <header>
            <ul>
                <li><img src="../img/logo-senza-sfondo.png" alt="logo"></li>
                <li><a href="#"><img src="../icon/notifications.svg" alt="notifications"></a></li>
                <li><a href="#"><img src="../icon/menu.svg" alt="menu"></a></li>
            </ul>
       </header>
       <nav>
           <ul>
            <li><a href="#"><img src="../icon/home.svg" alt="home"></a></li>
            <li><a href="#"><img src="../icon/explore.svg" alt="explore"></a></li>
            <li><a href="#"><img src="../icon/chat.svg" alt="chat"></a></li>
            <li><a href="#"><img src="../icon/newPost.svg" alt="new post"></a></li>
            <li><a href="#"><img src="../icon/profile.svg" alt="personal profile"></a></li>
           </ul>
       </nav><main>
            <form action="">
                <input type="text" id="Search" placeholder="Search for your arts">
            </form>
            <article class="post">
                <header>
                    <img src="../img/ProfileImg.png" alt="User Avatar">
                    <a href="#" aria-label="View user profile">Audemars Piguet</a>
                </header>
                <img src="../img/audemars piguet.jpg" alt="Post Image">
                <p>Breve descrizione del post... ed eventuali #</p>
                <section>
                    <a href="#" id="likeButton" onclick="changeLike()" aria-label="like">
                        <img class="icon" src="../icon/like-empty.svg" alt="like button"></a>
                    <a href="#" id="commentButton" onclick="changeComment()" aria-label="comment">
                        <img class="icon" src="../icon/comment-empty.svg" alt="comment button"></a>
                    <a href="#" id="shareButton" onclick="changeComment()" aria-label="share">
                        <img class="icon" src="../icon/share.svg" alt="comment button"></a>                 
                </section>
            </article>
            <article class="post">
                <header>
                    <img src="../img/ProfileImg.png" alt="User Avatar">
                    <a href="#" aria-label="View user profile">Audemars Piguet</a>
                </header>
                <img src="../img/audemars piguet.jpg" alt="Post Image">
                <p>Breve descrizione del post... ed eventuali #</p>
                <section>
                    <a href="#" id="likeButton" onclick="changeLike()" aria-label="like">
                        <img class="icon" src="../icon/like-empty.svg" alt="like button"></a>
                    <a href="#" id="commentButton" onclick="changeComment()" aria-label="comment">
                        <img class="icon" src="../icon/comment-empty.svg" alt="comment button"></a>
                    <a href="#" id="shareButton" onclick="changeComment()" aria-label="share">
                        <img class="icon" src="../icon/share.svg" alt="comment button"></a>                 
                </section>
            </article>
       </main>
       
       <script src=""></script>
    </body>
</html>