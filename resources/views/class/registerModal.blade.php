<div class="modal fade" id="registerModal" data-bs-backdrop="false" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="registerModalLabel">Create an account</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
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
