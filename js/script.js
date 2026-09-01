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

            event.preventDefault();

            message.textContent =
                "Password must be at least 8 characters long.";

            message.classList.add("error-message");

            registerForm.appendChild(message);

            return;
        }


        // Check if passwords match
        if (password.value !== confirmPassword.value) {

            event.preventDefault();

            message.textContent =
                "Passwords do not match.";

            message.classList.add("error-message");

            registerForm.appendChild(message);

            return;
        }


        // Check terms checkbox
        if (!agreement.checked) {

            event.preventDefault();

            message.textContent =
                "Please agree to the Terms and Conditions and Privacy Policy.";

            message.classList.add("error-message");

            registerForm.appendChild(message);

            return;
        }

        // If validation passes,
        // the form continues to register.php

    });

}

// ========================================
// CONTACT PAGE
// Form Validation
// ========================================

const contactForm = document.querySelector(".contact-form");

if (contactForm) {

    contactForm.addEventListener("submit", function (event) {

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

            event.preventDefault();

            message.textContent =
                "Please enter your full name.";

            message.classList.add("error-message");

            contactForm.appendChild(message);

            return;
        }


        // Check email
        if (!email.validity.valid) {

            event.preventDefault();

            message.textContent =
                "Please enter a valid email address.";

            message.classList.add("error-message");

            contactForm.appendChild(message);

            return;
        }


        // Check subject
        if (subject.value.trim().length < 3) {

            event.preventDefault();

            message.textContent =
                "Please enter a subject.";

            message.classList.add("error-message");

            contactForm.appendChild(message);

            return;
        }


        // Check message
        if (messageField.value.trim().length < 10) {

            event.preventDefault();

            message.textContent =
                "Please enter a message with at least 10 characters.";

            message.classList.add("error-message");

            contactForm.appendChild(message);

            return;
        }

        // If everything passes, the form submits normally to PHP.

    });

}

// ========================================
// APPOINTMENT PAGE
// Form Validation
// ========================================

const appointmentForm = document.querySelector(".appointment-form");

if (appointmentForm) {

    appointmentForm.addEventListener("submit", function (event) {

        const firstName = appointmentForm.querySelector('input[name="first_name"]');
        const lastName = appointmentForm.querySelector('input[name="last_name"]');
        const email = appointmentForm.querySelector('input[name="email"]');
        const phone = appointmentForm.querySelector('input[name="phone"]');
        const service = appointmentForm.querySelector('select[name="service"]');
        const appointmentDate = appointmentForm.querySelector('input[name="appointment_date"]');
        const appointmentTime = appointmentForm.querySelector('input[name="appointment_time"]');
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

            event.preventDefault();

            message.textContent =
                "Please enter your first name.";

            message.classList.add("error-message");

            appointmentForm.appendChild(message);

            return;
        }


        // Check last name
        if (lastName.value.trim().length < 2) {

            event.preventDefault();

            message.textContent =
                "Please enter your last name.";

            message.classList.add("error-message");

            appointmentForm.appendChild(message);

            return;
        }


        // Check email
        if (!email.validity.valid) {

            event.preventDefault();

            message.textContent =
                "Please enter a valid email address.";

            message.classList.add("error-message");

            appointmentForm.appendChild(message);

            return;
        }


        // Check phone number
        if (phone.value.trim().length < 7) {

            event.preventDefault();

            message.textContent =
                "Please enter a valid phone number.";

            message.classList.add("error-message");

            appointmentForm.appendChild(message);

            return;
        }


        // Check service
        if (service.value === "") {

            event.preventDefault();

            message.textContent =
                "Please select a type of visit.";

            message.classList.add("error-message");

            appointmentForm.appendChild(message);

            return;
        }


        // Check appointment date
        if (appointmentDate.value === "") {

            event.preventDefault();

            message.textContent =
                "Please select a preferred appointment date.";

            message.classList.add("error-message");

            appointmentForm.appendChild(message);

            return;
        }


        // Prevent past dates
        const selectedDate = new Date(
            appointmentDate.value + "T00:00:00"
        );

        const today = new Date();

        today.setHours(0, 0, 0, 0);

        if (selectedDate < today) {

            event.preventDefault();

            message.textContent =
                "Please choose a date that is today or later.";

            message.classList.add("error-message");

            appointmentForm.appendChild(message);

            return;
        }


        // Check appointment time
        if (appointmentTime.value === "") {

            event.preventDefault();

            message.textContent =
                "Please select a preferred appointment time.";

            message.classList.add("error-message");

            appointmentForm.appendChild(message);

            return;
        }


        // Check reason for visit
        if (reason.value.trim().length < 10) {

            event.preventDefault();

            message.textContent =
                "Please provide a brief reason for your visit.";

            message.classList.add("error-message");

            appointmentForm.appendChild(message);

            return;
        }

        // If all validation passes,
        // the form submits normally to PHP.

    });

}


