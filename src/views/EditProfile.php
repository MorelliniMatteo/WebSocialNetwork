<?php

session_start();

include_once('../db/database.php');

$database = new Database();

// Controlla se l'utente è loggato
if (!isset($_SESSION['user_id'])) {
    // Reindirizza l'utente non autenticato alla pagina di accesso
    header("Location: login.php");
    exit();
}

// Ottieni l'ID dell'utente dalla sessione
$loggedInUserID = $_SESSION['user_id'];

// Fetch user data
$userData = $database->getUserByID($loggedInUserID);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the submitted form data
    $newUsername = $_POST['new_username'];
    $newEmail = $_POST['new_email'];
    $newBio = $_POST['new_bio'];

    // Validate input (you should perform more comprehensive validation)
    if (empty($newUsername) && empty($newEmail) && empty($newBio)) {
        // If no fields are modified, do nothing and redirect back to profile.php
        header('Location: profile.php');
        exit();
    }

    // Check if the new username or email already exists
    $existingUser = $database->getUserByUsername($newUsername);
    $existingEmail = $database->getUserByEmail($newEmail);

    if ($existingUser && $newUsername !== $userData['Username']) {
        $errorMessage = "Username already exists. Please choose a different one.";
    } elseif ($existingEmail && $newEmail !== $userData['Email']) {
        $errorMessage = "Email already exists. Please choose a different one.";
    } else {
        // Get the existing user data
        $existingUserData = $database->getUserByID($loggedInUserID);

        // Update user data in the database
        $result = $database->updateUser(
            $loggedInUserID,
            !empty($newUsername) ? $newUsername : $existingUserData['Username'],
            !empty($newEmail) ? $newEmail : $existingUserData['Email'],
            !empty($newBio) ? $newBio : $existingUserData['Bio']
        );

        if ($result) {
            echo '<script>alert("Profile updated successfully!");</script>';
            // Refresh user data after update
            $userData = $database->getUserByID($loggedInUserID);
        } else {
            echo '<script>alert("Profile update failed. Please try again later.!");</script>';
        }

        // Redirect back to the profile page after submission
        header('Location: profile.php');
        exit();
    }
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/EditProfile.css">
</head>
<body>
<!-- Controllato con Achecker, tutto ok -->
<main class="main">

    <header class="header">
        <div class="public-container header-container">
            <!-- <span class="username"><?php echo $userData['Username']; ?></span> -->
        </div>
    </header>
    <section class="settings-form public-container">
        <form class="form" method="POST">
            <section class="back photo-section">
                <section class="photo-container">
                    <input type="file" id="photoInput" accept="image/*">
                    <label for="photoInput">
                        <div class="image-wrapper">
                            <img src="../img/defaultUser.png" alt="postImage" id="postImage" class="default-image">
                        </div>
                    </label>
                </section>
                <button type="button" class="back-button" id="backButton" onclick="goBack()">Back</button>
            </section>
            
            <section class="input-container ic1">
                <input id="new_username" name="new_username" class="input" type="text" placeholder=" " />
                <div class="cut"></div>
                <label for="new_username" class="placeholder">Username</label>
            </section>
            <section class="input-container ic2">
                <input id="new_email" name="new_email" class="input" type="email" placeholder=" " />
                <div class="cut"></div>
                <label for="new_email" class="placeholder">New Email</label>
            </section>
            <section class="input-container ic2 ic3">
                <textarea id="new_bio" name="new_bio" class="input" type="text" placeholder=" "></textarea>
                <div class="cut cut-short"></div>
                <label for="new_bio" class="placeholder">Bio</>
            </section>
            <button type="submit" class="submit">Update Profile</button>
        </form>
    </section>

</main>

<?php include_once('Nav.php'); ?>

<script src="../js/backbutton.js"></script>
<script src="../js/importTheme.js"></script>
<script src="../js/editProfile.js"></script>

</body>
</html>