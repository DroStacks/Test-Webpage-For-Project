<?php

require_once "/etc/healthbridge/db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../html/register.php");
    exit;
}

$firstName = trim($_POST["first_name"] ?? "");
$lastName = trim($_POST["last_name"] ?? "");
$email = trim($_POST["email"] ?? "");
$phone = trim($_POST["phone"] ?? "");
$password = $_POST["password"] ?? "";
$confirmPassword = $_POST["confirm_password"] ?? "";

if (
    $firstName === "" ||
    $lastName === "" ||
    $email === "" ||
    $password === "" ||
    $confirmPassword === ""
) {
    die("Please complete all required fields.");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Please enter a valid email address.");
}

if ($password !== $confirmPassword) {
    die("Passwords do not match.");
}

if (strlen($password) < 8) {
    die("Password must be at least 8 characters long.");
}

$stmt = $pdo->prepare(
    "SELECT id
     FROM users
     WHERE email = ?"
);

$stmt->execute([$email]);

if ($stmt->fetch()) {
    die("An account already exists with this email address.");
}

$passwordHash = password_hash(
    $password,
    PASSWORD_DEFAULT
);

$stmt = $pdo->prepare(
    "INSERT INTO users
        (first_name, last_name, email, phone, password_hash)
     VALUES
        (?, ?, ?, ?, ?)"
);

$stmt->execute([
    $firstName,
    $lastName,
    $email,
    $phone,
    $passwordHash
]);

header("Location: ../html/login.php?registered=1");
exit;
?>
