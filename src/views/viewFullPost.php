<?php

function viewPostHTML($post, $userData, $database) {
    $postID = $post['PostID'];
    $userID = $userData['UserID'];

    echo '<div class="post-container" id="' . $postID . '">';
    echo '<div class="post">';
    echo '<header>';
    echo '<img src="' . $database->getUserProfileInfo($post['UserID'])['LogoURL'] . '" alt="User Avatar">';
    echo '<a href="#" label="View user profile">' . $database->getUserByID($post['UserID'])['Username'] . '</a>';
    echo '</header>';
    echo '<img src="' . $post['MediaURL'] . '" alt="Post Image">';
    echo '<p>' . $post['Caption'] . '</p>';
    echo '<section>';
    echo '<h1>interaction</h1>';
    echo '<img class="icon likeButton" ' . ($database->getLikesFromPost($postID, $userID) ? 'src="../icon/like.svg"' : 'src="../icon/like-empty.svg"') . ' alt="like button" onclick="Like(' . $postID . ',' . $userID . ')">';
    echo '<img class="icon commentButton" src="../icon/comment-empty.svg" alt="comment button" onclick="openComments(' . $postID . ')">';
    echo '<img class="icon shareButton" src="../icon/share.svg" alt="comment button" onclick="sharePost(' . $postID . ')">';
    echo '</section>';
    echo '</div>';
    echo '<aside class="comments">';
    echo '<h2>Commenti</h2>';
    echo '<div class="comments-container">';
    echo '<p class="description">' . $post['Caption'] . '</p>';

    $comments = $database->getCommentsFromPostID($postID);
    foreach ($comments as $comment) {
        echo '<p>' . $database->getUserByID($comment['UserID'])['Username'] . ': ' . $comment['CommentText'] . '</p>';
    }

    echo '</div>';
    echo '<form id="commentForm">';
    echo '<input type="hidden" name="PostID" value="' . $postID . '">';
    echo '<input type="hidden" name="UserID" value="' . $userID . '">';
    echo '<label for="CommentText"></label>';
    echo '<input type="text" name="CommentText" id="CommentText" placeholder="add a comment" required>';
    echo '<input type="button" value="send comment" onclick="submitComment()">';
    echo '</form>';
    echo '</aside>';
    echo '</div>';
}

?>
