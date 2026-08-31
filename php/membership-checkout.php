<?php

session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: ../html/login.php");
    exit;
}

require_once "/etc/healthbridge/db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../html/membership.php");
    exit;
}

$userId = $_SESSION["user_id"];

$plan = strtolower(trim($_POST["plan"] ?? ""));
$cardName = trim($_POST["card_name"] ?? "");
$cardNumber = preg_replace("/\D/", "", $_POST["card_number"] ?? "");
$expiration = trim($_POST["expiration"] ?? "");
$cvv = preg_replace("/\D/", "", $_POST["cvv"] ?? "");

$allowedPlans = [
    "essential" => "Essential",
    "plus" => "Plus",
    "premier" => "Premier"
];

if (!isset($allowedPlans[$plan])) {
    die("Invalid membership plan selected.");
}

if (
    $cardName === "" ||
    $cardNumber === "" ||
    $expiration === "" ||
    $cvv === ""
) {
    die("Please complete all checkout fields.");
}

/*
 * Mock checkout validation only.
 * No real payment is processed.
 * No card information is stored.
 */

if ($cardNumber !== "4242424242424242") {
    die(
        "For this educational checkout, please use the test card " .
        "4242 4242 4242 4242."
    );
}

if (!preg_match("/^(0[1-9]|1[0-2])\/\d{2}$/", $expiration)) {
    die("Please enter the expiration date in MM/YY format.");
}

if (!preg_match("/^\d{3,4}$/", $cvv)) {
    die("Please enter a valid test CVV.");
}

$membershipName = $allowedPlans[$plan];

$stmt = $pdo->prepare(
    "UPDATE users
     SET
        membership_plan = ?,
        membership_status = 'Active',
        membership_started_at = NOW()
     WHERE id = ?"
);

$stmt->execute([
    $membershipName,
    $userId
]);

header("Location: dashboard.php?membership=success");
exit;

?>
