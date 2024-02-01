<?php
include_once('../db/database.php');

$database = new Database();
$errorMessage = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['confirmButton'])) {
        // Verifica che entrambi i campi siano compilati
        if (!empty($_FILES['photoInput']['name']) && !empty($_POST['descriptionInput'])) {
            // Esegue l'upload della foto e ottiene l'URL
            $targetDirectory = "../img/";  // Assicurati di creare questa cartella
            $targetFile = $targetDirectory . basename($_FILES["photoInput"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

            // Controlla se il file immagine è un'immagine reale o un'immagine falsa o un file corrotto
            if (isset($_POST["submit"])) {
                // getimagesize è un metodo che ottiene informazioni sull'immagine in questione se restituisce info
                // valide allora $uploadOk viene messo a true altrimenti a false
                $check = getimagesize($_FILES["photoInput"]["tmp_name"]);
                if ($check !== false) {
                    $uploadOk = 1;
                } else {
                    $uploadOk = 0;
                }
            }

            // Verifica se il file esiste già, se è già presente non ha senso creare un post con la stessa foto
            // e altri utenti non possono rubare l'arte di una persona perciò il file diventa univoco e assume valore
            if (file_exists($targetFile)) {
                $uploadOk = 0;
            }

            // Verifica la dimensione massima del file
            if ($_FILES["photoInput"]["size"] > 500000) {
                $uploadOk = 0;
            }

            // Consenti solo alcuni formati di file, limitando file che non sono immagini
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif") {
                $uploadOk = 0;
            }

            // Controlla se $uploadOk è impostato su 0 a causa di un errore
            if ($uploadOk == 0) {
                $errorMessage = "Errore nell'upload del file.";
            } else {
                if (move_uploaded_file($_FILES["photoInput"]["tmp_name"], $targetFile)) {
                    // Ottieni il resto dei dati dal modulo
                    $userID = 1;  // Sostituisci con l'ID utente reale
                    $mediaURL = $targetFile;
                    $caption = $_POST['descriptionInput'];
                    $categoryID = 1;  // Sostituisci con l'ID della categoria reale

                    // Inserisci il post nel database
                    if ($database->insertPost($userID, $mediaURL, $caption, $categoryID)) {
                        // Reindirizza all'URL del profilo
                        header("Location: Profile.php");
                        exit();
                    } else {
                        $errorMessage = "Errore durante l'inserimento del post nel database.";
                    }
                } else {
                    $errorMessage = "Errore nell'upload del file.";
                }
            }
        } else {
            $errorMessage = "Entrambi i campi devono essere compilati.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/creazione-post.css">
    <title>Social Network Post</title>
</head>

<body>
    <main>
        <img src="../img/CreateYourPost.png" alt="" id="pic1">
        <section>
            <article>
                <header>
                    <img src="../img/Profile.png" alt="User Avatar">
                    <h1>Create Post</h1>
                </header>

                <form method="post" enctype="multipart/form-data">
                    <section>
                        <input type="file" id="photoInput" name="photoInput" accept="image/*" style="display: none;" onchange="handlePhotoUpload(event)">
                        <label for="photoInput">
                            <img src="../icon/aggiungi-foto.svg" alt="postImage" id="postImage">
                        </label>
                    </section>

                    <!-- Elemento con ID 'postDescription' -->
                    <label for="descriptionInput">Descrizione del Post:</label>
                    <textarea id="descriptionInput" name="descriptionInput" placeholder="Inserisci una descrizione..." rows="2"></textarea>
                   
                    
                    <label for="error-message" class="error-message"><?php echo "$errorMessage" ?></label>


                    <button type="submit" name="confirmButton" id="confirmButton">Confirm</button>

                    <!-- Messaggio di conferma -->
                    <section id="confirmationMessage" style="display: none;">
                        <p>Il post è stato inviato con successo!</p>
                    </section>
                </form>

            </article>
        </section>
        <img src="../img/CreateYourPost.png" alt="" id="pic2">
    </main>

    <?php include_once('Nav.php'); ?>

    <script src="../js/creazione-post.js"></script>

</body>

</html>