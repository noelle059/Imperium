<div class="modal fade" id="loginModal" data-bs-backdrop="false" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="registerModalLabel">CLASSROOM AUTOMATION & MANAGEMENT SYSTEM</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="loginForm" action="{{ route('login') }}" method="POST" onsubmit="return validateLoginForm()">
            @csrf

            <div class="form-group">
                <input type="text" id="email" name="email" placeholder="Email" oninput="validateUsername(this)" required>
                <span id="usernameError" class="error-message"></span>
                <span class="error-icon">&#9888;</span>
            </div>
            <div class="form-group">
                <input type="password" id="password" name="password" placeholder="Password" oninput="validatePassword(this)" required>
                <span id="passwordError" class="error-message"></span>
                <span class="error-icon">&#9888;</span>
                <button id="togglePassword" type="button">
                <i class="fas fa-eye" id="toggleIcon"></i>
                </button>
            </div>
            <input type="submit" id="loginBtn" value="Login" />
            <div>
                <a href="{{ url('auth/google') }}" class="google-btn">Login using Google</a>
            </div>
            <p class="signup">
                Don't have an account?
                <a href="#" data-bs-toggle="modal" data-bs-target="#registerModal" data-bs-dismiss="modal">Register Now.</a>
            </p>
            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                <div class="forgot-password">
                    <a href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                    </a>
                </div>
                @endif
            </div>
            </form>
        </div>
        </div>
    </div>
    </div>
