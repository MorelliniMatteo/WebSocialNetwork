<?php
include_once('../db/database.php');

// Assume the user is logged in and you have the user ID
$loggedInUserID = 4; //Replace with the actual logged-in user ID

$database = new Database();

$userData = $database->getUserByID($loggedInUserID);

function generatePostHTML($post, $database, $userData)
{
    $postID = $post['PostID'];

    $userProfileInfo = $database->getUserProfileInfo($post['UserID']);
    $userLogoURL = $userProfileInfo['LogoURL'];

    $username = $database->getUserByID($post['UserID'])['Username'];
    $mediaURL = $post['MediaURL'];
    $caption = $post['Caption'];

    $likesSrc = $database->getLikesFromPost($postID, $userData['UserID']) ? "../icon/like.svg" : "../icon/like-empty.svg";

    $comments = $database->getCommentsFromPostID($postID);

    // Create a new DOMDocument
    $dom = new DOMDocument('1.0', 'UTF-8');
    $dom->formatOutput = true;

    // Create the main container div
    $postContainer = $dom->createElement('div');
    $postContainer->setAttribute('class', 'post-container');
    $postContainer->setAttribute('id', $postID);

    // Create the post div
    $postDiv = $dom->createElement('div');
    $postDiv->setAttribute('class', 'post');

    // Header section
    $header = $dom->createElement('header');
    $header->appendChild($dom->createElement('img', ''))->setAttribute('src', $userLogoURL);
    $userLink = $dom->createElement('a', $username);
    $userLink->setAttribute('href', '#');
    $userLink->setAttribute('label', 'View user profile');
    $header->appendChild($userLink);
    $postDiv->appendChild($header);

    // Image and caption
    $postDiv->appendChild($dom->createElement('img', ''))->setAttribute('src', $mediaURL);
    $postDiv->appendChild($dom->createElement('p', $caption));

    // Interaction section
    $section = $dom->createElement('section');
    $section->appendChild($dom->createElement('h1', 'interaction'));

    // Like button
    $likeButton = $dom->createElement('img', '');
    $likeButton->setAttribute('class', 'icon likeButton');
    $likeButton->setAttribute('src', $likesSrc);
    $likeButton->setAttribute('alt', 'like button');
    $section->appendChild($likeButton);

    // Comment button
    $commentButton = $dom->createElement('img', '');
    $commentButton->setAttribute('class', 'icon commentButton');
    $commentButton->setAttribute('src', '../icon/comment-empty.svg');
    $commentButton->setAttribute('alt', 'comment button');
    $commentButton->setAttribute('onclick', "openComments($postID)");
    $section->appendChild($commentButton);

    // Share button
    $shareButton = $dom->createElement('img', '');
    $shareButton->setAttribute('class', 'icon shareButton');
    $shareButton->setAttribute('src', '../icon/saved.svg');
    $shareButton->setAttribute('alt', 'comment button');
    $shareButton->setAttribute('onclick', "sharePost($postID)");
    $section->appendChild($shareButton);

    $postDiv->appendChild($section);
    $postContainer->appendChild($postDiv);

    // Comments section
    $aside = $dom->createElement('aside');
    $aside->setAttribute('class', 'comments');

    $h2 = $dom->createElement('h2', 'Commenti');
    $aside->appendChild($h2);

    $commentsContainer = $dom->createElement('div');
    $commentsContainer->setAttribute('class', 'comments-container');

    // Description
    $description = $dom->createElement('p', $caption);
    $commentsContainer->appendChild($description);

    // Comments
    foreach ($comments as $comment) {
        $commentUsername = $database->getUserByID($comment['UserID'])['Username'];
        $commentText = $comment['CommentText'];
        $commentsContainer->appendChild($dom->createElement('p', "$commentUsername: $commentText"));
    }

    $aside->appendChild($commentsContainer);

    // Comment form
    $commentForm = $dom->createElement('form');
    $commentForm->setAttribute('id', 'commentForm_' . $postID);

    $postIDHidden = $dom->createElement('input');
    $postIDHidden->setAttribute('type', 'hidden');
    $postIDHidden->setAttribute('name', 'PostID');
    $postIDHidden->setAttribute('value', $postID);
    $commentForm->appendChild($postIDHidden);
    $userIDHidden = $dom->createElement('input');
    $userIDHidden->setAttribute('type', 'hidden');
    $userIDHidden->setAttribute('name', 'UserID');
    $userIDHidden->setAttribute('value', $userData['UserID']);
    $commentForm->appendChild($postIDHidden);
    $commentForm->appendChild($userIDHidden);

    $label = $dom->createElement('label', '');
    $label->setAttribute('for', 'CommentText');
    $commentForm->appendChild($label);

    $commentInput = $dom->createElement('input');
    $commentInput->setAttribute('type', 'text');
    $commentInput->setAttribute('id', 'CommentText');
    $commentInput->setAttribute('name', 'CommentText');
    $commentInput->setAttribute('placeholder', 'add a comment'); // Add this line
    $commentForm->appendChild($commentInput);

    $commentForm->appendChild($dom->createElement('input'))->setAttribute('type', 'button');
    $commentForm->lastChild->setAttribute('value', 'send comment');
    $commentForm->lastChild->setAttribute('onclick', 'submitComment(' . $postID . ')');

    $aside->appendChild($commentForm);
    $postContainer->appendChild($aside);

    // Append the main container to the document
    $dom->appendChild($postContainer);

    // Output the HTML
    $html = $dom->saveHTML();

    return $html;
}


if (isset($_POST['dati'])) {
    $post = json_decode($_POST['dati'], true);
    echo generatePostHTML($post, $database, $userData);
}


?>
