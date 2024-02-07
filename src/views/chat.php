<?php

session_start();
include_once('../db/database.php');
include_once('../models/ImageHelper.php');


$database = new Database();

// Verifica se l'utente è autenticato
if (!isset($_SESSION['user_id'])) {
    // Utente non autenticato, potresti reindirizzarlo alla pagina di login
    header('Location: login.php');
    exit();
}

// Ottieni l'ID dell'utente dalla sessione
$currentUserID = $_SESSION['user_id'];

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
    
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <style>
        * {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

.sender-name {
  color: var(--text);
}


button {
  border: none;
  transition: .4s ease-in-out;
  background: transparent;
}

textarea {
  border: none;
  background: #fff;
  resize: none;
}

img {
  object-fit: cover;
}

.header {
  font-size: 30px;
  font-weight: 500;
  text-align: center;
  margin: 20px 0;
  border-bottom: 1px solid black;
  padding-bottom: 20px;
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
  margin: 0 10px;
  margin-bottom: 8px;
  border-radius: 10px;
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
  background: var(--contrast);
  color: var(--text);
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
  border-bottom: 1px solid black;
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
  border-radius: 1rem 1rem 1rem 0.25rem;
  padding: 1rem 1.5rem;
  display: flex;
  flex-direction: row;
  width: 250px;
  background: var(--text);
  color: var(--contrast);
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
  padding: 10px;
  display: flex;
  justify-content: space-around; 
  align-items: center; 
  background: var(--backgnd);
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
  background: var(--text);
}

.sendText-button {
  background-color: var(--elem1);
  padding: 18px 22px;
  cursor: pointer;
  border-radius: 4px;
}

.sendText-button:hover {
  background: var(--text);
}

.invisible {
    display: none;
}

.main.active {
  width: 100%;
  margin: 0;
}

@media screen and (min-width: 768px) {

  body {
      font-size: 18px;
  }

}

@media screen and (min-width: 1280px) {

  body {
      font-size: 20px;
  }
  
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
                    <img class="sender-image" src="<?php echo displayProfileImage($database, $user['LogoURL']) ?>" />
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
                    <img src="<?= $path . 'back.svg' ?>" alt="back" class="back-image icon">
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

<?php include_once('Nav.php'); ?>


</body>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="../js/importTheme.js"></script>
<script src="../js/chat.js"></script>
</html>
