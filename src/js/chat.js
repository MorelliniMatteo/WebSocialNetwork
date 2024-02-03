$(document).ready(function () {
    const messageButtons = $('.message');
    const navbar = $('.navbar');
    const messageContainer = $('.message-container');
    const dialogPage = $('.dialog-page');
    const dialogContainer = $('#dialogContainer');
    const currentChatUserInfo = $('#currentChatUserInfo');
    const sendButton = $('#sendButton');
    const userInput = $('#userInput');



    let currentUserID = parseInt($('#userID').text(), 10);
    let currentSenderID;

    messageButtons.on('click', function () {
        console.log('Message button clicked');

        const senderName = $(this).find('.sender-name').text();
        const senderImage = $(this).find('.sender-image').attr('src');
        const senderID = parseInt($(this).find('.sender-id').text(), 10);
        currentSenderID = senderID;

        // Set the header information for the person you clicked
        currentChatUserInfo.html(`
            <div class="sender-profile-image small">
                <img class="sender-image" src="${senderImage}" />
            </div>
            <span class="sender-name">${senderName}</span>
            <span class="sender-id invisible">${senderID}</span>
        `);

        console.log(senderID)
        console.log(currentUserID)

        // Fetch and display messages between two users
        fetchAndDisplayMessages(senderID, currentUserID);
        messageContainer.css('display', 'none');
        navbar.css('display', 'none');
        dialogPage.css('display', 'flex');
        $('main.main').addClass('active');
    });

    $('#backButton').on('click', function () {
        // Hide the dialog page and show the message container when the back button is clicked
        dialogPage.css('display', 'none');
        messageContainer.css('display', 'flex');
        navbar.css('display', 'flex');
        $('main.main').removeClass('active');
    });

    function fetchAndDisplayMessages(senderID, currentUserID) {
        // Fetch messages from the server using jQuery AJAX
        $.ajax({
            url: '../models/get_messages.php',
            method: 'POST',
            data: {
                senderID: senderID,
                currentUserID: currentUserID
            },
            dataType: 'json',
            success: function (messages) {

                // Display messages in the dialogContainer
                dialogContainer.empty();

                $.each(messages, function (index, message) {
                    const isCurrentUserMessage = message.SenderID == currentUserID;
                    const dialogClass = isCurrentUserMessage ? 'right' : '';

                    const dialog = $('<div>', {
                        class: 'dialog ' + dialogClass,
                        html: `
                            <div class="dialog-text">${message.MessageText}</div>
                            <div class="text-sendTime">
                                <div class="send-time">${message.SendDate}</div>
                            </div>
                        `
                    });

                    dialogContainer.append(dialog);
                });
                console.log('AJAX ended success:', messages);
            },
            error: function (error) {
                console.error('Error fetching messages:', error);
            }
        });
    }

    sendButton.on('click', function () {
        const senderID = currentUserID;
        const receiverID = currentSenderID;
        const messageText = userInput.val();

        // Check if the message is not empty
        if (messageText.trim() !== '') {
            // Send an AJAX request to insert the message into the database
            $.ajax({
                url: '../models/insert_message.php',
                method: 'POST',
                data: {
                    senderID: senderID,
                    receiverID: receiverID,
                    messageText: messageText
                },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        // Message successfully inserted, you can handle this as needed
                        console.log('Message sent successfully');
                        userInput.val('');
                    } else {
                        console.error('Error inserting message:', response.error);
                    }
                },
                error: function (error) {
                    console.error('AJAX error:', error);
                }
            });
        }
    });
});
