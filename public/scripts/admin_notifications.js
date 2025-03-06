$(document).ready(function () {
    function fetchNotifications() {
        $.ajax({
            url: window.notificationsUrl, // Use the variable defined in Blade
            type: 'GET',
            success: function (notifications) {
                console.log("Fetched Notifications:", notifications);

                // Update the modal list
                $('#notificationList').empty();
                if (notifications.length > 0) {
                    notifications.forEach(function (notification) {
                        $('#notificationList').append(`
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                ${notification.message}
                                <button class="btn btn-sm btn-danger remove-notification" data-id="${notification.id}">
                                    <i class="bi bi-x"></i>
                                </button>
                            </li>
                        `);
                    });

                    // Update and show notification count
                    $('#notificationBadge').text(notifications.length).show();
                } else {
                    $('#notificationList').html('<li class="list-group-item">No new notifications.</li>');
                    $('#notificationBadge').hide();
                }
            },
            error: function (xhr) {
                console.error('Error fetching notifications:', xhr);
            }
        });
    }

    // Fetch notifications when the modal opens
    $('#notificationModal').on('show.bs.modal', fetchNotifications);

    // Mark all notifications as read (Soft Delete)
    $('#markAllAsRead').click(function () {
        $.ajax({
            url: window.markAllReadUrl, // Use the variable defined in Blade
            type: 'POST',
            data: { _token: window.csrfToken }, // Use the CSRF token variable
            success: function () {
                $('#notificationList').html('<li class="list-group-item">No new notifications.</li>');
                $('#notificationBadge').hide(); // Hide bell badge
            },
            error: function (xhr) {
                console.error('Error marking notifications as read:', xhr);
            }
        });
    });

    // Remove individual notification (Soft Delete)
    $(document).on('click', '.remove-notification', function () {
        let notificationId = $(this).data('id');
        let $notificationItem = $(this).closest('li');

        $.ajax({
            url: `${window.notificationsUrl}/${notificationId}`, // Use the variable defined in Blade
            type: 'DELETE',
            data: { _token: window.csrfToken }, // Use the CSRF token variable
            success: function () {
                $notificationItem.remove();
                let count = $('#notificationList li').length;
                if (count === 0) {
                    $('#notificationList').html('<li class="list-group-item">No new notifications.</li>');
                    $('#notificationBadge').hide();
                } else {
                    $('#notificationBadge').text(count);
                }
            },
            error: function (xhr) {
                console.error('Error removing notification:', xhr);
            }
        });
    });

    // Auto-fetch notifications every 15 seconds
    setInterval(fetchNotifications, 15000);

    // Fetch notifications immediately when page loads
    fetchNotifications();
});