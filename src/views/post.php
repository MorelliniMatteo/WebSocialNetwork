<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verifica se l'utente è autenticato
if (!isset($_SESSION['user_id'])) {
    // Utente non autenticato, potresti reindirizzarlo alla pagina di login
    header('Location: login.php');
    exit();
}

// Ottieni l'ID dell'utente dalla sessione
$loggedInUserID = $_SESSION['user_id'];

include_once('../db/database.php');
include_once('../models/api.php');

$database = new Database();

// Fetch user data
$userData = $database->getUserByID($loggedInUserID);

if (isset($_POST['post'])) {
    $postDecoded = urldecode($_POST['post']);
    $post = json_decode($postDecoded, true);
}


if (isset($_GET['PostID'])) {
    $PostID = $_GET['PostID'];
    $post = $database->getPostByID($PostID);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>ArtHub - Post</title>
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
         </ul>
    </header>
    <main class="single-post">
        <?php echo generatePostHTML($post, $database, $userData); ?>
        <div class="space">
            <p>space</p>
        </div>
    </main>
    
    <?php include_once("Nav.php"); ?>
    
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="../js/post.js"></script>
    <script src="../js/importTheme.js"></script>
 </body>
</html>