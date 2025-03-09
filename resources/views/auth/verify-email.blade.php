<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <link rel="icon" type="image/svg" href="{{ asset('images/FAVICON_1.png') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap">
    <!-- Include SweetAlert CSS and JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            margin-top: 20px;
            background-color: #f2f3f8;
            position: relative;
            min-height: 100vh;
            background-image: url("../../images/CLASSROOM_BACKGROUND.svg");
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            font-family: Poppins, sans-serif !important;
        }
        .card {
            background-image: linear-gradient(to bottom, #a7d1ab, #c5ebac, #80a184);
            border-radius: 10px !important;
            box-shadow: 0 1px 15px 1px rgba(52, 40, 104, 0.08);
            max-width: 500px;
            width: 100%;
            height: auto;
            padding: 20px;
            text-align: center;
        }
        .h2 {
            font-size: 30px !important;
            font-weight: 600 !important;
            text-transform: uppercase;
            letter-spacing: 2px !important;
            color: #555 !important;
        }
        .form-control {
            width: 100% !important;
            padding: 8px !important;
            background: #f5f5f5 !important;
            color: #333 !important;
            border-radius: 7px !important;
            font-size: 15px !important;
        }
        .btn-primary {
            width: 100% !important;
            background: #9ABA2F !important;
            color: #fff !important;
            font-size: 14px !important;
            font-weight: 500 !important;
            border-radius: 15px !important;
            border: none !important;
            padding: 10px 15px !important;
            cursor: pointer;
            transition: 0.5s !important;
        }
        .btn-primary:hover {
            background: #f5f5f5 !important;
            color: #809927 !important;
        }
        .login-button {
            display: block;
            margin-top: 10px;
            color: #555 !important;
            text-decoration: none !important;
            font-size: 15px !important;
        }
        .login-button:hover {
            text-decoration: underline !important;
            color: #fff !important;
        }
        .logout-btn {
            background: transparent;
            color: #555 !important;
            border: none;
            font-size: 15px;
            text-decoration: none;
            cursor: pointer;
            margin-top: 10px;
        }
        .logout-btn:hover {
            text-decoration: underline;
            color: #fff !important;
        }


        .login-button {
            color: #555 !important;
            text-decoration: none !important;
            font-size: 15px !important;
            font-weight: 400 !important;
        }

        .login-button:hover {
            text-decoration: underline !important;
            color: #f5f5f5 !important;
        }
    </style>
</head>
<body>
    <div class="card">
        <x-floating-alert :message="session('alert')" />
        <h2 class="h2">Email Verification</h2>
        <p>Thanks for signing up! Please verify your email by clicking the link sent to your email. If you didn’t receive it, click the button below to resend.</p>
        
        @if (session('status') == 'verification-link-sent')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Verification Link Sent',
                text: '{{ __("A new verification link has been sent to the email address you provided during registration.") }}',
                confirmButtonText: 'OK'
            });
        });
    </script>
@endif
        
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button class="btn-primary" type="submit">Resend Verification Email</button>
        </form>
        
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="logout-btn" type="submit">Log Out</button>
        </form>
    </div>
</body>
</html>