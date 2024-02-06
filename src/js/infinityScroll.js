const page = document.querySelector("main").classList.value;
let categoryID = 0;
//if we are in explore, we update the categoryID by taking its value with an ajax request
if (page === 'explore') {
    $.ajax({
        url: '../models/setCategoryID.php',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            categoryID = data.categoryID;
            console.log('categoryID from PHP:', categoryID);
        },
        error: function(error) {
            console.error('Errore durante la richiesta AJAX:', error);
        }
    });
    console.log(categoryID);
}
const postsContainer = document.querySelector(".posts-container");
const sentinel = document.querySelector(".space");
let index = 0;

function getPostsFromServer(n) {
    return $.ajax({
        type: 'POST',
        url: '../models/loadPosts.php',
        data: { 
            index: n,
            queryName: page,
            categoryID: categoryID
        },
        dataType: 'json',
    })
    .then(function(data) {
        if (data.status === "error") {
            return Promise.reject(new Error(data.message));
        } else {
            //console.log(data);
            return Promise.resolve(data.posts);
        }
    })
    .fail(function(jqXHR, textStatus, errorThrown) {
        return Promise.reject(new Error(`Errore nella richiesta AJAX: ${textStatus} - ${errorThrown}`));
    });
}

function loadMorePosts() {
    getPostsFromServer(index)
        .then(posts => {
            if(posts){
                posts.forEach(element => {
                    let datiJSON = JSON.stringify(element);
                    page === 'home' ? viewFullPost(datiJSON) : viewImg(datiJSON);
            });
            index+=5;
            } else {
                console.log(page);
                console.log("nessun altro post disponibile.");
            }
        })
        .catch(error => {
            console.error(error);
        });
}

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

function viewImg(dati){
    $.ajax({
        type: 'POST',
        url: '../models/viewInExplore.php',
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


const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if(entry.isIntersecting) {
            loadMorePosts();
        }
    });
});

observer.observe(sentinel);