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