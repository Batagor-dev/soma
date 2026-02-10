/**
 * Register Page JavaScript
 * Handles password visibility toggle and strength indicator
 */

/**
 * Toggle password visibility
 * @param {string} inputId - ID of the password input field
 * @param {string} iconId - ID of the toggle icon
 */
function togglePassword(inputId, iconId) {
    const passwordInput = document.getElementById(inputId);
    const toggleIcon = document.getElementById(iconId);

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        toggleIcon.classList.remove("bi-eye-slash-fill");
        toggleIcon.classList.add("bi-eye-fill");
    } else {
        passwordInput.type = "password";
        toggleIcon.classList.remove("bi-eye-fill");
        toggleIcon.classList.add("bi-eye-slash-fill");
    }
}

/**
 * Check password strength and update visual indicator
 */
function checkPasswordStrength() {
    const password = document.getElementById("password").value;
    const strengthBar = document.getElementById("passwordStrengthBar");
    const strengthContainer = document.getElementById("passwordStrength");

    // Hide strength indicator if password is empty
    if (password.length === 0) {
        strengthContainer.classList.remove("show");
        return;
    }

    // Show strength indicator
    strengthContainer.classList.add("show");

    let strength = 0;

    // Check length
    if (password.length >= 8) strength++;
    if (password.length >= 12) strength++;

    // Check for numbers
    if (/\d/.test(password)) strength++;

    // Check for special characters
    if (/[!@#$%^&*(),.?":{}|<>]/.test(password)) strength++;

    // Check for uppercase and lowercase
    if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;

    // Update strength bar
    strengthBar.className = "password-strength-bar";

    if (strength <= 2) {
        strengthBar.classList.add("weak");
    } else if (strength <= 4) {
        strengthBar.classList.add("medium");
    } else {
        strengthBar.classList.add("strong");
    }
}
