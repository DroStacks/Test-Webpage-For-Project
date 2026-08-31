<?php

session_start();

require_once "/etc/healthbridge/db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../html/contact.php");
    exit;
}

$userId = $_SESSION["user_id"] ?? null;

$name = trim($_POST["name"] ?? "");
$email = trim($_POST["email"] ?? "");
$subject = trim($_POST["subject"] ?? "");
$message = trim($_POST["message"] ?? "");

if (
    $name === "" ||
    $email === "" ||
    $subject === "" ||
    $message === ""
) {
    die("Please complete all contact form fields.");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Please enter a valid email address.");
}

if (strlen($name) < 2) {
    die("Please enter your full name.");
}

if (strlen($subject) < 3) {
    die("Please enter a valid subject.");
}

if (strlen($message) < 10) {
    die("Please enter a longer message.");
}

$stmt = $pdo->prepare(
    "INSERT INTO contact_messages
        (user_id, name, email, subject, message)
     VALUES
        (?, ?, ?, ?, ?)"
);

$stmt->execute([
    $userId,
    $name,
    $email,
    $subject,
    $message
]);

header("Location: ../html/contact.php?message=success");
exit;

?>
