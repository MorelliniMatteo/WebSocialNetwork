let likeButtons = document.querySelectorAll(".likeButton");
let saveButton = document.querySelectorAll(".saveButton");
let userID = 4; // replace with loggedIn userID

$(document).on('click', '.likeButton', function() {
    let likeButton = $(this);
    let post = likeButton.closest(".post-container");
    let postID = post.attr('id');

    // Aggiungi o rimuovi il like a seconda dello stato corrente
    if (likeButton.attr('src').endsWith("like-empty.svg")) {
        likeButton.attr('src', "../icon/like.svg");
    } else {
        likeButton.attr('src', "../icon/like-empty.svg");
    }
    
    // Esegui la richiesta AJAX
    $.ajax({
        type: 'POST',
        url: '../models/pushLike.php',
        data: { 
            postID: postID,
            userID: userID,
            add: (likeButton.attr('src').endsWith("like-empty.svg")) ? 0 : 1
        },
        success: function (response) {
            console.log(response);
        },
        error: function (errore) {
            console.error('Errore nella richiesta AJAX:', errore);
        }
    });
});

$(document).on('click', '.saveButton', function() {
    let saveButton = $(this);
    let post = saveButton.closest(".post-container");
    let postID = post.attr('id');

    // Aggiungi o rimuovi il like a seconda dello stato corrente
    if (saveButton.attr('src').endsWith("saved.svg")) {
        saveButton.attr('src', "../icon/save.svg");
    } else {
        saveButton.attr('src', "../icon/saved.svg");
    }
    
    // Esegui la richiesta AJAX
    $.ajax({
        type: 'POST',
        url: '../models/pushSave.php', // TO DO
        data: { 
            postID: postID,
            userID: userID,
            add: (saveButton.attr('src').endsWith("save.svg")) ? 0 : 1
        },
        success: function (response) {
            console.log(response);
        },
        error: function (errore) {
            console.error('Errore nella richiesta AJAX:', errore);
        }
    });
});

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
        xhr.open('POST', '../models/pushComment.php', true); //../models/pushComment.php
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