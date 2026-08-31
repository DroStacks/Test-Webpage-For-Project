<?php

session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: ../html/login.php");
    exit;
}

require_once "/etc/healthbridge/db.php";

$userId = $_SESSION["user_id"];
$firstName = $_SESSION["first_name"];
$email = $_SESSION["email"] ?? "";

// Get this user's membership information
$stmt = $pdo->prepare(
    "SELECT
        membership_plan,
        membership_status,
        membership_started_at
     FROM users
     WHERE id = ?"
);

$stmt->execute([$userId]);

$membership = $stmt->fetch();


// Get this user's upcoming active appointments
$stmt = $pdo->prepare(
    "SELECT
        id,
        appointment_date,
        appointment_time,
        service,
        reason,
        status
     FROM appointments
     WHERE user_id = ?
       AND appointment_date >= CURDATE()
       AND status = 'Scheduled'
     ORDER BY appointment_date ASC, appointment_time ASC"
);

$stmt->execute([$userId]);

$appointments = $stmt->fetchAll();


// Get this user's appointment history
$stmt = $pdo->prepare(
    "SELECT
        id,
        appointment_date,
        appointment_time,
        service,
        reason,
        status
     FROM appointments
     WHERE user_id = ?
       AND (
            appointment_date < CURDATE()
            OR status <> 'Scheduled'
       )
     ORDER BY appointment_date DESC, appointment_time DESC"
);

$stmt->execute([$userId]);

$appointmentHistory = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Patient Dashboard | HealthBridge Medical</title>

    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" type="image/x-icon" href="../images/favicon.ico">
</head>

