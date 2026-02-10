// ================================================
// RESET PASSWORD - JavaScript Functions
// ================================================

// Toggle Password Visibility
function togglePassword(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);

    if (input.type === "password") {
        input.type = "text";
        icon.classList.remove("bi-eye-slash-fill");
        icon.classList.add("bi-eye-fill");
    } else {
        input.type = "password";
        icon.classList.remove("bi-eye-fill");
        icon.classList.add("bi-eye-slash-fill");
    }
}

// Check Password Strength
function checkPasswordStrength() {
    const password = document.getElementById("password").value;
    const strengthBar = document.getElementById("passwordStrengthBar");
    const strengthText = document.getElementById("passwordStrengthText");
    const strengthContainer = document.getElementById("passwordStrength");

    // Requirements elements
    const reqLength = document.getElementById("req-length");
    const reqUppercase = document.getElementById("req-uppercase");
    const reqLowercase = document.getElementById("req-lowercase");
    const reqNumber = document.getElementById("req-number");

    if (password.length === 0) {
        strengthContainer.classList.remove("show");
        strengthText.classList.remove("show");

        // Reset all requirements
        reqLength.classList.remove("valid");
        reqUppercase.classList.remove("valid");
        reqLowercase.classList.remove("valid");
        reqNumber.classList.remove("valid");

        return;
    }

    strengthContainer.classList.add("show");
    strengthText.classList.add("show");

    let strength = 0;

    // Check length
    if (password.length >= 8) {
        strength++;
        reqLength.classList.add("valid");
    } else {
        reqLength.classList.remove("valid");
    }

    // Check uppercase
    if (/[A-Z]/.test(password)) {
        strength++;
        reqUppercase.classList.add("valid");
    } else {
        reqUppercase.classList.remove("valid");
    }

    // Check lowercase
    if (/[a-z]/.test(password)) {
        strength++;
        reqLowercase.classList.add("valid");
    } else {
        reqLowercase.classList.remove("valid");
    }

    // Check number
    if (/[0-9]/.test(password)) {
        strength++;
        reqNumber.classList.add("valid");
    } else {
        reqNumber.classList.remove("valid");
    }

    // Update strength bar and text
    strengthBar.classList.remove("weak", "medium", "strong");
    strengthText.classList.remove("weak", "medium", "strong");

    if (strength <= 2) {
        strengthBar.classList.add("weak");
        strengthText.classList.add("weak");
        strengthText.textContent = "Password lemah";
    } else if (strength === 3) {
        strengthBar.classList.add("medium");
        strengthText.classList.add("medium");
        strengthText.textContent = "Password sedang";
    } else {
        strengthBar.classList.add("strong");
        strengthText.classList.add("strong");
        strengthText.textContent = "Password kuat";
    }

    // Check match if confirmation field has value
    checkPasswordMatch();
}

// Check Password Match
function checkPasswordMatch() {
    const password = document.getElementById("password").value;
    const confirmation = document.getElementById("password_confirmation").value;
    const matchElement = document.getElementById("passwordMatch");

    if (confirmation.length === 0) {
        matchElement.classList.remove("show");
        return;
    }

    matchElement.classList.add("show");
    matchElement.classList.remove("match", "no-match");

    if (password === confirmation) {
        matchElement.classList.add("match");
        matchElement.innerHTML =
            '<i class="bi bi-check-circle-fill"></i> Password cocok';
    } else {
        matchElement.classList.add("no-match");
        matchElement.innerHTML =
            '<i class="bi bi-x-circle-fill"></i> Password tidak cocok';
    }
}

// Auto-dismiss alerts after 5 seconds
document.addEventListener("DOMContentLoaded", function () {
    const alerts = document.querySelectorAll(".alert-custom");

    alerts.forEach((alert) => {
        setTimeout(() => {
            alert.style.animation = "fadeOut 0.5s ease";
            setTimeout(() => {
                alert.remove();
            }, 500);
        }, 5000);
    });
});

// Add fadeOut animation
const style = document.createElement("style");
style.textContent = `
    @keyframes fadeOut {
        from { opacity: 1; transform: translateY(0); }
        to { opacity: 0; transform: translateY(-20px); }
    }
`;
document.head.appendChild(style);
