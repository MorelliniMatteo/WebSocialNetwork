<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <link rel="stylesheet" href="../css/chat.css">
</head>
<body>

<?php
// Your PHP logic goes here, such as retrieving messages from the database

// Example code to fetch messages from the database
$messages = [
    ["sender" => "Junkai store", "message" => "Hi! Thanks for reaching out. What can I get for you?", "time" => "02:58 PM"],
    // Add more messages as needed
];
?>

<main class="main">

    <header class="header">
        <span class="username">Junkai</span>
    </header>

    <section class="message-container">
        <?php foreach ($messages as $message): ?>
            <button class="message">
                <div class="sender-info">
                    <div class="sender-profile-image">
                        <img class="sender-image" src="./profile.jpg" />
                    </div>
                    <span class="sender-name"><?= $message['sender'] ?></span>
                </div>

                <div class="message-info">
                    <span class="update-time"><?= $message['time'] ?></span>
                </div>
            </button>
        <?php endforeach; ?>
    </section>

    <main class="dialog-page">
        <!-- Your existing HTML for the dialog page -->

        <div class="dialog-container">
            <?php foreach ($messages as $message): ?>
                <div class="dialog">
                    <div class="dialog-text">
                        <?= $message['message'] ?>
                    </div>
                    <div class="text-sendTime">
                        <div class="send-time"><?= $message['time'] ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Remaining HTML for the dialog page -->
    </main>


</main>

</body>
</html>
