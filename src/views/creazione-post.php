<?php
include_once('../db/database.php');

$database = new Database();
$errorMessage = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['confirmButton'])) {
        // Verifica che entrambi i campi siano compilati
        if (!empty($_FILES['photoInput']['name']) && !empty($_POST['descriptionInput']) && !empty($_POST['category'])) {
            // Esegue l'upload della foto e ottiene l'URL
            $targetDirectory = "../img/";  // Assicurati di creare questa cartella
            $targetFile = $targetDirectory . basename($_FILES["photoInput"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

            // Controlla se il file immagine è un'immagine reale o un'immagine falsa o un file corrotto
            $check = getimagesize($_FILES["photoInput"]["tmp_name"]);
            if ($check === false) {
                $uploadOk = 0;
            }

            // Verifica se il file esiste già
            if (file_exists($targetFile)) {
                $uploadOk = 0;
            }

            // Verifica la dimensione massima del file
            if ($_FILES["photoInput"]["size"] > 500000) {
                $uploadOk = 0;
            }

            // Consenti solo alcuni formati di file, limitando file che non sono immagini
            $allowedFormats = ["jpg", "jpeg", "png", "gif"];
            if (!in_array($imageFileType, $allowedFormats)) {
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
                    
                    // Chiamare il metodo getCategoryID della tua istanza di Database
                    $categoryID = $database->getCategoryID($_POST['category']);

                    // Verifica se la categoria è stata selezionata
                    if ($categoryID !== null) {
                        // Inserisci il post nel database
                        if ($database->insertPost($userID, $mediaURL, $caption, $categoryID)) {
                            // Reindirizza all'URL del profilo
                            header("Location: Profile.php");
                            exit();
                        } else {
                            $errorMessage = "Errore durante l'inserimento del post nel database.";
                        }
                    } else {
                        $errorMessage = "Seleziona una categoria valida.";
                    }
                } else {
                    $errorMessage = "Errore nell'upload del file.";
                }
            }
        } else {
            $errorMessage = "Tutti i campi devono essere compilati.";
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
        <img src="../img/CreateYourPost1.png" alt="" id="pic1">
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

                    <div class="container">
                        <label for="descriptionInput">Descrizione del Post:</label>
                        <textarea id="descriptionInput" name="descriptionInput" placeholder="Inserisci una descrizione..." rows="2"></textarea>
                        <select name="category" id="category">
                            <option value="" disabled selected>Category</option>
                            <option value="opzione1">Travel</option>
                            <option value="opzione2">Nature</option>
                            <option value="opzione3">Lifestyle</option>
                            <option value="opzione3">Art</option>
                            <option value="opzione3">Sculpture</option>
                            <option value="opzione3">DigitalArt</option>
                        </select>
                    </div>
                    
                    <label for="error-message" class="error-message"><?php echo "$errorMessage" ?></label>


                    <button type="submit" name="confirmButton" id="confirmButton">Confirm</button>

                    <!-- Messaggio di conferma -->
                    <section id="confirmationMessage" style="display: none;">
                        <p>Il post è stato inviato con successo!</p>
                    </section>
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