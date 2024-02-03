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
    <style>
        * {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

button {
  border: none;
  background: #fff;
  transition: .4s ease-in-out;
}
textarea {
  border: none;
  background: #eceaea;
  resize: none;
}

.header {
  font-size: 30px;
  font-weight: 500;
  text-align: center;
  margin: 20px 0;
}

.message-container {
  display: flex;
  flex-direction: column;
}

.message {
  display: flex;
  align-items: center;
  padding: 1rem 1.5rem;
  gap: 2rem;
  justify-content: space-between;
  transition: 0.5s ease-in;
}

.sender-info {
  display: flex;
  align-items: center;
  gap: 20px;

}

.sender-profile-image {
  width: 70px;
  height: 70px;
}

.sender-profile-image .sender-image {
  width: 100%;
  height: 100%;
  border-radius: 10px;
}

.message:hover {
  background: #efefef;
}



/* Dialog Page */

.dialog-page {
  display: none;
  flex-direction: column;
}


.header-container {
  display: flex;
  align-items: center;
  justify-content: center;
  position: relative;
  padding-bottom: 20px;
  border-bottom: 2px solid black;
}

.small {
  width: 50px;
  height: 50px;
}

.back-button {
  position: absolute;
  left: 2%;
  top: 15%;
  width: 30px;
  height: 30px;
}

.back-button:hover {
  transform: scale(1.4);
}

.dialog-container {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
  padding: 10px;
  padding-top: 25px;
  padding-bottom: 100px;
}

.dialog {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.dialog-text {
  background: #eceaea;
  border-radius: 1rem 1rem 1rem 0.25rem;
  padding: 1rem 1.5rem;
  display: flex;
  flex-direction: row;
  width: 250px;
}

.text-sendTime {
  font-size: 12px;
  font-weight: 100;
  padding-left: 10px;
}

.dialog.right {
  align-items: flex-end;
}


/* Input */


.input-container {
  position: fixed;
  bottom: 0;
  width: 100%;
  background-color: #f0f0f0;
  padding: 10px;
  display: flex;
  justify-content: space-around; 
  align-items: center; 
}

.input-wrapper {
  display: flex;
  align-items: center;
  width: 100%;
}

#userInput {
  width: 100%;
  padding: 8px;
  font-size: 16px;
  border: 1px solid #ccc;
  border-radius: 5px;
  margin-right: 10px;
}

.sendText-button {
  background-color: #4CAF50;
  padding: 18px 22px;
  cursor: pointer;
  border-radius: 4px;
}

.sendText-button:hover {
  background: #efefef;
}

.invisible {
    display: none;
}
    </style>
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
