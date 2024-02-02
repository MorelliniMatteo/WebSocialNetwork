
const postsContainer = document.querySelector(".posts-container");
const sentinel = document.querySelector(".space");
const index = 5;

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
                let post = createPostElement(element, userData, database);
                postsContainer.appendChild(post);
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

let userData = {
    'UserID': 1
};

let database = {
    'getUserProfileInfo': function (userID) {
        return {
            'LogoURL': 'path-to-your-logo.jpg'
        };
    },
    'getUserByID': function (userID) {
        return {
            'Username': 'TestUser'
        };
    },
    'getLikesFromPost': function (postID, userID) {
        // Logica di esempio
        return false;
    },
    'getCommentsFromPostID': function (postID) {
        // Logica di esempio
        return [];
    }
}

function createPostElement(post, userData, database) {
    let postContainer = document.createElement('div');
    postContainer.className = 'post-container';
    postContainer.id = post.PostID;

    let postDiv = document.createElement('div');
    postDiv.className = 'post';

    let header = document.createElement('header');
    let avatarImg = document.createElement('img');
    avatarImg.src = database.getUserProfileInfo(post.UserID).LogoURL;
    avatarImg.alt = 'User Avatar';

    let usernameLink = document.createElement('a');
    usernameLink.href = '#';
    usernameLink.label = 'View user profile';
    usernameLink.textContent = database.getUserByID(post.UserID).Username;

    header.appendChild(avatarImg);
    header.appendChild(usernameLink);

    let postImg = document.createElement('img');
    postImg.src = post.MediaURL;
    postImg.alt = 'Post Image';

    let postCaption = document.createElement('p');
    postCaption.textContent = post.Caption;

    let interactionSection = document.createElement('section');
    let interactionHeader = document.createElement('h1');

    let likeButton = document.createElement('img');
    likeButton.className = 'icon likeButton';
    likeButton.src = database.getLikesFromPost(post.PostID, userData.UserID) ? '../icon/like.svg' : '../icon/like-empty.svg';
    likeButton.alt = 'like button';
    likeButton.onclick = function () {
        Like(post.PostID, userData.UserID);
    };

    let commentButton = document.createElement('img');
    commentButton.className = 'icon commentButton';
    commentButton.src = '../icon/comment-empty.svg';
    commentButton.alt = 'comment button';
    commentButton.onclick = function () {
        openComments(post.PostID);
    };

    let shareButton = document.createElement('img');
    shareButton.className = 'icon shareButton';
    shareButton.src = '../icon/share.svg';
    shareButton.alt = 'comment button';
    shareButton.onclick = function () {
        sharePost(post.PostID);
    };

    interactionHeader.textContent = 'interaction';
    interactionSection.appendChild(interactionHeader);
    interactionSection.appendChild(likeButton);
    interactionSection.appendChild(commentButton);
    interactionSection.appendChild(shareButton);

    postDiv.appendChild(header);
    postDiv.appendChild(postImg);
    postDiv.appendChild(postCaption);
    postDiv.appendChild(interactionSection);

    let commentsAside = document.createElement('aside');
    commentsAside.className = 'comments';

    let commentsHeader = document.createElement('h2');
    commentsHeader.textContent = 'Commenti';

    let commentsContainer = document.createElement('div');
    commentsContainer.className = 'comments-container';

    let descriptionP = document.createElement('p');
    descriptionP.className = 'description';
    descriptionP.textContent = post.Caption;

    commentsContainer.appendChild(descriptionP);

    let comments = database.getCommentsFromPostID(post.PostID);
    comments.forEach(function (comment) {
        let commentP = document.createElement('p');
        commentP.textContent = database.getUserByID(comment.UserID).Username + ': ' + comment.CommentText;
        commentsContainer.appendChild(commentP);
    });

    let commentForm = document.createElement('form');
    commentForm.id = 'commentForm';
    let postIDInput = document.createElement('input');
    postIDInput.type = 'hidden';
    postIDInput.name = 'PostID';
    postIDInput.value = post.PostID;

    let userIDInput = document.createElement('input');
    userIDInput.type = 'hidden';
    userIDInput.name = 'UserID';
    userIDInput.value = userData.UserID;

    let commentLabel = document.createElement('label');
    commentLabel.for = 'CommentText';

    let commentInput = document.createElement('input');
    commentInput.type = 'text';
    commentInput.name = 'CommentText';
    commentInput.id = 'CommentText';
    commentInput.placeholder = 'add a comment';
    commentInput.required = true;

    let sendCommentButton = document.createElement('input');
    sendCommentButton.type = 'button';
    sendCommentButton.value = 'send comment';
    sendCommentButton.onclick = function () {
        submitComment();
    };

    commentForm.appendChild(postIDInput);
    commentForm.appendChild(userIDInput);
    commentForm.appendChild(commentLabel);
    commentForm.appendChild(commentInput);
    commentForm.appendChild(sendCommentButton);

    commentsAside.appendChild(commentsHeader);
    commentsAside.appendChild(commentsContainer);
    commentsAside.appendChild(commentForm);

    postContainer.appendChild(postDiv);
    postContainer.appendChild(commentsAside);

    return postContainer;
}