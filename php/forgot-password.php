<?php

session_start();

require_once "/etc/healthbridge/db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../html/forgot-password.php");
    exit;
}

$email = trim($_POST["email"] ?? "");

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Please enter a valid email address.");
}

$stmt = $pdo->prepare(
    "SELECT id
     FROM users
     WHERE email = ?"
);

$stmt->execute([$email]);

$user = $stmt->fetch();

if (!$user) {
    header("Location: ../html/forgot-password.php?sent=1");
    exit;
}

$userId = $user["id"];

$token = bin2hex(random_bytes(32));

$tokenHash = hash("sha256", $token);

$expiresAt = date(
    "Y-m-d H:i:s",
    time() + 3600
);

$stmt = $pdo->prepare(
    "INSERT INTO password_resets
        (user_id, token_hash, expires_at)
     VALUES
        (?, ?, ?)"
);

$stmt->execute([
    $userId,
    $tokenHash,
    $expiresAt
]);

header(
    "Location: ../html/reset-password.php?token=" .
    urlencode($token)
);

exit;

?>
