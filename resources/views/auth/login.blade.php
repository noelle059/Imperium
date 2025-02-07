<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login and Signup</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="{{ asset('scripts/login.js') }}" defer></script>
</head>
<body>
<section>
    <div class="container">
        <div class="user signinBx">
            <div class="imgBx"><img src="images/IMPERIUM_ICON.png" alt="" /></div>
            <div class="formBx">
                <form id="loginForm" action="" onsubmit="return validateLoginForm()">
                    <h2>CLASSROOM AUTOMATION & MANAGEMENT SYSTEM</h2>
                    <div class="form-group">
                        <input type="text" id="username" name="username" placeholder="Username" oninput="validateUsername(this)" required>
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
                        <a href="#" onclick="toggleForm();">Register Now.</a>
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

        <div class="user signupBx">
            <div class="formBx">
                <form action="{{ route('register') }}" method="POST" onsubmit="return validateSignupForm()">
                    @csrf
                    <h2>Create an account</h2>
                    <div class="form-group">
                        <input type="text" id="signupName" name="name" placeholder="First Name" oninput="validateSignupName(this)" required>
                             <span id="signupNameError" class="error-message"></span>
                    </div>
                    <div class="form-group">
                       <input type="text" id="signupLastName" name="last_name" placeholder="Last Name" oninput="validateSignupLastName(this)">
                            <span id="signupLastNameError" class="error-message"></span>
                            <span class="error-icon">&#9888;</span>
                    </div>
                    <div class="form-group">
                        <input type="email" id="signupEmail" name="email" placeholder="Email Address" oninput="validateSignupEmail(this)">
                            <span id="signupEmailError" class="error-message"></span>
                            <span class="error-icon">&#9888;</span>
                    </div>
                    <div class="form-group">
                        <input type="text" id="signupContactNumber" name="contact_number" placeholder="Contact Number" oninput="validateSignupContactNumber(this)" required>
                            <span id="signupContactNumberError" class="error-message"></span>
                    </div>
                    <div class="form-group">
                        <input type="password" id="signupPassword" name="password" placeholder="Password"  oninput="validateSignupPassword(this)">
                            <span id="signupPasswordError" class="error-message"></span>
                            <span class="error-icon">&#9888;</span>
                            <button id="toggleSignupPassword" type="button">
                                <i class="fas fa-eye" id="toggleSignupPasswordIcon"></i>
                            </button>
                    </div>
                    <div class="form-group">
                        <input type="password" id="signupConfirmPassword" name="password_confirmation" placeholder="Confirm Password" oninput="validateSignupConfirmPassword(this)">
                            <span id="signupConfirmPasswordError" class="error-message"></span>
                            <span class="error-icon">&#9888;</span>
                            <button id="toggleSignupConfirmPassword" type="button">
                                <i class="fas fa-eye" id="toggleSignupConfirmPasswordIcon"></i>
                            </button>
                    </div>
                    <div class="form-group">
                        <div class="g-recaptcha" data-sitekey="6LdSlMsqAAAAAOSck4VmalLxW2CpjG3vpmaC7SUe"></div>
                        <x-input-error :messages="$errors->get('recaptcha')" class="mt-2" />
                        <div id="recaptcha-warning" class="text-red-500 mt-2 hidden"></div>
                    </div>
                    <input type="submit" value="Register" class="btn" />
                    <p class="signup">
                            Already have an account ?
                            <a href="#" onclick="toggleForm();">Sign in.</a>
                        </p>
                </form>
            </div>
            <div class="imgBx"><img src="images/CSD.png" alt="" /></div>
        </div>
    </div>




</section>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script>
        function validateRecaptcha() {
            var response = grecaptcha.getResponse();
            var warning = document.getElementById('recaptcha-warning');

            if (response.length === 0) {
                warning.classList.remove('hidden'); // Show warning message
                return false; // Prevent form submission
            } else {
                warning.classList.add('hidden'); // Hide warning message
                return true; // Allow form submission
            }
        }
    </script>
</body>
</html>