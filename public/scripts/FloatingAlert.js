// public/scripts/floatingAlert.js

function showFloatingAlert() {
    document.addEventListener('DOMContentLoaded', function() {
        // Check if the alert exists and has content
        var alert = document.getElementById('floating-alert');
        if (alert && alert.innerHTML.trim() !== '') {
            alert.classList.add('show'); // Add the show class to display it
            // Hide it after 5 seconds
            setTimeout(function() {
                alert.classList.remove('show'); // Remove the show class after 5 seconds
            }, 5000); // Set to 5000 milliseconds (5 seconds)
        }
    });
}

// Call the function to show the alert
showFloatingAlert();