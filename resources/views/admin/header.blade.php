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
  </head>

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
                <!-- Navbar Header--><a href="{{ route('admin.dashboard') }}" class="navbar-brand">
                    <div class="brand-text brand-big visible text-uppercase">
                        <img src="/images/colored_logo_with_text.png" alt="logo image" style="width: 180px; height: auto;">
                    </div>
                    <div class="brand-text brand-sm">
                        <img src="/images/colored_logo.png" alt="logo image" style="width: 58px; height: auto;">
                    </div>
                </a>
                <!-- Sidebar Toggle Btn-->
                <button class="sidebar-toggle">
                    <i class="fa fa-long-arrow-left"></i>
                </button>
            </div>
            <div class="right-menu list-inline no-margin-bottom">
                <div class="list-inline-item">
                    <a href="#" class="search-open nav-link"><i class="icon-magnifying-glass-browser"></i></a>
                </div>
                <div class="list-inline-item dropdown">
                    <a id="navbarDropdownMenuLink1" href="http://example.com" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false" class="nav-link messages-toggle"><i
                            class="icon-email"></i><span class="badge" style="background-color: #47773f; color: white;" >5</span></a>
                    <div aria-labelledby="navbarDropdownMenuLink1" class="dropdown-menu messages">
                        <a href="#" class="dropdown-item message d-flex align-items-center">
                            <div class="profile">
                                <img src="/images/avatar-3.jpg" alt="..." class="img-fluid" />
                                <div class="status online"></div>
                            </div>
                            <div class="content">
                                <strong class="d-block">Nadia Halsey</strong><span class="d-block">lorem ipsum dolor sit
                                    amit</span><small class="date d-block">9:30am</small>
                            </div>
                        </a><a href="#" class="dropdown-item message d-flex align-items-center">
                            <div class="profile">
                                <img src="/images/avatar-2.jpg" alt="..." class="img-fluid" />
                                <div class="status away"></div>
                            </div>
                            <div class="content">
                                <strong class="d-block">Peter Ramsy</strong><span class="d-block">lorem ipsum dolor sit
                                    amit</span><small class="date d-block">7:40am</small>
                            </div>
                        </a><a href="#" class="dropdown-item message d-flex align-items-center">
                            <div class="profile">
                                <img src="/images/avatar-1.jpg" alt="..." class="img-fluid" />
                                <div class="status busy"></div>
                            </div>
                            <div class="content">
                                <strong class="d-block">Sam Kaheil</strong><span class="d-block">lorem ipsum dolor sit
                                    amit</span><small class="date d-block">6:55am</small>
                            </div>
                        </a><a href="#" class="dropdown-item message d-flex align-items-center">
                            <div class="profile">
                                <img src="/images/avatar-5.jpg" alt="..." class="img-fluid" />
                                <div class="status offline"></div>
                            </div>
                            <div class="content">
                                <strong class="d-block">Sara Wood</strong><span class="d-block">lorem ipsum dolor sit
                                    amit</span><small class="date d-block">10:30pm</small>
                            </div>
                        </a><a href="#" class="dropdown-item text-center message">
                            <strong>See All Messages <i class="fa fa-angle-right"></i></strong></a>
                    </div>
                </div>
                <!-- Tasks end-->
                
                
              
               
                <!-- Log out-->
                <div class="list-inline-item logout">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link">Logout <i class="icon-logout"></i></a>                </div>

            </div>
        </div>
    </nav>
</header>

    

<!-- SIDEBAR -->
 @include('admin.sidebar')