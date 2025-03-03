<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account</title>
    <link rel="icon" type="image/svg" href="{{ asset('images/FAVICON_1.png') }}">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="{{ asset('scripts/login.js') }}" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<x-floating-alert :message="session('alert')" />
<!-- Display SweetAlert for validation errors -->
@if ($errors->any())
    <script>
        const errors = @json($errors->all());
        Swal.fire({
            title: 'Register error!',
            icon: 'error',
            html: '<ul>' + errors.map(error => '<li>' + error + '</li>').join('') + '</ul>',
            confirmButtonText: 'Okay'
        });
    </script>
@endif
<section>
    <div class="container">
        <div class="user signinBx">
            <div class="imgBx"><img src="images/IMPERIUM_ICON.png" alt="" /></div>
            <div class="formBx">
                <form id="loginForm" action="{{ route('login') }}" method="POST" onsubmit="return validateLoginForm()">
                @csrf
                    <h2>CLASSROOM AUTOMATION & MANAGEMENT SYSTEM</h2>
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
                    <a href="{{ url('/') }}" class="login-button d-lg-block">
                        <i class="fas fa-arrow-circle-left"></i>
                    </a>
                </form>
            </div>
        </div>

        <div class="user signupBx">
            <div class="formBx">
            <form action="{{ route('register.store') }}" method="POST" enctype="multipart/form-data" onsubmit="return validateSignupForm()">
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
        <input type="file" id="idPicture" name="id_picture" accept="image/*" required>
        <span class="error-message" id="idPictureError"></span>
    </div>
                    <div class="form-group">
                        <div class="g-recaptcha" data-sitekey="6LdSlMsqAAAAAOSck4VmalLxW2CpjG3vpmaC7SUe"></div>
                        <x-input-error :messages="$errors->get('recaptcha')" class="mt-2" />
                        <div id="recaptcha-warning" class="text-red-500 mt-2 hidden"></div>
                    </div>


                    <!-- Terms and Conditions Modal -->
<div id="termsModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Terms and Conditions</h2>
        <div id="termsText" class="terms-text" onscroll="enableCheckbox()">
            <p>Welcome to Imperium – Classroom Automation and Management System. By accessing and using this website, you agree to comply with and be bound by the following terms and conditions. If you do not agree to these terms, please do not proceed with the use of this website
                <br>
                <br>

1. Acceptance of Terms
By using our website and services, you acknowledge that you have read, understood, and agree to be bound by these terms and conditions, as well as any applicable laws and regulations.
<br>
<br>

2. Purpose of the System
Imperium – Classroom Automation and Management System is designed to streamline classroom management and improve operational efficiency through automation and authentication technologies. The system is intended for use by professors, school administrators, facility management staff, and security personnel.
<br>
<br>

3. User Responsibilities
<br>

● Users must provide accurate and truthful information when accessing the system.
<br>


● Users are responsible for maintaining the confidentiality of their login credentials.
<br>

● Unauthorized access, modification, or misuse of the system is strictly prohibited.
<br>

● Users must comply with all applicable university policies and regulations regarding classroom management and automation.
<br>
<br>

4. Data Collection and Privacy
<br>

● The system collects and stores data related to classroom access and appliance usage for tracking and validation purposes.
<br>

● Personal information will be handled in accordance with university data protection policies.
<br>

● Users agree to the collection and processing of their data for operational and security purposes.
<br>
<br>

<br>

5. System Availability and Limitations
<br>

● The system may experience downtime due to maintenance, technical issues, or unforeseen circumstances.
<br>

● The university is not liable for any data loss, disruptions, or system failures beyond its reasonable control.
<br>

● Features and functionalities may be updated, modified, or discontinued without prior notice.
<br>

<br>
<br>

6. Security and Access Control
<br>

● Access to classrooms and appliances is subject to RFID-based authentication.
<br>

● Any attempt to bypass security measures or gain unauthorized access will result in disciplinary action.
<br>

● Users must report any suspicious activity or security breaches immediately.
<br>

<br>

<br>

7. Limitation of Liability
<br>

● The university and its developers shall not be held liable for any direct, indirect, incidental, or consequential damages arising from the use or inability to use the system.
<br>

● The system is provided "as is" without any warranties, expressed or implied.
<br>

<br>
<br>

8. Modification of Terms
<br>

● The university reserves the right to update or modify these terms at any time. Users will be notified of any significant changes.
<br>

● Continued use of the system after modifications constitute acceptance of the revised terms.
<br>

<br>
<br>

9. Governing Law
<br>

● These terms and conditions shall be governed by and construed in accordance with the laws of the Republic of the Philippines and the policies of the University of Caloocan City.
<br>
<br>

10. Contact Information
<br>

For any concerns or inquiries regarding these terms and conditions, you may contact:
<br>

University of Caloocan City Biglang Awa St. corner 11th Ave Cattleya St, Caloocan CityTelephone Number: (02) 324.65.81 Computer Studies Department – BSIT Program
<br>

By proceeding to use this website, <br>
you acknowledge that you have read and understood these terms and conditions and agree to abide by them.</p>
            <p style="margin-top: 50px; text-align: center;">End of Terms and Conditions</p>
        </div>
        <button onclick="closeModal()">Close</button>
    </div>
</div>

<!-- Updated Checkbox and Button -->
<div class="form-group">
    <input type="checkbox" id="termsCheckbox" name="terms" disabled required onchange="toggleRegisterButton()">
    <label for="termsCheckbox" style="text-align:center;"> I agree to the <a href="#" onclick="openModal(); return false;">Terms and Conditions</a></label>
</div>


                    
<input type="submit" value="Register" class="btn" id="registerBtn" disabled title="You need to read the Terms and Conditions first." />
                    <p class="signup">
                            Already have an account ?
                            <a href="#" onclick="toggleForm();">Sign in.</a>
                        </p>
                </form>
            </div>
            <div class="imgBx"><img src="images/CSD.svg" alt="" /></div>
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