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
    <link rel="stylesheet" href="../css/profile.css">
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

<?php include_once('Nav.php'); ?>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="../js/importTheme.js"></script>
<script src="../js/profileSwitchPost.js"></script>

</body>
</html>
