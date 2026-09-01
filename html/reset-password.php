<?php

session_start();

$token = $_GET["token"] ?? "";

if ($token === "") {
    header("Location: forgot-password.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Reset Password | HealthBridge Medical</title>

    <link rel="stylesheet" href="../css/style.css?v=3">
    <link rel="icon" type="image/x-icon" href="../images/favicon.ico">
</head>

<body>

    <header>

        <div class="utility-bar">
            <div class="utility-content">

                <div class="utility-left">
                    <a href="contact.php">Support Center</a>
                    <span>|</span>
                    <span>Language: English</span>
                </div>

                <div class="utility-right">

                    <?php if (isset($_SESSION["user_id"])): ?>

                        <span>
                            Welcome,
                            <?php echo htmlspecialchars(
                                $_SESSION["first_name"],
                                ENT_QUOTES,
                                "UTF-8"
                            ); ?>
                        </span>

                        <a href="../php/dashboard.php">
                            Dashboard
                        </a>

                        <a href="../php/logout.php" class="login-button">
                            Logout
                        </a>

                    <?php else: ?>

                        <a href="register.php">
                            Register
                        </a>

                        <a href="login.php" class="login-button">
                            Patient Login
                        </a>

                    <?php endif; ?>

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
                    <li><a href="about.php">About</a></li>
                    <li><a href="services.php">Services</a></li>
                    <li><a href="membership.php">Memberships</a></li>
                    <li><a href="contact.php">Contact</a></li>
                    <li><a href="appointment.php">Appointments</a></li>
                </ul>

            </nav>

        </div>

    </header>


    <main>

        <section class="forgot-password-page">

            <div class="login-heading">

                <h2>Create a New Password</h2>

                <p>
                    Enter a new password for your HealthBridge Medical account.
                </p>

            </div>


            <form
                class="forgot-password-form"
                action="../php/reset-password.php"
                method="post"
            >

                <input
                    type="hidden"
                    name="token"
                    value="<?php echo htmlspecialchars(
                        $token,
                        ENT_QUOTES,
                        "UTF-8"
                    ); ?>"
                >


                <div class="register-field">

                    <label for="new-password">
                        New Password
                    </label>

                    <input
                        type="password"
                        id="new-password"
                        name="password"
                        placeholder="Enter a new password"
                        minlength="8"
                        required
                    >

                </div>


                <div class="register-field">

                    <label for="confirm-new-password">
                        Confirm New Password
                    </label>

                    <input
                        type="password"
                        id="confirm-new-password"
                        name="confirm_password"
                        placeholder="Confirm your new password"
                        minlength="8"
                        required
                    >

                </div>


                <button type="submit" class="button-submit">
                    Reset Password
                </button>


                <p class="p">

                    Remember your password?

                    <a href="login.php" class="span">
                        Back to Sign In
                    </a>

                </p>

            </form>

        </section>

    </main>


    <footer>

        <div class="footer-main">

            <div class="footer-content">

                <div class="footer-brand">

                    <h2>HealthBridge Medical</h2>

                    <p>
                        Compassionate, reliable healthcare for
                        individuals and families.
                    </p>

                </div>

                <div class="footer-links">

                    <a href="about.php">About</a>
                    <a href="contact.php">Contact</a>
                    <a href="login.php">Patient Login</a>
                    <a href="privacy.php">Privacy Policy</a>
                    <a href="terms.php">Terms and Conditions</a>
                    <a href="accessibility.php">Accessibility</a>

                </div>

            </div>

        </div>


        <div class="footer-bottom">

            <p>
                © 2026 HealthBridge Medical. This website is a mock
                educational project and does not provide real medical services.
            </p>

        </div>

    </footer>

    <?php require_once "../php/chatbot-widget.php"; ?>

<script src="../js/script.js?v=4"></script>
    
</body>

</html>
