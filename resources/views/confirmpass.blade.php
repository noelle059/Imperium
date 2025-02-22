<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Password</title>
    <link rel="icon" type="image/svg" href="{{ asset('images/FAVICON_1.png') }}">
    <link rel="stylesheet" href="{{ asset('css/confirmpass.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="{{ asset('scripts/confirmpass.js') }}" defer></script>
</head>
<body>
    <div class="container h-100">
        <div class="row h-100">
            <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
                <div class="d-table-cell align-middle">
                    <div class="card mb-4">
                        <div class="text-center mt-4">
                            <h1 class="h2">Confirm Password</h1>
                            <p class="lead">
                                Please confirm your password to proceed.
                            </p>
                        </div>

                        <form id="confirmPasswordForm" action="{{ route('password.store') }}" method="POST">
    @csrf
    <input type="hidden" name="token" value="{{ $request->route('token') }}">
    <input type="hidden" name="email" value="{{ $request->email }}">

    <div class="form-group">
        <label>New Password</label>
        <div class="input-group">
            <input id="password" class="form-control form-control-lg password-field" type="password" name="password" placeholder="Enter your new password" oninput="validateEnterNewPassword(this)" required>
            <i class="fas fa-eye toggle-password" onclick="togglePassword('password', this)"></i>
        </div>
        <span id="signupPasswordError" class="error-message"></span>
    </div>

    <div class="form-group">
        <label>Confirm New Password</label>
        <div class="input-group">
            <input id="confirm-password" class="form-control form-control-lg password-field" type="password" name="password_confirmation" placeholder="Re-enter your new password" oninput="validateConfirmNewPassword(this)" required>
            <i class="fas fa-eye toggle-password" onclick="togglePassword('confirm-password', this)"></i>
        </div>
        <span id="signupConfirmPasswordError" class="error-message"></span>
    </div>

    <div class="text-center mt-3">
        <button type="submit" id="confirmPasswordBtn" class="btn btn-lg btn-primary">Confirm Password</button>
        <a href="{{ route('login') }}" class="login-button d-lg-block">Back to Login</a>
    </div>
</form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>