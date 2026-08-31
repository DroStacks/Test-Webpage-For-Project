<?php

session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: ../html/login.php");
    exit;
}

require_once "/etc/healthbridge/db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: dashboard.php");
    exit;
}

$userId = $_SESSION["user_id"];
$appointmentId = $_POST["appointment_id"] ?? "";

if (
    $appointmentId === "" ||
    !filter_var($appointmentId, FILTER_VALIDATE_INT)
) {
    die("Invalid appointment request.");
}

$stmt = $pdo->prepare(
    "SELECT id, status
     FROM appointments
     WHERE id = ?
       AND user_id = ?
     LIMIT 1"
);

$stmt->execute([
    $appointmentId,
    $userId
]);

$appointment = $stmt->fetch();

if (!$appointment) {
    die("Appointment not found.");
}

if ($appointment["status"] !== "Scheduled") {
    die("This appointment cannot be cancelled.");
}

$stmt = $pdo->prepare(
    "UPDATE appointments
     SET status = 'Cancelled'
     WHERE id = ?
       AND user_id = ?"
);

$stmt->execute([
    $appointmentId,
    $userId
]);

header("Location: dashboard.php?appointment=cancelled");
exit;

?>
