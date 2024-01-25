<?php

include_once('database.php');
include_once('FollowerCreator.php');
include_once('CommentCreator.php');
include_once('MessageCreator.php');
include_once('NotificationCreator.php');
include_once('PostCreator.php');
include_once('Register.php');

function displayData() {
    $database = new Database();

    $users = $database->getUsers();
    $categories = $database->getCategories();
    $posts = $database->getPosts();
    $followers = $database->getFollowers();
    $comments = $database->getComments();
    $chatMessages = $database->getChatMessages();
    $notifications = $database->getNotifications();

    echo "<pre>";
    echo "Users:\n";
    print_r($users);

    echo "\nCategories:\n";
    print_r($categories);

    echo "\nPosts:\n";
    print_r($posts);

    echo "\nFollowers:\n";
    print_r($followers);

    echo "\nComments:\n";
    print_r($comments);

    echo "\nChat Messages:\n";
    print_r($chatMessages);

    echo "\nNotifications:\n";
    print_r($notifications);
    echo "</pre>";
}

function testFollowerCreator() {
    $followerCreator = new FollowerCreator();
    $message = $followerCreator->createFollower(1, 2);
    echo $message . '\n';
}

function testCommentCreator() {
    $commentCreator = new CommentCreator();
    $message = $commentCreator->createComment(1, 2, 'Great post!');
    echo $message . '\n';
}

function testMessageCreator() {
    $messageCreator = new MessageCreator();
    $message = $messageCreator->createMessage(1, 2, 'Hello! How are you?');
    echo $message . '\n';
}

function testNotificationCreator() {
    $notificationCreator = new NotificationCreator();
    $message = $notificationCreator->createNotification(1, 'You have a new follower.');
    echo $message . '\n';
}

function testPostCreator() {
    $postCreator = new PostCreator();
    $message = $postCreator->createPost(1, 'post_image.jpg', 'A new post!', 2);
    echo $message . '\n';
}

function testRegister() {
    $register = new UserHelper();
    $message = $register->registerUser('newuser', 'password123', 'newuser@example.com', 'Hello, I am a new user.');
    echo $message . '\n';
}

// Example usage of functions
displayData();
testFollowerCreator();
testCommentCreator();
testMessageCreator();
testNotificationCreator();
testPostCreator();
testRegister();

?>
