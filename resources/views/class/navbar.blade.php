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
                    <li class="nav-item"><a class="nav-link active mx-lg-2" href="#carouselExampleIndicators">Home</a></li>
                    <li class="nav-item"><a class="nav-link mx-lg-2" href="#about">About</a></li>
                    <li class="nav-item"><a class="nav-link mx-lg-2" href="#feedback">Feedback</a></li>
                    <li class="nav-item"><a class="nav-link mx-lg-2" href="#insights">Insights</a></li>
                    <li class="nav-item"><a class="nav-link mx-lg-2" href="#contact">Contact</a></li>
                    <li class="nav-item d-lg-none">
                        <button type="button" class="login-button" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
                        <button type="button" class="register-button" data-bs-toggle="modal" data-bs-target="#registerModal">Register</button>
                    </li>
                </ul>
            </div>
        </div>
        <div class="d-flex gap-2">
            <button type="button" class="login-button d-none d-lg-block" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
            <button type="button" class="register-button d-none d-lg-block" data-bs-toggle="modal" data-bs-target="#registerModal">Register</button>
        </div>

            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
    </div>
</nav>
