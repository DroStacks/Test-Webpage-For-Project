<?php

session_start();

require_once "/etc/healthbridge/db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../html/forgot-password.php");
    exit;
}

$token = trim($_POST["token"] ?? "");
$password = $_POST["password"] ?? "";
$confirmPassword = $_POST["confirm_password"] ?? "";

if ($token === "") {
    die("Invalid password reset request.");
}

if ($password === "" || $confirmPassword === "") {
    die("Please complete both password fields.");
}

if ($password !== $confirmPassword) {
    die("Passwords do not match.");
}

if (strlen($password) < 8) {
    die("Password must be at least 8 characters long.");
}

$tokenHash = hash("sha256", $token);

$stmt = $pdo->prepare(
    "SELECT
        id,
        user_id,
        expires_at,
        used_at
     FROM password_resets
     WHERE token_hash = ?
     LIMIT 1"
);

$stmt->execute([$tokenHash]);

$resetRequest = $stmt->fetch();

if (!$resetRequest) {
    die("This password reset link is invalid.");
}

if ($resetRequest["used_at"] !== null) {
    die("This password reset link has already been used.");
}

if (strtotime($resetRequest["expires_at"]) < time()) {
    die("This password reset link has expired.");
}

$newPasswordHash = password_hash(
    $password,
    PASSWORD_DEFAULT
);

$pdo->beginTransaction();

try {

    $stmt = $pdo->prepare(
        "UPDATE users
         SET password_hash = ?
         WHERE id = ?"
    );

    $stmt->execute([
        $newPasswordHash,
        $resetRequest["user_id"]
    ]);

    $stmt = $pdo->prepare(
        "UPDATE password_resets
         SET used_at = NOW()
         WHERE id = ?"
    );

    $stmt->execute([
        $resetRequest["id"]
    ]);

    $pdo->commit();

} catch (Throwable $e) {

    $pdo->rollBack();

    die("Unable to reset password. Please try again.");
}

header("Location: ../html/login.php?reset=success");
exit;

?>
