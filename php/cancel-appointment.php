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
// ONLY ALLOW POST
// --------------------------------------------------

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: dashboard.php");
    exit;
}

$userId = $_SESSION["user_id"];

// --------------------------------------------------
// CSRF VALIDATION
// --------------------------------------------------

$submittedToken =
    $_POST["csrf_token"] ?? "";

$sessionToken =
    $_SESSION["dashboard_csrf_token"] ?? "";

if (
    $submittedToken === "" ||
    $sessionToken === "" ||
    !hash_equals(
        $sessionToken,
        $submittedToken
    )
) {

    header(
        "Location: dashboard.php?appointment=csrf_error"
    );
    exit;
}

// --------------------------------------------------
// VALIDATE APPOINTMENT ID
// --------------------------------------------------

$appointmentId =
    filter_input(
        INPUT_POST,
        "appointment_id",
        FILTER_VALIDATE_INT
    );

if (!$appointmentId) {

    header(
        "Location: dashboard.php?appointment=invalid"
    );
    exit;
}

// --------------------------------------------------
// FIND APPOINTMENT
// --------------------------------------------------

try {

    $stmt = $pdo->prepare(
        "SELECT
            id,
            status,
            appointment_date
         FROM appointments
         WHERE id = ?
         AND user_id = ?
         LIMIT 1"
    );

    $stmt->execute([
        $appointmentId,
        $userId
    ]);

    $appointment =
        $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$appointment) {

        header(
            "Location: dashboard.php?appointment=not_found"
        );
        exit;
    }

    // --------------------------------------------------
    // ONLY ACTIVE APPOINTMENTS CAN BE CANCELLED
    // --------------------------------------------------

    $cancellableStatuses = [
        "Pending",
        "Confirmed"
    ];

    if (
        !in_array(
            $appointment["status"],
            $cancellableStatuses,
            true
        )
    ) {

        header(
            "Location: dashboard.php?appointment=cannot_cancel"
        );
        exit;
    }

    // Do not allow cancellation of past appointments.

    if (
        $appointment["appointment_date"] <
        date("Y-m-d")
    ) {

        header(
            "Location: dashboard.php?appointment=cannot_cancel"
        );
        exit;
    }

    // --------------------------------------------------
    // CANCEL APPOINTMENT
    // --------------------------------------------------

    $updateStmt = $pdo->prepare(
        "UPDATE appointments
         SET status = 'Cancelled'
         WHERE id = ?
         AND user_id = ?
         AND status IN ('Pending', 'Confirmed')"
    );

    $updateStmt->execute([
        $appointmentId,
        $userId
    ]);

    if ($updateStmt->rowCount() !== 1) {

        header(
            "Location: dashboard.php?appointment=cannot_cancel"
        );
        exit;
    }

    // Rotate token after successful action.

    $_SESSION["dashboard_csrf_token"] =
        bin2hex(random_bytes(32));

    header(
        "Location: dashboard.php?appointment=cancelled"
    );
    exit;

} catch (PDOException $e) {

    header(
        "Location: dashboard.php?appointment=error"
    );
    exit;
}
?>
