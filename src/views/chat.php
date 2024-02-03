<?php

include_once('../db/database.php');

$currentUserID = 2; // Change this to the actual ID of the current user

$database = new Database();

$conversationUsers = $database->getConversationUsers($currentUserID);

$currentUserName = $database->getUserByID($currentUserID)["Username"];

$path = "../img/chat/";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <link rel="stylesheet" href="../css/chat.css">
</head>
<body>

<main class="main">

    <header class="header">
        <span class="username" id="username"><?= $currentUserName ?></span>
        <span class="userID invisible" id="userID"><?= $currentUserID ?></span>
    </header>

    <section class="message-container">
    <?php foreach ($conversationUsers as $user): ?>
        <button class="message">
            <div class="sender-info">
                <div class="sender-profile-image">
                    <img class="sender-image" src="<?= $path . $user['LogoURL'] ?>" />
                </div>
                <span class="sender-name"><?= $user['Username'] ?></span>
                <span class="sender-id invisible"><?= $user['UserID'] ?></span>
            </div>
        </button>
    <?php endforeach; ?>
    </section>

    <main class="dialog-page">
        <div class="header-container">

            <button class="back-button" id="backButton">
                <div class="back-image-container">
                    <img src="<?= $path . 'back.svg' ?>" alt="back" class="back-image">
                </div>
            </button>
            
            <div class="sender-info" id="currentChatUserInfo">
            </div>
        
        </div>

        <div class="dialog-container" id="dialogContainer">
        </div>


        <div class="input-container">
            <div class="input-wrapper">
                    <label for="userInput"></label>
                    <textarea id="userInput" placeholder="Type your message..."></textarea>
                    <button id="sendButton" class="sendText-button"><img src="../img/chat/send.svg" alt="send" class="sendText-Image"></button>
                </div>
            </div>

    </main>

</main>

</body>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="../js/chat.js"></script>
</html>
