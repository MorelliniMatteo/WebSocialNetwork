<?php

class Database {
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "arthub";
    private $conn;

    public function __construct() {
        try {
            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->dbname}", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function getUsers() {
        $query = "SELECT * FROM Users";
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCategories() {
        $query = "SELECT * FROM Categories";
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPosts() {
        $query = "SELECT * FROM Posts";
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getFollowers() {
        $query = "SELECT * FROM Followers";
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getComments() {
        $query = "SELECT * FROM Comments";
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getChatMessages() {
        $query = "SELECT * FROM ChatMessages";
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getNotifications($userID) {
        $query = "
            SELECT 
                n.NotificationID,
                n.fromUserID,
                fromUser.Username AS FromUserName,
                n.toUserID,
                toUser.Username AS ToUserName,
                n.NotificationText,
                n.PostID
            FROM 
                Notifications n
                INNER JOIN Users fromUser ON n.fromUserID = fromUser.UserID
                INNER JOIN Users toUser ON n.toUserID = toUser.UserID
            WHERE 
                n.toUserID = :userID
            ORDER BY 
                n.NotificationDate DESC
        ";
    
        $params = array(':userID' => $userID);
    
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute($params);
    
            // Fetch all notifications for the user
            $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            return $notifications;
        } catch (PDOException $e) {
            // Handle the exception (log, display an error message, etc.)
            return false;
        }
    }
    
    

    // Get user data by ID
    public function getUserByID($userID) {
        $query = "SELECT * FROM Users WHERE UserID = :userID";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Get user by username
    public function getUserByUsername($username) {
        $query = "SELECT * FROM Users WHERE Username = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Get user by email
    public function getUserByEmail($email) {
        $query = "SELECT * FROM Users WHERE Email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Insert user
    public function insertUser($username, $password, $email, $bio) {
        $query = "INSERT INTO Users (Username, Password, Email, Bio) VALUES (:username, :password, :email, :bio)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':bio', $bio, PDO::PARAM_STR);
        return $stmt->execute();

    }

    // Insert post
    public function insertPost($userID, $mediaURL, $caption, $categoryID) {
        $query = "INSERT INTO Posts (UserID, MediaURL, Caption, CategoryID) VALUES (:userID, :mediaURL, :caption, :categoryID)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        $stmt->bindParam(':mediaURL', $mediaURL, PDO::PARAM_STR);
        $stmt->bindParam(':caption', $caption, PDO::PARAM_STR);
        $stmt->bindParam(':categoryID', $categoryID, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Insert comment
    public function insertComment($postID, $userID, $commentText) {
        $query = "INSERT INTO Comments (PostID, UserID, CommentText) VALUES (:postID, :userID, :commentText)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':postID', $postID, PDO::PARAM_INT);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        $stmt->bindParam(':commentText', $commentText, PDO::PARAM_STR);
        return $stmt->execute();
    }

    function generateNotificationMessage($actionType, $actorUserID) {
        
        $actor = $this->getUserByID($actorUserID);
    
        switch ($actionType) {
            case 'follow':
                return $actor['Username'] . ' started following you.';
            case 'save':
                return $actor['Username'] . ' saved one of your posts.';
            case 'like':
                return $actor['Username'] . ' liked one of your posts.';
            case 'tag':
                return $actor['Username'] . ' tagged you in a post.';
            default:
                return 'Unknown action type.';
        }
    }

    // Insert notification
    // Assume you have a method to insert data into the Notifications table
    public function insertNotification($fromUserID, $toUserID, $actionType, $postID = null) {
        // Implement this method to insert data into the Notifications table
        // You can use your existing method like $this->conn->prepare() and $stmt->execute() here

        // Example query, adjust based on your actual table structure
        $query = "
            INSERT INTO Notifications (fromUserID, toUserID, NotificationText, PostID)
            VALUES (:fromUserID, :toUserID, :notificationText, :postID)
        ";

        // Example messages based on action types
        $notificationText = $this->generateNotificationMessage($actionType, $fromUserID);

        // Bind parameters and execute the query
        $params = array(
            ':fromUserID' => $fromUserID,
            ':toUserID' => $toUserID,
            ':notificationText' => $notificationText,
            ':postID' => $postID
        );

        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute($params);

            // Return the last inserted ID if needed
            return $this->conn->lastInsertId();
        } catch (PDOException $e) {
            // Handle the exception (log, display an error message, etc.)
            return false;
        }
    }



    // Insert follower
    public function insertFollower($followerUserID, $followingUserID) {
        $query = "INSERT INTO Followers (FollowerUserID, FollowingUserID) VALUES (:followerUserID, :followingUserID)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':followerUserID', $followerUserID, PDO::PARAM_INT);
        $stmt->bindParam(':followingUserID', $followingUserID, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Insert message
    public function insertMessage($senderID, $receiverID, $messageText) {
        $query = "INSERT INTO ChatMessages (SenderID, ReceiverID, MessageText) VALUES (:senderID, :receiverID, :messageText)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':senderID', $senderID, PDO::PARAM_INT);
        $stmt->bindParam(':receiverID', $receiverID, PDO::PARAM_INT);
        $stmt->bindParam(':messageText', $messageText, PDO::PARAM_STR);
        return $stmt->execute();
    }

    // Insert like
    public function insertLike($postID, $userID){
        $query = "INSERT INTO Likes (PostID, UserID) VALUES (:postID, :userID);";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':postID', $postID, PDO::PARAM_INT);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Remove like
    public function removeLike($postID, $userID){
        $query = "DELETE FROM likes WHERE PostID =:postID AND UserID = :userID ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':postID', $postID, PDO::PARAM_INT);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Update user data
    public function updateUser($userID, $newUsername, $newEmail, $newBio) {
        $query = "UPDATE Users SET Username = :newUsername, Email = :newEmail, Bio = :newBio WHERE UserID = :userID";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':newUsername', $newUsername, PDO::PARAM_STR);
        $stmt->bindParam(':newEmail', $newEmail, PDO::PARAM_STR);
        $stmt->bindParam(':newBio', $newBio, PDO::PARAM_STR);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getUserPosts($userID) {
        $query = "
            SELECT 
                p.*, 
                COUNT(l.LikeID) AS LikesCount 
            FROM 
                posts p
                LEFT JOIN likes l ON p.PostID = l.PostID
            WHERE 
                p.UserID = :userID
            GROUP BY 
                p.PostID
        ";

        $params = array(':userID' => $userID);

        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute($params);

            // Fetch all posts for the user with the count of likes
            $userPosts = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $userPosts;
        } catch (PDOException $e) {
            // Handle the exception (log, display an error message, etc.)
            return false;
        }
    }

    public function getPostCount($userID) {
        $query = "SELECT COUNT(PostID) AS PostCount FROM posts WHERE UserID = :userID";
        $params = array(':userID' => $userID);

        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute($params);

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return ($result) ? $result['PostCount'] : 0;
        } catch (PDOException $e) {
            // Handle the exception (log, display an error message, etc.)
            return 0;
        }
    }

    public function getFollowersCount($userID) {
        $query = "SELECT COUNT(FollowerID) AS FollowersCount FROM followers WHERE UserID = :userID";
        $params = array(':userID' => $userID);

        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute($params);

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return ($result) ? $result['FollowersCount'] : 0;
        } catch (PDOException $e) {
            // Handle the exception (log, display an error message, etc.)
            return 0;
        }
    }

    public function getFollowingCount($userID) {
        $query = "SELECT COUNT(FollowerID) AS FollowingCount FROM followers WHERE FollowerUserID = :userID";
        $params = array(':userID' => $userID);

        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute($params);

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return ($result) ? $result['FollowingCount'] : 0;
        } catch (PDOException $e) {
            // Handle the exception (log, display an error message, etc.)
            return 0;
        }
    }

    public function getLikesCount($postID) {
        $query = "SELECT COUNT(LikeID) AS LikesCount FROM Likes WHERE PostID = :postID";
        $params = array(':postID' => $postID);
    
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute($params);
    
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            return ($result) ? $result['LikesCount'] : 0;
        } catch (PDOException $e) {
            // Handle the exception (log, display an error message, etc.)
            return 0;
        }
    }
    
    public function getCommentsCount($postID) {
        $query = "SELECT COUNT(CommentID) AS CommentsCount FROM Comments WHERE PostID = :postID";
        $params = array(':postID' => $postID);
    
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute($params);
    
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            return ($result) ? $result['CommentsCount'] : 0;
        } catch (PDOException $e) {
            // Handle the exception (log, display an error message, etc.)
            return 0;
        }
    }

    public function getUserProfileInfo($userID) {
        $query = "SELECT LogoURL FROM UserInfos WHERE UserID = :userID";
        $params = array(':userID' => $userID);

        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute($params);

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return ($result) ? $result : array('LogoURL' => 'default_logo.jpg');
            // Assuming 'default_logo.jpg' is a placeholder for users without a custom logo
        } catch (PDOException $e) {
            // Handle the exception (log, display an error message, etc.)
            return array('LogoURL' => 'default_logo.jpg');
            // Assuming 'default_logo.jpg' is a placeholder for users without a custom logo
        }
    }

    public function getPostFromFollowing($userID) {
        $query = "SELECT Posts.* FROM Posts
                  JOIN Followers ON Posts.UserID = Followers.FollowingUserID
                  WHERE Followers.FollowerUserID = :userID
                  ORDER BY Posts.PostDate DESC ";
        $params = array(':userID' => $userID);
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($result) {
            return $result;
        } else {
            die("Errore nella query: ");
        }
    }

    public function getCommentsFromPostID($postID) {
        $query = "SELECT UserID, CommentText FROM Comments WHERE PostID = :postID";
        $params = array(':postID' => $postID);
    
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getLikesFromPost($postID, $userID){
        $query = "SELECT LikeID FROM likes WHERE PostID = :postID AND UserID = :userID";
        $params = array(':postID' => $postID, ':userID' => $userID);
    
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function verifyUserPassword($email, $password) {
        // Ottieni le informazioni sull'utente basandoti sull'email
        $existingUser = $this->getUserByEmail($email);
    
        // Controlla se l'utente esiste e se la password fornita è corretta
        if ($existingUser && password_verify($password, $existingUser['Password'])) {
            // La password è corretta
            return 1;
        } else {
            // Password errata o utente non trovato
            return 0;
        }
    }
}


?>