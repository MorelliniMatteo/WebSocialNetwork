<?php

session_start();

include_once('../db/database.php');
include_once('../models/ImageHelper.php');

$userID = isset($_GET['id']) ? $_GET['id'] : null;


// Verifica se l'utente è autenticato
if ( (!isset($_SESSION['user_id'])) || (!$userID) ) {
    // Utente non autenticato, potresti reindirizzarlo alla pagina di login
    header('Location: login.php');
    exit();
}

$loggedInUserID = $_SESSION['user_id'];

if ($userID == $_SESSION['user_id']) {
    header('Location: Profile.php');
}


$database = new Database();

$iconImagePath = "../icon/";

// Fetch user data
$userData = $database->getUserByID($userID);

// Fetch user counts
$postCount = $database->getPostCount($userID);
$followersCount = $database->getFollowersCount($userID);
$followingCount = $database->getFollowingCount($userID);

// Fetch user profile info
$profileInfo = $database->getUserProfileInfo($userID);

$isFollower = $database->isFollower($loggedInUserID, $userID);

// Fetch user posts
$userPosts = $database->getUserPosts($userID);
$userLikedPosts = $database->getUserLikedPosts($userID);
$userTaggedPosts = $database->getUserTaggedPosts($userID);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat+Alternates:wght@300;500&family=Newsreader:opsz,wght@6..72,200&display=swap');

* {
    padding: 0;
    margin: 0;
    box-sizing: border-box;
    font-family: 'Montserrat Alternates', sans-serif;
    
}

#taggedSection {
    display: none;
}

#savedSection {
    display: none;
}

ul {
    list-style: none;
}

a {
    text-decoration: none;
}


.btn {
    text-decoration: none;
    border: none;
    background: var(--backgnd);
}

.line {
    max-width: 80%;
    height: 2px;
    background: var(--text);
    transition: 1s ease;
    margin-top: 20px;
}

.main {
    height: 100vh;
}

.logout-button {
    position: absolute;
    top: 30%;
    right: 5%;
    width: 50px;
    height: 25px;
    font-size: 12px;
    padding-top: 4px;
    text-align: center;
    border-radius: 5px;
    background: #000;
    color: #fff;
    transition: 0.4s all ease;
}

.logout-button:hover {
    background: #fff;
    color: #000;
}

.public-container {
    width: 100%;
    margin: 0 auto;
}

.header {
    height: 50px;
    width: 100%;
    position: relative;
}

.header-container {
    display: flex;
    height: 100%;
    justify-content: center;
    align-items: center;

}

.header-container ul {
    display: flex;
}

.header-container li img {
    display: block;
    position: relative;
}

.user-setting ul{
    display: flex;
    gap: 1rem;
}

.profile {
    display: flex;
    height: 90px;
    margin-top: 10px;
}

.profile .profile-logo {
    width: 100px;
    border-radius: 70%;
}

.profile img {
    width: 100%;
    height: 100%;
    border-radius: 70%;
    object-fit: cover;
    cursor: auto;
}


.profile-container {
    display: flex;
    justify-content: space-around;
}

.profile .profile-posts {
    display: flex;
    font-size: 14px;
    align-items: center;
    gap: 1rem;
}

.profile .profile-post {
    display: flex;
    flex-direction: column;

}

.profile .profile-post span {
    text-align: center;
}

.profile .profile-post span:first-child {
    font-weight: 200;
}


.info-container {
    margin-top: 20px;
}

.info {
    display: flex;
    flex-direction: column;
    margin-left: 25px;
}

.info-container .user-description {
    font-weight: 300;
}

.profile-edit,
.profile-follow{
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 20px;
}

.profile-edit-box,
.profile-follow-box {
    width: 90%;
    border-radius: 0.8rem;
    padding: 0 20px;
    height: 30px;

    margin-top: 20px;
    transition: 0.5s ease;
    background-color: gray;
    text-align: center;
}

.profile-edit-box:hover,
.profile-follow-box:hover {
    background-color: white;
}

.profile-edit span,
.profile-follow span {
    transition: 0.5s ease;
}

.profile-edit:hover span,
.profile-follow:hover span {
    color: black;
}

.profile-edit .btn span,
.profile-follow .btn span{
    display: block;
    padding-top: 5px;
}



.tab-container {
    display: flex;
    height: 50px;
    justify-content: space-around;
    align-items: center;
    margin-top: 20px;
}



.user-posts {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    grid-gap: 10px;
    box-sizing: border-box;
    border: 12px solid transparent;
}



.user-posts .post {
    position: relative;
}