// =========================
// HEALTHBRIDGE CHATBOT
// =========================

const chatbotToggle = document.getElementById("chatbotToggle");
const chatbotWindow = document.getElementById("chatbotWindow");
const chatbotClose = document.getElementById("chatbotClose");

const chatbotForm = document.getElementById("chatbotForm");
const chatbotInput = document.getElementById("chatbotInput");
const chatbotMessages = document.getElementById("chatbotMessages");


if (
    chatbotToggle &&
    chatbotWindow &&
    chatbotClose &&
    chatbotForm &&
    chatbotInput &&
    chatbotMessages
) {

    chatbotToggle.addEventListener("click", function () {

        chatbotWindow.hidden = false;

        chatbotInput.focus();

    });


    chatbotClose.addEventListener("click", function () {

        chatbotWindow.hidden = true;

    });


    chatbotForm.addEventListener("submit", async function (event) {

        event.preventDefault();

        const message = chatbotInput.value.trim();

        if (message === "") {
            return;
        }


        addChatbotMessage(
            message,
            "user"
        );


        chatbotInput.value = "";
        chatbotInput.disabled = true;


        const thinkingMessage = addChatbotMessage(
            "Thinking...",
            "assistant"
        );


        try {

            const response = await fetch(
                    "/php/chatbot.php",
                {
                    method: "POST",

                    headers: {
                        "Content-Type": "application/json"
                    },

                    body: JSON.stringify({
                        message: message
                    })
                }
            );


            const data = await response.json();


            thinkingMessage.remove();


            if (
                !response.ok ||
                data.success !== true
            ) {

                addChatbotMessage(
                    data.message ||
                    "The HealthBridge Assistant is temporarily unavailable.",
                    "assistant"
                );

                return;
            }


            addChatbotMessage(
                data.reply,
                "assistant"
            );

        } catch (error) {

            thinkingMessage.remove();

            addChatbotMessage(
                "The HealthBridge Assistant is temporarily unavailable.",
                "assistant"
            );

        } finally {

            chatbotInput.disabled = false;
            chatbotInput.focus();

        }

    });

}


function addChatbotMessage(
    message,
    sender
) {

    const messageElement = document.createElement("div");

    messageElement.classList.add(
        "chatbot-message"
    );


    if (sender === "user") {

        messageElement.classList.add(
            "chatbot-message-user"
        );

    } else {

        messageElement.classList.add(
            "chatbot-message-assistant"
        );

    }


    message = message
    .replace(/\*\*(.*?)\*\*/g, "$1")
    .replace(/\*(.*?)\*/g, "$1")
    .replace(/^\s*-\s+/gm, "• ");

messageElement.textContent = message;

    chatbotMessages.appendChild(
        messageElement
    );


    chatbotMessages.scrollTop =
        chatbotMessages.scrollHeight;


    return messageElement;

}
