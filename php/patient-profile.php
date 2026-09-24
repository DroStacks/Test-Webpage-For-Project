
<?php

session_start();

// Require patient login
if (!isset($_SESSION["user_id"])) {
    header("Location: ../html/login.php");
    exit;
}

require_once "/etc/healthbridge/db.php";

$userId = $_SESSION["user_id"];

// Retrieve the patient's existing account information
$stmt = $pdo->prepare(
    "SELECT
        first_name,
        email,
        membership_plan,
        membership_status
     FROM users
     WHERE id = ?"
);

$stmt->execute([$userId]);

$patient = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$patient) {
    header("Location: logout.php");
    exit;
}

$firstName = $patient["first_name"];
$email = $patient["email"];

// Escape output for safe HTML display
function escapeHtml($value)
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

    <title>Patient Profile | HealthBridge Medical</title>

    <!-- Master CSS -->
    <link rel="stylesheet" href="../css/style.css?v=4">

    <link
        rel="icon"
        type="image/x-icon"
        href="../images/favicon.ico"
    >

</head>

<body>

    <!-- HEADER -->

    <header>

        <div class="utility-bar">

            <div class="utility-content">

                <div class="utility-left">

                    <a href="../html/contact.php">
                        Support Center
                    </a>

                    <span>|</span>

                    <span>Language: English</span>

                </div>

                <div class="utility-right">

                    <span>
                        Welcome,
                        <?php echo escapeHtml($firstName); ?>
                    </span>

                    <a
                        href="logout.php"
                        class="login-button"
                    >
                        Logout
                    </a>

                </div>

            </div>

        </div>


        <div class="main-header">

            <nav>

                <div class="logo">
                    <h1>HealthBridge Medical</h1>
                </div>

                <ul class="nav-links">

                    <li>
                        <a href="../index.php">Home</a>
                    </li>

                    <li>
                        <a href="../html/services.php">Services</a>
                    </li>

                    <li>
                        <a href="../html/membership.php">Memberships</a>
                    </li>

                    <li>
                        <a href="../html/appointment.php">Appointments</a>
                    </li>

                    <li>
                        <a href="../html/contact.php">Contact</a>
                    </li>

                </ul>

            </nav>

        </div>

    </header>


    <!-- PATIENT PROFILE -->

    <main>

        <section class="profile-page">

            <a
                href="dashboard.php"
                class="profile-back"
            >
                &larr; Back to Dashboard
            </a>


            <div class="profile-header">

                <h2>My Patient Profile</h2>

                <p>
                    Manage your personal information,
                    billing details, and medical records.
                </p>

            </div>


            <!-- PATIENT OVERVIEW -->

            <div class="profile-overview">

                <div class="profile-avatar">

                    <?php
                    echo escapeHtml(
                        strtoupper(substr($firstName, 0, 1))
                    );
                    ?>

                </div>

                <div>

                    <h3>
                        <?php echo escapeHtml($firstName); ?>
                    </h3>

                    <p>
                        <?php echo escapeHtml($email); ?>
                    </p>

                    <span class="profile-status">
                        Patient Account
                    </span>

                </div>

            </div>


            <div class="profile-grid">


                <!-- PERSONAL INFORMATION -->

                <div class="profile-card">

                    <h3>Personal Information</h3>

                    <p class="profile-description">
                        View your account details and personal
                        contact information.
                    </p>


                    <div class="profile-field">

                        <label for="profile-first-name">
                            First Name
                        </label>

                        <input
                            type="text"
                            id="profile-first-name"
                            value="<?php echo escapeHtml($firstName); ?>"
                            disabled
                        >

                    </div>


                    <div class="profile-field">

                        <label for="profile-email">
                            Email Address
                        </label>

                        <input
                            type="email"
                            id="profile-email"
                            value="<?php echo escapeHtml($email); ?>"
                            disabled
                        >

                    </div>


                    <div class="profile-field">

                        <label for="profile-phone">
                            Phone Number
                        </label>

                        <input
                            type="tel"
                            id="profile-phone"
                            placeholder="Not provided"
                            disabled
                        >

                    </div>


                    <div class="profile-field">

                        <label for="profile-dob">
                            Date of Birth
                        </label>

                        <input
                            type="text"
                            id="profile-dob"
                            placeholder="Not provided"
                            disabled
                        >

                    </div>


                    <div class="profile-field">

                        <label for="profile-emergency">
                            Emergency Contact
                        </label>

                        <input
                            type="text"
                            id="profile-emergency"
                            placeholder="Not provided"
                            disabled
                        >

                    </div>


                    <div class="profile-notice">
                        Profile editing will be available once
                        the additional patient information
                        fields are connected to the database.
                    </div>

                    <button
                        type="button"
                        class="profile-button"
                        disabled
                    >
                        Edit Personal Information
                    </button>

                </div>


                <!-- ADDRESS INFORMATION -->

                <div class="profile-card">

                    <h3>Address Information</h3>

                    <p class="profile-description">
                        Manage your residential and
                        billing address information.
                    </p>


                    <div class="profile-field">

                        <label for="profile-street">
                            Street Address
                        </label>

                        <input
                            type="text"
                            id="profile-street"
                            placeholder="Not provided"
                            disabled
                        >

                    </div>


                    <div class="profile-field">

                        <label for="profile-apartment">
                            Apartment / Suite
                        </label>

                        <input
                            type="text"
                            id="profile-apartment"
                            placeholder="Optional"
                            disabled
                        >

                    </div>


                    <div class="profile-row">

                        <div class="profile-field">

                            <label for="profile-city">
                                City
                            </label>

                            <input
                                type="text"
                                id="profile-city"
                                placeholder="Not provided"
                                disabled
                            >

                        </div>


                        <div class="profile-field">

                            <label for="profile-state">
                                State
                            </label>

                            <input
                                type="text"
                                id="profile-state"
                                placeholder="Not provided"
                                disabled
                            >

                        </div>

                    </div>


                    <div class="profile-field">

                        <label for="profile-zip">
                            ZIP Code
                        </label>

                        <input
                            type="text"
                            id="profile-zip"
                            placeholder="Not provided"
                            disabled
                        >

                    </div>


                    <div class="profile-notice">
                        Address information will be saved
                        to your patient profile once
                        database integration is complete.
                    </div>

                    <button
                        type="button"
                        class="profile-button"
                        disabled
                    >
                        Edit Address
                    </button>

                </div>


                <!-- BILLING AND INSURANCE -->

                <div class="profile-card">

                    <h3>Billing &amp; Insurance</h3>

                    <p class="profile-description">
                        Manage your insurance information,
                        billing address, and payment details.
                    </p>


                    <div class="profile-field">

                        <label for="profile-insurance">
                            Insurance Provider
                        </label>

                        <input
                            type="text"
                            id="profile-insurance"
                            placeholder="Not provided"
                            disabled
                        >

                    </div>


                    <div class="profile-field">

                        <label for="profile-policy">
                            Insurance Policy Number
                        </label>

                        <input
                            type="text"
                            id="profile-policy"
                            placeholder="Not provided"
                            disabled
                        >

                    </div>


                    <div class="profile-field">

                        <label for="profile-billing-address">
                            Billing Address
                        </label>

                        <input
                            type="text"
                            id="profile-billing-address"
                            placeholder="Not provided"
                            disabled
                        >

                    </div>


                    <div class="profile-field">

                        <label for="profile-payment">
                            Payment Method
                        </label>

                        <input
                            type="text"
                            id="profile-payment"
                            placeholder="No payment method on file"
                            disabled
                        >

                    </div>


                    <div class="profile-notice">
                        Billing and insurance features are
                        currently demonstration placeholders.
                        Do not enter real payment-card or
                        insurance information.
                    </div>

                    <button
                        type="button"
                        class="profile-button"
                        disabled
                    >
                        Manage Billing
                    </button>

                </div>


                <!-- MEDICAL RECORDS -->

                <div class="profile-card">

                    <h3>Medical Records</h3>

                    <p class="profile-description">
                        Access your medical history,
                        medications, allergies, and
                        healthcare visit summaries.
                    </p>


                    <div class="profile-record">

                        <h4>Medical History</h4>

                        <p>
                            No medical history is currently
                            available in your patient profile.
                        </p>

                    </div>


                    <div class="profile-record">

                        <h4>Medications</h4>

                        <p>
                            No medication records are
                            currently available.
                        </p>

                    </div>


                    <div class="profile-record">

                        <h4>Allergies</h4>

                        <p>
                            No allergy information has
                            been added to your profile.
                        </p>

                    </div>


                    <div class="profile-record">

                        <h4>Test Results</h4>

                        <p>
                            No test results are
                            currently available.
                        </p>

                    </div>


                    <div class="profile-record">

                        <h4>Visit Summaries</h4>

                        <p>
                            No medical visit summaries
                            are currently available.
                        </p>

                    </div>


                    <div class="profile-notice">
                        Medical records will be connected
                        to the patient database in a
                        future development stage.
                    </div>

                </div>


                <!-- ACCOUNT SECURITY -->

                <div class="profile-card profile-full-width">

                    <h3>Account Security</h3>

                    <p class="profile-description">
                        Manage your HealthBridge Medical
                        account security and login settings.
                    </p>


                    <div class="profile-field">

                        <label for="security-email">
                            Account Email
                        </label>

                        <input
                            type="email"
                            id="security-email"
                            value="<?php echo escapeHtml($email); ?>"
                            disabled
                        >

                    </div>


                    <div class="profile-record">

                        <h4>Password</h4>

                        <p>
                            Your account password is protected
                            and is not displayed.
                        </p>

                    </div>


                    <div class="profile-notice">
                        Password management options will
                        be added in a future update.
                    </div>


                    <a
                        href="logout.php"
                        class="profile-button"
                    >
                        Logout of Account
                    </a>

                </div>


            </div>

        </section>

    </main>


    <!-- FOOTER -->

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

                    <a href="../html/about.php">About</a>

                    <a href="../html/contact.php">Contact</a>

                    <a href="../html/membership.php">Memberships</a>

                    <a href="../html/privacy.php">Privacy Policy</a>

                    <a href="../html/terms.php">Terms and Conditions</a>

                    <a href="../html/accessibility.php">Accessibility</a>

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


    <!-- CHATBOT -->

    <?php require_once "chatbot-widget.php"; ?>


    <!-- JAVASCRIPT -->

    <script src="../js/script.js?v=4"></script>

</body>

</html>
