<?php

session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Our Doctors | HealthBridge Medical</title>

    <link
        rel="stylesheet"
        href="../css/style.css?v=4"
    >

    <link
        rel="icon"
        type="image/x-icon"
        href="../images/favicon.ico"
    >

</head>

<body>

    <!-- ==========================================
         HEADER
    =========================================== -->

    <header>

        <div class="utility-bar">

            <div class="utility-content">

                <div class="utility-left">

                    <a href="contact.php">
                        Support Center
                    </a>

                    <span>|</span>

                    <span>
                        Language: English
                    </span>

                </div>

                <div class="utility-right">

                    <?php if (isset($_SESSION["user_id"])): ?>

                        <span>
                            Welcome,
                            <?php
                            echo htmlspecialchars(
                                $_SESSION["first_name"] ?? "",
                                ENT_QUOTES,
                                "UTF-8"
                            );
                            ?>
                        </span>

                        <a href="../php/dashboard.php">
                            Dashboard
                        </a>

                        <a
                            href="../php/logout.php"
                            class="login-button"
                        >
                            Logout
                        </a>

                    <?php else: ?>

                        <a href="register.php">
                            Register
                        </a>

                        <a
                            href="login.php"
                            class="login-button"
                        >
                            Patient Login
                        </a>

                    <?php endif; ?>

                </div>

            </div>

        </div>


        <div class="main-header">

            <nav>

                <div class="logo">

                    <h1>
                        HealthBridge Medical
                    </h1>

                </div>

                <ul class="nav-links">

                    <li>
                        <a href="../index.php">
                            Home
                        </a>
                    </li>

                    <li>
                        <a href="about.php">
                            About
                        </a>
                    </li>

                    <li>
                        <a href="services.php">
                            Services
                        </a>
                    </li>

                    <li>
                        <a href="membership.php">
                            Memberships
                        </a>
                    </li>

                    <li>
                        <a href="contact.php">
                            Contact
                        </a>
                    </li>

                    <li>
                        <a href="appointment.php">
                            Appointments
                        </a>
                    </li>

                </ul>

            </nav>

        </div>

    </header>


    <!-- ==========================================
         MAIN CONTENT
    =========================================== -->

    <main>

        <section class="page-heading">

            <h2>
                Meet Our Doctors
            </h2>

            <p>
                Meet the fictional healthcare professionals
                featured in the HealthBridge Medical
                educational project.
            </p>

        </section>


        <section class="doctors-section">

            <div class="doctors-container">


                <!-- ==================================
                     DOCTOR 1
                =================================== -->

                <article class="doctor-card">

                    <h2>
                        Dr. Emily Carter, MD
                    </h2>

                    <h3>
                        Primary Care &amp; Internal Medicine
                    </h3>

                    <p>
                        <strong>Medical Degree:</strong>
                        Doctor of Medicine, Westbridge
                        University School of Medicine
                    </p>

                    <p>
                        <strong>Residency:</strong>
                        Internal Medicine, Westbridge
                        University Medical Center
                    </p>

                    <p>
                        Dr. Carter focuses on comprehensive
                        primary care, preventive medicine,
                        and helping adult patients manage
                        their long-term health needs.
                    </p>

                </article>


                <!-- ==================================
                     DOCTOR 2
                =================================== -->

                <article class="doctor-card">

                    <h2>
                        Dr. Marcus Bennett, DO
                    </h2>

                    <h3>
                        Family Medicine
                    </h3>

                    <p>
                        <strong>Medical Degree:</strong>
                        Doctor of Osteopathic Medicine,
                        Pacific Valley College of
                        Osteopathic Medicine
                    </p>

                    <p>
                        <strong>Residency:</strong>
                        Family Medicine, Pacific Valley
                        Regional Medical Center
                    </p>

                    <p>
                        Dr. Bennett provides family medicine
                        services for patients across
                        different stages of life with an
                        emphasis on preventive care and
                        patient education.
                    </p>

                </article>


                <!-- ==================================
                     DOCTOR 3
                =================================== -->

                <article class="doctor-card">

                    <h2>
                        Dr. Sophia Ramirez, MD
                    </h2>

                    <h3>
                        Preventive Medicine
                    </h3>

                    <p>
                        <strong>Medical Degree:</strong>
                        Doctor of Medicine, Redwood Coast
                        School of Medicine
                    </p>

                    <p>
                        <strong>Residency:</strong>
                        Preventive Medicine, Redwood Coast
                        Health Center
                    </p>

                    <p>
                        Dr. Ramirez specializes in preventive
                        health services, routine screenings,
                        wellness planning, and helping
                        patients identify health risks
                        early.
                    </p>

                </article>


                <!-- ==================================
                     DOCTOR 4
                =================================== -->

                <article class="doctor-card">

                    <h2>
                        Dr. Daniel Kim, MD
                    </h2>

                    <h3>
                        Internal Medicine
                    </h3>

                    <p>
                        <strong>Medical Degree:</strong>
                        Doctor of Medicine, North Valley
                        University College of Medicine
                    </p>

                    <p>
                        <strong>Residency:</strong>
                        Internal Medicine, North Valley
                        University Hospital
                    </p>

                    <p>
                        Dr. Kim provides adult primary care
                        with a focus on routine medical
                        evaluations, chronic condition
                        management, and coordinated care.
                    </p>

                </article>


                <!-- ==================================
                     DOCTOR 5
                =================================== -->

                <article class="doctor-card">

                    <h2>
                        Dr. Olivia Thompson, MD
                    </h2>

                    <h3>
                        Family Medicine
                    </h3>

                    <p>
                        <strong>Medical Degree:</strong>
                        Doctor of Medicine, Sierra Heights
                        College of Medicine
                    </p>

                    <p>
                        <strong>Residency:</strong>
                        Family Medicine, Sierra Heights
                        Community Hospital
                    </p>

                    <p>
                        Dr. Thompson focuses on accessible
                        family healthcare, routine
                        examinations, preventive services,
                        and long-term patient relationships.
                    </p>

                </article>


                <!-- ==================================
                     DOCTOR 6
                =================================== -->

                <article class="doctor-card">

                    <h2>
                        Dr. Ethan Brooks, DO
                    </h2>

                    <h3>
                        Primary Care
                    </h3>

                    <p>
                        <strong>Medical Degree:</strong>
                        Doctor of Osteopathic Medicine,
                        Western Lakes College of
                        Osteopathic Medicine
                    </p>

                    <p>
                        <strong>Residency:</strong>
                        Family Medicine, Western Lakes
                        Medical Center
                    </p>

                    <p>
                        Dr. Brooks provides primary care
                        services with an emphasis on
                        preventive health, wellness,
                        lifestyle education, and
                        patient-centered care.
                    </p>

                </article>

            </div>


            <div class="doctors-disclaimer">

                <p>
                    <strong>Educational Project Notice:</strong>
                    All doctors, medical institutions,
                    credentials, biographies, and professional
                    information shown on this page are
                    fictional and were created solely for
                    this educational demonstration website.
                </p>

            </div>

        </section>

    </main>


    <!-- ==========================================
         FOOTER
    =========================================== -->

    <footer>

        <div class="footer-main">

            <div class="footer-content">

                <div class="footer-brand">

                    <h2>
                        HealthBridge Medical
                    </h2>

                    <p>
                        Compassionate, reliable healthcare
                        for individuals and families.
                    </p>

                </div>


                <div class="footer-links">

                    <a href="about.php">
                        About
                    </a>

                    <a href="contact.php">
                        Contact
                    </a>

                    <?php if (isset($_SESSION["user_id"])): ?>

                        <a href="../php/dashboard.php">
                            Patient Dashboard
                        </a>

                    <?php else: ?>

                        <a href="login.php">
                            Patient Login
                        </a>

                    <?php endif; ?>

                    <a href="privacy.php">
                        Privacy Policy
                    </a>

                    <a href="terms.php">
                        Terms and Conditions
                    </a>

                    <a href="accessibility.php">
                        Accessibility
                    </a>

                </div>

            </div>

        </div>


        <div class="footer-bottom">

            <p>
                © 2026 HealthBridge Medical.
                This website is a mock educational project
                and does not provide real medical services.
            </p>

        </div>

    </footer>


    <?php require_once "../php/chatbot-widget.php"; ?>

    <script src="../js/script.js?v=4"></script>

</body>

</html>
