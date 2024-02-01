function Like(postID, userID) {
    let post = document.getElementById(postID);
    let icon = post.querySelector(".likeButton");
    let xhr = new XMLHttpRequest();

    // Cambia l'icona al click
    if (icon.src.endsWith("like-empty.svg")) {
        icon.src = "../icon/like.svg"; // Cambia con il percorso dell'icona "like-filled"
        var dati = "postID=" + encodeURIComponent(postID) + "&userID=" + encodeURIComponent(userID) + "&add=1";
    } else {
        icon.src = "../icon/like-empty.svg"; // Ripristina con il percorso dell'icona "like-empty"
        var dati = "postID=" + encodeURIComponent(postID) + "&userID=" + encodeURIComponent(userID) + "&add=0";
    }

    xhr.open("POST", 'pushLike.php', true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function() {
        if (xhr.status === 200) {
            // La richiesta è andata a buon fine
            console.log(xhr.responseText);
        } else {
            console.error("Errore nella chiamata AJAX. Status:", xhr.status);
        }
    };
    
    xhr.send(dati);
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

function submitComment() {
    let formData = new FormData(document.getElementById('commentForm'));

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