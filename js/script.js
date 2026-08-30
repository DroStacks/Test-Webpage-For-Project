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

// ========================================
// REGISTER PAGE
// Form Validation
// ========================================

const registerForm = document.querySelector(".register-form");

if (registerForm) {

    registerForm.addEventListener("submit", function (event) {

        event.preventDefault();

        const password = document.getElementById("register-password");
        const confirmPassword = document.getElementById("confirm-password");
        const agreement = document.getElementById("register-agreement");

        // Remove old message if one already exists
        const oldMessage = document.getElementById("register-message");

        if (oldMessage) {
            oldMessage.remove();
        }


        // Create message
        const message = document.createElement("p");

        message.id = "register-message";
        message.classList.add("register-message");


        // Check password length
        if (password.value.length < 8) {

            message.textContent =
                "Password must be at least 8 characters long.";

            message.classList.add("error-message");

            registerForm.appendChild(message);

            return;
        }


        // Check if passwords match
        if (password.value !== confirmPassword.value) {

            message.textContent =
                "Passwords do not match.";

            message.classList.add("error-message");

            registerForm.appendChild(message);

            return;
        }


        // Check terms checkbox
        if (!agreement.checked) {

            message.textContent =
                "Please agree to the Terms and Conditions and Privacy Policy.";

            message.classList.add("error-message");

            registerForm.appendChild(message);

            return;
        }


        // Everything passed
        message.textContent =
            "Registration form looks good! Account creation will be enabled when the backend is connected.";

        message.classList.add("success-message");

        registerForm.appendChild(message);

    });

}

// ========================================
// CONTACT PAGE
// Form Validation
// ========================================

const contactForm = document.querySelector(".contact-form");

if (contactForm) {

    contactForm.addEventListener("submit", function (event) {

        event.preventDefault();

        const name = contactForm.querySelector('input[name="name"]');
        const email = contactForm.querySelector('input[name="email"]');
        const subject = contactForm.querySelector('input[name="subject"]');
        const messageField = contactForm.querySelector('textarea[name="message"]');

        // Remove old validation message
        const oldMessage = document.getElementById("contact-form-message");

        if (oldMessage) {
            oldMessage.remove();
        }

        // Create validation message
        const message = document.createElement("p");

        message.id = "contact-form-message";
        message.classList.add("contact-message");


        // Check name
        if (name.value.trim().length < 2) {

            message.textContent =
                "Please enter your full name.";

            message.classList.add("error-message");

            contactForm.appendChild(message);

            return;
        }


        // Check email
        if (!email.validity.valid) {

            message.textContent =
                "Please enter a valid email address.";

            message.classList.add("error-message");

            contactForm.appendChild(message);

            return;
        }


        // Check subject
        if (subject.value.trim().length < 3) {

            message.textContent =
                "Please enter a subject.";

            message.classList.add("error-message");

            contactForm.appendChild(message);

            return;
        }


        // Check message
        if (messageField.value.trim().length < 10) {

            message.textContent =
                "Please enter a message with at least 10 characters.";

            message.classList.add("error-message");

            contactForm.appendChild(message);

            return;
        }


        // Everything passed
        message.textContent =
            "Your message looks good! Sending will be enabled when the backend is connected.";

        message.classList.add("success-message");

        contactForm.appendChild(message);

    });

}
