let like = document.querySelectorAll(".likeButton");

like.forEach( (element) => {
    element.addEventListener( 'click', function() {
        
    })
});

function Like(postID, userID) {
    let post = document.getElementById(postID);
    let icon = post.querySelector(".likeButton");
    
    let dati = "postID=" + encodeURIComponent(postID) + "&userID=" + encodeURIComponent(userID) + "&add=1";

    // Cambia l'icona al click
    if (icon.src.endsWith("like-empty.svg")) {
        icon.src = "../icon/like.svg"; // Cambia con il percorso dell'icona "like-filled"
        let dati = "postID=" + encodeURIComponent(postID) + "&userID=" + encodeURIComponent(userID) + "&add=1";
    } else {
        icon.src = "../icon/like-empty.svg"; // Ripristina con il percorso dell'icona "like-empty"
        let dati = "postID=" + encodeURIComponent(postID) + "&userID=" + encodeURIComponent(userID) + "&add=0";
    }

    $.ajax({
        type: 'POST',
        url: '../views/pushLike.php',
        data: { dati: dati },
        success: function (resposne) {
                console.log(response);
            },
            error: function (errore) {
                console.error('Errore nella richiesta AJAX:', errore);
            }
        })
}

function openComments(postID) {
    let post = document.getElementById(postID);
    let icon = post.querySelector(".commentButton"); // Seleziona l'elemento dell'icona commento

    if (!post.classList.contains("open")){
        post.classList.add("open");
        icon.src = "../icon/comment.svg"; // Cambia con il percorso dell'icona "comment-filled"
    } else {
        post.classList.remove("open");
        icon.src = "../icon/comment-empty.svg"; // Ripristina con il percorso dell'icona "comment-empty"
    }
}

function submitComment(postID) {
    let form = document.getElementById("commentForm_" + postID);

    if(form){
        let formData = new FormData(form);

        let xhr = new XMLHttpRequest();
        xhr.open('POST', 'pushComment.php', true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                console.log(xhr.responseText);
            } else {
                console.error('Errore nella richiesta AJAX');
            }
        };
    
        xhr.send(formData);
    } else {
        console.error('Errore: form non trovato');
    }
    
}


/*function changeFollow() {
    let followButton = document.getElementById("followButton");
    let icon = followButton.querySelector(".icon");

    // Cambia l'icona al click
    if (icon.src.endsWith("unfollow.svg")) {
        icon.src = "../icon/follow.svg"; // Cambia con il percorso dell'icona "like-filled"
    } else {
        icon.src = "../icon/unfollow.svg"; // Ripristina con il percorso dell'icona "like-empty"
    }
}*/