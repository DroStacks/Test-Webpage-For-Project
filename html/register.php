<?php
session_start();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Register | HealthBridge Medical</title>

    <link rel="stylesheet" href="../css/style.css?v=3">
    <link rel="icon" type="image/x-icon" href="../images/favicon.ico">
</head>

<body>

    <header>

        <div class="utility-bar">
            <div class="utility-content">

                <div class="utility-left">
                    <a href="contact.php">Support Center</a>
                    <span>|</span>
                    <span>Language: English</span>
                </div>

               <div class="utility-right">

    <?php if (isset($_SESSION["user_id"])): ?>

        <span>
            Welcome, <?php echo htmlspecialchars($_SESSION["first_name"]); ?>
        </span>

        <a href="../php/dashboard.php">
            Dashboard
        </a>

        <a href="../php/logout.php" class="login-button">
            Logout
        </a>

    <?php else: ?>

        <a href="register.php">Register</a>

        <a href="login.php" class="login-button">
            Patient Login
        </a>

    <?php endif; ?>

</div>

            </div>
        </div>

        <div class="main-header">

            <nav>

                <div class="logo">
                    <h1>HealthBridge Medical</h1>
                </div>

                <ul class="nav-links">
                    <li><a href="../index.php">Home</a></li>
                    <li><a href="about.php">About</a></li>
                    <li><a href="services.php">Services</a></li>
                    <li><a href="membership.php">Memberships</a></li>
                    <li><a href="contact.php">Contact</a></li>
                    <li><a href="appointment.php">Appointments</a></li>
                </ul>

            </nav>

        </div>

    </header>


    <main>

        <section class="register-page">

            <div class="login-heading">

                <h2>Create Your Account</h2>

                <p>
                    Register for a HealthBridge Medical patient account.
                </p>

            </div>


            <form
    class="register-form"
    action="../php/register.php"
    method="post"
>

                <div class="form-row">

                    <div class="register-field">

                        <label for="register-first-name">
                            First Name
                        </label>

                        <input
                            type="text"
                            id="register-first-name"
                            name="first_name"
                            placeholder="Enter your first name"
                            required
                        >

                    </div>


                    <div class="register-field">

                        <label for="register-last-name">
                            Last Name
                        </label>

                        <input
                            type="text"
                            id="register-last-name"
                            name="last_name"
                            placeholder="Enter your last name"
                            required
                        >

                    </div>

                </div>


                <div class="register-field">

                    <label for="register-email">
                        Email
                    </label>

                    <input
                        type="email"
                        id="register-email"
                        name="email"
                        placeholder="Enter your email"
                        required
                    >

                </div>


                <div class="register-field">

                    <label for="register-phone">
                        Phone Number
                    </label>

                    <input
                        type="tel"
                        id="register-phone"
                        name="phone"
                        placeholder="Enter your phone number"
                    >

                </div>


                <div class="register-field">

                    <label for="register-password">
                        Password
                    </label>

                    <div class="register-password-wrapper">

                        <input
                            type="password"
                            id="register-password"
                            name="password"
                            placeholder="Create a password"
                            required
                        >

                        <button
                            type="button"
                            class="password-toggle"
                            id="register-password-toggle"
                            aria-label="Show password"
                        >
                            <svg
                                viewBox="0 0 576 512"
                                height="18"
                                width="18"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32z"></path>
                            </svg>
                        </button>

                    </div>

                </div>


                <div class="register-field">

                    <label for="confirm-password">
                        Confirm Password
                    </label>

                    <div class="register-password-wrapper">

                        <input
                            type="password"
                            id="confirm-password"
                            name="confirm_password"
                            placeholder="Re-enter your password"
                            required
                        >

                        <button
                            type="button"
                            class="password-toggle"
                            id="confirm-password-toggle"
                            aria-label="Show password"
                        >
                            <svg
                                viewBox="0 0 576 512"
                                height="18"
                                width="18"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32z"></path>
                            </svg>
                        </button>

                    </div>

                </div>


                <div class="register-agreement">

                    <input
                        type="checkbox"
                        id="register-agreement"
                        name="agreement"
                        required
                    >

                    <label for="register-agreement">
                        I agree to the
                        <a href="terms.php">Terms and Conditions</a>
                        and
                        <a href="privacy.php">Privacy Policy</a>.
                    </label>

                </div>


                <button type="submit" class="button-submit">
                    Create Account
                </button>


                <p class="p">

                    Already have an account?

                    <a href="login.php" class="span">
                        Sign In
                    </a>

                </p>

            </form>

        </section>

    </main>


    <footer>

        <div class="footer-main">

            <div class="footer-content">

                <div class="footer-brand">

                    <h2>HealthBridge Medical</h2>

                    <p>
                        Compassionate, reliable healthcare for
                        individuals and families.
                    </p>

                </div>


                <div class="footer-links">

                    <a href="about.php">About</a>
                    <a href="contact.php">Contact</a>
                    <a href="login.php">Patient Login</a>
                    <a href="privacy.php">Privacy Policy</a>
                    <a href="terms.php">Terms and Conditions</a>
                    <a href="accessibility.php">Accessibility</a>

                </div>

            </div>

        </div>


        <div class="footer-bottom">

            <p>
                © 2026 HealthBridge Medical. This website is a mock
                educational project and does not provide real medical services.
            </p>

        </div>

    </footer>


    <?php require_once "../php/chatbot-widget.php"; ?>

<script src="../js/script.js?v=4"></script>

</body>

</html>
