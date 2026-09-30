<?php

session_start();

require_once "/etc/healthbridge/db.php";

// --------------------------------------------------
// CSRF TOKEN
// --------------------------------------------------

if (empty($_SESSION["appointment_csrf_token"])) {
    $_SESSION["appointment_csrf_token"] =
        bin2hex(random_bytes(32));
}

$csrfToken =
    $_SESSION["appointment_csrf_token"];

// --------------------------------------------------
// DEFAULT FORM VALUES
// --------------------------------------------------

$firstName = "";
$lastName = "";
$email = "";
$phone = "";

$service = "";
$appointmentDate = "";
$appointmentTime = "";
$reason = "";

// --------------------------------------------------
// LOAD LOGGED-IN PATIENT INFORMATION
// --------------------------------------------------

if (isset($_SESSION["user_id"])) {

    try {

        $patientStmt = $pdo->prepare(
            "SELECT
                first_name,
                last_name,
                email,
                phone
             FROM users
             WHERE id = ?"
        );

        $patientStmt->execute([
            $_SESSION["user_id"]
        ]);

        $patient =
            $patientStmt->fetch(PDO::FETCH_ASSOC);

        if ($patient) {

            $firstName =
                $patient["first_name"] ?? "";

            $lastName =
                $patient["last_name"] ?? "";

            $email =
                $patient["email"] ?? "";

            $phone =
                $patient["phone"] ?? "";

        }

    } catch (PDOException $e) {

        // Keep form available even if patient
        // information cannot be preloaded.

    }

}

// --------------------------------------------------
// RESTORE FORM VALUES AFTER VALIDATION ERROR
// --------------------------------------------------

if (
    isset($_SESSION["appointment_old"]) &&
    is_array($_SESSION["appointment_old"])
) {

    $old =
        $_SESSION["appointment_old"];

    $firstName =
        $old["first_name"] ?? $firstName;

    $lastName =
        $old["last_name"] ?? $lastName;

    $email =
        $old["email"] ?? $email;

    $phone =
        $old["phone"] ?? $phone;

    $service =
        $old["service"] ?? "";

    $appointmentDate =
        $old["appointment_date"] ?? "";

    $appointmentTime =
        $old["appointment_time"] ?? "";

    $reason =
        $old["reason"] ?? "";

    unset($_SESSION["appointment_old"]);

}

// --------------------------------------------------
// ERROR MESSAGE
// --------------------------------------------------

$appointmentError = "";

if (isset($_SESSION["appointment_error"])) {

    $appointmentError =
        $_SESSION["appointment_error"];

    unset($_SESSION["appointment_error"]);

}

// --------------------------------------------------
// SUCCESS MESSAGE
// --------------------------------------------------

$appointmentSuccess = "";

if (
    isset($_GET["appointment"]) &&
    $_GET["appointment"] === "success"
) {

    $appointmentSuccess =
        "Your appointment request has been submitted successfully. Its current status is Pending.";

}

// --------------------------------------------------
// HELPER
// --------------------------------------------------

