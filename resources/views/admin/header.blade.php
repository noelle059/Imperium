<!DOCTYPE html>
<!--HEADER- SIDEBAR - NAVIGATION -->

<head> 
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Imperium Admin</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="/vendor/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="/vendor/font-awesome/css/font-awesome.min.css">
    <!-- Custom Font Icons CSS-->
    <link rel="stylesheet" href="/css/font.css">
    <!-- Google fonts - Muli-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Muli:300,400,700">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="/css/style.default.css" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="/css/custom.css">
    <!-- Favicon-->
    <link rel="shortcut icon" href="/images/circle_favicon.png">
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->

    <!-- ICONS-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<<<<<<< HEAD
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">





  </head>
=======
    <style>
        /* Green modal background */
.modal-content {
    background-color: #28a745 !important; /* Bootstrap success green */
    color: black; /* White text for contrast */
    border-radius: 8px;
}

/* Green modal header */
.modal-header {
    background-color: #218838 !important; /* Darker green */
    color: white;
    border-bottom: none;
}

/* Green header */
.header {
    background-color: #28a745 !important;
    color: white;
}

/* Style the close button */
.modal-header .btn-close {
    filter: invert(1); /* Makes it white */
}

/* Green modal footer */
.modal-footer {
    background-color: #218838 !important;
    border-top: none;
}

#markAllAsRead {
    background-color: #28a745; /* Green */
    border-color: #218838;
    color: white;
}

#markAllAsRead:hover {
    background-color:red; /* Darker Green on Hover */
    border-color: #1e7e34;
}

    </style>
</head>
>>>>>>> eaad63c65b8375c45c673ebc77921d6623c96b8a

<body>
<header class="header">
    <nav class="navbar navbar-expand-lg">
        <div class="search-panel">
            <div class="search-inner d-flex align-items-center justify-content-center">
                <div class="close-btn">Close <i class="fa fa-close"></i></div>
                <form id="searchForm" action="#">
                    <div class="form-group">
                        <input type="search" name="search" placeholder="What are you searching for..." />
                        <button type="submit" class="submit">Search</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="container-fluid d-flex align-items-center justify-content-between">
            <div class="navbar-header">
                <a href="{{ route('admin.dashboard') }}" class="navbar-brand">
                    <div class="brand-text brand-big visible text-uppercase">
                        <img src="/images/colored_logo_with_text.png" alt="logo image" style="width: 180px; height: auto;">
                    </div>
                    <div class="brand-text brand-sm">
                        <img src="/images/colored_logo.png" alt="logo image" style="width: 58px; height: auto;">
                    </div>
                </a>
                <button class="sidebar-toggle">
                    <i class="fa fa-long-arrow-left"></i>
                </button>
            </div>
            <div class="right-menu list-inline no-margin-bottom">
                <!-- Notification Toggle Btn-->
                <button class="btn btn-light me-2 position-relative" type="button" data-bs-toggle="modal" data-bs-target="#notificationModal">
                    <i class="fas fa-bell" style="font-size: 20px;"></i>
                    <span id="notificationBadge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="display: none;">
                        0
                    </span>
                </button>

                <!-- Log out-->
                <div class="list-inline-item logout">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link">Logout <i class="icon-logout"></i></a>
                </div>
            </div>
        </div>
    </nav>
</header>

<!-- Notification Modal -->
<div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="notificationModalLabel" aria-hidden="true">
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

<!-- SIDEBAR -->
@include('admin.sidebar')

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap JS -->
<script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
   $(document).ready(function () {
    function fetchNotifications() {
        $.ajax({
            url: '{{ route("notifications.index") }}', // This will call the index method in your NotificationController
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
                                    <i class="bi bi-x">X</i>
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
            url: '{{ route("notifications.markAllRead") }}',
            type: 'POST',
            data: { _token: '{{ csrf_token() }}' },
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
            url: '{{ route("notifications.destroy", "") }}/' + notificationId,
            type: 'DELETE',
            data: { _token: '{{ csrf_token() }}' },
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
    setInterval(fetchNotifications, 1000);

    // Fetch notifications immediately when page loads
    fetchNotifications();
});
</script>
</body>