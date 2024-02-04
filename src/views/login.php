<?php
session_start(); // Avvia la sessione

include_once('../db/database.php');

$database = new Database();

// Verifica se il modulo è stato inviato
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica quale pulsante è stato premuto
    if (isset($_POST['signup'])) {
        // Form di registrazione inviato
        $Username = $_POST['txt'];
        $Email = $_POST['email'];
        $Password = $_POST['pswd'];

        // Effettua la convalida e la registrazione
        if (empty($Username) || empty($Email) || empty($Password)) {
            $errorMessage = "Please fill in all required fields.";
        } else {
            // Verifica se l'email o il nome utente esistono già
            $existingEmail = $database->getUserByEmail($Email);
            $existingUsername = $database->getUserByUsername($Username);

            if ($existingEmail) {
                $errorMessage = "Email already exists. Please put a different one or Login.";
            } elseif ($existingUsername) {
                $errorMessage = "Username already exists. Please put a different one or Login.";
            } else {
                // Determina il percorso della foto di default
                $defaultPhotoPath = '../img/defaultUserPng.jpg';

                // Hash della password e inserimento del nuovo utente
                $hashedPassword = password_hash($Password, PASSWORD_DEFAULT);
                $database->insertUser($Username, $hashedPassword, $Email, '');

                // Ottieni l'ID dell'utente appena inserito
                $userID = $database->getUserByEmail($Email)['UserID'];

                // Inserisci la foto di default nella tabella UserInfos con il nome utente come FullName
                $database->insertDefaultPhoto($userID, $defaultPhotoPath, $Username);

                $_SESSION['user_id'] = $userID; // Setta l'ID utente nella sessione
                header('Location: profile.php');
                exit();
            }
        }   
    } elseif (isset($_POST['login'])) {
        // Form di login inviato
        $Email = $_POST['email'];
        $Password = $_POST['pswd'];

        // Valida l'input (è consigliabile effettuare una convalida più approfondita)
        if (empty($Email) || empty($Password)) {
            $errorMessage = "Please fill in all required fields.";
        } else {
            // Verifica se l'email esiste
            $user = $database->getUserByEmail($Email);

            if ($user && password_verify($Password, $user['Password'])) {
                // Password corretta
                $_SESSION['user_id'] = $user['UserID']; // Setta l'ID utente nella sessione
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
                
                <form class="signup" method="POST">
                    <label for="chk-signup" aria-hidden="true">Sign up</label>

                    <?php if (isset($errorMessage) && !empty($errorMessage)): ?>
                        <label for="error-message" class="error-message"><?php echo $errorMessage; ?></label>
                    <?php endif; ?>

                    <label for="txt">User name</label>
                    <input type="text" id="txt" name="txt" placeholder="User name" required="">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Email" required="">
                    <label for="pswd">Password</label>
                    <input type="password" id="pswd" name="pswd" placeholder="Password" required="">
                    <button type="submit" name="signup">Sign up</button>
                </form>
                
                <form class="login" method="POST">
                    <label for="chk-login" aria-hidden="true" id="loginLabel">Login</label>
                    <label for="login-email">Email</label>
                    <input type="email" id="login-email" name="email" placeholder="Email" required="">
                    <label for="login-pswd">Password</label>
                    <input type="password" id="login-pswd" name="pswd" placeholder="Password" required="">
                    <button type="submit" name="login">Login</button>
                </form>        
                    
            </main>
                
            <img src="../img/LoginFinalPic1.png" alt="">
            
        </div>

        <footer>
            <a href="homePreview.html">Home</a>
            <!-- Aggiungi altri link secondo necessità -->
            <p>Copyright © 2023 All Rights Reserved by ArtHub.</p>
        </footer>

        <script src="../js/login.js"></script>

    </body>
</html>