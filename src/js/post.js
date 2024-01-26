function changeLike() {
    let likeButton = document.getElementById("likeButton");
    let icon = likeButton.querySelector(".icon");

    // Cambia l'icona al click
    if (icon.src.endsWith("like-empty.svg")) {
        icon.src = "../icon/like.svg"; // Cambia con il percorso dell'icona "like-filled"
    } else {
        icon.src = "../icon/like-empty.svg"; // Ripristina con il percorso dell'icona "like-empty"
    }
}

function changeComment() {
    let post = document.querySelector(".post-container");

    if (!post.classList.contains("open")){
        post.classList.add("open");
    } else {
        post.classList.remove("open");
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