function escapeAppointmentHtml($value)
{
    return htmlspecialchars(
        (string) ($value ?? ""),
        ENT_QUOTES,
        "UTF-8"
    );
}

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Appointments | HealthBridge Medical
    </title>

    <link
        rel="stylesheet"
        href="../css/style.css?v=8"
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
                            echo escapeAppointmentHtml(
                                $_SESSION["first_name"] ?? ""
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
                        <a
                            href="appointment.php"
                            class="active"
                        >
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
                Request an Appointment
            </h2>

            <p>
                Submit your preferred appointment details
                and a member of our team will contact you
                to confirm availability.
            </p>

        </section>

        <section class="appointment-layout">

            <!-- ==================================
                 APPOINTMENT INFORMATION
            =================================== -->

            <div class="appointment-info">

                <h2>
                    Before You Request
                </h2>

                <p>
                    Appointment requests are not immediately
                    confirmed. Our team will review your
                    request and contact you with available
                    appointment times.
                </p>

                <div class="appointment-info-item">

                    <h3>
                        Office Hours
                    </h3>

                    <p>
                        Monday - Friday:
                        8:00 AM - 5:00 PM
                    </p>

                    <p>
                        Saturday:
                        9:00 AM - 1:00 PM
                    </p>

                    <p>
                        Sunday:
                        Closed
                    </p>

                </div>

                <div class="appointment-info-item">

                    <h3>
                        Request Status
                    </h3>

                    <p>
                        New appointment requests are saved
                        with a Pending status until reviewed.
                    </p>

                </div>

                <div class="appointment-info-item">

                    <h3>
                        Need Help?
                    </h3>

                    <p>
                        Contact our support team if you have
                        questions before requesting an
                        appointment.
                    </p>

                </div>

            </div>

            <!-- ==================================
                 APPOINTMENT FORM
            =================================== -->

            <div class="appointment-form-container">

                <h2>
                    Appointment Request Form
                </h2>

                <?php if ($appointmentSuccess !== ""): ?>

                    <div class="profile-success">

                        <?php
                        echo escapeAppointmentHtml(
                            $appointmentSuccess
                        );
                        ?>

                    </div>

                <?php endif; ?>

                <?php if ($appointmentError !== ""): ?>

                    <div class="profile-error">

                        <?php
                        echo escapeAppointmentHtml(
                            $appointmentError
                        );
                        ?>

                    </div>

                <?php endif; ?>

                <?php if (!isset($_SESSION["user_id"])): ?>

                    <div class="profile-notice">

                        You must be logged into a patient
                        account before submitting an
                        appointment request.

                    </div>

                    <a
                        href="login.php"
                        class="primary-button form-button"
                    >
                        Patient Login
                    </a>

                <?php else: ?>

                    <form
                        action="../php/appointment.php"
                        method="post"
                        class="appointment-form"
                    >

                        <!-- CSRF -->

                        <input
                            type="hidden"
                            name="csrf_token"
                            value="<?php
                            echo escapeAppointmentHtml(
                                $csrfToken
                            );
                            ?>"
                        >

                        <!-- NAME -->

                        <div class="form-row">

                            <div class="form-group">

                                <label for="first-name">
                                    First Name
                                </label>

                                <input
                                    type="text"
                                    id="first-name"
                                    name="first_name"
                                    maxlength="50"
                                    value="<?php
                                    echo escapeAppointmentHtml(
                                        $firstName
                                    );
                                    ?>"
                                    required
                                >

                            </div>

                            <div class="form-group">

                                <label for="last-name">
                                    Last Name
                                </label>

                                <input
                                    type="text"
                                    id="last-name"
                                    name="last_name"
                                    maxlength="50"
                                    value="<?php
                                    echo escapeAppointmentHtml(
                                        $lastName
                                    );
                                    ?>"
                                    required
                                >

                            </div>

                        </div>

                        <!-- EMAIL -->

                        <div class="form-group">

                            <label for="appointment-email">
                                Email
                            </label>

                            <input
                                type="email"
                                id="appointment-email"
                                name="email"
                                maxlength="255"
                                value="<?php
                                echo escapeAppointmentHtml(
                                    $email
                                );
                                ?>"
                                required
                            >

                        </div>

                        <!-- PHONE -->

                        <div class="form-group">

                            <label for="appointment-phone">
                                Phone Number
                            </label>

                            <input
                                type="tel"
                                id="appointment-phone"
                                name="phone"
                                maxlength="25"
                                value="<?php
                                echo escapeAppointmentHtml(
                                    $phone
                                );
                                ?>"
                                required
                            >

                        </div>

                        <!-- SERVICE -->

                        <div class="form-group">

                            <label for="service">
                                Type of Visit
                            </label>

                            <select
                                id="service"
                                name="service"
                                required
                            >

                                <option value="">
                                    Select a service
                                </option>

                                <option
                                    value="primary-care"
                                    <?php
                                    echo $service === "primary-care"
                                        ? "selected"
                                        : "";
                                    ?>
                                >
                                    Primary Care
                                </option>

                                <option
                                    value="preventive-care"
                                    <?php
                                    echo $service === "preventive-care"
                                        ? "selected"
                                        : "";
                                    ?>
                                >
                                    Preventive Care
                                </option>

                                <option
                                    value="family-medicine"
                                    <?php
                                    echo $service === "family-medicine"
                                        ? "selected"
                                        : "";
                                    ?>
                                >
                                    Family Medicine
                                </option>

                            </select>

                        </div>

                        <!-- DATE / TIME -->

                        <div class="form-row">

                            <div class="form-group">

                                <label for="preferred-date">
                                    Preferred Date
                                </label>

                                <input
                                    type="date"
                                    id="preferred-date"
                                    name="appointment_date"
                                    min="<?php
                                    echo date("Y-m-d");
                                    ?>"
                                    value="<?php
                                    echo escapeAppointmentHtml(
                                        $appointmentDate
                                    );
                                    ?>"
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
                                    value="<?php
                                    echo escapeAppointmentHtml(
                                        $appointmentTime
                                    );
                                    ?>"
                                    required
                                >

                            </div>

                        </div>

                        <!-- REASON -->

                        <div class="form-group">

                            <label for="appointment-reason">
                                Reason for Visit
                            </label>

                            <textarea
                                id="appointment-reason"
                                name="reason"
                                rows="5"
                                maxlength="2000"
                                placeholder="Briefly describe the reason for your visit"
                                required
                            ><?php
                            echo escapeAppointmentHtml(
                                $reason
                            );
                            ?></textarea>

                        </div>

                        <div class="profile-notice">

                            HealthBridge Medical is an
                            educational demonstration project.
                            Do not enter real medical or
                            personally sensitive information.

                        </div>

                        <button
                            type="submit"
                            class="primary-button form-button"
                        >
                            Submit Appointment Request
                        </button>

                    </form>

                <?php endif; ?>

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
