// script.js
$(document).ready(function() {
    
    let followerID = $("#userData").data("loggedinuserid");
    let followingID = $("#userData").data("userid");
    
    $("#followBtn").on("click", function() {
        toggleFollow(followerID, followingID);
    });


    console.log("userID:", followingID);
    console.log("loggedInUserID:", followerID);
});

function toggleFollow(loggedInUserID, userIDToFollow) {
    let followTextElement = $("#followText");
    let loggedInUser = loggedInUserID;
    let userToFollow = userIDToFollow;

    if (followTextElement.text() === "Follow") {
        followTextElement.text("Unfollow");

        // Call a PHP script to handle database update using jQuery AJAX
        $.ajax({
            type: "POST",
            url: "../models/updateFollower.php",
            data: {
                action: "follow",
                loggedInUserID: loggedInUser,
                userIDToFollow: userToFollow
            },
            success: function(response) {
                console.log("Record added successfully");
            },
            error: function(error) {
                console.error("Error:", error);
            }
        });
    } else {
        followTextElement.text("Follow");

        // Call a PHP script to handle database update using jQuery AJAX
        $.ajax({
            type: "POST",
            url: "../models/updateFollower.php",
            data: {
                action: "unfollow",
                loggedInUserID: loggedInUserID,
                userIDToFollow: userIDToFollow
            },
            success: function(response) {
                console.log("Follower removed successfully");
            },
            error: function(error) {
                console.error("Error:", error);
            }
        });
    }
}
