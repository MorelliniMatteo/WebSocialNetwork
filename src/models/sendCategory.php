<?php

session_start();

include_once("../db/database.php");

// Assume the user is logged in and you have the user ID
$loggedInUserID = 1; //Replace with the actual logged-in user ID

$database = new Database();
$categoryID = 0;

// Gestione dell'invio del form search
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $searchQuery = $_POST["Search"];
    if ($searchQuery) { 
        $categoryID = $database->getCategoryID($searchQuery);
        $_SESSION["categoryID"] = $categoryID;
    } else {
        echo 'default category: all';
    }

    // Ridirigi alla stessa pagina
    header("Location: ../views/explore.php");
    exit();
}
?>
