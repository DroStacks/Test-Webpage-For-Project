<?php
session_start();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Appointments | HealthBridge Medical</title>

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

            <h2>Request an Appointment</h2>

            <p>
                Submit your preferred appointment details and a member
                of our team will contact you to confirm availability.
            </p>

        </section>


        <section class="appointment-layout">

            <div class="appointment-info">

                <h2>Before You Request</h2>

                <p>
                    Appointment requests are not immediately confirmed.
                    Our team will review your request and contact you
                    with available appointment times.
                </p>

                <div class="appointment-info-item">
                    <h3>Office Hours</h3>
                    <p>Monday - Friday: 8:00 AM - 5:00 PM</p>
                    <p>Saturday: 9:00 AM - 1:00 PM</p>
                </div>

                <div class="appointment-info-item">
                    <h3>Need Help?</h3>
                    <p>
                        Contact our support team if you have questions
                        before requesting an appointment.
                    </p>
                </div>

            </div>


            <div class="appointment-form-container">

                <h2>Appointment Request Form</h2>

                <form action="../php/appointment.php" method="post" class="appointment-form">

                    <div class="form-row">

                        <div class="form-group">
                            <label for="first-name">First Name</label>

                            <input
                                type="text"
                                id="first-name"
                                name="first_name"
                                required
                            >
                        </div>

                        <div class="form-group">
                            <label for="last-name">Last Name</label>

                            <input
                                type="text"
                                id="last-name"
                                name="last_name"
                                required
                            >
                        </div>

                    </div>


                    <div class="form-group">
                        <label for="appointment-email">Email</label>

                        <input
                            type="email"
                            id="appointment-email"
                            name="email"
                            required
                        >
                    </div>


                    <div class="form-group">
                        <label for="appointment-phone">Phone Number</label>

                        <input
                            type="tel"
                            id="appointment-phone"
                            name="phone"
                            required
                        >
                    </div>


                    <div class="form-group">
                        <label for="service">Type of Visit</label>

                        <select id="service" name="service" required>

                            <option value="">Select a service</option>

                            <option value="primary-care">
                                Primary Care
                            </option>

                            <option value="preventive-care">
                                Preventive Care
                            </option>

                            <option value="family-medicine">
                                Family Medicine
                            </option>

                        </select>

                    </div>


                    <div class="form-row">

                        <div class="form-group">
                            <label for="preferred-date">
                                Preferred Date
                            </label>

                            <input 
                                type="date" 
                                id="preferred-date" 
                                name="appointment_date" 
                                required 
                            >
                        </div>


                        <div class="form-group">
                            <label for="preferred-time">
                                Preferred Time
                            </label>

                            <input 
                                type="time" 
                                id="preferred-time" 
                                name="appointment_time" 
                                required 
                            >
                        </div>

                    </div>


                    <div class="form-group">
                        <label for="appointment-reason">
                            Reason for Visit
                        </label>

                        <textarea
                            id="appointment-reason"
                            name="reason"
                            rows="5"
                            placeholder="Briefly describe the reason for your visit"
                            required
                        ></textarea>
                    </div>


                    <button type="submit" class="primary-button form-button">
                        Submit Appointment Request
                    </button>

                </form>

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
