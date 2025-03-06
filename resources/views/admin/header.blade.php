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

    <!-- ICONS-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    {{-- SWEET ALERT --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.1/dist/sweetalert2.min.css">

</head>

<body>
    {{-- HEADER --}}
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
                            <img src="/images/colored_logo_with_text.png" alt="logo image"
                                style="width: 180px; height: auto;">
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
                    <button class="btn btn-light me-2 position-relative" type="button" data-bs-toggle="modal"
                        data-bs-target="#notificationModal">
                        <i class="fas fa-bell" style="font-size: 20px; color: #47773f;"></i>
                        <span id="notificationBadge"
                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                            style="display: none;">
                            0
                        </span>
                    </button>

                    <!-- Log out-->
                    <div class="list-inline-item logout">
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        <a href="#"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            class="nav-link">Logout <i class="icon-logout"></i></a>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- Notification Modal -->
    <div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="notificationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="notificationModalLabel">Notifications</h5>
                </div>
                <div class="modal-body">
                    <ul class="list-group" id="notificationList">
                        <li class="list-group-item">Loading notifications...</li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm gradient-button mb-2" id="markAllAsRead">Mark All as Read</button>
                    <button type="button" class="gradient-button" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- SIDEBAR -->
    @include('admin.sidebar')
