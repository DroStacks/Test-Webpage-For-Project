<?php

session_start();

require_once "/etc/healthbridge/db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../html/login.php");
    exit;
}

$email = trim($_POST["email"] ?? "");
$password = $_POST["password"] ?? "";


/* ========================================
   BASIC VALIDATION
======================================== */

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Please enter a valid email address.");
}

if ($password === "") {
    die("Please enter your password.");
}


/* ========================================
   FIND USER
======================================== */

$stmt = $pdo->prepare(
    "SELECT id, first_name, last_name, email, password_hash
     FROM users
     WHERE email = ?"
);

$stmt->execute([$email]);

$user = $stmt->fetch();


/* ========================================
   VERIFY LOGIN
======================================== */

if (!$user || !password_verify($password, $user["password_hash"])) {
    die("Invalid email or password.");
}


/* ========================================
   CREATE SESSION
======================================== */

session_regenerate_id(true);

$_SESSION["user_id"] = $user["id"];
$_SESSION["first_name"] = $user["first_name"];
$_SESSION["email"] = $user["email"];


/* ========================================
   LOGIN SUCCESS
======================================== */

header("Location: dashboard.php");
exit;

?>
