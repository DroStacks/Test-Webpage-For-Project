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
