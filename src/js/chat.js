// chat.js

document.addEventListener('DOMContentLoaded', function() {
    
    const messageButtons = document.querySelectorAll('.message');
    messageButtons.forEach(button => {
        button.addEventListener('click', showDialogContainer);
    });

    document.getElementById('backButton').addEventListener('click', showMessageContainer);
});

function showDialogContainer() {
    document.querySelector('.message-container').style.display = 'none';
    document.querySelector('.dialog-page').style.display = 'flex';
}

function showMessageContainer() {
    document.querySelector('.message-container').style.display = 'flex';
    document.querySelector('.dialog-page').style.display = 'none';
}
