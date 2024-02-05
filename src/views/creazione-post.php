<?php
// Inizio o ripristino della sessione
session_start();

include_once('../db/database.php');

$database = new Database();
$errorMessage = "";

// Verifica se l'utente è autenticato
if (!isset($_SESSION['user_id'])) {
    // Utente non autenticato, potresti reindirizzarlo alla pagina di login
    header('Location: login.php');
    exit();
}

// Ottieni l'ID dell'utente dalla sessione
$userID = $_SESSION['user_id'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/creazione-post.css">
    <link rel="stylesheet" href="../css/style.css">
    <title>Social Network Post</title>
</head>

<body>
    <main>
        <img src="../img/CreateYourPost1.png" alt="" id="pic1">
        <section>
            <article>
                <header>
                    <img src="../img/Profile.png" alt="User Avatar">
                    <h1>Create Post</h1>
                </header>

                <form action="handleCreatePost.php" method="post" enctype="multipart/form-data">
                    <section>
                        <input type="file" id="photoInput" name="photoInput" accept="image/*">
                        <label for="photoInput">
                            <span class="image-name hidden">12345</span>
                            <img src="../icon/aggiungi-foto.svg" alt="postImage" id="postImage">
                        </label>
                    </section>

                    <div class="container">
                        <label for="descriptionInput">Descrizione del Post:</label>
                        <textarea id="descriptionInput" name="descriptionInput" placeholder="Inserisci una descrizione..." rows="2"></textarea>
                        <select name="category" id="category">
                            <option value="" disabled selected>Category</option>
                            <option value="travel">Travel</option>
                            <option value="nature">Nature</option>
                            <option value="lifestyle">Lifestyle</option>
                            <option value="art">Art</option>
                            <option value="sculpture">Sculpture</option>
                            <option value="digital-art">Digital Art</option>
                        </select>
                    </div>

                    <label for="error-message" class="error-message"><?php echo "$errorMessage" ?></label>

                    <button type="submit" name="confirmButton" id="confirmButton">Confirm</button>
                </form>

            </article>
        </section>
        <img src="../img/CreateYourPost2.png" alt="" id="pic2">
    </main>

    <?php include_once('Nav.php'); ?>

    <script src="../js/creazione-post.js"></script>
    <script src="../js/importTheme.js"></script>

</body>

</html>