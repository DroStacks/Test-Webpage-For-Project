// ========================================
// PATIENT LOGIN
// Show / Hide Password
// ========================================

const passwordInput = document.getElementById("login-password");
const passwordToggle = document.getElementById("password-toggle");

if (passwordInput && passwordToggle) {

    passwordToggle.addEventListener("click", function () {

        if (passwordInput.type === "password") {

            passwordInput.type = "text";

            passwordToggle.setAttribute(
                "aria-label",
                "Hide password"
            );

        } else {

            passwordInput.type = "password";

            passwordToggle.setAttribute(
                "aria-label",
                "Show password"
            );

        }

    });

}

// ========================================
// REGISTER PAGE
// Show / Hide Password
// ========================================

const registerPassword = document.getElementById("register-password");
const registerPasswordToggle = document.getElementById("register-password-toggle");

const confirmPassword = document.getElementById("confirm-password");
const confirmPasswordToggle = document.getElementById("confirm-password-toggle");


if (registerPassword && registerPasswordToggle) {

    registerPasswordToggle.addEventListener("click", function () {

        if (registerPassword.type === "password") {

            registerPassword.type = "text";

            registerPasswordToggle.setAttribute(
                "aria-label",
                "Hide password"
            );

        } else {

            registerPassword.type = "password";

            registerPasswordToggle.setAttribute(
                "aria-label",
                "Show password"
            );

        }

    });

}


if (confirmPassword && confirmPasswordToggle) {

    confirmPasswordToggle.addEventListener("click", function () {

        if (confirmPassword.type === "password") {

            confirmPassword.type = "text";

            confirmPasswordToggle.setAttribute(
                "aria-label",
                "Hide password"
            );

        } else {

            confirmPassword.type = "password";

            confirmPasswordToggle.setAttribute(
                "aria-label",
                "Show password"
            );

        }

    });

}
