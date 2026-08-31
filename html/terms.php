<?php
session_start();
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Terms and Conditions | HealthBridge Medical</title>

    <link rel="stylesheet" href="../css/style.css">
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
                    <li><a href="contact.php">Contact</a></li>
                    <li><a href="appointment.php">Appointments</a></li>
                </ul>

            </nav>

        </div>

    </header>


    <main>

        <section class="page-heading">

            <h2>Terms and Conditions</h2>

            <p>
                Please review the terms that apply to the use of this
                educational HealthBridge Medical website.
            </p>

        </section>


        <section class="policy-container">

            <div class="policy-card">

                <p class="policy-updated">
                    Last Updated: August 2026
                </p>


                <h2>1. Educational Purpose</h2>

                <p>
                    HealthBridge Medical is a fictional healthcare
                    website created for educational and demonstration
                    purposes. It is not operated by a real healthcare
                    provider and does not provide medical treatment,
                    diagnosis, or professional medical advice.
                </p>


                <h2>2. Use of the Website</h2>

                <p>
                    Visitors may use this website to explore its
                    demonstration features, including contact forms,
                    appointment requests, user accounts, and other
                    website functionality developed as part of the
                    project.
                </p>


                <h2>3. Medical Information</h2>

                <p>
                    Information displayed on this website should not
                    be considered professional medical advice. Users
                    should consult a qualified healthcare professional
                    for actual medical concerns.
                </p>


                <h2>4. User Information</h2>

                <p>
                    Users should only enter fictional or test
                    information into forms on this website. Real
                    medical records, financial information, protected
                    health information, or other sensitive personal
                    information should not be submitted.
                </p>


                <h2>5. User Accounts</h2>

                <p>
                    Account registration and login features may be
                    included to demonstrate authentication and database
                    functionality. Accounts created on this website are
                    intended only for educational testing.
                </p>


                <h2>6. Website Availability</h2>

                <p>
                    HealthBridge Medical does not guarantee that the
                    website or its features will remain available at
                    all times. Features may be modified, removed, or
                    temporarily unavailable during development.
                </p>


                <h2>7. Limitation of Liability</h2>

                <p>
                    Because this website is an educational project,
                    HealthBridge Medical is not responsible for actions
                    taken based on information displayed on the website
                    or information entered into its demonstration
                    features.
                </p>


                <h2>8. Changes to These Terms</h2>

                <p>
                    These terms may be updated as new website features
                    are developed or existing features are changed.
                </p>


                <h2>9. Contact</h2>

                <p>
                    Questions about these terms can be submitted through
                    the HealthBridge Medical contact page.
                </p>

                <a href="contact.php" class="primary-button">
                    Contact Us
                </a>

            </div>

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


    <script src="../js/script.js"></script>

</body>

</html>
