<?php

include_once('database.php');
// include_once('FollowerCreator.php');
// include_once('CommentCreator.php');
// include_once('MessageCreator.php');
// include_once('NotificationCreator.php');
// include_once('PostCreator.php');
// include_once('Register.php');

// function displayData() {
    
//     $database = new Database();
//     $users = $database->getUsers();
//     $categories = $database->getCategories();
//     $posts = $database->getPosts();
//     $followers = $database->getFollowers();
//     $comments = $database->getComments();
//     $chatMessages = $database->getChatMessages();
//     $notifications = $database->getNotifications(2);

//     echo "<pre>";
//     echo "Users:\n";
//     print_r($users);

//     echo "\nCategories:\n";
//     print_r($categories);

//     echo "\nPosts:\n";
//     print_r($posts);

//     echo "\nFollowers:\n";
//     print_r($followers);

//     echo "\nComments:\n";
//     print_r($comments);

//     echo "\nChat Messages:\n";
//     print_r($chatMessages);

//     echo "\nNotifications:\n";
//     print_r($notifications);
//     echo "</pre>";
// }

// function testFollowerCreator() {
//     $followerCreator = new FollowerCreator();
//     $message = $followerCreator->createFollower(1, 2);
//     echo $message . '\n';
// }

// function testCommentCreator() {
//     $commentCreator = new CommentCreator();
//     $message = $commentCreator->createComment(1, 2, 'Great post!');
//     echo $message . '\n';
// }

// function testMessageCreator() {
//     $messageCreator = new MessageCreator();
//     $message = $messageCreator->createMessage(1, 2, 'Hello! How are you?');
//     echo $message . '\n';
// }

// function testNotificationCreator() {
//     $notificationCreator = new NotificationCreator();
//     $message = $notificationCreator->createNotification(1, 'You have a new follower.');
//     echo $message . '\n';
// }

// function testPostCreator() {
//     $postCreator = new PostCreator();
//     $message = $postCreator->createPost(1, 'post_image.jpg', 'A new post!', 2);
//     echo $message . '\n';
// }

// function testRegister() {
//     $register = new UserHelper();
//     $message = $register->registerUser('newuser', 'password123', 'newuser@example.com', 'Hello, I am a new user.');
//     echo $message . '\n';
// }

// Example usage of functions
// displayData();
// testFollowerCreator();
// testCommentCreator();
// testMessageCreator();
// testNotificationCreator();
// testPostCreator();
// testRegister();


// Example usage:
// $fromUserID = 2; // Replace with the actual user ID of the actor
// $toUserID = 1;   // Replace with the actual user ID of the recipient
// $actionType = 'save';
// $postID = 2;  // Replace with the actual post ID if applicable

$database = new Database();

// $insertedNotificationID = $database->insertNotification($fromUserID, $toUserID, $actionType, $postID);

// if ($insertedNotificationID) {
//     echo 'Notification inserted successfully with ID: ' . $insertedNotificationID;
// } else {
//     echo 'Failed to insert notification.';
// }

// echo $database->removeNotification(14);


// $userTaggedPosts = $database->getUserTaggedPosts(1);
// foreach ($userTaggedPosts as $key => $post) {
//     echo $post['PostID'];
// }

// $currentUserID = 1; // Change this to the actual ID of the current user
// $conversationUsers = $database->getConversationUsers($currentUserID);
// var_dump($conversationUsers);

// Fetch messages based on the sender and current user IDs
// $messages = $database->getMessages(2, 1);

// Return messages as JSON
// echo json_encode($messages);


$path = '../img/chat/';
$imageName = "profile.jpg";
$imageData = file_get_contents($path . $imageName);
// $database->uploadImage($imageName, $imageData);

// Example of retrieving image
$database->retrieveImage($imageName);