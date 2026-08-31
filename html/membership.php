<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Memberships | HealthBridge Medical</title>

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
                    Choose the level of care that fits you.
                </h2>

                <p>
                    HealthBridge memberships are designed to provide
                    convenient access, personalized support, and additional
                    healthcare services for our members.
                </p>

            </div>

        </section>


        <section class="membership-page">

            <div class="membership-grid">

                <div class="membership-card">

                    <h3>Essential</h3>

                    <p class="membership-description">
                        A simple option for patients who want convenient
                        access to core HealthBridge services.
                    </p>

                    <div class="membership-price">
                        <span class="price">$49</span>
                        <span class="price-period">/ month</span>
                    </div>

                    <p class="annual-price">
                        $499 billed annually
                    </p>

                    <ul class="membership-benefits">
                        <li>Patient portal access</li>
                        <li>Online appointment scheduling</li>
                        <li>Secure account access</li>
                        <li>General care coordination</li>
                        <li>Standard appointment availability</li>
                    </ul>

                    <a href="register.php" class="membership-button">
                        Choose Essential
                    </a>

                </div>


                <div class="membership-card featured">

                    <div class="popular-badge">
                        Most Popular
                    </div>

                    <h3>Plus</h3>

                    <p class="membership-description">
                        Expanded access and additional convenience for
                        patients who want more personalized support.
                    </p>

                    <div class="membership-price">
                        <span class="price">$99</span>
                        <span class="price-period">/ month</span>
                    </div>

                    <p class="annual-price">
                        $999 billed annually
                    </p>

                    <ul class="membership-benefits">
                        <li>Everything in Essential</li>
                        <li>Priority appointment scheduling</li>
                        <li>Virtual care access</li>
                        <li>Expanded wellness services</li>
                        <li>Enhanced care coordination</li>
                        <li>Priority patient support</li>
                    </ul>

                    <a href="register.php" class="membership-button">
                        Choose Plus
                    </a>

                </div>


                <div class="membership-card">

                    <h3>Premier</h3>

                    <p class="membership-description">
                        Our highest level of membership for patients seeking
                        premium access and greater care convenience.
                    </p>

                    <div class="membership-price">
                        <span class="price">$199</span>
                        <span class="price-period">/ month</span>
                    </div>

                    <p class="annual-price">
                        $1,999 billed annually
                    </p>

                    <ul class="membership-benefits">
                        <li>Everything in Plus</li>
                        <li>Highest scheduling priority</li>
                        <li>Extended virtual care access</li>
                        <li>Personalized wellness planning</li>
                        <li>Premium care coordination</li>
                        <li>Dedicated member support</li>
                    </ul>

                    <a href="register.php" class="membership-button">
                        Choose Premier
                    </a>

                </div>

            </div>


            <div class="membership-disclaimer">

                <h3>Important Information</h3>

                <p>
                    HealthBridge Medical memberships are part of this
                    educational mock website and do not represent real
                    medical services or insurance coverage. Membership
                    plans are not health insurance.
                </p>

            </div>

        </section>

    </main>


    <footer>

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

        <div class="footer-bottom">

            <p>
                © 2026 HealthBridge Medical. This website is a mock
                educational project and does not provide real medical
                services.
            </p>

        </div>

    </footer>

</body>

</html>
