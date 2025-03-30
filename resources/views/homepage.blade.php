<!DOCTYPE html>
<html lang="en">
@if (session('alert'))
    <x-floating-alert :message="session('alert')" />
@endif

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="icon" type="image/svg" href="{{ asset('images/FAVICON_1.png') }}">

    <!-- Local Stylesheets -->
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/about.css') }}">
    <link rel="stylesheet" href="{{ asset('css/feedback.css') }}">
    <link rel="stylesheet" href="{{ asset('css/insights.css') }}">
    <link rel="stylesheet" href="{{ asset('css/contact.css') }}">
    <link rel="stylesheet" href="{{ asset('css/mediaquery.css') }}">
    <link rel="stylesheet" href="{{ asset('css/newlogin.css') }}">

    <!-- Scripts -->
    <script src="{{ asset('scripts/login.js') }}" defer></script>
    <script src="{{ asset('scripts/landingpage.js') }}" defer></script>
    <script src="{{ asset('scripts/feedback.js') }}" defer></script>

    <!-- Stylesheets -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>

<body data-bs-spy="scroll" data-bs-target=".navbar" data-bs-offset="100">
    @include('class.navbar')
    @include('class.carousel', ['images' => $images])
    @include('class.about')
    @include('class.feedback')
    @include('class.feedbackModal')
    @include('class.insights')
    @include('class.contact')

    <!-- Login and Registration Modals -->
    @include('class.loginModal')
    @include('class.registerModal')

    <!-- Terms and Conditions Modal -->
    @include('class.termsModal')

    <!-- Error Handling Script -->
    <script>
    @if ($errors->any())
        document.addEventListener('DOMContentLoaded', function() {
            const errors = @json($errors->all());
            Swal.fire({
                title: 'Registration error!',
                icon: 'error',
                html: '<ul>' + errors.map(error => '<li>' + error + '</li>').join('') + '</ul>',
                confirmButtonText: 'Okay'
            });

            const modalId = errors.some(error => error.includes('password') || error.includes('email'))
                ? 'loginModal'
                : 'registerModal';

            new bootstrap.Modal(document.getElementById(modalId)).show();
        });
    @endif

    document.addEventListener('DOMContentLoaded', function () {
        var registerModal = document.getElementById('registerModal');

        registerModal.addEventListener('hidden.bs.modal', function () {
            document.body.classList.remove('modal-open');
            document.body.style.overflow = 'auto'; // Ensures scrolling is re-enabled
        });

        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('archived')) {
            Swal.fire({
                icon: 'error',
                title: 'Account Archived',
                text: 'Your account has been archived. Please contact the admin.',
                confirmButtonText: 'Okay'
            }).then(() => {
                // After SweetAlert is closed, clean up the URL by removing the query parameter
                const newUrl = window.location.href.split('?')[0];
                window.history.replaceState({}, document.title, newUrl);
            });
        }
    });

    </script>

    <!-- External Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</body>
</html>
