<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Memberships | HealthBridge Medical</title>

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
                            Welcome,
                            <?php echo htmlspecialchars(
                                $_SESSION["first_name"],
                                ENT_QUOTES,
                                "UTF-8"
                            ); ?>
                        </span>

                        <a href="../php/dashboard.php">
                            Dashboard
                        </a>

                        <a href="../php/logout.php" class="login-button">
                            Logout
                        </a>

                    <?php else: ?>

                        <a href="register.php">
                            Register
                        </a>

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

        <section class="membership-hero">

            <div class="membership-hero-content">

                <span class="membership-eyebrow">
                    HealthBridge Memberships
                </span>

                <h2>
                    Simple monthly healthcare memberships.
                </h2>

                <p>
                    Choose a membership based on how much access,
                    convenience, and support you want from HealthBridge
                    Medical.
                </p>

            </div>

        </section>


        <section class="membership-page">

            <div class="membership-grid">


                <!-- Essential Plan -->

                <div class="membership-card">

                    <h3>Essential</h3>

                    <p class="membership-description">
                        A flexible option for patients who want access
                        to essential HealthBridge services at an
                        affordable monthly price.
                    </p>

                    <div class="membership-price">
                        <span class="price">$39</span>
                        <span class="price-period">/ month</span>
                    </div>

                    <ul class="membership-benefits">

                        <li>
                            Patient portal access
                        </li>

                        <li>
                            Online appointment scheduling
                        </li>

                        <li>
                            Standard appointment availability
                        </li>

                        <li>
                            General care coordination
                        </li>

                        <li>
                            $30 primary care visit fee
                        </li>

                        <li>
                            $25 virtual visit fee
                        </li>

                    </ul>

                    <a
                        href="checkout.php?plan=essential"
                        class="membership-button"
                    >
                        Choose Essential
                    </a>

                </div>


                <!-- Plus Plan -->

                <div class="membership-card featured">

                    <div class="popular-badge">
                        Most Popular
                    </div>

                    <h3>Plus</h3>

                    <p class="membership-description">
                        Designed for patients who want faster access,
                        lower visit fees, and additional healthcare
                        support.
                    </p>

                    <div class="membership-price">
                        <span class="price">$79</span>
                        <span class="price-period">/ month</span>
                    </div>

                    <ul class="membership-benefits">

                        <li>
                            Everything included in Essential
                        </li>

                        <li>
                            Priority appointment scheduling
                        </li>

                        <li>
                            Expanded wellness services
                        </li>

                        <li>
                            Enhanced care coordination
                        </li>

                        <li>
                            Priority patient support
                        </li>

                        <li>
                            $20 primary care visit fee
                        </li>

                        <li>
                            $10 virtual visit fee
                        </li>

                    </ul>

                    <a
                        href="checkout.php?plan=plus"
                        class="membership-button"
                    >
                        Choose Plus
                    </a>

                </div>


                <!-- Premier Plan -->

                <div class="membership-card">

                    <h3>Premier</h3>

                    <p class="membership-description">
                        Premium access for patients who want our
                        highest level of convenience, support, and
                        routine care benefits.
                    </p>

                    <div class="membership-price">
                        <span class="price">$149</span>
                        <span class="price-period">/ month</span>
                    </div>

                    <ul class="membership-benefits">

                        <li>
                            Everything included in Plus
                        </li>

                        <li>
                            Highest scheduling priority
                        </li>

                        <li>
                            Personalized wellness planning
                        </li>

                        <li>
                            Premium care coordination
                        </li>

                        <li>
                            Dedicated member support
                        </li>

                        <li>
                            $0 routine primary care visit fee
                        </li>

                        <li>
                            $0 virtual visit fee
                        </li>

                    </ul>

                    <a
                        href="checkout.php?plan=premier"
                        class="membership-button"
                    >
                        Choose Premier
                    </a>

                </div>

            </div>


            <div class="membership-disclaimer">

                <h3>Membership Information</h3>

                <p>
                    HealthBridge Medical memberships are not health
                    insurance. Membership fees and member visit fees
                    shown on this website are fictional and are used
                    only for this educational project.
                </p>

            </div>

        </section>

    </main>


   <footer>

    <div class="footer-main">

        <div class="footer-content">

            <div class="footer-brand">

                <h2>HealthBridge Medical</h2>

                <p>
                    Connecting patients with convenient and accessible
                    healthcare services.
                </p>

            </div>

            <div class="footer-links">

                <a href="about.php">About</a>
                <a href="contact.php">Contact</a>
                <a href="membership.php">Memberships</a>
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
            educational project and does not provide real medical
            services.
        </p>

    </div>

</footer>

    <?php require_once "../php/chatbot-widget.php"; ?>

<script src="../js/script.js?v=4"></script>
    
</body>

</html>
