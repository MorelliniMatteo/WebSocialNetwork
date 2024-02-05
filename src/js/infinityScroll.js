
const postsContainer = document.querySelector(".posts-container");
const sentinel = document.querySelector(".space");
let index = 0;

function getPostsFromServer(n) {
    return $.ajax({
        type: 'POST',
        url: '../views/loadPosts.php',
        data: { 
            index: n,
            queryName: 'home'
        },
        dataType: 'json',
    })
    .then(function(data) {
        if (data.status === "error") {
            return Promise.reject(new Error(data.message));
        } else {
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
                    $.ajax({
                    type: 'POST',
                    url: '../models/api.php',
                    data: { dati: datiJSON },
                    success: function (risposta) {
                        let div = document.createElement('div');
                        div.innerHTML = risposta;
                        postsContainer.append(div);
                        },
                        error: function (errore) {
                            console.error('Errore nella richiesta AJAX:', errore);
                        }
                    });
            });
            index+=5;
            } else {
                console.log("nessun altro post disponibile.");
            }
        })
        .catch(error => {
            console.error(error);
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