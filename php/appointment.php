<?php

session_start();

// --------------------------------------------------
// REQUIRE LOGIN
// --------------------------------------------------

if (!isset($_SESSION["user_id"])) {
    header("Location: ../html/login.php");
    exit;
}

require_once "/etc/healthbridge/db.php";

// --------------------------------------------------
// ONLY ALLOW POST REQUESTS
// --------------------------------------------------

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../html/appointment.php");
    exit;
}

$userId = $_SESSION["user_id"];

// --------------------------------------------------
// CSRF VALIDATION
// --------------------------------------------------

$submittedToken = $_POST["csrf_token"] ?? "";
$sessionToken = $_SESSION["appointment_csrf_token"] ?? "";

if (
    $sessionToken === "" ||
    $submittedToken === "" ||
    !hash_equals($sessionToken, $submittedToken)
) {
    $_SESSION["appointment_error"] =
        "Your session could not be verified. Please try again.";

    header("Location: ../html/appointment.php");
    exit;
}

// --------------------------------------------------
// COLLECT FORM DATA
// --------------------------------------------------

$firstName =
    trim($_POST["first_name"] ?? "");

$lastName =
    trim($_POST["last_name"] ?? "");

$email =
    trim($_POST["email"] ?? "");

$phone =
    trim($_POST["phone"] ?? "");

$service =
    trim($_POST["service"] ?? "");

$appointmentDate =
    trim($_POST["appointment_date"] ?? "");

$appointmentTime =
    trim($_POST["appointment_time"] ?? "");

$reason =
    trim($_POST["reason"] ?? "");

// Preserve submitted values if validation fails.

$_SESSION["appointment_old"] = [
    "first_name" => $firstName,
    "last_name" => $lastName,
    "email" => $email,
    "phone" => $phone,
    "service" => $service,
    "appointment_date" => $appointmentDate,
    "appointment_time" => $appointmentTime,
    "reason" => $reason
];

// --------------------------------------------------
// REQUIRED FIELD VALIDATION
// --------------------------------------------------

if (
    $firstName === "" ||
    $lastName === "" ||
    $email === "" ||
    $phone === "" ||
    $service === "" ||
    $appointmentDate === "" ||
    $appointmentTime === "" ||
    $reason === ""
) {
    $_SESSION["appointment_error"] =
        "Please complete all required appointment fields.";

    header("Location: ../html/appointment.php");
    exit;
}

// --------------------------------------------------
// LENGTH VALIDATION
// --------------------------------------------------

if (
    strlen($firstName) > 50 ||
    strlen($lastName) > 50
) {
    $_SESSION["appointment_error"] =
        "First name and last name must be 50 characters or fewer.";

    header("Location: ../html/appointment.php");
    exit;
}

if (strlen($email) > 255) {
    $_SESSION["appointment_error"] =
        "Email address is too long.";

    header("Location: ../html/appointment.php");
    exit;
}

if (strlen($phone) > 25) {
    $_SESSION["appointment_error"] =
        "Phone number must be 25 characters or fewer.";

    header("Location: ../html/appointment.php");
    exit;
}

if (strlen($reason) > 2000) {
    $_SESSION["appointment_error"] =
        "Reason for visit must be 2000 characters or fewer.";

    header("Location: ../html/appointment.php");
    exit;
}

// --------------------------------------------------
// EMAIL VALIDATION
// --------------------------------------------------

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION["appointment_error"] =
        "Please enter a valid email address.";

    header("Location: ../html/appointment.php");
    exit;
}

// --------------------------------------------------
// SERVICE VALIDATION
// --------------------------------------------------

$allowedServices = [
    "primary-care",
    "preventive-care",
    "family-medicine"
];

if (!in_array($service, $allowedServices, true)) {
    $_SESSION["appointment_error"] =
        "Please select a valid service.";

    header("Location: ../html/appointment.php");
    exit;
}

// --------------------------------------------------
// DATE VALIDATION
// --------------------------------------------------

$date =
    DateTime::createFromFormat(
        "Y-m-d",
        $appointmentDate
    );

$dateErrors =
    DateTime::getLastErrors();

$dateIsValid =
    $date !== false &&
    (
        $dateErrors === false ||
        (
            $dateErrors["warning_count"] === 0 &&
            $dateErrors["error_count"] === 0
        )
    ) &&
    $date->format("Y-m-d") === $appointmentDate;

if (!$dateIsValid) {
    $_SESSION["appointment_error"] =
        "Please select a valid appointment date.";

    header("Location: ../html/appointment.php");
    exit;
}

$today = new DateTime("today");

if ($date < $today) {
    $_SESSION["appointment_error"] =
        "Appointment date cannot be in the past.";

    header("Location: ../html/appointment.php");
    exit;
}

// --------------------------------------------------
// TIME VALIDATION
// --------------------------------------------------

$time =
    DateTime::createFromFormat(
        "H:i",
        $appointmentTime
    );

$timeErrors =
    DateTime::getLastErrors();

$timeIsValid =
    $time !== false &&
    (
        $timeErrors === false ||
        (
            $timeErrors["warning_count"] === 0 &&
            $timeErrors["error_count"] === 0
        )
    ) &&
    $time->format("H:i") === $appointmentTime;

if (!$timeIsValid) {
    $_SESSION["appointment_error"] =
        "Please select a valid appointment time.";

    header("Location: ../html/appointment.php");
    exit;
}

// --------------------------------------------------
// PREVENT PAST TIME TODAY
// --------------------------------------------------

$requestedDateTime =
    DateTime::createFromFormat(
        "Y-m-d H:i",
        $appointmentDate . " " . $appointmentTime
    );

$now = new DateTime();

if (
    $requestedDateTime !== false &&
    $requestedDateTime < $now
) {
    $_SESSION["appointment_error"] =
        "Appointment time cannot be in the past.";

    header("Location: ../html/appointment.php");
    exit;
}

// --------------------------------------------------
// SAVE APPOINTMENT REQUEST
// --------------------------------------------------

try {

    $stmt = $pdo->prepare(
        "INSERT INTO appointments (
            user_id,
            first_name,
            last_name,
            email,
            phone,
            appointment_date,
            appointment_time,
            service,
            reason,
            status
        )
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pending')"
    );

    $stmt->execute([
        $userId,
        $firstName,
        $lastName,
        $email,
        $phone,
        $appointmentDate,
        $appointmentTime,
        $service,
        $reason
    ]);

    // Clear old form data after successful submission.
    unset($_SESSION["appointment_old"]);

    // Rotate token after successful request.
    $_SESSION["appointment_csrf_token"] =
        bin2hex(random_bytes(32));

    header(
        "Location: ../html/appointment.php?appointment=success"
    );
    exit;

} catch (PDOException $e) {

    $_SESSION["appointment_error"] =
        "We could not submit your appointment request at this time. Please try again.";

    header("Location: ../html/appointment.php");
    exit;
}
