const allLinks = document.querySelectorAll("nav ul a");
const allTabs = document.querySelectorAll(".tab-content");
const body = document.querySelector("body");

allLinks.forEach((elem) => {
    elem.addEventListener('click', function(){
        const linkId = elem.id;

        allTabs.forEach((elem) => {
            if(elem.id.includes(linkId)){
                elem.classList.add('active');
                elem.classList.remove('disable');
            } else {
                elem.classList.remove('active');
                elem.classList.add('disable');
            }
        });
    });
});