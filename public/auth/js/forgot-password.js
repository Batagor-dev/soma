/**
 * Forgot Password Page JavaScript
 * Handles form validation and user feedback
 */

document.addEventListener("DOMContentLoaded", function () {
    /**
     * Email input validation
     */
    const emailInput = document.getElementById("email");

    if (emailInput) {
        emailInput.addEventListener("input", function () {
            validateEmail(this);
        });

        emailInput.addEventListener("blur", function () {
            validateEmail(this);
        });
    }

    /**
     * Form submission handler
     */
    const forgotPasswordForm = document.querySelector("form");

    if (forgotPasswordForm) {
        forgotPasswordForm.addEventListener("submit", function (e) {
            const emailInput = document.getElementById("email");

            if (!validateEmail(emailInput)) {
                e.preventDefault();
                emailInput.focus();
            }
        });
    }

    /**
     * Auto dismiss alerts after 5 seconds
     */
    const alerts = document.querySelectorAll(".alert-custom");
    alerts.forEach(function (alert) {
        setTimeout(function () {
            fadeOutAlert(alert);
        }, 5000);
    });
});

/**
 * Validate email format
 * @param {HTMLElement} input - Email input element
 * @returns {boolean} - Validation result
 */
function validateEmail(input) {
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const isValid = emailPattern.test(input.value);

    if (input.value.length > 0 && !isValid) {
        input.classList.add("is-invalid");

        // Add custom error message if not exists
        if (!input.parentElement.querySelector(".invalid-feedback-custom")) {
            const errorDiv = document.createElement("div");
            errorDiv.className = "invalid-feedback-custom";
            errorDiv.innerHTML = `
                <span class="error-label">Error:</span>
                <span class="error-message">Format email tidak valid</span>
            `;
            input.parentElement.appendChild(errorDiv);
        }

        return false;
    } else {
        input.classList.remove("is-invalid");

        // Remove custom error message if exists
        const errorDiv = input.parentElement.querySelector(
            ".invalid-feedback-custom"
        );
        if (errorDiv && !input.classList.contains("is-invalid")) {
            errorDiv.remove();
        }

        return true;
    }
}

/**
 * Fade out alert element
 * @param {HTMLElement} alert - Alert element to fade out
 */
function fadeOutAlert(alert) {
    alert.style.transition = "opacity 0.5s ease";
    alert.style.opacity = "0";

    setTimeout(function () {
        alert.remove();
    }, 500);
}
