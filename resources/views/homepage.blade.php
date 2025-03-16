<x-floating-alert :message="session('alert')" />
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="icon" type="image/svg" href="{{ asset('images/FAVICON_1.png') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/about.css') }}">
    <link rel="stylesheet" href="{{ asset('css/feedback.css') }}">
    <link rel="stylesheet" href="{{ asset('css/insights.css') }}">
    <link rel="stylesheet" href="{{ asset('css/contact.css') }}">
    <link rel="stylesheet" href="{{ asset('css/mediaquery.css') }}">
    <!-- <link rel="stylesheet" href="{{ asset('css/login.css') }}"> -->
    <link rel="stylesheet" href="{{ asset('css/newlogin.css') }}">
    <script src="{{ asset('scripts/login.js') }}" defer></script>
    <script src="{{ asset('scripts/landingpage.js') }}" defer></script>
    <script src="{{ asset('scripts/feedback.js') }}" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!--ABOUT-->
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.4/components/abouts/about-2/assets/css/about-2.css">
    <!--ABOUT-->

    <!--FEEDBACK-->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!--FEEDBACK-->

    <!-- FOOTER -->
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css'>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css'>
    <link href='//netdna.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css' rel='stylesheet' />
    <!-- FOOTER -->
</head>

<body data-bs-spy="scroll" data-bs-target=".navbar" data-bs-offset="100">

    @include('class.navbar')
    @include('class.carousel', ['images' => $images])
    @include('class.about')
    @include('class.feedback')
    @include('class.feedbackModal')
    @include('class.insights')
    @include('class.contact')

    <!-- Login Modal -->
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

    <!-- Registration Modal -->
    <div class="modal fade" id="registerModal" data-bs-backdrop="false" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-s">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="registerModalLabel">Create an account</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <!-- Registration form copied from your login.blade.php -->
            <form action="{{ route('register.store') }}" method="POST" enctype="multipart/form-data" onsubmit="return validateSignupForm()">
            @csrf
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
                <input type="password" id="signupPassword" name="password" placeholder="Password" oninput="validateSignupPassword(this)">
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
            <div class="form-group">
                <input  class="checkbox" type="checkbox" id="termsCheckbox" name="terms" disabled required onchange="toggleRegisterButton()">
                <label for="termsCheckbox" style="text-align:center;"> I agree to the <a href="#" onclick="openModal(); return false;">Terms and Conditions</a></label>
            </div                     >
            <input type="submit" value="Register" class="btn" id="registerBtn" disabled title="You need to read the Terms and Conditions first." />
            <p class="signup">
                Already have an account?
                <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal" data-bs-dismiss="modal">Sign in.</a>
            </p>
            </form>
        </div>
        </div>
    </div>
    </div>

    <!-- Terms and Conditions Modal -->
    <div id="termsModal" class="modal">
    <div class="modal-terms">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Terms and Conditions</h2>
        <div id="termsText" class="terms-text" onscroll="enableCheckbox()">
        <!-- Terms content from your existing page -->
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

        // If there are errors, show the appropriate modal
        if (errors.some(error => error.includes('password') || error.includes('email'))) {
            var loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
            loginModal.show();
        } else {
            var registerModal = new bootstrap.Modal(document.getElementById('registerModal'));
            registerModal.show();
        }
        });
    @endif

    // Add modal specific functions
    function openModal() {
        document.getElementById('termsModal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('termsModal').style.display = 'none';
    }

    function enableCheckbox() {
        var termsText = document.getElementById('termsText');
        var checkbox = document.getElementById('termsCheckbox');

        if (termsText.scrollTop + termsText.clientHeight >= termsText.scrollHeight - 5) {
        checkbox.disabled = false;
        }
    }

    function toggleRegisterButton() {
        var checkbox = document.getElementById('termsCheckbox');
        var registerBtn = document.getElementById('registerBtn');

        registerBtn.disabled = !checkbox.checked;
    }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</body>

</html>
