
const postsContainer = document.querySelector(".posts-container");
const sentinel = document.querySelector(".space");
let index = 5;

function getPostsFromServer(n) {
    return new Promise((resolve, reject) => {
        const xhr = new XMLHttpRequest();
        const url = 'loadPosts.php';
        xhr.open('POST', url, true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    const data = JSON.parse(xhr.responseText);
                    if (data.status === "error") {
                        reject(new Error(data.message));
                    } else {
                        resolve(data.posts);
                    }
                } else {
                    reject(new Error(`Errore nella richiesta AJAX: ${xhr.status} - ${xhr.statusText}`));
                }
            }
        };
        xhr.send(`index=${n}`);
    });
}

function loadMorePosts() {
    getPostsFromServer(index)
        .then(posts => {
            console.log(posts);
            if(posts.length > 0){
                posts.forEach(element => {
                    let datiJSON = JSON.stringify(element);
                    $.ajax({
                    type: 'POST',
                    url: '../models/api.php',
                    data: { dati: datiJSON },
                    success: function (risposta) {
                        console.log(risposta);
                        postsContainer.append(risposta);
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