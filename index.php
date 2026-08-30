<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>HealthBridge Medical</title>

    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/x-icon" href="images/favicon.ico">
</head>

<body>

    <header>

    <div class="utility-bar">
        <div class="utility-content">

            <div class="utility-left">
                <a href="html/contact.php">Support Center</a>
                <span>|</span>
                <span>Language: English</span>
            </div>

           <div class="utility-right">

    <?php if (isset($_SESSION["user_id"])): ?>

        <span>
            Welcome, <?php echo htmlspecialchars($_SESSION["first_name"]); ?>
        </span>

        <a href="php/dashboard.php">
            Dashboard
        </a>

        <a href="php/logout.php" class="login-button">
            Logout
        </a>

    <?php else: ?>

        <a href="html/register.php">
            Register
        </a>

        <a href="html/login.php" class="login-button">
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
                <li><a href="index.php">Home</a></li>
                <li><a href="html/about.php">About</a></li>
                <li><a href="html/services.php">Services</a></li>
                <li><a href="html/contact.php">Contact</a></li>
                <li><a href="html/appointment.php">Appointments</a></li>
            </ul>

        </nav>

    </div>

</header>

    <main>
   <section class="hero">

    <div class="hero-content">

        <span class="hero-label">Trusted Healthcare</span>

        <h2>Healthcare You Can Depend On</h2>

        <p>
            HealthBridge Medical provides compassionate, reliable,
            and patient-focused care for individuals and families.
        </p>

        <div class="hero-buttons">

            <a href="html/appointment.php" class="primary-button">
                Request Appointment
            </a>

            <a href="html/services.php" class="secondary-button">
                View Services
            </a>

        </div>

    </div>

</section>

<section class="services-section">
    <div class="section-heading">
        <h2>Our Services</h2>
        <p>Comprehensive care designed to support your health at every stage.</p>
    </div>

    <div class="services-grid">
        <article class="service-card">
            <h3>Primary Care</h3>
            <p>
                Routine checkups, illness treatment, and ongoing care for individuals and families.
            </p>
        </article>

        <article class="service-card">
            <h3>Preventive Care</h3>
            <p>
                Screenings, wellness exams, and preventive services focused on long-term health.
            </p>
        </article>

        <article class="service-card">
            <h3>Family Medicine</h3>
            <p>
                Personalized healthcare for patients of different ages and stages of life.
            </p>
        </article>
    </div>
</section>

       <section class="why-us">

    <div class="section-heading">
        <h2>Why Choose HealthBridge?</h2>
        <p>Quality healthcare centered around you and your family.</p>
    </div>

    <div class="why-us-grid">

        <div class="why-us-item">

            <div class="why-us-icon">
                ♡
            </div>

            <h3>Patient-Focused Care</h3>

            <p>
                We focus on providing personalized care based on the
                individual needs of each patient.
            </p>

        </div>


        <div class="why-us-item">

            <div class="why-us-icon">
                🩺
            </div>

            <h3>Experienced Providers</h3>

            <p>
                Our healthcare professionals are committed to providing
                dependable and compassionate medical care.
            </p>

        </div>


        <div class="why-us-item">

            <div class="why-us-icon">
                📅
            </div>

            <h3>Convenient Access</h3>

            <p>
                Easily request appointments and access important
                healthcare resources through our website.
            </p>

        </div>

    </div>

</section>
    

</main>


<footer>

    <div class="footer-main">

        <div class="footer-content">

            <div class="footer-brand">
                <h2>HealthBridge Medical</h2>

                <p>
                    Compassionate, reliable healthcare for individuals
                    and families.
                </p>
            </div>


            <div class="footer-links">

                <a href="html/about.php">About</a>
    <a href="html/contact.php">Contact</a>
    <a href="html/login.php">Patient Login</a>
    <a href="html/privacy.php">Privacy Policy</a>
    <a href="html/terms.php">Terms and Conditions</a>
    <a href="html/accessibility.php">Accessibility</a>

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


<script src="js/script.js"></script>
    

</body>

</html>
