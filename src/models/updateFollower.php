<?php
session_start();

include_once("../db/database.php");



if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if user is not authenticated
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = isset($_POST['action']) ? $_POST['action'] : '';

    if ($action === 'follow' || $action === 'unfollow') {
        $database = new Database();

        $loggedInUserID = isset($_POST['loggedInUserID']) ? $_POST['loggedInUserID'] : '';
        $userIDToFollow = isset($_POST['userIDToFollow']) ? $_POST['userIDToFollow'] : '';

        if ($action === 'follow') {
            $database->insertFollower($loggedInUserID, $userIDToFollow);
            $database->insertNotification($loggedInUserID, $userIDToFollow, 'follow');
        } else if ($action === 'unfollow') {
            $database->removeFollower($loggedInUserID, $userIDToFollow);
        }
    } 

}
?>
