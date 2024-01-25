<?php
include_once('../models/database.php');

// Assume the user is logged in and you have the user ID
$loggedInUserID = 2; // Replace with the actual logged-in user ID

$database = new Database();

// Fetch user data
$userData = $database->getUserByID($loggedInUserID);

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the submitted form data
    $newUsername = $_POST['new_username'];
    $newEmail = $_POST['new_email'];
    $newBio = $_POST['new_bio'];

    // Validate input (you should perform more comprehensive validation)
    if (empty($newUsername) || empty($newEmail)) {
        $errorMessage = "Please fill in all required fields.";
    } else {
        // Check if the new username or email already exists
        $existingUser = $database->getUserByUsername($newUsername);
        $existingEmail = $database->getUserByEmail($newEmail);

        if ($existingUser && $newUsername !== $userData['Username']) {
            $errorMessage = "Username already exists. Please choose a different one.";
        } elseif ($existingEmail && $newEmail !== $userData['Email']) {
            $errorMessage = "Email already exists. Please choose a different one.";
        } else {
            // Update user data in the database
            $result = $database->updateUser($loggedInUserID, $newUsername, $newEmail, $newBio);

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
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <!-- <link rel="stylesheet" href="../css/EditProfile.css"> -->
    <link rel="stylesheet" href="../css/Profile.css">
    <link rel="stylesheet" href="../css/Nav.css">
</head>
<body>

<main class="main">

    <header class="header">
        <div class="public-container header-container">
            <span class="username"><?php echo $userData['Username']; ?></span>
        </div>
    </header>
    <section class="settings-form public-container">
        <form method="post" action="">
            <label for="new_username">New Username:</label>
            <input type="text" id="new_username" name="new_username" value="<?php echo $userData['Username']; ?>" required><br>

            <label for="new_email">New Email:</label>
            <input type="email" id="new_email" name="new_email" value="<?php echo $userData['Email']; ?>" required><br>

            <label for="new_bio">New Bio:</label>
            <textarea id="new_bio" name="new_bio"><?php echo $userData['Bio']; ?></textarea><br>

            <button type="submit">Update Profile</button>
        </form>
    </section>

</main>

<?php include_once('Nav.php'); ?>

</body>
</html>