.user-posts img {
    border-radius: 3%;
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.user-posts .post-box {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0 30px;
    flex-direction: column;
    transition: 0.3s ease-out;
    opacity: 0;
    background: rgba(0, 0, 0, 0.8);
    color: #fff;
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    font-size: 10px;
    border-radius: 3%;
}

.user-posts .post-box .post-title {
    font-size: 20px;
    font-weight: 400;
    margin-bottom: 60px;
}

.user-posts .post-content {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 1rem;
}

.user-posts .post-content .post-content-box {
    display: flex;
    flex-direction: column;
}


@media screen and (min-width: 768px) {

    * {
        font-size: 18px;
    }

    .info-container{
        max-width: 100%;
        justify-content: center;
        align-items: center;
    }

    .profile .profile-posts {
        gap: 3rem;
    }

    .info {
        margin: 0 50px;
        justify-content: center;
        align-items: center;
    }

    .user-posts {
        border: 20px solid transparent;
    }

    .user-posts .post-box:hover {
        opacity: 1;
    }

}

@media screen and (min-width: 1280px) {

    * {
        font-size: 20px;
    }

    .profile .profile-posts {
        gap: 5rem;
    }

    .user-posts {
        border: 30px solid transparent;
    }
    
}
    </style>

</head>
<body>

    <main class="main">

        <header class="header">
            <div class="public-container header-container">
                <span class="username"><?php echo $userData['Username']; ?></span>
            </div>

        </header>

        <section class="profile">
            <div class="public-container profile-container">
                <a href="../models/ChangeProfileImage.php" class="profile-logo">
                    <img src="<?php echo displayProfileImage($database, $profileInfo['LogoURL']); ?>" alt="profile-image">
                </a>

                <div class="profile-posts">
                    <div class="profile-post">
                        <span class="profile-posts-number"><?php echo $postCount; ?></span>
                        <span>Posts</span>
                    </div>
                    <div class="profile-post">
                        <span class="profile-followers-number"><?php echo $followersCount; ?></span>
                        <span>Followers</span>
                    </div>
                    <div class="profile-post">
                        <span class="profile-following-number"><?php echo $followingCount; ?></span>
                        <span>Following</span>
                    </div>
                </div>
            </div>
        </section>

        <section class="public-container info-container">
            <div class="info">
                <span class="username"><?php echo $userData['Username']; ?></span>
                <br>
                <p class="user-description"><?php echo $userData['Bio']; ?></p>
            </div>
        </section>

        <div class="public-container profile-follow">
            <div class="profile-follow-box">
                <a href="#" class="btn" id="followBtn">
                    <span id='followText'><?php echo ($isFollower ? "Unfollow" : "Follow"); ?></span>
                </a>
            </div>
        </div>

        <div class="public-container line"></div>

        <section class="public-container tab-container">
            <button id="postSectionBtn" class="post-logo btn"><img class="icon" src="<?php echo $iconImagePath . 'post.svg' ?>" alt="post"></button>
            <button id="taggedSectionBtn" class="post-logo btn"><img class="icon" src="<?php echo $iconImagePath . 'tag.svg' ?>" alt="tagged"></button>
            <button id="savedSectionBtn" class="post-logo btn"><img class="icon" src="<?php echo $iconImagePath . 'saved.svg' ?>" alt="saved"></button>
        </section>


        <section id="postSection" class="public-container user-posts">
            <?php foreach ($userPosts as $post) : ?>
                    <a href="#" class="post">
                        <img src="<?php echo displayProfileImage($database, $post['MediaURL']); ?>" alt="post-image">
                        <div class="post-box">
                            <h3 class="post-title"><?php echo $post['Caption']; ?></h3>
                            <div class="post-content">
                                <div class="post-content-box">
                                    <span class="post-content-likes-number"><?php echo $database->getLikesCount($post['PostID']); ?></span>
                                    <span class="post-content-likes-label">LIKES</span>
                                </div>
                                <div class="post-content-box">
                                    <span class="post-content-comments-number"><?php echo $database->getCommentsCount($post['PostID']); ?></span>
                                    <span class="post-content-comments-label">COMMENTS</span>
                                </div>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
        </section>

        <section id="taggedSection" class="public-container user-posts">
            <?php foreach ($userTaggedPosts as $post) : ?>
                <a href="#" class="post">
                    <img src="<?php echo displayProfileImage($database, $post['MediaURL']); ?>" alt="post-image">
                    <div class="post-box">
                        <h3 class="post-title"><?php echo $post['Caption']; ?></h3>
                        <div class="post-content">
                            <div class="post-content-box">
                                <span class="post-content-likes-number"><?php echo $database->getLikesCount($post['PostID']); ?></span>
                                <span class="post-content-likes-label">LIKES</span>
                            </div>
                            <div class="post-content-box">
                                <span class="post-content-comments-number"><?php echo $database->getCommentsCount($post['PostID']); ?></span>
                                <span class="post-content-comments-label">COMMENTS</span>
                            </div>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </section>

        <section id="savedSection" class="public-container user-posts">
            <?php foreach ($userLikedPosts as $post) : ?>
                <a href="#" class="post">
                    <img src="<?php echo displayProfileImage($database, $post['MediaURL']); ?>" alt="post-image">
                    <div class="post-box">
                        <h3 class="post-title"><?php echo $post['Caption']; ?></h3>
                        <div class="post-content">
                            <div class="post-content-box">
                                <span class="post-content-likes-number"><?php echo $database->getLikesCount($post['PostID']); ?></span>
                                <span class="post-content-likes-label">LIKES</span>
                            </div>
                            <div class="post-content-box">
                                <span class="post-content-comments-number"><?php echo $database->getCommentsCount($post['PostID']); ?></span>
                                <span class="post-content-comments-label">COMMENTS</span>
                            </div>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </section>

    </main>

    <div id="userData" data-userid="<?php echo $userID; ?>" data-loggedinuserid="<?php echo $loggedInUserID; ?>"></div>


    <?php include_once('Nav.php'); ?>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="../js/importTheme.js"></script>
<script src="../js/profileSwitchPost.js"></script>
<script src="../js/follow.js"></script>

</body>
</html>
