<?php
session_start();
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Privacy Policy | HealthBridge Medical</title>

    <link rel="stylesheet" href="../css/style.css?v=2">
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

        <section class="page-heading">

            <h2>Privacy Policy</h2>

            <p>
                Learn how HealthBridge Medical handles information
                submitted through this educational website.
            </p>

        </section>


        <section class="policy-container">

            <div class="policy-card">

                <p class="policy-updated">
                    Last Updated: August 2026
                </p>


                <h2>1. Overview</h2>

                <p>
                    HealthBridge Medical is a mock healthcare website
                    created for educational purposes. This website does
                    not provide real medical services and should not be
                    used to submit actual medical or sensitive personal
                    information.
                </p>


                <h2>2. Information We May Collect</h2>

                <p>
                    This website may include forms that request
                    information such as your name, email address,
                    phone number, appointment preferences, or general
                    contact information.
                </p>

                <p>
                    Any information entered into this educational
                    project should be fictional or test information only.
                </p>


                <h2>3. How Information Is Used</h2>

                <p>
                    Information submitted through forms may be used
                    within the project to demonstrate features such as
                    form validation, appointment requests, user accounts,
                    database storage, and website functionality.
                </p>


                <h2>4. Information Security</h2>

                <p>
                    HealthBridge Medical is designed to demonstrate
                    common website security practices. These may include
                    password hashing, input validation, access controls,
                    secure database queries, and encrypted connections.
                </p>

                <p>
                    Because this website is an educational project,
                    users should not enter real protected health
                    information, financial information, passwords used
                    on other websites, or other sensitive data.
                </p>


                <h2>5. Cookies and Sessions</h2>

                <p>
                    The website may use browser cookies or server
                    sessions to demonstrate features such as user
                    authentication and maintaining a logged-in session.
                </p>


                <h2>6. Third-Party Services</h2>

                <p>
                    The website may use external tools, libraries,
                    hosting platforms, or other technologies as part
                    of its development. These services may operate
                    according to their own privacy practices.
                </p>


                <h2>7. Educational Use</h2>

                <p>
                    HealthBridge Medical is not a real healthcare
                    provider. Content, contact information, patient
                    features, and medical services displayed on this
                    website are fictional and are provided solely for
                    demonstration and educational purposes.
                </p>


                <h2>8. Contact</h2>

                <p>
                    Questions regarding this mock Privacy Policy can be
                    submitted through the HealthBridge Medical contact
                    page.
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
