<?php
include_once('../db/database.php');

$database = new Database();

$loggedInUserID = 4; //Replace with the actual logged-in user ID

// Verifica se sono stati ricevuti i dati corretti tramite POST
if (isset($_POST['index']) && isset($_POST['queryName']) && isset($_POST['categoryID'])){
    $index = $_POST['index'];
    $queryName = $_POST['queryName'];
    $categoryID = $_POST['categoryID'];

    if ($queryName == 'explore') {
        if ($categoryID) {
            $categoryID = $_POST['categoryID'];
            $posts = $database->getPostsByCategory($categoryID, $index);
        } else {
            $posts = $database->getRandomPosts($index);
        }
    } else {
        $posts = $database->getPostFromFollowing($loggedInUserID, $index);
    }

    if ($posts) {
        echo json_encode(["posts" => $posts]);
    } else {
        echo json_encode(["status" => "error", "message" => "Si è verificato un errore durante il caricamento dei post dal database."]);
    }

} else {
    echo json_encode(["status" => "error", "message" => "Dati mancanti o non validi"]);
}

?>