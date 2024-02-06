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
include_once('../models/ImageHelper.php');

$database = new Database();

// Fetch user data
$userData = $database->getUserByID($loggedInUserID);

function generatePostHTML($post, $database, $userData) {
    $postSerialized = urlencode(json_encode($post));

    $html = '<div class="post-img">';
    $html .= '<form action="post.php" method="post">';
    $html .= '<input type="hidden" name="post" value="' . $postSerialized . '">';
    $html .= '<button type="submit" name="viewPost" label="View Full Post"><img src="' . displayProfileImage($database, $post['MediaURL']) . '" alt="Post Image"></button>';
    $html .= '</form>';
    $html .= '</div>';

    return $html;
}


if (isset($_POST['dati'])) {
    $post = json_decode($_POST['dati'], true);
    echo generatePostHTML($post, $database, $userData);
}


?>