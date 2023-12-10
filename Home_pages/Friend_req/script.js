$(document).ready(function() {
    // Add friend button click event
    $('.addFriendBtn').on('click', function() {
        var userId = $(this).closest('.user').data('userid');

        // Send friend request via AJAX
        $.ajax({
            type: 'POST',
            url: 'send_friend_request.php',
            data: { userId: userId },
            success: function(response) {
                alert(response); // Display success or error message
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });
});
