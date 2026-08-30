<?php

session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: ../html/login.php");
    exit;
}

$firstName = $_SESSION["first_name"];

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
                        <?php
                        echo htmlspecialchars(
                            $firstName,
                            ENT_QUOTES,
                            "UTF-8"
                        );
                        ?>
                    </span>
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
                </ul>

            </nav>

        </div>

    </header>


    <main>

        <section class="dashboard-page">

            <div class="dashboard-card">

                <h2>
                    Welcome,
                    <?php
                    echo htmlspecialchars(
                        $firstName,
                        ENT_QUOTES,
                        "UTF-8"
                    );
                    ?>!
                </h2>

                <p>
                    You are successfully signed in to your
                    HealthBridge Medical patient account.
                </p>

            </div>

        </section>

    </main>

</body>

</html>
