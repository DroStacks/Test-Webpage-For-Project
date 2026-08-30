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

// ========================================
// APPOINTMENT PAGE
// Form Validation
// ========================================

const appointmentForm = document.querySelector(".appointment-form");

if (appointmentForm) {

    appointmentForm.addEventListener("submit", function (event) {

        event.preventDefault();

        const firstName = appointmentForm.querySelector('input[name="first_name"]');
        const lastName = appointmentForm.querySelector('input[name="last_name"]');
        const email = appointmentForm.querySelector('input[name="email"]');
        const phone = appointmentForm.querySelector('input[name="phone"]');
        const service = appointmentForm.querySelector('select[name="service"]');
        const preferredDate = appointmentForm.querySelector('input[name="preferred_date"]');
        const preferredTime = appointmentForm.querySelector('input[name="preferred_time"]');
        const reason = appointmentForm.querySelector('textarea[name="reason"]');

        // Remove old validation message
        const oldMessage =
            document.getElementById("appointment-form-message");

        if (oldMessage) {
            oldMessage.remove();
        }

        // Create validation message
        const message = document.createElement("p");

        message.id = "appointment-form-message";
        message.classList.add("appointment-message");


        // Check first name
        if (firstName.value.trim().length < 2) {

            message.textContent =
                "Please enter your first name.";

            message.classList.add("error-message");

            appointmentForm.appendChild(message);

            return;
        }


        // Check last name
        if (lastName.value.trim().length < 2) {

            message.textContent =
                "Please enter your last name.";

            message.classList.add("error-message");

            appointmentForm.appendChild(message);

            return;
        }


        // Check email
        if (!email.validity.valid) {

            message.textContent =
                "Please enter a valid email address.";

            message.classList.add("error-message");

            appointmentForm.appendChild(message);

            return;
        }


        // Check phone number
        if (phone.value.trim().length < 7) {

            message.textContent =
                "Please enter a valid phone number.";

            message.classList.add("error-message");

            appointmentForm.appendChild(message);

            return;
        }


        // Check service
        if (service.value === "") {

            message.textContent =
                "Please select a type of visit.";

            message.classList.add("error-message");

            appointmentForm.appendChild(message);

            return;
        }


        // Check preferred date
        if (preferredDate.value === "") {

            message.textContent =
                "Please select a preferred appointment date.";

            message.classList.add("error-message");

            appointmentForm.appendChild(message);

            return;
        }


        // Prevent past dates
        const selectedDate = new Date(
            preferredDate.value + "T00:00:00"
        );

        const today = new Date();

        today.setHours(0, 0, 0, 0);

        if (selectedDate < today) {

            message.textContent =
                "Please choose a date that is today or later.";

            message.classList.add("error-message");

            appointmentForm.appendChild(message);

            return;
        }


        // Check preferred time
        if (preferredTime.value === "") {

            message.textContent =
                "Please select a preferred appointment time.";

            message.classList.add("error-message");

            appointmentForm.appendChild(message);

            return;
        }


        // Check reason for visit
        if (reason.value.trim().length < 10) {

            message.textContent =
                "Please provide a brief reason for your visit.";

            message.classList.add("error-message");

            appointmentForm.appendChild(message);

            return;
        }


        // Everything passed
        message.textContent =
            "Your appointment request looks good! Submission will be enabled when the backend is connected.";

        message.classList.add("success-message");

        appointmentForm.appendChild(message);

    });

}
