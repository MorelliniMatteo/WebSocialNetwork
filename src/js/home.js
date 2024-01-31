let menu = document.querySelector(".menu");
let aside = document.querySelector(".menu-content");
const checkbox = document.querySelector(".checkbox");

menu.addEventListener('click', () => {
    if(aside.classList.contains("show")){
        aside.classList.remove("show");
    } else {
        aside.classList.add("show");
    }
});

checkbox.addEventListener('change', () => {
    document.body.classList.toggle("dark");
});

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