function changeLike() {
    var likeButton = document.getElementById("likeButton");
    var icon = likeButton.querySelector(".icon");

    // Cambia l'icona al click
    if (icon.src.endsWith("like-empty.svg")) {
        icon.src = "../icon/like.svg"; // Cambia con il percorso dell'icona "like-filled"
    } else {
        icon.src = "../icon/like-empty.svg"; // Ripristina con il percorso dell'icona "like-empty"
    }
}

function changeComment() {
    var commentButton = document.getElementById("commentButton");
    var icon = commentButton.querySelector(".icon");

    // Cambia l'icona al click
    if (icon.src.endsWith("comment-empty.svg")) {
        icon.src = "../icon/comment.svg"; // Cambia con il percorso dell'icona "like-filled"
    } else {
        icon.src = "../icon/comment-empty.svg"; // Ripristina con il percorso dell'icona "like-empty"
    }
}

function changeFollow() {
    var followButton = document.getElementById("followButton");
    var icon = followButton.querySelector(".icon");

    // Cambia l'icona al click
    if (icon.src.endsWith("unfollow.svg")) {
        icon.src = "../icon/follow.svg"; // Cambia con il percorso dell'icona "like-filled"
    } else {
        icon.src = "../icon/unfollow.svg"; // Ripristina con il percorso dell'icona "like-empty"
    }
}