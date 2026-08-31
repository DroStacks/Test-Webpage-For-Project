<?php

session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: ../html/login.php");
    exit;
}

$firstName = $_SESSION["first_name"];
$email = $_SESSION["email"] ?? "";

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


            <div class="dashboard-grid">

                <div class="dashboard-section">

                    <h3>Upcoming Appointments</h3>

                    <p class="dashboard-empty">
                        You currently have no upcoming appointments.
                    </p>

                    <a
                        href="../html/appointment.php"
                        class="dashboard-button"
                    >
                        Schedule an Appointment
                    </a>

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
