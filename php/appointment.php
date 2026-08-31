<?php

session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: ../html/login.php");
    exit;
}

require_once "/etc/healthbridge/db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../html/appointment.php");
    exit;
}

$userId = $_SESSION["user_id"];

$service = trim($_POST["service"] ?? "");
$appointmentDate = trim($_POST["appointment_date"] ?? "");
$appointmentTime = trim($_POST["appointment_time"] ?? "");
$reason = trim($_POST["reason"] ?? "");

if (
    $service === "" ||
    $appointmentDate === "" ||
    $appointmentTime === "" ||
    $reason === ""
) {
    die("Please complete all required appointment fields.");
}

$allowedServices = [
    "primary-care",
    "preventive-care",
    "family-medicine"
];

if (!in_array($service, $allowedServices, true)) {
    die("Invalid service selected.");
}

if (strtotime($appointmentDate) < strtotime(date("Y-m-d"))) {
    die("Appointment date cannot be in the past.");
}

$stmt = $pdo->prepare(
    "INSERT INTO appointments
        (user_id, appointment_date, appointment_time, service, reason)
     VALUES
        (?, ?, ?, ?, ?)"
);

$stmt->execute([
    $userId,
    $appointmentDate,
    $appointmentTime,
    $service,
    $reason
]);

header("Location: dashboard.php?appointment=success");
exit;

?>
