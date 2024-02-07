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

    public function getUserIDByUsername($username) {
        $query = "SELECT UserID FROM Users WHERE Username = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($result) {
            return $result['UserID'];
        } else {
            return false; // User not found
        }
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
        
        if ($stmt->execute()) {
            // Return the last inserted PostID
            return $this->conn->lastInsertId();
        } else {
            return false; // Failed to insert post
        }
    }
    

    public function insertTagged($postID, $userID) {
        try {
            $query = "INSERT INTO Tagged (PostID, UserID) VALUES (:postID, :userID)";
            $statement = $this->conn->prepare($query);
            $statement->bindParam(':postID', $postID, PDO::PARAM_INT);
            $statement->bindParam(':userID', $userID, PDO::PARAM_INT);
            $statement->execute();

            return true; // Insert successful
        } catch (PDOException $e) {
            echo "Error inserting tag: " . $e->getMessage();
            return false; // Insert failed
        }
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

    // Insert like
    public function insertSave($postID, $userID){
        $query = "INSERT INTO saved (PostID, UserID) VALUES (:postID, :userID);";
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

    // Remove like
    public function removeSave($postID, $userID){
        $query = "DELETE FROM saved WHERE PostID =:postID AND UserID = :userID ";
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
        $query = "SELECT COUNT(FollowerID) AS FollowersCount FROM followers WHERE FollowingUserID = :userID";
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

    public function getUsersByString($input) {
        $query = "SELECT * FROM Users
                  WHERE LOWER(Username) LIKE LOWER(:input) OR LOWER(Username) = LOWER(:exactInput)";
        $params = array(':input' => $input . '%', ':exactInput' => $input);
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
    
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($result == '') {
            // "nobody found with this name";
        } else {
            return $result;
        }

    }    
    

    /** returns posts to put on the home page */
    public function getPostFromFollowing($userID, $offset) {
        $query = "SELECT Posts.* FROM Posts
                  JOIN Followers ON Posts.UserID = Followers.FollowingUserID
                  WHERE Followers.FollowerUserID = :userID
                  ORDER BY Posts.PostDate DESC 
                  LIMIT " . $offset . ", 5";
        $params = array(':userID' => $userID);
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($result) {
            return $result;
        } else {
            die(json_encode("Errore nella query: "));
        }
    }

    /** returns posts to put on the explore page */
    public function getRandomPosts($offset) {
        $query = "SELECT * FROM Posts
                  ORDER BY Posts.PostDate DESC
                  LIMIT :offset, 5";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        
        if ($stmt->execute()) {

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($result) {
                return $result;
            } else {
                die(json_encode("La query getRandomPost non ha restituito risultati."));
            }

        } else {
            die(json_encode("Errore nella query getRandomPost: " . implode(" ", $stmt->errorInfo())));
        }
    }
    

    /** returns posts to put on the explore page, filtered by category */
    public function getPostsByCategory($categoryID, $offset){
        $query = "SELECT * FROM Posts
                  WHERE CategoryID = :categoryID
                  ORDER BY PostDate DESC
                  LIMIT " . $offset . ", 5";
        $params = array(':categoryID' => $categoryID);
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($result) {
            return $result;
        } else {
            die(json_encode("Errore nella query getPostsFromCategory: "));
        }
    }


    public function getUserIDByPostID($postID) {
        try {
            $query = "SELECT UserID FROM Posts WHERE PostID = :postID";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':postID', $postID, PDO::PARAM_INT);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                return $result['UserID'];
            } else {
                return false; // Post not found or no associated user
            }
        } catch (PDOException $e) {
            // Handle the exception if needed
            echo "Error: " . $e->getMessage();
            return false;
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

    public function getSaveFromPost($postID, $userID){
        $query = "SELECT SavedID FROM saved WHERE PostID = :postID AND UserID = :userID";
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

    public function removeNotification($notificationID) {
        $query = "DELETE FROM Notifications WHERE NotificationID = :notificationID";
    
        $params = array(':notificationID' => $notificationID);
    
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute($params);
    
            // Check the number of affected rows to verify if the deletion was successful
            if ($stmt->rowCount() > 0) {
                // Return true on success
                return true;
            } else {
                // Return false if no rows were affected (notification not found)
                return false;
            }
        } catch (PDOException $e) {
            // Log or display the error message
            error_log('Error removing notification: ' . $e->getMessage());
            // Return false on failure
            return false;
        }
    }

    public function getUserLikedPosts($userID) {
        $query = "
            SELECT 
                p.*, 
                COUNT(l.LikeID) AS LikesCount 
            FROM 
                posts p
                INNER JOIN likes l ON p.PostID = l.PostID
            WHERE 
                l.UserID = :userID
            GROUP BY 
                p.PostID
        ";
    
        $params = array(':userID' => $userID);
    
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute($params);
    
            // Fetch all posts liked by the user with the count of likes
            $userLikedPosts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            return $userLikedPosts;
        } catch (PDOException $e) {
            // Handle the exception (log, display an error message, etc.)
            return false;
        }
    }

    public function getUserSavedPosts($userID) {
        $query = "
            SELECT 
                p.*, 
                COUNT(s.SavedID) AS SavedCount 
            FROM 
                posts p
                INNER JOIN saved s ON p.PostID = s.PostID
            WHERE 
                s.UserID = :userID
            GROUP BY 
                p.PostID
        ";
    
        $params = array(':userID' => $userID);
    
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute($params);
    
            // Fetch all posts liked by the user with the count of likes
            $userSavedPosts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            return $userSavedPosts;
        } catch (PDOException $e) {
            // Handle the exception (log, display an error message, etc.)
            return false;
        }
    }

    public function getUserTaggedPosts($userID) {
        $query = "
            SELECT 
                p.*, 
                COUNT(t.TaggedID) AS TagCount 
            FROM 
                posts p
                INNER JOIN tagged t ON p.PostID = t.PostID
            WHERE 
                t.UserID = :userID
            GROUP BY 
                p.PostID
        ";
    
        $params = array(':userID' => $userID);
    
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute($params);
    
            // Fetch all posts tagged by the user with the count of tags
            $userTaggedPosts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            return $userTaggedPosts;
        } catch (PDOException $e) {
            // Handle the exception (log, display an error message, etc.)
            return false;
        }
    }
    
    public function getCategoryID($categoryName) {
        $query = "SELECT CategoryID FROM Categories WHERE CategoryName = :categoryName";
        $params = array(':categoryName' => $categoryName);

        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute($params);

            // Restituisci l'ID della categoria se trovato
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return ($result) ? $result['CategoryID'] : null;
        } catch (PDOException $e) {
            // Gestisci l'eccezione (registra, visualizza un messaggio di errore, ecc.)
            return null;
        }
    }

    public function getUserChatMessages($userID) {
        $query = "
            SELECT 
                cm.MessageID,
                cm.SenderID,
                cm.ReceiverID,
                cm.MessageText,
                cm.SendDate,
                u.Username AS SenderUsername
            FROM 
                ChatMessages cm
                INNER JOIN Users u ON cm.SenderID = u.UserID
            WHERE 
                cm.ReceiverID = :userID
            ORDER BY 
                cm.SendDate DESC
        ";
    
        $params = array(':userID' => $userID);
    
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute($params);
    
            // Fetch all chat messages for the user
            $userChatMessages = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            return $userChatMessages;
        } catch (PDOException $e) {
            // Handle the exception (log, display an error message, etc.)
            return false;
        }
    }

    public function getConversationUsers($currentUserID) {
        $sql = "SELECT DISTINCT u.UserID, u.Username, ui.LogoURL
                FROM Users u
                JOIN ChatMessages cm ON u.UserID = cm.SenderID OR u.UserID = cm.ReceiverID
                LEFT JOIN UserInfos ui ON u.UserID = ui.UserID
                WHERE cm.SenderID = :currentUserID OR cm.ReceiverID = :currentUserID
                   OR u.UserID IN (SELECT FollowingUserID FROM Followers WHERE FollowerUserID = :currentUserID)";
    
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':currentUserID', $currentUserID, PDO::PARAM_INT);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function getMessages($senderID, $receiverID) {
        $sql = "SELECT MessageText, SendDate, SenderID
                FROM ChatMessages
                WHERE (SenderID = :senderID AND ReceiverID = :receiverID)
                OR (SenderID = :receiverID AND ReceiverID = :senderID)
                ORDER BY SendDate";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':senderID', $senderID, PDO::PARAM_INT);
        $stmt->bindParam(':receiverID', $receiverID, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function uploadImage($imageName, $imageData) {
        try {
            $stmt = $this->conn->prepare("INSERT INTO Images (ImageName, ImageData) VALUES (:imageName, :imageData)");
            $stmt->bindParam(':imageName', $imageName);
            $stmt->bindParam(':imageData', $imageData, PDO::PARAM_LOB);
            
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function retrieveImage($imageName) {
        try {
            $stmt = $this->conn->prepare("SELECT ImageData FROM Images WHERE ImageName = :imageName");
            $stmt->bindParam(':imageName', $imageName);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                return $result['ImageData'];
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo "Error retrieving image: " . $e->getMessage();
            return null;
        }
    }

    public function getImageAsBase64($imageName) {
        $imageData = $this->retrieveImage($imageName);

        if ($imageData) {
            return base64_encode($imageData);
        } else {
            return null;
        }
    }

    public function insertDefaultPhoto($userID, $photoPath, $fullName) {
        $query = "INSERT INTO UserInfos (UserID, LogoURL, FullName) VALUES (:userID, :photoPath, :fullName)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        $stmt->bindParam(':photoPath', $photoPath, PDO::PARAM_STR);
        $stmt->bindParam(':fullName', $fullName, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function checkDuplicateImageName($imageName) {
        try {
            $stmt = $this->conn->prepare("SELECT ImageID FROM Images WHERE ImageName = :imageName");
            $stmt->bindParam(':imageName', $imageName);
            $stmt->execute();
            $rowCount = $stmt->rowCount();
            return $rowCount > 0;
        } catch (PDOException $e) {
            echo "Error checking duplicate image name: " . $e->getMessage();
            return false;
        }
    }

    public function updateUserLogoURL($userID, $logoURL) {
        try {
            $stmt = $this->conn->prepare("UPDATE UserInfos SET LogoURL = :logoURL WHERE UserID = :userID");
            $stmt->bindParam(':logoURL', $logoURL);
            $stmt->bindParam(':userID', $userID);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Error updating LogoURL: " . $e->getMessage();
            return false;
        }
    }

    public function imageNameExists($imageName) {
        try {
            $query = "SELECT COUNT(*) FROM Images WHERE ImageName = :imageName";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':imageName', $imageName, PDO::PARAM_STR);
            $stmt->execute();

            $count = $stmt->fetchColumn();

            return ($count > 0);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false; // You might want to handle the error more gracefully in a production environment
        }
    }

    public function getPostByID($postID) {
        try {
            $sql = "SELECT * FROM Posts WHERE PostID = :postID";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':postID', $postID, PDO::PARAM_INT);
            $stmt->execute();

            $post = $stmt->fetch(PDO::FETCH_ASSOC);

            return $post;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function removeFollower($followerID, $followingID) {
        try {
            $stmt = $this->conn->prepare("DELETE FROM Followers WHERE FollowerUserID = :followerID AND FollowingUserID = :followingID");
            $stmt->bindParam(':followerID', $followerID, PDO::PARAM_INT);
            $stmt->bindParam(':followingID', $followingID, PDO::PARAM_INT);
            $stmt->execute();

            // Check if any rows were affected
            $rowCount = $stmt->rowCount();
            return $rowCount > 0;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function isFollower($loggedInUserID, $userIDToFollow) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM Followers WHERE FollowerUserID = :loggedInUserID AND FollowingUserID = :userIDToFollow");
            $stmt->bindParam(':loggedInUserID', $loggedInUserID, PDO::PARAM_INT);
            $stmt->bindParam(':userIDToFollow', $userIDToFollow, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

}

?>