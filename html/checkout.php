<?php

session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$plan = strtolower(trim($_GET["plan"] ?? ""));

$plans = [
    "essential" => [
        "name" => "Essential",
        "price" => 39,
        "primary_fee" => 30,
        "virtual_fee" => 25
    ],

    "plus" => [
        "name" => "Plus",
        "price" => 79,
        "primary_fee" => 20,
        "virtual_fee" => 10
    ],

    "premier" => [
        "name" => "Premier",
        "price" => 149,
        "primary_fee" => 0,
        "virtual_fee" => 0
    ]
];

if (!isset($plans[$plan])) {
    header("Location: membership.php");
    exit;
}

$selectedPlan = $plans[$plan];

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Membership Checkout | HealthBridge Medical
    </title>

   <link rel="stylesheet" href="../css/style.css?v=2">

    <link
        rel="icon"
        type="image/x-icon"
        href="../images/favicon.ico"
    >

</head>

<body>


    <header>

        <div class="utility-bar">

            <div class="utility-content">

                <div class="utility-left">

                    <a href="contact.php">
                        Support Center
                    </a>

                    <span>|</span>

                    <span>
                        Language: English
                    </span>

                </div>


                <div class="utility-right">

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

                    <a
                        href="../php/logout.php"
                        class="login-button"
                    >
                        Logout
                    </a>

                </div>

            </div>

        </div>


        <div class="main-header">

            <nav>

                <div class="logo">

                    <h1>
                        HealthBridge Medical
                    </h1>

                </div>


                <ul class="nav-links">

                    <li>
                        <a href="../index.php">
                            Home
                        </a>
                    </li>

                    <li>
                        <a href="about.php">
                            About
                        </a>
                    </li>

                    <li>
                        <a href="services.php">
                            Services
                        </a>
                    </li>

                    <li>
                        <a href="membership.php">
                            Memberships
                        </a>
                    </li>

                    <li>
                        <a href="contact.php">
                            Contact
                        </a>
                    </li>

                    <li>
                        <a href="appointment.php">
                            Appointments
                        </a>
                    </li>

                </ul>

            </nav>

        </div>

    </header>


    <main>


        <section class="membership-hero">

            <div class="membership-hero-content">

                <span class="membership-eyebrow">
                    Membership Checkout
                </span>

                <h2>
                    Complete Your Membership
                </h2>

                <p>
                    Review your selected HealthBridge Medical
                    membership and complete the test checkout below.
                </p>

            </div>

        </section>


        <section class="membership-page">


            <div class="checkout-container">


                <!-- Membership Summary -->

                <div class="checkout-summary">

                    <h3>
                        Membership Summary
                    </h3>


                    <div class="checkout-plan">

                        <div>

                            <span class="checkout-label">
                                Selected Plan
                            </span>

                            <h2>
                                <?php echo htmlspecialchars(
                                    $selectedPlan["name"],
                                    ENT_QUOTES,
                                    "UTF-8"
                                ); ?>
                            </h2>

                        </div>


                        <div class="checkout-price">

                            $<?php echo (int) $selectedPlan["price"]; ?>

                            <span>
                                / month
                            </span>

                        </div>

                    </div>


                    <div class="checkout-details">

                        <p>

                            <strong>
                                Primary Care Visit Fee:
                            </strong>

                            $<?php echo (int) $selectedPlan["primary_fee"]; ?>

                        </p>


                        <p>

                            <strong>
                                Virtual Visit Fee:
                            </strong>

                            $<?php echo (int) $selectedPlan["virtual_fee"]; ?>

                        </p>


                        <p>

                            <strong>
                                Billing:
                            </strong>

                            Monthly

                        </p>

                    </div>

                </div>


                <!-- Test Payment Form -->

                <div class="checkout-payment">

                    <h3>
                        Payment Information
                    </h3>


                    <div class="checkout-test-notice">

                        <strong>
                            Test Checkout Only
                        </strong>

                        <p>
                            Do not enter real credit card information.
                            This educational website does not process
                            real payments or store payment card data.
                        </p>

                    </div>


                    <form
                        action="../php/membership-checkout.php"
                        method="post"
                        class="checkout-form"
                    >


                        <input
                            type="hidden"
                            name="plan"
                            value="<?php echo htmlspecialchars(
                                $plan,
                                ENT_QUOTES,
                                "UTF-8"
                            ); ?>"
                        >


                        <div class="register-field">

                            <label for="card-name">
                                Name on Card
                            </label>

                            <input
                                type="text"
                                id="card-name"
                                name="card_name"
                                placeholder="Test User"
                                autocomplete="off"
                                required
                            >

                        </div>


                        <div class="register-field">

                            <label for="card-number">
                                Test Card Number
                            </label>

                            <input
                                type="text"
                                id="card-number"
                                name="card_number"
                                placeholder="4242 4242 4242 4242"
                                inputmode="numeric"
                                autocomplete="off"
                                maxlength="19"
                                required
                            >

                        </div>


                        <div class="checkout-form-row">


                            <div class="register-field">

                                <label for="expiration">
                                    Expiration
                                </label>

                                <input
                                    type="text"
                                    id="expiration"
                                    name="expiration"
                                    placeholder="12/30"
                                    autocomplete="off"
                                    maxlength="5"
                                    required
                                >

                            </div>


                            <div class="register-field">

                                <label for="cvv">
                                    CVV
                                </label>

                                <input
                                    type="text"
                                    id="cvv"
                                    name="cvv"
                                    placeholder="123"
                                    inputmode="numeric"
                                    autocomplete="off"
                                    maxlength="4"
                                    required
                                >

                            </div>


                        </div>


                        <button
                            type="submit"
                            class="button-submit"
                        >

                            Activate
                            <?php echo htmlspecialchars(
                                $selectedPlan["name"],
                                ENT_QUOTES,
                                "UTF-8"
                            ); ?>
                            Membership

                        </button>


                    </form>

                </div>

            </div>


            <div class="membership-disclaimer">

                <h3>
                    Test Payment Information
                </h3>

                <p>
                    This checkout is part of a mock educational
                    project. No real payment is processed and no
                    credit card information should be entered.
                    HealthBridge Medical memberships shown on this
                    website are fictional.
                </p>

            </div>

        </section>


    </main>


    <footer>

        <div class="footer-main">

            <div class="footer-content">

                <div class="footer-brand">

                    <h2>
                        HealthBridge Medical
                    </h2>

                    <p>
                        Compassionate, reliable healthcare for
                        individuals and families.
                    </p>

                </div>


                <div class="footer-links">

                    <a href="about.php">
                        About
                    </a>

                    <a href="contact.php">
                        Contact
                    </a>

                    <a href="membership.php">
                        Memberships
                    </a>

                    <a href="login.php">
                        Patient Login
                    </a>

                    <a href="privacy.php">
                        Privacy Policy
                    </a>

                    <a href="terms.php">
                        Terms and Conditions
                    </a>

                    <a href="accessibility.php">
                        Accessibility
                    </a>

                </div>

            </div>

        </div>


        <div class="footer-bottom">

            <p>
                © 2026 HealthBridge Medical. This website is a mock
                educational project and does not provide real medical
                services.
            </p>

        </div>

    </footer>


</body>

</html>
