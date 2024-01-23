<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/creazione-post.css">
    <title>Social Network Post</title>
</head>

<body>
    <main>
        <article>
            <header>
                <img src="../img/Profile.png" alt="User Avatar">
                <h1>Creazione post</h1>
            </header>

            <section>
                <input type="file" id="photoInput" accept="image/*" style="display: none;" onchange="handlePhotoUpload(event)">
                <label for="photoInput">
                    <img src="../icon/aggiungi-foto.svg" alt="postImage" id="postImage">
                </label>
            </section>

            <!-- Elemento con ID 'postDescription' -->
            <label for="descriptionInput">Descrizione del Post:</label>
            <textarea id="descriptionInput" name="descriptionInput" placeholder="Inserisci una descrizione..." rows="2"></textarea>

            <button id="confirmButton">Confirm</button>

            <!-- Messaggio di conferma -->
            <section id="confirmationMessage" style="display: none;">
                <p>Il post è stato inviato con successo!</p>
            </section>

        </article>
    </main>

    <script src="../js/creazione-post.js"></script>

</body>

</html>