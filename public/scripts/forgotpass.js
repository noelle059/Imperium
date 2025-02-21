document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("emailForm");
    const emailInput = document.getElementById("email");

    form.addEventListener("submit", function (event) {
        if (!emailInput.value.trim() || !emailInput.checkValidity()) {
            emailInput.classList.add("is-invalid");
            emailInput.classList.remove("is-valid");
            event.preventDefault(); // Stop form submission
            event.stopPropagation();
        } else {
            emailInput.classList.remove("is-invalid");
            emailInput.classList.add("is-valid"); // Optional: Green border if valid
        }
    });

    // Remove validation error when typing or clearing input
    emailInput.addEventListener("input", function () {
        if (emailInput.value.trim() === "") {
            emailInput.classList.remove("is-invalid", "is-valid"); // Remove both classes when empty
        } else if (emailInput.checkValidity()) {
            emailInput.classList.remove("is-invalid");
            emailInput.classList.add("is-valid");
        } else {
            emailInput.classList.remove("is-valid");
            emailInput.classList.add("is-invalid");
        }
    });
});
