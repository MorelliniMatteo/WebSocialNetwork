<?php
include_once('../db/database.php');

// Assume the user is logged in and you have the user ID
$loggedInUserID = 4; //Replace with the actual logged-in user ID

$database = new Database();

$userData = $database->getUserByID($loggedInUserID);

function generatePostHTML($post) {

    $html = '<div class="post-img">';
    $html .= '<a href="post.php?postID=' . $post['PostID'] . '" label="View Full Post"><img src="' . $post['MediaURL'] . '" alt="Post Image"></a>';
    $html .= '</div>';

    return $html;
}


if (isset($_POST['dati'])) {
    $post = json_decode($_POST['dati'], true);
    echo generatePostHTML($post, $database, $userData);
}


?>
