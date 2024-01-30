<?php
include_once('../db/database.php');

$database = new Database();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check which button was pressed
    if (isset($_POST['signup'])) {
        // Registration form submitted
        $Username = $_POST['txt'];
        $Email = $_POST['email'];
        $Password = $_POST['pswd'];

        // Perform validation and registration
        if (empty($Username) || empty($Email) || empty($Password)) {
            $errorMessage = "Please fill in all required fields.";
        } else {
            // Check if the email or username already exists
            $existingEmail = $database->getUserByEmail($Email);
            $existingUsername = $database->getUserByUsername($Username);

            if ($existingEmail) {
                $errorMessage = "Email already exists. Please put a different one or Login.";
            } elseif ($existingUsername) {
                $errorMessage = "Username already exists. Please put a different one or Login.";
            } else {
                // Hash the password and insert the new user
                $hashedPassword = password_hash($Password, PASSWORD_DEFAULT);
                $database->insertUser($Username, $hashedPassword, $Email, '');
                header('Location: profile.php');
                exit();
            }
        }
    } elseif (isset($_POST['login'])) {
        // Login form submitted
        $Email = $_POST['login-email'];
        $Password = $_POST['login-pswd'];

        // Validate input (you should perform more comprehensive validation)
        if (empty($Email) || empty($Password)) {
            $errorMessage = "Please fill in all required fields.";
        } else {
            // Check if the email exists
            $user = $database->getUserByEmail($Email);

            if ($user && password_verify($Password, $user['Password'])) {
                // Password corretta
                header('Location: profile.php');
                exit();
            } else {
                // Email o password errate
                $errorMessage = "Email or Password are incorrect. Try again or Sign Up";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="UTF-8">
        <link rel="icon" href="../img/logo.PNG" type="image/x-icon">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/login.css">
        <title>Login - Sign Up</title>
    </head>
    <!-- Controllato con Achecker, tutto ok -->
    <body>
        
        <div class="container">

            <input type="checkbox" id="chk-signup" aria-hidden="true">
            <input type="checkbox" id="chk-login" aria-hidden="true">

            <main>  
            	
                <img src="../img/logo.PNG" alt="">
                
                <form class="signup">
                    <label for="chk-signup" aria-hidden="true">Sign up</label>
                    <label for="txt">User name</label>
                    <input type="text" id="txt" name="txt" placeholder="User name" required="">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Email" required="">
                    <label for="pswd">Password</label>
                    <input type="password" id="pswd" name="pswd" placeholder="Password" required="">
                    <button type="submit" name="signup">Sign up</button>
                </form>
                
                <form class="login">
                    <label for="chk-login" aria-hidden="true" id="loginLabel">Login</label>
                    <label for="login-email">Email</label>
                    <input type="email" id="login-email" name="email" placeholder="Email" required="">
                    <label for="login-pswd">Password</label>
                    <input type="password" id="login-pswd" name="pswd" placeholder="Password" required="">
                    <button type="submit" name="login">Login</button>
                </form>        
                    
            </main>
                
            <img src="../img/LoginFinalPic.png" alt="">
            
        </div>

        <footer>
            <a href="homePreview.html">Home</a>
            <!-- Aggiungi altri link secondo necessità -->
            <p>Copyright © 2023 All Rights Reserved by ArtHub.</p>
        </footer>

        <script src="../js/login.js"></script>

    </body>
</html>