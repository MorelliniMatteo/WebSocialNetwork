<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
    /* Add these styles in the head of your HTML document or in your CSS file */

    .notification-container {
        position: relative;
        display: inline-block;
    }

    #notificationBtn {
        padding: 10px;
        background-color: #3498db;
        color: #fff;
        border: none;
        cursor: pointer;
    }

    #notificationDropdown {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        width: 300px;
        background-color: #fff;
        border: 1px solid #ccc;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        z-index: 1;
        overflow-y: auto; 
        max-height: 300px;
    }

    .notification-item {
        padding: 10px;
        border-bottom: 1px solid #eee;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .notification-item:hover {
        background-color: #f5f5f5;
    }

    .notification-sender {
        font-weight: bold;
        color: #3498db;
    }

    .notification-text {
        margin-left: 5px;
    }
</style>


</head>
<body>
    <div class="notification-container">
        <button id="notificationBtn"><img class="icon" src="../icon/notifications.svg" alt="notifications"></button>
        <div class="notification-dropdown" id="notificationDropdown">
        </div>
    </div>

<!-- Include jQuery library (if not already included) -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<!-- Add this script in your HTML or include it in a separate JS file -->
<script>
$(document).ready(function() {
    // Attach click event to the notification button
    $('#notificationBtn').on('click', function() {
        // Toggle visibility of the notification dropdown
        $('#notificationDropdown').toggle();

        // Check if the dropdown is visible and load notifications if needed
        if ($('#notificationDropdown').is(':visible')) {
            loadNotifications();
        }
    });

    // Function to load notifications using AJAX
    function loadNotifications() {
        // Make an AJAX request to fetch notifications from the server
        $.ajax({
            url: '../models/getNotifications.php', // Replace with your PHP file to fetch notifications
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                // Handle the received data and update the notification dropdown
                updateNotificationDropdown(data);
            },
            error: function(error) {
                console.log('Error fetching notifications: ', error);
            }
        });
    }

// Function to update the notification dropdown content
function updateNotificationDropdown(notifications) {
    const dropdownContent = $('#notificationDropdown');

    // Clear existing content
    dropdownContent.empty();

    // Check if there are notifications
    if (notifications.length > 0) {
        // Iterate through notifications and append to the dropdown
        notifications.forEach(function(notification) {
            let notificationItem = $('<div class="notification-item"></div>');

            // Add sender information
            let senderInfo = $('<span class="notification-sender">' + notification.FromUserName + ': ' + '</span>');
            notificationItem.append(senderInfo);

            // Add notification text
            notificationItem.append(notification.NotificationText);

            // Add remove button
            let removeButton = $('<button class="remove-notification">X</button>');
            removeButton.on('click', function() {
                // Handle the remove button click
                removeNotification(notification.NotificationID);
            });
            notificationItem.append(removeButton);

            dropdownContent.append(notificationItem);
        });
    } else {
        // If no notifications, display a message
        dropdownContent.append('<div class="notification-item">No new notifications</div>');
    }

    // Show the dropdown after updating content
    $('#notificationDropdown').show();
}

// Function to handle the remove button click
function removeNotification(notificationID) {
    // Implement the logic to remove the notification from the database
    // You may use AJAX to send a request to the server to delete the notification
    // Adjust this function based on your server-side implementation
    $.ajax({
        type: 'POST',
        url: '../models/remove_notification.php', // Add timestamp to prevent caching
        data: { notificationID: notificationID },
        success: function(response) {
            // Handle the success response
            console.log(notificationID + 'Notification removed successfully' + response);
        },
        error: function(error) {
            // Handle the error
            console.error('Error removing notification', error);
        }
    });
}


});
</script>

</body>
</html>