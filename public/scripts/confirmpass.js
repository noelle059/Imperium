// Function to toggle password visibility
function togglePassword(inputId, icon) {
    let input = document.getElementById(inputId);

    if (input.type === "password") {
        input.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash"); 
    } else {
        input.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye"); 
    }
}

// VALIDATION SA NEW PASS
function validateEnterNewPassword(input) {
    const password = input.value;
    const errorSpan = document.getElementById('signupPasswordError');
    const confirmPasswordInput = document.getElementById('confirm-password');

    const specialCharRegex = /[!@#$%^&*()_+\-=\[\]{};':",\\|,.<>\/?]/;

    if (password.length < 8 || !specialCharRegex.test(password)) {
        errorSpan.textContent = "Password must be at least 8 characters long and contain at least one special character."; 
        errorSpan.style.display = 'block';
        input.classList.add('invalid');
    } else {
        errorSpan.textContent = "";
        errorSpan.style.display = 'none';
        input.classList.remove('invalid');
    }

    if (confirmPasswordInput.value !== "") {
        validateConfirmNewPassword(confirmPasswordInput);
    }

    updateConfirmPasswordButtonState();
}

// VALIDATION PAG NA CONFIRN NEW PASS PO
function validateConfirmNewPassword(input) {
    const confirmPassword = input.value;
    const password = document.getElementById('password').value;
    const errorSpan = document.getElementById('signupConfirmPasswordError');

    if (confirmPassword !== password || confirmPassword === "") {
        errorSpan.textContent = "Passwords do not match.";
        errorSpan.style.display = 'block';
        input.classList.add('invalid');
    } else {
        errorSpan.textContent = "";
        errorSpan.style.display = 'none';
        input.classList.remove('invalid');
    }

    updateConfirmPasswordButtonState();
}

// MAG DISABLED SI BUTTON KAPAG MALI YUNG INPUTS SIR
function updateConfirmPasswordButtonState() {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm-password').value;
    const passwordError = document.getElementById('signupPasswordError').textContent;
    const confirmPasswordError = document.getElementById('signupConfirmPasswordError').textContent;
    const button = document.getElementById('confirmPasswordBtn');

    if (password !== "" && confirmPassword !== "" && passwordError === "" && confirmPasswordError === "") {
        button.removeAttribute("disabled");
    } else {
        button.setAttribute("disabled", "true");
    }
}
