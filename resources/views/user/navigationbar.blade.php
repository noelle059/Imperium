<!-- Navbar -->
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container">
        <a class="navbar-brand" href="{{ route('user.dashboard') }}"> <img src="/images/colored_logo_with_text.png"
                alt="logo image" style="width: 125px; height: auto;">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>



        {{-- Notification --}}
        {{-- <button class="btn btn-light me-2 position-relative" type="button" data-bs-toggle="modal"
            data-bs-target="#notificationModal">
            <i class="bi bi-bell"></i>
            <span id="notificationBadge"
                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                style="display: none;">
                0
            </span>
        </button> --}}

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 text-end">



                <li class="nav-item dropdown">

                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu">

                        <li><a class="dropdown-item" href="{{ route('user.dashboard') }}">Dashboard</a></li>
                        <hr class="dropdown-divider">
                        <li><a class="dropdown-item" href="{{ route('AccountProfile') }}">Account Profile</a></li>
                        <hr class="dropdown-divider">
                        <li><a class="dropdown-item" href="{{ route('AccountHistory') }}">Login History</a></li>
                        <hr class="dropdown-divider">
                        <li>
                            <form method="POST" action="{{ route('logout') }}" class="m-0">
                                @csrf
                                <button type="submit" class="dropdown-item"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>
    </div>


    <!-- Notification Modal -->
    <div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="notificationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="notificationModalLabel">Notifications</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="list-group" id="notificationList">
                        <li class="list-group-item">Loading notifications...</li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-primary mb-2" id="markAllAsRead">Mark All as Read</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


</nav>



<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        function fetchNotifications() {
            $.ajax({
                url: '{{ route('notifications.index') }}', // This will call the index method in your NotificationController
                type: 'GET',
                success: function(notifications) {
                    console.log("Fetched Notifications:", notifications);

                    // Update the modal list
                    $('#notificationList').empty();
                    if (notifications.length > 0) {
                        notifications.forEach(function(notification) {
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
                        $('#notificationList').html(
                            '<li class="list-group-item">No new notifications.</li>');
                        $('#notificationBadge').hide();
                    }
                },
                error: function(xhr) {
                    console.error('Error fetching notifications:', xhr);
                }
            });
        }

        // Fetch notifications when the modal opens
        $('#notificationModal').on('show.bs.modal', fetchNotifications);

        // Mark all notifications as read (Soft Delete)
        $('#markAllAsRead').click(function() {
            $.ajax({
                url: '{{ route('notifications.markAllRead') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function() {
                    $('#notificationList').html(
                        '<li class="list-group-item">No new notifications.</li>');
                    $('#notificationBadge').hide(); // Hide bell badge
                },
                error: function(xhr) {
                    console.error('Error marking notifications as read:', xhr);
                }
            });
        });

        // Remove individual notification (Soft Delete)
        $(document).on('click', '.remove-notification', function() {
            let notificationId = $(this).data('id');
            let $notificationItem = $(this).closest('li');

            $.ajax({
                url: '{{ route('notifications.destroy', '') }}/' + notificationId,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function() {
                    $notificationItem.remove();
                    let count = $('#notificationList li').length;
                    if (count === 0) {
                        $('#notificationList').html(
                            '<li class="list-group-item">No new notifications.</li>');
                        $('#notificationBadge').hide();
                    } else {
                        $('#notificationBadge').text(count);
                    }
                },
                error: function(xhr) {
                    console.error('Error removing notification:', xhr);
                }
            });
        });

        // Auto-fetch notifications every 15 seconds
        setInterval(fetchNotifications, 15000);

        // Fetch notifications immediately when page loads
        fetchNotifications();
    });
</script>
