<?php

if (isset($_POST['post'])) {
    $post = json_decode($_POST['post'], true);
}

?>

<script>
    
    function viewFullPost(dati){
        $.ajax({
            type: 'POST',
            url: '../models/api.php',
            data: { dati: dati },
            success: function (risposta) {
                let div = document.createElement('div');
                div.innerHTML = risposta;
                postsContainer.append(div);
                },
            error: function (errore) {
                console.error('Errore nella richiesta AJAX:', errore);
            }
    });
}
</script>