<body>

    <header>

        <div class="utility-bar">
            <div class="utility-content">

                <div class="utility-left">
                    <a href="../html/contact.php">Support Center</a>
                    <span>|</span>
                    <span>Language: English</span>
                </div>

                <div class="utility-right">

                    <span>
                        Welcome,
                        <?php echo htmlspecialchars(
                            $firstName,
                            ENT_QUOTES,
                            "UTF-8"
                        ); ?>
                    </span>

                    <a href="logout.php" class="login-button">
                        Logout
                    </a>

                </div>

            </div>
        </div>


        <div class="main-header">

            <nav>

                <div class="logo">
                    <h1>HealthBridge Medical</h1>
                </div>

                <ul class="nav-links">
                    <li><a href="../index.php">Home</a></li>
                    <li><a href="../html/services.php">Services</a></li>
                    <li><a href="../html/membership.php">Memberships</a></li>
                    <li><a href="../html/appointment.php">Appointments</a></li>
                    <li><a href="../html/contact.php">Contact</a></li>
                </ul>

            </nav>

        </div>

    </header>


    <main>

        <section class="dashboard-page">

            <div class="dashboard-welcome">

                <h2>
                    Welcome,
                    <?php echo htmlspecialchars(
                        $firstName,
                        ENT_QUOTES,
                        "UTF-8"
                    ); ?>!
                </h2>

                <p>
                    Manage your HealthBridge Medical account,
                    appointments, and patient services.
                </p>

            </div>


            <?php if (
                isset($_GET["appointment"]) &&
                $_GET["appointment"] === "success"
            ): ?>

                <div class="dashboard-success">
                    Your appointment request was submitted successfully.
                </div>

            <?php endif; ?>


            <?php if (
                isset($_GET["appointment"]) &&
                $_GET["appointment"] === "cancelled"
            ): ?>

                <div class="dashboard-success">
                    Your appointment was cancelled successfully.
                </div>

            <?php endif; ?>


            <?php if (
                isset($_GET["membership"]) &&
                $_GET["membership"] === "success"
            ): ?>

                <div class="dashboard-success">
                    Your HealthBridge Medical membership was activated successfully.
                </div>

            <?php endif; ?>


            <div class="dashboard-grid">

                <div class="dashboard-section">

                    <h3>Upcoming Appointments</h3>

                    <?php if (count($appointments) > 0): ?>

                        <div class="appointment-list">

                            <?php foreach ($appointments as $appointment): ?>

                                <?php

                                $serviceNames = [
                                    "primary-care" => "Primary Care",
                                    "preventive-care" => "Preventive Care",
                                    "family-medicine" => "Family Medicine"
                                ];

                                $serviceName =
                                    $serviceNames[$appointment["service"]]
                                    ?? $appointment["service"];

                                $formattedDate = date(
                                    "F j, Y",
                                    strtotime($appointment["appointment_date"])
                                );

                                $formattedTime = date(
                                    "g:i A",
                                    strtotime($appointment["appointment_time"])
                                );

                                ?>

                                <div class="appointment-item">

                                    <div class="appointment-item-header">

                                        <h4>
                                            <?php echo htmlspecialchars(
                                                $serviceName,
                                                ENT_QUOTES,
                                                "UTF-8"
                                            ); ?>
                                        </h4>

                                        <span class="appointment-status">
                                            <?php echo htmlspecialchars(
                                                $appointment["status"],
                                                ENT_QUOTES,
                                                "UTF-8"
                                            ); ?>
                                        </span>

                                    </div>


                                    <p>
                                        <strong>Date:</strong>

                                        <?php echo htmlspecialchars(
                                            $formattedDate,
                                            ENT_QUOTES,
                                            "UTF-8"
                                        ); ?>
                                    </p>


                                    <p>
                                        <strong>Time:</strong>

                                        <?php echo htmlspecialchars(
                                            $formattedTime,
                                            ENT_QUOTES,
                                            "UTF-8"
                                        ); ?>
                                    </p>


                                    <p>
                                        <strong>Reason:</strong>

                                        <?php echo htmlspecialchars(
                                            $appointment["reason"],
                                            ENT_QUOTES,
                                            "UTF-8"
                                        ); ?>
                                    </p>


                                    <?php if (
                                        $appointment["status"] === "Scheduled"
                                    ): ?>

                                        <form
                                            action="cancel-appointment.php"
                                            method="post"
                                            class="cancel-appointment-form"
                                        >

                                            <input
                                                type="hidden"
                                                name="appointment_id"
                                                value="<?php echo (int) $appointment["id"]; ?>"
                                            >

                                            <button
                                                type="submit"
                                                class="dashboard-button dashboard-cancel"
                                            >
                                                Cancel Appointment
                                            </button>

                                        </form>

                                    <?php endif; ?>

                                </div>

                            <?php endforeach; ?>

                        </div>

                    <?php else: ?>

                        <p class="dashboard-empty">
                            You currently have no upcoming appointments.
                        </p>

                    <?php endif; ?>


                    <a
                        href="../html/appointment.php"
                        class="dashboard-button"
                    >
                        Schedule an Appointment
                    </a>

                                </div>


                <div class="dashboard-section">

                    <h3>Appointment History</h3>

                    <?php if (count($appointmentHistory) > 0): ?>

                        <div class="appointment-list">

                            <?php foreach ($appointmentHistory as $appointment): ?>

                                <?php

                                $serviceNames = [
                                    "primary-care" => "Primary Care",
                                    "preventive-care" => "Preventive Care",
                                    "family-medicine" => "Family Medicine"
                                ];

                                $serviceName =
                                    $serviceNames[$appointment["service"]]
                                    ?? $appointment["service"];

                                $formattedDate = date(
                                    "F j, Y",
                                    strtotime($appointment["appointment_date"])
                                );

                                $formattedTime = date(
                                    "g:i A",
                                    strtotime($appointment["appointment_time"])
                                );

                                ?>

                                <div class="appointment-item">

                                    <div class="appointment-item-header">

                                        <h4>
                                            <?php echo htmlspecialchars(
                                                $serviceName,
                                                ENT_QUOTES,
                                                "UTF-8"
                                            ); ?>
                                        </h4>

                                        <span class="appointment-status">
                                            <?php echo htmlspecialchars(
                                                $appointment["status"],
                                                ENT_QUOTES,
                                                "UTF-8"
                                            ); ?>
                                        </span>

                                    </div>

                                    <p>
                                        <strong>Date:</strong>

                                        <?php echo htmlspecialchars(
                                            $formattedDate,
                                            ENT_QUOTES,
                                            "UTF-8"
                                        ); ?>
                                    </p>

                                    <p>
                                        <strong>Time:</strong>

                                        <?php echo htmlspecialchars(
                                            $formattedTime,
                                            ENT_QUOTES,
                                            "UTF-8"
                                        ); ?>
                                    </p>

                                    <p>
                                        <strong>Reason:</strong>

                                        <?php echo htmlspecialchars(
                                            $appointment["reason"],
                                            ENT_QUOTES,
                                            "UTF-8"
                                        ); ?>
                                    </p>

                                </div>

                            <?php endforeach; ?>

                        </div>

                    <?php else: ?>

                        <p class="dashboard-empty">
                            You do not have any appointment history yet.
                        </p>

                    <?php endif; ?>

                </div>


                <div class="dashboard-section">

                    <h3>Account Information</h3>

                    <p>
                        <strong>Name:</strong>

                        <?php echo htmlspecialchars(
                            $firstName,
                            ENT_QUOTES,
                            "UTF-8"
                        ); ?>
                    </p>

                    <p>
                        <strong>Email:</strong>

                        <?php echo htmlspecialchars(
                            $email,
                            ENT_QUOTES,
                            "UTF-8"
                        ); ?>
                    </p>

                </div>


                <div class="dashboard-section">

                    <h3>Membership</h3>

                    <?php if (
                        !empty($membership["membership_plan"]) &&
                        $membership["membership_status"] === "Active"
                    ): ?>

                        <p>
                            <strong>Plan:</strong>

                            <?php echo htmlspecialchars(
                                $membership["membership_plan"],
                                ENT_QUOTES,
                                "UTF-8"
                            ); ?>
                        </p>


                        <p>
                            <strong>Status:</strong>

                            <?php echo htmlspecialchars(
                                $membership["membership_status"],
                                ENT_QUOTES,
                                "UTF-8"
                            ); ?>
                        </p>


                        <?php if (
                            !empty($membership["membership_started_at"])
                        ): ?>

                            <p>
                                <strong>Member Since:</strong>

                                <?php echo htmlspecialchars(
                                    date(
                                        "F j, Y",
                                        strtotime(
                                            $membership["membership_started_at"]
                                        )
                                    ),
                                    ENT_QUOTES,
                                    "UTF-8"
                                ); ?>
                            </p>

                        <?php endif; ?>


                        <a
                            href="../html/membership.php"
                            class="dashboard-button"
                        >
                            View Membership Plans
                        </a>

                    <?php else: ?>

                        <p class="dashboard-empty">
                            You do not currently have an active membership.
                        </p>

                        <a
                            href="../html/membership.php"
                            class="dashboard-button"
                        >
                            View Membership Plans
                        </a>

                    <?php endif; ?>

                </div>


                <div class="dashboard-section">

                    <h3>Quick Actions</h3>

                    <div class="dashboard-actions">

                        <a
                            href="../html/appointment.php"
                            class="dashboard-action-link"
                        >
                            Book Appointment
                        </a>

                        <a
                            href="../html/services.php"
                            class="dashboard-action-link"
                        >
                            View Services
                        </a>

                        <a
                            href="../html/membership.php"
                            class="dashboard-action-link"
                        >
                            View Memberships
                        </a>

                        <a
                            href="../html/contact.php"
                            class="dashboard-action-link"
                        >
                            Contact Support
                        </a>

                    </div>

                </div>


                <div class="dashboard-section">

                    <h3>Patient Account</h3>

                    <p>
                        Securely access your HealthBridge Medical
                        patient portal.
                    </p>

                    <a
                        href="logout.php"
                        class="dashboard-button dashboard-logout"
                    >
                        Logout
                    </a>

                </div>

            </div>

        </section>

    </main>

</body>

</html>
