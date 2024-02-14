<?php
// Inizio o ripristino della sessione
session_start();

include_once('../db/database.php');
include_once('../models/ImageHelper.php');

$database = new Database();
$errorMessage = "";


// Verifica se l'utente è autenticato
if (!isset($_SESSION['user_id'])) {
    // Utente non autenticato, potresti reindirizzarlo alla pagina di login
    header('Location: login.php');
    exit();
}

// Ottieni l'ID dell'utente dalla sessione
$loggedInUserID = $_SESSION['user_id'];

$profileInfo = $database->getUserProfileInfo($loggedInUserID);

$categories = $database->getCategories();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirmButton'])) {
    $category = isset($_POST['category']) ? $_POST['category'] : "";
    $description = empty($_POST['descriptionInput']) ? "..." : $_POST['descriptionInput'];
    $categoryID = $database->getCategoryID($category);

    // Verificare se la categoria è stata selezionata
    if (empty($category)) {
        $errorMessage = "Must choose a category";
    } elseif ($_FILES["photoInput"]["error"] === UPLOAD_ERR_OK) {
        $fileData = file_get_contents($_FILES["photoInput"]["tmp_name"]);
        $imageName = basename($_FILES["photoInput"]["name"]);

        if ($database->imageNameExists($imageName)) {
            $errorMessage = "Image name already exists";
        } else {
            if ($database->uploadImage($imageName, $fileData)) {
                // Create a new post
                $newPostID = $database->insertPost($loggedInUserID, $imageName, $description, $categoryID);

                // Check for "@" symbol in the description
                if (preg_match_all('/@(\w+)/', $description, $matches)) {
                    $taggedUsernames = $matches[1];

                    // Insert records into Tagged table
                    foreach ($taggedUsernames as $username) {
                        // Get the UserID based on the username
                        $taggedUserID = $database->getUserIDByUsername($username);

                        // Insert into Tagged only if UserID is found
                        if ($taggedUserID !== false) {
                            $database->insertTagged($newPostID, $taggedUserID);
                            $database->insertNotification($loggedInUserID, $taggedUserID, 'tag', $newPostID);
                        } else {
                            // Handle the case when the user with the given username is not found
                            echo "User with username '$username' not found.";
                        }
                    }
                }
                header("Location: Profile.php");
            } else {
                $errorMessage = "Failed to upload";
            }
        }
    } else {
        $errorMessage = "Failed";
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
    <link rel="stylesheet" href="../css/style.css">
    <title>Social Network Post</title>
</head>

<body>
    <main>
        <img src="../img/CreateYourPost1.png" alt="" id="pic1">
        <section>
            <article>
                <header>
                    <img src="<?php echo displayProfileImage($database, $profileInfo['LogoURL']); ?>" alt="User Avatar">
                    <h1>Create Post</h1>
                </header>

                <form method="post" enctype="multipart/form-data">
                    <section>
                        <input type="file" id="photoInput" name="photoInput" accept="image/*">
                        <label for="photoInput">
                            <img src="../icon/aggiungi-foto.svg" alt="postImage" id="postImage">
                        </label>
                    </section>

                    <div class="container">
                        <label for="descriptionInput">Descrizione del Post:</label>
                        <textarea id="descriptionInput" name="descriptionInput" placeholder="Inserisci una descrizione..." rows="2"></textarea>
                        <label for="category">Category:</label>
                        <select name="category" id="category"> 
                            <option value="" selected disabled>category</option>
                            <?php foreach($categories as $category) : ?> 
                                <option value="<?php echo $category['CategoryName'] ?>"><?php echo $category['CategoryName'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <span for="error-message" class="error-message"><?php echo "$errorMessage" ?></span>

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
