<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand me-auto" href="#">IMPERIUM</a>
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasNavbarLabel">IMPERIUM</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav justify-content-center flex-grow-1 pe-3">
                    <li class="nav-item"><a class="nav-link active mx-lg-2" href="#">Home</a></li>
                    <li class="nav-item"><a class="nav-link mx-lg-2" href="#">About</a></li>
                    <li class="nav-item"><a class="nav-link mx-lg-2" href="#">FAQ</a></li>
                    <li class="nav-item"><a class="nav-link mx-lg-2" href="#">Contact</a></li>
                    <li class="nav-item"><a class="nav-link mx-lg-2" href="#">Insights</a></li>
                    <li class="nav-item d-lg-none">
                        <a href="{{ route('login') }}" class="login-button">Login</a>
                    </li>
                </ul>
            </div>
        </div>
        <a href="{{ route('login') }}" class="login-button d-none d-lg-block">Login</a>  
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
</nav>