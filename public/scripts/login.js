const toggleForm = () => {
  const container = document.querySelector('.container');
  container.classList.toggle('active');
};

function validateUsername(input) {
  const username = input.value;
  const errorSpan = document.getElementById('usernameError');

  if (username === '') {
      errorSpan.textContent = "Username is required.";
      errorSpan.style.display = 'block';
      input.classList.add('invalid');
      return false;
  } else {
      errorSpan.textContent = "";
      errorSpan.style.display = 'none';
      input.classList.remove('invalid');
      return true;
  }
}

function validatePassword(input) {
  const password = input.value;
  const errorSpan = document.getElementById('passwordError');

  const specialCharRegex = /[!@#$%^&*()_+\-=\[\]{};':",\\|,.<>\/?]/;

  if (password.length < 8 || !specialCharRegex.test(password)) {
    errorSpan.textContent = "Password must be at least 8 characters long and contain at least one special character."; 
    errorSpan.style.display = 'block';
    input.classList.add('invalid');
    return false;
  } else {
    errorSpan.textContent = "";
    errorSpan.style.display = 'none';
    input.classList.remove('invalid');
    return true;
  }
}

function validateLoginForm() {
  let isValid = true;
  isValid = validateUsername(document.getElementById('username')) && isValid;
  isValid = validatePassword(document.getElementById('password')) && isValid;
  return isValid;
}


function continueWithGoogle() {
  console.log("Continue with Google button clicked!");
}

function validateSignupUsername(input) {
  const username = input.value;
  const errorSpan = document.getElementById('signupUsernameError');

  if (username === '') {
      errorSpan.textContent = "Username is required.";
      errorSpan.style.display = 'block';
      input.classList.add('invalid');
      return false;
  } else {
      errorSpan.textContent = "";
      errorSpan.style.display = 'none';
      input.classList.remove('invalid');
      return true;
  }
}

function validateSignupEmail(input) {
  const email = input.value;
  const errorSpan = document.getElementById('signupEmailError');
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

  if (email === '') {
      errorSpan.textContent = "Email is required.";
      errorSpan.style.display = 'block';
      input.classList.add('invalid');
      return false;
  } else if (!emailRegex.test(email)) {
      errorSpan.textContent = "Invalid email format.";
      errorSpan.style.display = 'block';
      input.classList.add('invalid');
      return false;
  } else {
      errorSpan.textContent = "";
      errorSpan.style.display = 'none';
      input.classList.remove('invalid');
      return true;
  }
}

function validateSignupPassword(input) {
  const password = input.value;
  const errorSpan = document.getElementById('signupPasswordError');

  const specialCharRegex = /[!@#$%^&*()_+\-=\[\]{};':",\\|,.<>\/?]/;

  if (password.length < 8 || !specialCharRegex.test(password)) {
    errorSpan.textContent = "Password must be at least 8 characters long and contain at least one special character."; 
    errorSpan.style.display = 'block';
    input.classList.add('invalid');
    return false;
  } else {
    errorSpan.textContent = "";
    errorSpan.style.display = 'none';
    input.classList.remove('invalid');
    return true;
  }
}

function validateSignupConfirmPassword(input) {
  const confirmPassword = input.value;
  const password = document.getElementById('signupPassword').value; 
  const errorSpan = document.getElementById('signupConfirmPasswordError');

  if (confirmPassword !== password) {
    errorSpan.textContent = "Passwords do not match.";
    errorSpan.style.display = 'block';
    input.classList.add('invalid');
    return false;
  } else {
    errorSpan.textContent = "";
    errorSpan.style.display = 'none';
    input.classList.remove('invalid');
    return true;
  }
}


// HIDE AND SHOW BUTTON ICON FOR LOG IN
const passwordInput = document.getElementById('password');
  const togglePasswordButton = document.getElementById('togglePassword');
  const toggleIcon = document.getElementById('toggleIcon'); 

  togglePasswordButton.addEventListener('click', function() {
    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordInput.setAttribute('type', type);

  
    if (type === 'password') {
      toggleIcon.classList.remove('fa-eye-slash');
      toggleIcon.classList.add('fa-eye');
    } else {
      toggleIcon.classList.remove('fa-eye');
      toggleIcon.classList.add('fa-eye-slash');
    }
  });


  // HIDE AND SHOW BUTTON ICON FOR REGISTER
  const signupPasswordInput = document.getElementById('signupPassword');
  const toggleSignupPasswordButton = document.getElementById('toggleSignupPassword');
  const toggleSignupPasswordIcon = document.getElementById('toggleSignupPasswordIcon');

  toggleSignupPasswordButton.addEventListener('click', function() {
    const type = signupPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    signupPasswordInput.setAttribute('type', type);

    if (type === 'password') {
      toggleSignupPasswordIcon.classList.remove('fa-eye-slash');
      toggleSignupPasswordIcon.classList.add('fa-eye');
    } else {
      toggleSignupPasswordIcon.classList.remove('fa-eye');
      toggleSignupPasswordIcon.classList.add('fa-eye-slash');
    }
  });


  const signupConfirmPasswordInput = document.getElementById('signupConfirmPassword');
  const toggleSignupConfirmPasswordButton = document.getElementById('toggleSignupConfirmPassword');
  const toggleSignupConfirmPasswordIcon = document.getElementById('toggleSignupConfirmPasswordIcon');

  toggleSignupConfirmPasswordButton.addEventListener('click', function() {
    const type = signupConfirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    signupConfirmPasswordInput.setAttribute('type', type);

    if (type === 'password') {
      toggleSignupConfirmPasswordIcon.classList.remove('fa-eye-slash');
      toggleSignupConfirmPasswordIcon.classList.add('fa-eye');
    } else {
      toggleSignupConfirmPasswordIcon.classList.remove('fa-eye');
      toggleSignupConfirmPasswordIcon.classList.add('fa-eye-slash');
    }
  });