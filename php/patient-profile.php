<?php

session_start();

// Require patient login
if (!isset($_SESSION["user_id"])) {
    header("Location: ../html/login.php");
    exit;
}

require_once "/etc/healthbridge/db.php";

$userId = $_SESSION["user_id"];

// --------------------------------------------------
// CSRF TOKEN
// --------------------------------------------------

if (empty($_SESSION["profile_csrf_token"])) {
    $_SESSION["profile_csrf_token"] = bin2hex(random_bytes(32));
}

$csrfToken = $_SESSION["profile_csrf_token"];

// --------------------------------------------------
// MESSAGES
// --------------------------------------------------

$profileError = "";
$profileSuccess = "";

// --------------------------------------------------
// FORM PROCESSING
// --------------------------------------------------

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $action = $_POST["action"] ?? "";
    $submittedToken = $_POST["csrf_token"] ?? "";

    if (!hash_equals($csrfToken, $submittedToken)) {

        $profileError =
            "Your session could not be verified. Please refresh the page and try again.";

    } else {

        // --------------------------------------------------
        // UPDATE PERSONAL INFORMATION
        // --------------------------------------------------

        if ($action === "update_personal_info") {

            $firstName = trim($_POST["first_name"] ?? "");
            $lastName = trim($_POST["last_name"] ?? "");
            $phone = trim($_POST["phone"] ?? "");
            $dateOfBirth = trim($_POST["date_of_birth"] ?? "");
            $emergencyContact =
                trim($_POST["emergency_contact"] ?? "");

            if ($firstName === "" || $lastName === "") {

                $profileError =
                    "First name and last name are required.";

            } elseif (
                strlen($firstName) > 50 ||
                strlen($lastName) > 50
            ) {

                $profileError =
                    "First name and last name must be 50 characters or fewer.";

            } elseif (strlen($phone) > 25) {

                $profileError =
                    "Phone number must be 25 characters or fewer.";

            } elseif (strlen($emergencyContact) > 100) {

                $profileError =
                    "Emergency contact must be 100 characters or fewer.";

            } else {

                if ($dateOfBirth !== "") {

                    $date =
                        DateTime::createFromFormat(
                            "Y-m-d",
                            $dateOfBirth
                        );

                    $dateErrors =
                        DateTime::getLastErrors();

                    $dateIsValid =
                        $date !== false &&
                        (
                            $dateErrors === false ||
                            (
                                $dateErrors["warning_count"] === 0 &&
                                $dateErrors["error_count"] === 0
                            )
                        ) &&
                        $date->format("Y-m-d") ===
                            $dateOfBirth;

                    if (!$dateIsValid) {

                        $profileError =
                            "Please enter a valid date of birth.";

                    } elseif (
                        $date > new DateTime("today")
                    ) {

                        $profileError =
                            "Date of birth cannot be in the future.";

                    }

                }

                if ($profileError === "") {

                    try {

                        $updateStmt = $pdo->prepare(
                            "UPDATE users
                             SET
                                first_name = ?,
                                last_name = ?,
                                phone = ?,
                                date_of_birth = ?,
                                emergency_contact = ?
                             WHERE id = ?"
                        );

                        $updateStmt->execute([
                            $firstName,
                            $lastName,
                            $phone !== ""
                                ? $phone
                                : null,
                            $dateOfBirth !== ""
                                ? $dateOfBirth
                                : null,
                            $emergencyContact !== ""
                                ? $emergencyContact
                                : null,
                            $userId
                        ]);

                        $_SESSION["first_name"] =
                            $firstName;

                        header(
                            "Location: patient-profile.php?profile_updated=1"
                        );
                        exit;

                    } catch (PDOException $e) {

                        $profileError =
                            "We could not update your personal information at this time. Please try again.";

                    }

                }

            }

        }

        // --------------------------------------------------
        // UPDATE ADDRESS
        // --------------------------------------------------

        elseif ($action === "update_address") {

            $streetAddress =
                trim($_POST["street_address"] ?? "");

            $apartmentSuite =
                trim($_POST["apartment_suite"] ?? "");

            $city =
                trim($_POST["city"] ?? "");

            $state =
                trim($_POST["state"] ?? "");

            $zipCode =
                trim($_POST["zip_code"] ?? "");

            if (
                $streetAddress === "" ||
                $city === "" ||
                $state === "" ||
                $zipCode === ""
            ) {

                $profileError =
                    "Street address, city, state, and ZIP code are required.";

            } elseif (strlen($streetAddress) > 150) {

                $profileError =
                    "Street address must be 150 characters or fewer.";

            } elseif (strlen($apartmentSuite) > 50) {

                $profileError =
                    "Apartment or suite must be 50 characters or fewer.";

            } elseif (strlen($city) > 100) {

                $profileError =
                    "City must be 100 characters or fewer.";

            } elseif (strlen($state) > 50) {

                $profileError =
                    "State must be 50 characters or fewer.";

            } elseif (strlen($zipCode) > 10) {

                $profileError =
                    "ZIP code must be 10 characters or fewer.";

            } elseif (
                !preg_match(
                    '/^\d{5}(-\d{4})?$/',
                    $zipCode
                )
            ) {

                $profileError =
                    "Please enter a valid ZIP code.";

            } else {

                try {

                    $addressStmt = $pdo->prepare(
                        "UPDATE users
                         SET
                            street_address = ?,
                            apartment_suite = ?,
                            city = ?,
                            state = ?,
                            zip_code = ?
                         WHERE id = ?"
                    );

                    $addressStmt->execute([
                        $streetAddress,
                        $apartmentSuite !== ""
                            ? $apartmentSuite
                            : null,
                        $city,
                        $state,
                        $zipCode,
                        $userId
                    ]);

                    header(
                        "Location: patient-profile.php?address_updated=1"
                    );
                    exit;

                } catch (PDOException $e) {

                    $profileError =
                        "We could not update your address at this time. Please try again.";

                }

            }

        }

        // --------------------------------------------------
        // UPDATE BILLING & INSURANCE
        // --------------------------------------------------

        elseif ($action === "update_billing") {

            $insuranceProvider =
                trim($_POST["insurance_provider"] ?? "");

            $policyNumber =
                trim($_POST["policy_number"] ?? "");

            $billingAddress =
                trim($_POST["billing_address"] ?? "");

            $cardType =
                trim($_POST["card_type"] ?? "");

            $cardLastFour =
                trim($_POST["card_last_four"] ?? "");

            $allowedCardTypes = [
                "",
                "Visa",
                "Mastercard",
                "American Express",
                "Discover"
            ];

            if (strlen($insuranceProvider) > 100) {

                $profileError =
                    "Insurance provider must be 100 characters or fewer.";

            } elseif (strlen($policyNumber) > 100) {

                $profileError =
                    "Policy number must be 100 characters or fewer.";

            } elseif (strlen($billingAddress) > 255) {

                $profileError =
                    "Billing address must be 255 characters or fewer.";

            } elseif (
                !in_array(
                    $cardType,
                    $allowedCardTypes,
                    true
                )
            ) {

                $profileError =
                    "Please select a valid card type.";

            } elseif (
                $cardLastFour !== "" &&
                !preg_match('/^\d{4}$/', $cardLastFour)
            ) {

                $profileError =
                    "The card last four must contain exactly four digits.";

            } elseif (
                ($cardType === "" && $cardLastFour !== "") ||
                ($cardType !== "" && $cardLastFour === "")
            ) {

                $profileError =
                    "Please provide both the card type and last four digits.";

            } else {

                try {

                    $billingStmt = $pdo->prepare(
                        "INSERT INTO patient_billing (
                            user_id,
                            insurance_provider,
                            policy_number,
                            billing_address,
                            card_type,
                            card_last_four
                         )
                         VALUES (?, ?, ?, ?, ?, ?)
                         ON DUPLICATE KEY UPDATE
                            insurance_provider =
                                VALUES(insurance_provider),
                            policy_number =
                                VALUES(policy_number),
                            billing_address =
                                VALUES(billing_address),
                            card_type =
                                VALUES(card_type),
                            card_last_four =
                                VALUES(card_last_four)"
                    );

                    $billingStmt->execute([
                        $userId,
                        $insuranceProvider !== ""
                            ? $insuranceProvider
                            : null,
                        $policyNumber !== ""
                            ? $policyNumber
                            : null,
                        $billingAddress !== ""
                            ? $billingAddress
                            : null,
                        $cardType !== ""
                            ? $cardType
                            : null,
                        $cardLastFour !== ""
                            ? $cardLastFour
                            : null
                    ]);

                    header(
                        "Location: patient-profile.php?billing_updated=1"
                    );
                    exit;

                } catch (PDOException $e) {

                    $profileError =
                        "We could not update your billing and insurance information at this time. Please try again.";

                }

            }

        }

        // --------------------------------------------------
        // ADD MEDICAL RECORD
        // --------------------------------------------------

        elseif ($action === "add_medical_record") {

            $recordType =
                trim($_POST["record_type"] ?? "");

            $recordTitle =
                trim($_POST["record_title"] ?? "");

            $recordDate =
                trim($_POST["record_date"] ?? "");

            $recordDetails =
                trim($_POST["record_details"] ?? "");

            $allowedRecordTypes = [
                "Medical History",
                "Medication",
                "Allergy",
                "Test Result",
                "Visit Summary"
            ];

            if (
                !in_array(
                    $recordType,
                    $allowedRecordTypes,
                    true
                )
            ) {

                $profileError =
                    "Please select a valid medical record type.";

            } elseif ($recordTitle === "") {

                $profileError =
                    "Medical record title is required.";

            } elseif (strlen($recordTitle) > 150) {

                $profileError =
                    "Medical record title must be 150 characters or fewer.";

            } elseif ($recordDetails === "") {

                $profileError =
                    "Medical record details are required.";

            } else {

                if ($recordDate !== "") {

                    $date =
                        DateTime::createFromFormat(
                            "Y-m-d",
                            $recordDate
                        );

                    $dateErrors =
                        DateTime::getLastErrors();

                    $dateIsValid =
                        $date !== false &&
                        (
                            $dateErrors === false ||
                            (
                                $dateErrors["warning_count"] === 0 &&
                                $dateErrors["error_count"] === 0
                            )
                        ) &&
                        $date->format("Y-m-d") ===
                            $recordDate;

                    if (!$dateIsValid) {

                        $profileError =
                            "Please enter a valid medical record date.";

                    }

                }

                if ($profileError === "") {

                    try {

                        $recordStmt = $pdo->prepare(
                            "INSERT INTO medical_records (
                                user_id,
                                record_type,
                                title,
                                record_details,
                                record_date
                             )
                             VALUES (?, ?, ?, ?, ?)"
                        );

                        $recordStmt->execute([
                            $userId,
                            $recordType,
                            $recordTitle,
                            $recordDetails,
                            $recordDate !== ""
                                ? $recordDate
                                : null
                        ]);

                        header(
                            "Location: patient-profile.php?record_added=1"
                        );
                        exit;

                    } catch (PDOException $e) {

                        $profileError =
                            "We could not add the medical record at this time. Please try again.";

                    }

                }

            }

        }

        // --------------------------------------------------
        // UPDATE MEDICAL RECORD
        // --------------------------------------------------

        elseif ($action === "update_medical_record") {

            $recordId =
                filter_input(
                    INPUT_POST,
                    "record_id",
                    FILTER_VALIDATE_INT
                );

            $recordType =
                trim($_POST["record_type"] ?? "");

            $recordTitle =
                trim($_POST["record_title"] ?? "");

            $recordDate =
                trim($_POST["record_date"] ?? "");

            $recordDetails =
                trim($_POST["record_details"] ?? "");

            $allowedRecordTypes = [
                "Medical History",
                "Medication",
                "Allergy",
                "Test Result",
                "Visit Summary"
            ];

            if (!$recordId) {

                $profileError =
                    "The medical record could not be identified.";

            } elseif (
                !in_array(
                    $recordType,
                    $allowedRecordTypes,
                    true
                )
            ) {

                $profileError =
                    "Please select a valid medical record type.";

            } elseif ($recordTitle === "") {

                $profileError =
                    "Medical record title is required.";

            } elseif (strlen($recordTitle) > 150) {

                $profileError =
                    "Medical record title must be 150 characters or fewer.";

            } elseif ($recordDetails === "") {

                $profileError =
                    "Medical record details are required.";

            } else {

                // Validate optional record date
                if ($recordDate !== "") {

                    $date =
                        DateTime::createFromFormat(
                            "Y-m-d",
                            $recordDate
                        );

                    $dateErrors =
                        DateTime::getLastErrors();

                    $dateIsValid =
                        $date !== false &&
                        (
                            $dateErrors === false ||
                            (
                                $dateErrors["warning_count"] === 0 &&
                                $dateErrors["error_count"] === 0
                            )
                        ) &&
                        $date->format("Y-m-d") ===
                            $recordDate;

                    if (!$dateIsValid) {

                        $profileError =
                            "Please enter a valid medical record date.";

                    }

                }

                if ($profileError === "") {

                    try {

                        /*
                         * IMPORTANT:
                         * We require BOTH the record ID and
                         * logged-in user ID.
                         *
                         * This prevents one patient from
                         * editing another patient's record.
                         */

                        $updateRecordStmt =
                            $pdo->prepare(
                                "UPDATE medical_records
                                 SET
                                    record_type = ?,
                                    title = ?,
                                    record_details = ?,
                                    record_date = ?
                                 WHERE id = ?
                                 AND user_id = ?"
                            );

                        $updateRecordStmt->execute([
                            $recordType,
                            $recordTitle,
                            $recordDetails,
                            $recordDate !== ""
                                ? $recordDate
                                : null,
                            $recordId,
                            $userId
                        ]);

                        if (
                            $updateRecordStmt->rowCount() === 0
                        ) {

                            /*
                             * rowCount() can also be zero if
                             * identical values were submitted.
                             * Verify ownership/existence before
                             * deciding that the record is missing.
                             */

                            $verifyRecordStmt =
                                $pdo->prepare(
                                    "SELECT id
                                     FROM medical_records
                                     WHERE id = ?
                                     AND user_id = ?"
                                );

                            $verifyRecordStmt->execute([
                                $recordId,
                                $userId
                            ]);

                            if (!$verifyRecordStmt->fetch()) {

                                $profileError =
                                    "The medical record could not be found.";

                            }

                        }

                        if ($profileError === "") {

                            header(
                                "Location: patient-profile.php?record_updated=1"
                            );
                            exit;

                        }

                    } catch (PDOException $e) {

                        $profileError =
                            "We could not update the medical record at this time. Please try again.";

                    }

                }

            }

        }

        // --------------------------------------------------
        // DELETE MEDICAL RECORD
        // --------------------------------------------------

        elseif ($action === "delete_medical_record") {

            $recordId =
                filter_input(
                    INPUT_POST,
                    "record_id",
                    FILTER_VALIDATE_INT
                );

            if (!$recordId) {

                $profileError =
                    "The medical record could not be identified.";

            } else {

                try {

                    /*
                     * Again, require BOTH ID and user_id.
                     * A record belonging to another patient
                     * cannot be deleted.
                     */

                    $deleteRecordStmt =
                        $pdo->prepare(
                            "DELETE FROM medical_records
                             WHERE id = ?
                             AND user_id = ?"
                        );

                    $deleteRecordStmt->execute([
                        $recordId,
                        $userId
                    ]);

                    if (
                        $deleteRecordStmt->rowCount() !== 1
                    ) {

                        $profileError =
                            "The medical record could not be found or deleted.";

                    } else {

                        header(
                            "Location: patient-profile.php?record_deleted=1"
                        );
                        exit;

                    }

                } catch (PDOException $e) {

                    $profileError =
                        "We could not delete the medical record at this time. Please try again.";

                }

            }

        }

            
        // --------------------------------------------------
        // CHANGE PASSWORD
        // --------------------------------------------------

        elseif ($action === "change_password") {

            $currentPassword =
                $_POST["current_password"] ?? "";

            $newPassword =
                $_POST["new_password"] ?? "";

            $confirmPassword =
                $_POST["confirm_password"] ?? "";

            if (
                $currentPassword === "" ||
                $newPassword === "" ||
                $confirmPassword === ""
            ) {

                $profileError =
                    "All password fields are required.";

            } elseif (strlen($newPassword) < 8) {

                $profileError =
                    "Your new password must be at least 8 characters long.";

            } elseif (strlen($newPassword) > 255) {

                $profileError =
                    "Your new password is too long.";

            } elseif ($newPassword !== $confirmPassword) {

                $profileError =
                    "The new password and confirmation do not match.";

            } else {

                try {

                    // Retrieve current password hash
                    $passwordStmt = $pdo->prepare(
                        "SELECT password_hash
                         FROM users
                         WHERE id = ?"
                    );

                    $passwordStmt->execute([$userId]);

                    $passwordUser =
                        $passwordStmt->fetch(
                            PDO::FETCH_ASSOC
                        );

                    if (!$passwordUser) {

                        $profileError =
                            "Your account could not be found.";

                    } elseif (
                        !password_verify(
                            $currentPassword,
                            $passwordUser["password_hash"]
                        )
                    ) {

                        $profileError =
                            "Your current password is incorrect.";

                    } elseif (
                        password_verify(
                            $newPassword,
                            $passwordUser["password_hash"]
                        )
                    ) {

                        $profileError =
                            "Your new password must be different from your current password.";

                    } else {

                        $newPasswordHash =
                            password_hash(
                                $newPassword,
                                PASSWORD_DEFAULT
                            );

                        $passwordUpdateStmt =
                            $pdo->prepare(
                                "UPDATE users
                                 SET password_hash = ?
                                 WHERE id = ?"
                            );

                        $passwordUpdateStmt->execute([
                            $newPasswordHash,
                            $userId
                        ]);

                        // Rotate session ID after
                        // security-sensitive change.
                        session_regenerate_id(true);

                        // Rotate CSRF token as well.
                        $_SESSION["profile_csrf_token"] =
                            bin2hex(random_bytes(32));

                        header(
                            "Location: patient-profile.php?password_updated=1"
                        );
                        exit;

                    }

                } catch (PDOException $e) {

                    $profileError =
                        "We could not update your password at this time. Please try again.";

                }

            }

        }

    }

}

// --------------------------------------------------
// SUCCESS MESSAGES
// --------------------------------------------------

if (
    isset($_GET["profile_updated"]) &&
    $_GET["profile_updated"] === "1"
) {

    $profileSuccess =
        "Your personal information has been updated successfully.";

}

if (
    isset($_GET["address_updated"]) &&
    $_GET["address_updated"] === "1"
) {

    $profileSuccess =
        "Your address information has been updated successfully.";

}

if (
    isset($_GET["billing_updated"]) &&
    $_GET["billing_updated"] === "1"
) {

    $profileSuccess =
        "Your billing and insurance information has been updated successfully.";

}

if (
    isset($_GET["record_added"]) &&
    $_GET["record_added"] === "1"
) {

    $profileSuccess =
        "Your medical record has been added successfully.";

}

if (
    isset($_GET["record_updated"]) &&
    $_GET["record_updated"] === "1"
) {

    $profileSuccess =
        "Your medical record has been updated successfully.";

}

if (
    isset($_GET["record_deleted"]) &&
    $_GET["record_deleted"] === "1"
) {

    $profileSuccess =
        "Your medical record has been deleted successfully.";

}


if (
    isset($_GET["password_updated"]) &&
    $_GET["password_updated"] === "1"
) {

    $profileSuccess =
        "Your password has been changed successfully.";

}

// --------------------------------------------------
// RETRIEVE PATIENT INFORMATION
// --------------------------------------------------

$stmt = $pdo->prepare(
    "SELECT
        first_name,
        last_name,
        email,
        phone,
        date_of_birth,
        emergency_contact,
        street_address,
        apartment_suite,
        city,
        state,
        zip_code,
        membership_plan,
        membership_status
     FROM users
     WHERE id = ?"
);

$stmt->execute([$userId]);

$patient =
    $stmt->fetch(PDO::FETCH_ASSOC);

if (!$patient) {
    header("Location: logout.php");
    exit;
}

// Personal information

$firstName =
    $patient["first_name"];

$lastName =
    $patient["last_name"];

$email =
    $patient["email"];

$phone =
    $patient["phone"] ?? "";

$dateOfBirth =
    $patient["date_of_birth"] ?? "";

$emergencyContact =
    $patient["emergency_contact"] ?? "";

// Address information

$streetAddress =
    $patient["street_address"] ?? "";

$apartmentSuite =
    $patient["apartment_suite"] ?? "";

$city =
    $patient["city"] ?? "";

$state =
    $patient["state"] ?? "";

$zipCode =
    $patient["zip_code"] ?? "";

$fullName =
    trim($firstName . " " . $lastName);

// --------------------------------------------------
// RETRIEVE BILLING INFORMATION
// --------------------------------------------------

$billingStmt = $pdo->prepare(
    "SELECT
        insurance_provider,
        policy_number,
        billing_address,
        card_type,
        card_last_four
     FROM patient_billing
     WHERE user_id = ?"
);

$billingStmt->execute([$userId]);

$billing =
    $billingStmt->fetch(PDO::FETCH_ASSOC);

$insuranceProvider =
    $billing["insurance_provider"] ?? "";

$policyNumber =
    $billing["policy_number"] ?? "";

$billingAddress =
    $billing["billing_address"] ?? "";

$cardType =
    $billing["card_type"] ?? "";

$cardLastFour =
    $billing["card_last_four"] ?? "";

// --------------------------------------------------
// RETRIEVE MEDICAL RECORDS
// --------------------------------------------------

$medicalStmt = $pdo->prepare(
    "SELECT
        id,
        record_type,
        title,
        record_details,
        record_date,
        created_at
     FROM medical_records
     WHERE user_id = ?
     ORDER BY
        COALESCE(
            record_date,
            DATE(created_at)
        ) DESC,
        created_at DESC"
);

$medicalStmt->execute([$userId]);

$medicalRecords =
    $medicalStmt->fetchAll(
        PDO::FETCH_ASSOC
    );

// --------------------------------------------------
// HELPER
// --------------------------------------------------

function escapeHtml($value)
{
    return htmlspecialchars(
        (string) ($value ?? ""),
        ENT_QUOTES,
        "UTF-8"
    );
}

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
        Patient Profile | HealthBridge Medical
    </title>

    <link
        rel="stylesheet"
        href="../css/style.css?v=8"
    >

    <link
        rel="icon"
        type="image/x-icon"
        href="../images/favicon.ico"
    >

</head>

<body>

    <!-- ==========================================
         HEADER
    =========================================== -->

    <header>

        <div class="utility-bar">

            <div class="utility-content">

                <div class="utility-left">

                    <a href="../html/contact.php">
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
                        <?php echo escapeHtml($firstName); ?>
                    </span>

                    <a
                        href="logout.php"
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
                        <a href="../html/services.php">
                            Services
                        </a>
                    </li>

                    <li>
                        <a href="../html/membership.php">
                            Memberships
                        </a>
                    </li>

                    <li>
                        <a href="../html/appointment.php">
                            Appointments
                        </a>
                    </li>

                    <li>
                        <a href="../html/contact.php">
                            Contact
                        </a>
                    </li>

                </ul>

            </nav>

        </div>

    </header>

    <!-- ==========================================
         PATIENT PROFILE
    =========================================== -->

    <main>

        <section class="profile-page">

            <a
                href="dashboard.php"
                class="profile-back"
            >
                &larr; Back to Dashboard
            </a>

            <div class="profile-header">

                <h2>
                    My Patient Profile
                </h2>

                <p>
                    Manage your personal information,
                    billing details, medical records,
                    and account security.
                </p>

            </div>

            <?php if ($profileSuccess !== ""): ?>

                <div class="profile-success">

                    <?php
                    echo escapeHtml(
                        $profileSuccess
                    );
                    ?>

                </div>

            <?php endif; ?>

            <?php if ($profileError !== ""): ?>

                <div class="profile-error">

                    <?php
                    echo escapeHtml(
                        $profileError
                    );
                    ?>

                </div>

            <?php endif; ?>

            <!-- PATIENT OVERVIEW -->

            <div class="profile-overview">

                <div class="profile-avatar">

                    <?php
                    echo escapeHtml(
                        strtoupper(
                            substr(
                                $firstName,
                                0,
                                1
                            )
                        )
                    );
                    ?>

                </div>

                <div>

                    <h3>
                        <?php
                        echo escapeHtml(
                            $fullName
                        );
                        ?>
                    </h3>

                    <p>
                        <?php
                        echo escapeHtml(
                            $email
                        );
                        ?>
                    </p>

                    <span class="profile-status">
                        Patient Account
                    </span>

                </div>

            </div>

            <div class="profile-grid">

                <!-- ==================================
                     PERSONAL INFORMATION
                =================================== -->

                <div class="profile-card">

                    <h3>
                        Personal Information
                    </h3>

                    <p class="profile-description">
                        Manage your account details and
                        personal contact information.
                    </p>

                    <form
                        method="POST"
                        action="patient-profile.php"
                    >

                        <input
                            type="hidden"
                            name="action"
                            value="update_personal_info"
                        >

                        <input
                            type="hidden"
                            name="csrf_token"
                            value="<?php
                            echo escapeHtml(
                                $csrfToken
                            );
                            ?>"
                        >

                        <div class="profile-row">

                            <div class="profile-field">

                                <label for="profile-first-name">
                                    First Name
                                </label>

                                <input
                                    type="text"
                                    id="profile-first-name"
                                    name="first_name"
                                    maxlength="50"
                                    value="<?php
                                    echo escapeHtml(
                                        $firstName
                                    );
                                    ?>"
                                    required
                                    disabled
                                >

                            </div>

                            <div class="profile-field">

                                <label for="profile-last-name">
                                    Last Name
                                </label>

                                <input
                                    type="text"
                                    id="profile-last-name"
                                    name="last_name"
                                    maxlength="50"
                                    value="<?php
                                    echo escapeHtml(
                                        $lastName
                                    );
                                    ?>"
                                    required
                                    disabled
                                >

                            </div>

                        </div>

                        <div class="profile-field">

                            <label for="profile-email">
                                Email Address
                            </label>

                            <input
                                type="email"
                                id="profile-email"
                                value="<?php
                                echo escapeHtml(
                                    $email
                                );
                                ?>"
                                disabled
                            >

                        </div>

                        <div class="profile-field">

                            <label for="profile-phone">
                                Phone Number
                            </label>

                            <input
                                type="tel"
                                id="profile-phone"
                                name="phone"
                                maxlength="25"
                                value="<?php
                                echo escapeHtml(
                                    $phone
                                );
                                ?>"
                                placeholder="Not provided"
                                disabled
                            >

                        </div>

                        <div class="profile-field">

                            <label for="profile-dob">
                                Date of Birth
                            </label>

                            <input
                                type="date"
                                id="profile-dob"
                                name="date_of_birth"
                                value="<?php
                                echo escapeHtml(
                                    $dateOfBirth
                                );
                                ?>"
                                max="<?php
                                echo date("Y-m-d");
                                ?>"
                                disabled
                            >

                        </div>

                        <div class="profile-field">

                            <label for="profile-emergency">
                                Emergency Contact
                            </label>

                            <input
                                type="text"
                                id="profile-emergency"
                                name="emergency_contact"
                                maxlength="100"
                                value="<?php
                                echo escapeHtml(
                                    $emergencyContact
                                );
                                ?>"
                                placeholder="Not provided"
                                disabled
                            >

                        </div>

                        <div class="profile-notice">
                            Your email address is linked
                            to your HealthBridge account
                            and cannot be changed from
                            this section.
                        </div>

                        <div class="profile-edit-actions">

                            <button
                                type="button"
                                class="profile-button"
                                id="edit-personal-information"
                            >
                                Edit Personal Information
                            </button>

                            <button
                                type="submit"
                                class="profile-button"
                                id="save-personal-information"
                                hidden
                            >
                                Save Changes
                            </button>

                            <button
                                type="button"
                                class="profile-cancel-button"
                                id="cancel-personal-information"
                                hidden
                            >
                                Cancel
                            </button>

                        </div>

                    </form>

                </div>

                <!-- ==================================
                     ADDRESS
                =================================== -->

                <div class="profile-card">

                    <h3>
                        Address Information
                    </h3>

                    <p class="profile-description">
                        Manage your residential address
                        information.
                    </p>

                    <form
                        method="POST"
                        action="patient-profile.php"
                    >

                        <input
                            type="hidden"
                            name="action"
                            value="update_address"
                        >

                        <input
                            type="hidden"
                            name="csrf_token"
                            value="<?php
                            echo escapeHtml(
                                $csrfToken
                            );
                            ?>"
                        >

                        <div class="profile-field">

                            <label for="profile-street">
                                Street Address
                            </label>

                            <input
                                type="text"
                                id="profile-street"
                                name="street_address"
                                maxlength="150"
                                value="<?php
                                echo escapeHtml(
                                    $streetAddress
                                );
                                ?>"
                                placeholder="Not provided"
                                required
                                disabled
                            >

                        </div>

                        <div class="profile-field">

                            <label for="profile-apartment">
                                Apartment / Suite
                            </label>

                            <input
                                type="text"
                                id="profile-apartment"
                                name="apartment_suite"
                                maxlength="50"
                                value="<?php
                                echo escapeHtml(
                                    $apartmentSuite
                                );
                                ?>"
                                placeholder="Optional"
                                disabled
                            >

                        </div>

                        <div class="profile-row">

                            <div class="profile-field">

                                <label for="profile-city">
                                    City
                                </label>

                                <input
                                    type="text"
                                    id="profile-city"
                                    name="city"
                                    maxlength="100"
                                    value="<?php
                                    echo escapeHtml(
                                        $city
                                    );
                                    ?>"
                                    placeholder="Not provided"
                                    required
                                    disabled
                                >

                            </div>

                            <div class="profile-field">

                                <label for="profile-state">
                                    State
                                </label>

                                <input
                                    type="text"
                                    id="profile-state"
                                    name="state"
                                    maxlength="50"
                                    value="<?php
                                    echo escapeHtml(
                                        $state
                                    );
                                    ?>"
                                    placeholder="Not provided"
                                    required
                                    disabled
                                >

                            </div>

                        </div>

                        <div class="profile-field">

                            <label for="profile-zip">
                                ZIP Code
                            </label>

                            <input
                                type="text"
                                id="profile-zip"
                                name="zip_code"
                                maxlength="10"
                                value="<?php
                                echo escapeHtml(
                                    $zipCode
                                );
                                ?>"
                                placeholder="Not provided"
                                required
                                disabled
                            >

                        </div>

                        <div class="profile-notice">
                            Your saved address is used
                            as your primary patient address.
                        </div>

                        <div class="profile-edit-actions">

                            <button
                                type="button"
                                class="profile-button"
                                id="edit-address"
                            >
                                Edit Address
                            </button>

                            <button
                                type="submit"
                                class="profile-button"
                                id="save-address"
                                hidden
                            >
                                Save Address
                            </button>

                            <button
                                type="button"
                                class="profile-cancel-button"
                                id="cancel-address"
                                hidden
                            >
                                Cancel
                            </button>

                        </div>

                    </form>

                </div>

                <!-- ==================================
                     BILLING & INSURANCE
                =================================== -->

                <div class="profile-card">

                    <h3>
                        Billing &amp; Insurance
                    </h3>

                    <p class="profile-description">
                        Manage your insurance information
                        and demonstration payment method.
                    </p>

                    <form
                        method="POST"
                        action="patient-profile.php"
                    >

                        <input
                            type="hidden"
                            name="action"
                            value="update_billing"
                        >

                        <input
                            type="hidden"
                            name="csrf_token"
                            value="<?php
                            echo escapeHtml(
                                $csrfToken
                            );
                            ?>"
                        >

                        <div class="profile-field">

                            <label for="profile-insurance">
                                Insurance Provider
                            </label>

                            <input
                                type="text"
                                id="profile-insurance"
                                name="insurance_provider"
                                maxlength="100"
                                value="<?php
                                echo escapeHtml(
                                    $insuranceProvider
                                );
                                ?>"
                                placeholder="Not provided"
                                disabled
                            >

                        </div>

                        <div class="profile-field">

                            <label for="profile-policy">
                                Insurance Policy Number
                            </label>

                            <input
                                type="text"
                                id="profile-policy"
                                name="policy_number"
                                maxlength="100"
                                value="<?php
                                echo escapeHtml(
                                    $policyNumber
                                );
                                ?>"
                                placeholder="Not provided"
                                disabled
                            >

                        </div>

                        <div class="profile-field">

                            <label for="profile-billing-address">
                                Billing Address
                            </label>

                            <input
                                type="text"
                                id="profile-billing-address"
                                name="billing_address"
                                maxlength="255"
                                value="<?php
                                echo escapeHtml(
                                    $billingAddress
                                );
                                ?>"
                                placeholder="Not provided"
                                disabled
                            >

                        </div>

                        <div class="profile-row">

                            <div class="profile-field">

                                <label for="profile-card-type">
                                    Card Type
                                </label>

                                <select
                                    id="profile-card-type"
                                    name="card_type"
                                    disabled
                                >

                                    <option
                                        value=""
                                        <?php
                                        echo $cardType === ""
                                            ? "selected"
                                            : "";
                                        ?>
                                    >
                                        No card on file
                                    </option>

                                    <option
                                        value="Visa"
                                        <?php
                                        echo $cardType === "Visa"
                                            ? "selected"
                                            : "";
                                        ?>
                                    >
                                        Visa
                                    </option>

                                    <option
                                        value="Mastercard"
                                        <?php
                                        echo $cardType === "Mastercard"
                                            ? "selected"
                                            : "";
                                        ?>
                                    >
                                        Mastercard
                                    </option>

                                    <option
                                        value="American Express"
                                        <?php
                                        echo $cardType === "American Express"
                                            ? "selected"
                                            : "";
                                        ?>
                                    >
                                        American Express
                                    </option>

                                    <option
                                        value="Discover"
                                        <?php
                                        echo $cardType === "Discover"
                                            ? "selected"
                                            : "";
                                        ?>
                                    >
                                        Discover
                                    </option>

                                </select>

                            </div>

                            <div class="profile-field">

                                <label for="profile-card-last-four">
                                    Last Four Digits
                                </label>

                                <input
                                    type="text"
                                    id="profile-card-last-four"
                                    name="card_last_four"
                                    maxlength="4"
                                    inputmode="numeric"
                                    pattern="[0-9]{4}"
                                    value="<?php
                                    echo escapeHtml(
                                        $cardLastFour
                                    );
                                    ?>"
                                    placeholder="4242"
                                    disabled
                                >

                            </div>

                        </div>

                        <div class="profile-notice">
                            HealthBridge stores only a
                            demonstration card type and
                            last four digits. Never enter
                            a full card number, CVV,
                            banking information, or real
                            insurance information.
                        </div>

                        <div class="profile-edit-actions">

                            <button
                                type="button"
                                class="profile-button"
                                id="edit-billing"
                            >
                                Manage Billing
                            </button>

                            <button
                                type="submit"
                                class="profile-button"
                                id="save-billing"
                                hidden
                            >
                                Save Billing
                            </button>

                            <button
                                type="button"
                                class="profile-cancel-button"
                                id="cancel-billing"
                                hidden
                            >
                                Cancel
                            </button>

                        </div>

                    </form>

                </div>

                               <!-- ==================================
                     MEDICAL RECORDS
                =================================== -->

                <div class="profile-card">

                    <h3>
                        Medical Records
                    </h3>

                    <p class="profile-description">
                        Add, edit, and review medical history,
                        medications, allergies, test results,
                        and visit summaries.
                    </p>

                    <div class="medical-record-list">

                        <?php if (empty($medicalRecords)): ?>

                            <div class="profile-record">

                                <h4>
                                    No Medical Records
                                </h4>

                                <p>
                                    No medical records have
                                    been added to this patient
                                    profile yet.
                                </p>

                            </div>

                        <?php else: ?>

                            <?php foreach ($medicalRecords as $record): ?>

                                <div
                                    class="profile-record"
                                    id="medical-record-<?php
                                    echo (int) $record["id"];
                                    ?>"
                                >

                                    <!-- DISPLAY MODE -->

                                    <div
                                        id="record-display-<?php
                                        echo (int) $record["id"];
                                        ?>"
                                    >

                                        <div class="medical-record-heading">

                                            <span class="medical-record-type">

                                                <?php
                                                echo escapeHtml(
                                                    $record["record_type"]
                                                );
                                                ?>

                                            </span>

                                            <?php
                                            if (
                                                !empty(
                                                    $record["record_date"]
                                                )
                                            ):
                                            ?>

                                                <span class="medical-record-date">

                                                    <?php
                                                    echo escapeHtml(
                                                        date(
                                                            "m/d/Y",
                                                            strtotime(
                                                                $record[
                                                                    "record_date"
                                                                ]
                                                            )
                                                        )
                                                    );
                                                    ?>

                                                </span>

                                            <?php endif; ?>

                                        </div>

                                        <h4>

                                            <?php
                                            echo escapeHtml(
                                                $record["title"]
                                            );
                                            ?>

                                        </h4>

                                        <p>

                                            <?php
                                            echo nl2br(
                                                escapeHtml(
                                                    $record[
                                                        "record_details"
                                                    ]
                                                )
                                            );
                                            ?>

                                        </p>

                                        <div class="medical-record-controls">

                                            <button
                                                type="button"
                                                class="profile-button medical-edit-button"
                                                data-record-id="<?php
                                                echo (int) $record["id"];
                                                ?>"
                                            >
                                                Edit
                                            </button>

                                            <form
                                                method="POST"
                                                action="patient-profile.php"
                                                class="medical-delete-form"
                                            >

                                                <input
                                                    type="hidden"
                                                    name="action"
                                                    value="delete_medical_record"
                                                >

                                                <input
                                                    type="hidden"
                                                    name="record_id"
                                                    value="<?php
                                                    echo (int) $record["id"];
                                                    ?>"
                                                >

                                                <input
                                                    type="hidden"
                                                    name="csrf_token"
                                                    value="<?php
                                                    echo escapeHtml(
                                                        $csrfToken
                                                    );
                                                    ?>"
                                                >

                                                <button
                                                    type="submit"
                                                    class="medical-delete-button"
                                                >
                                                    Delete
                                                </button>

                                            </form>

                                        </div>

                                    </div>

                                    <!-- EDIT MODE -->

                                    <form
                                        method="POST"
                                        action="patient-profile.php"
                                        class="medical-record-edit-form"
                                        id="record-edit-<?php
                                        echo (int) $record["id"];
                                        ?>"
                                        hidden
                                    >

                                        <input
                                            type="hidden"
                                            name="action"
                                            value="update_medical_record"
                                        >

                                        <input
                                            type="hidden"
                                            name="record_id"
                                            value="<?php
                                            echo (int) $record["id"];
                                            ?>"
                                        >

                                        <input
                                            type="hidden"
                                            name="csrf_token"
                                            value="<?php
                                            echo escapeHtml(
                                                $csrfToken
                                            );
                                            ?>"
                                        >

                                        <div class="profile-field">

                                            <label
                                                for="edit-record-type-<?php
                                                echo (int) $record["id"];
                                                ?>"
                                            >
                                                Record Type
                                            </label>

                                            <select
                                                id="edit-record-type-<?php
                                                echo (int) $record["id"];
                                                ?>"
                                                name="record_type"
                                                required
                                            >

                                                <?php

                                                $recordTypes = [
                                                    "Medical History",
                                                    "Medication",
                                                    "Allergy",
                                                    "Test Result",
                                                    "Visit Summary"
                                                ];

                                                foreach (
                                                    $recordTypes
                                                    as $type
                                                ):

                                                ?>

                                                    <option
                                                        value="<?php
                                                        echo escapeHtml(
                                                            $type
                                                        );
                                                        ?>"
                                                        <?php
                                                        echo
                                                            $record[
                                                                "record_type"
                                                            ] === $type
                                                                ? "selected"
                                                                : "";
                                                        ?>
                                                    >
                                                        <?php
                                                        echo escapeHtml(
                                                            $type
                                                        );
                                                        ?>
                                                    </option>

                                                <?php endforeach; ?>

                                            </select>

                                        </div>

                                        <div class="profile-field">

                                            <label
                                                for="edit-record-title-<?php
                                                echo (int) $record["id"];
                                                ?>"
                                            >
                                                Title
                                            </label>

                                            <input
                                                type="text"
                                                id="edit-record-title-<?php
                                                echo (int) $record["id"];
                                                ?>"
                                                name="record_title"
                                                maxlength="150"
                                                value="<?php
                                                echo escapeHtml(
                                                    $record["title"]
                                                );
                                                ?>"
                                                required
                                            >

                                        </div>

                                        <div class="profile-field">

                                            <label
                                                for="edit-record-date-<?php
                                                echo (int) $record["id"];
                                                ?>"
                                            >
                                                Record Date
                                            </label>

                                            <input
                                                type="date"
                                                id="edit-record-date-<?php
                                                echo (int) $record["id"];
                                                ?>"
                                                name="record_date"
                                                value="<?php
                                                echo escapeHtml(
                                                    $record[
                                                        "record_date"
                                                    ] ?? ""
                                                );
                                                ?>"
                                            >

                                        </div>

                                        <div class="profile-field">

                                            <label
                                                for="edit-record-details-<?php
                                                echo (int) $record["id"];
                                                ?>"
                                            >
                                                Details
                                            </label>

                                            <textarea
                                                id="edit-record-details-<?php
                                                echo (int) $record["id"];
                                                ?>"
                                                name="record_details"
                                                rows="5"
                                                required
                                            ><?php
                                            echo escapeHtml(
                                                $record[
                                                    "record_details"
                                                ]
                                            );
                                            ?></textarea>

                                        </div>

                                        <div class="profile-edit-actions">

                                            <button
                                                type="submit"
                                                class="profile-button"
                                            >
                                                Save Changes
                                            </button>

                                            <button
                                                type="button"
                                                class="profile-cancel-button medical-edit-cancel"
                                                data-record-id="<?php
                                                echo (int) $record["id"];
                                                ?>"
                                            >
                                                Cancel
                                            </button>

                                        </div>

                                    </form>

                                </div>

                            <?php endforeach; ?>

                        <?php endif; ?>

                    </div>

                    <!-- ADD NEW RECORD -->

                    <div class="medical-record-actions">

                        <button
                            type="button"
                            class="profile-button"
                            id="show-medical-record-form"
                        >
                            Add Medical Record
                        </button>

                    </div>

                    <form
                        method="POST"
                        action="patient-profile.php"
                        id="medical-record-form"
                        class="medical-record-form"
                        hidden
                    >

                        <input
                            type="hidden"
                            name="action"
                            value="add_medical_record"
                        >

                        <input
                            type="hidden"
                            name="csrf_token"
                            value="<?php
                            echo escapeHtml(
                                $csrfToken
                            );
                            ?>"
                        >

                        <div class="profile-field">

                            <label for="record-type">
                                Record Type
                            </label>

                            <select
                                id="record-type"
                                name="record_type"
                                required
                            >

                                <option value="">
                                    Select record type
                                </option>

                                <option value="Medical History">
                                    Medical History
                                </option>

                                <option value="Medication">
                                    Medication
                                </option>

                                <option value="Allergy">
                                    Allergy
                                </option>

                                <option value="Test Result">
                                    Test Result
                                </option>

                                <option value="Visit Summary">
                                    Visit Summary
                                </option>

                            </select>

                        </div>

                        <div class="profile-field">

                            <label for="record-title">
                                Title
                            </label>

                            <input
                                type="text"
                                id="record-title"
                                name="record_title"
                                maxlength="150"
                                placeholder="Record title"
                                required
                            >

                        </div>

                        <div class="profile-field">

                            <label for="record-date">
                                Record Date
                            </label>

                            <input
                                type="date"
                                id="record-date"
                                name="record_date"
                            >

                        </div>

                        <div class="profile-field">

                            <label for="record-details">
                                Details
                            </label>

                            <textarea
                                id="record-details"
                                name="record_details"
                                rows="5"
                                placeholder="Enter record details"
                                required
                            ></textarea>

                        </div>

                        <div class="profile-notice">
                            For this educational project,
                            use fictional demonstration
                            medical information only.
                        </div>

                        <div class="profile-edit-actions">

                            <button
                                type="submit"
                                class="profile-button"
                            >
                                Save Medical Record
                            </button>

                            <button
                                type="button"
                                class="profile-cancel-button"
                                id="cancel-medical-record"
                            >
                                Cancel
                            </button>

                        </div>

                    </form>

                </div>

                <!-- ==================================
                     ACCOUNT SECURITY
                =================================== -->

                <div class="profile-card profile-full-width">

                    <h3>
                        Account Security
                    </h3>

                    <p class="profile-description">
                        Manage your HealthBridge Medical
                        account security and login settings.
                    </p>

                    <div class="profile-field">

                        <label for="security-email">
                            Account Email
                        </label>

                        <input
                            type="email"
                            id="security-email"
                            value="<?php
                            echo escapeHtml(
                                $email
                            );
                            ?>"
                            disabled
                        >

                    </div>

                    <div class="profile-record">

                        <h4>
                            Password
                        </h4>

                        <p>
                            Your account password is securely
                            hashed and is never displayed.
                        </p>

                    </div>

                    <button
                        type="button"
                        class="profile-button"
                        id="show-password-form"
                    >
                        Change Password
                    </button>

                    <form
                        method="POST"
                        action="patient-profile.php"
                        id="password-change-form"
                        class="password-change-form"
                        hidden
                    >

                        <input
                            type="hidden"
                            name="action"
                            value="change_password"
                        >

                        <input
                            type="hidden"
                            name="csrf_token"
                            value="<?php
                            echo escapeHtml(
                                $csrfToken
                            );
                            ?>"
                        >

                        <div class="profile-field">

                            <label for="current-password">
                                Current Password
                            </label>

                            <input
                                type="password"
                                id="current-password"
                                name="current_password"
                                autocomplete="current-password"
                                required
                            >

                        </div>

                        <div class="profile-field">

                            <label for="new-password">
                                New Password
                            </label>

                            <input
                                type="password"
                                id="new-password"
                                name="new_password"
                                minlength="8"
                                autocomplete="new-password"
                                required
                            >

                        </div>

                        <div class="profile-field">

                            <label for="confirm-password">
                                Confirm New Password
                            </label>

                            <input
                                type="password"
                                id="confirm-password"
                                name="confirm_password"
                                minlength="8"
                                autocomplete="new-password"
                                required
                            >

                        </div>

                        <div class="profile-notice">
                            Your new password must be at
                            least 8 characters long.
                            HealthBridge never displays
                            or stores your password in
                            plain text.
                        </div>

                        <div class="profile-edit-actions">

                            <button
                                type="submit"
                                class="profile-button"
                            >
                                Update Password
                            </button>

                            <button
                                type="button"
                                class="profile-cancel-button"
                                id="cancel-password-change"
                            >
                                Cancel
                            </button>

                        </div>

                    </form>

                    <div class="account-security-logout">

                        <a
                            href="logout.php"
                            class="profile-button"
                        >
                            Logout of Account
                        </a>

                    </div>

                </div>

            </div>

        </section>

    </main>

    <!-- ==========================================
         FOOTER
    =========================================== -->

    <footer>

        <div class="footer-main">

            <div class="footer-content">

                <div class="footer-brand">

                    <h2>
                        HealthBridge Medical
                    </h2>

                    <p>
                        Connecting patients with convenient
                        and accessible healthcare services.
                    </p>

                </div>

                <div class="footer-links">

                    <a href="../html/about.php">
                        About
                    </a>

                    <a href="../html/contact.php">
                        Contact
                    </a>

                    <a href="../html/membership.php">
                        Memberships
                    </a>

                    <a href="../html/privacy.php">
                        Privacy Policy
                    </a>

                    <a href="../html/terms.php">
                        Terms and Conditions
                    </a>

                    <a href="../html/accessibility.php">
                        Accessibility
                    </a>

                </div>

            </div>

        </div>

        <div class="footer-bottom">

            <p>
                © 2026 HealthBridge Medical.
                This website is a mock educational
                project and does not provide real
                medical services.
            </p>

        </div>

    </footer>

    <?php require_once "chatbot-widget.php"; ?>

    <script src="../js/script.js?v=4"></script>

    <!-- ==========================================
         PROFILE JAVASCRIPT
    =========================================== -->

    <script>

        document.addEventListener(
            "DOMContentLoaded",
            function () {

                // ----------------------------------
                // REUSABLE EDITABLE SECTION
                // ----------------------------------

                function setupEditableSection(
                    editButtonId,
                    saveButtonId,
                    cancelButtonId,
                    fieldIds
                ) {

                    const editButton =
                        document.getElementById(
                            editButtonId
                        );

                    const saveButton =
                        document.getElementById(
                            saveButtonId
                        );

                    const cancelButton =
                        document.getElementById(
                            cancelButtonId
                        );

                    const fields =
                        fieldIds.map(
                            function (id) {

                                return document.getElementById(
                                    id
                                );

                            }
                        );

                    if (
                        !editButton ||
                        !saveButton ||
                        !cancelButton
                    ) {
                        return;
                    }

                    const originalValues =
                        fields.map(
                            function (field) {

                                return field.value;

                            }
                        );

                    editButton.addEventListener(
                        "click",
                        function () {

                            fields.forEach(
                                function (field) {

                                    field.disabled =
                                        false;

                                }
                            );

                            editButton.hidden = true;
                            saveButton.hidden = false;
                            cancelButton.hidden = false;

                            if (fields[0]) {
                                fields[0].focus();
                            }

                        }
                    );

                    cancelButton.addEventListener(
                        "click",
                        function () {

                            fields.forEach(
                                function (
                                    field,
                                    index
                                ) {

                                    field.value =
                                        originalValues[
                                            index
                                        ];

                                    field.disabled =
                                        true;

                                }
                            );

                            saveButton.hidden = true;
                            cancelButton.hidden = true;
                            editButton.hidden = false;

                        }
                    );

                }

                // PERSONAL INFO

                setupEditableSection(
                    "edit-personal-information",
                    "save-personal-information",
                    "cancel-personal-information",
                    [
                        "profile-first-name",
                        "profile-last-name",
                        "profile-phone",
                        "profile-dob",
                        "profile-emergency"
                    ]
                );

                // ADDRESS

                setupEditableSection(
                    "edit-address",
                    "save-address",
                    "cancel-address",
                    [
                        "profile-street",
                        "profile-apartment",
                        "profile-city",
                        "profile-state",
                        "profile-zip"
                    ]
                );

                // BILLING

                setupEditableSection(
                    "edit-billing",
                    "save-billing",
                    "cancel-billing",
                    [
                        "profile-insurance",
                        "profile-policy",
                        "profile-billing-address",
                        "profile-card-type",
                        "profile-card-last-four"
                    ]
                );

                // ----------------------------------
                // MEDICAL RECORD FORM
                // ----------------------------------

                const showMedicalFormButton =
                    document.getElementById(
                        "show-medical-record-form"
                    );

                const medicalForm =
                    document.getElementById(
                        "medical-record-form"
                    );

                const cancelMedicalButton =
                    document.getElementById(
                        "cancel-medical-record"
                    );

                if (
                    showMedicalFormButton &&
                    medicalForm &&
                    cancelMedicalButton
                ) {

                    showMedicalFormButton.addEventListener(
                        "click",
                        function () {

                            medicalForm.hidden =
                                false;

                            showMedicalFormButton.hidden =
                                true;

                            const recordType =
                                document.getElementById(
                                    "record-type"
                                );

                            if (recordType) {
                                recordType.focus();
                            }

                        }
                    );

                    cancelMedicalButton.addEventListener(
                        "click",
                        function () {

                            medicalForm.reset();

                            medicalForm.hidden =
                                true;

                            showMedicalFormButton.hidden =
                                false;

                        }
                    );

                }

                // ----------------------------------
                // PASSWORD CHANGE FORM
                // ----------------------------------

                const showPasswordButton =
                    document.getElementById(
                        "show-password-form"
                    );

                const passwordForm =
                    document.getElementById(
                        "password-change-form"
                    );

                const cancelPasswordButton =
                    document.getElementById(
                        "cancel-password-change"
                    );

                if (
                    showPasswordButton &&
                    passwordForm &&
                    cancelPasswordButton
                ) {

                    showPasswordButton.addEventListener(
                        "click",
                        function () {

                            passwordForm.hidden =
                                false;

                            showPasswordButton.hidden =
                                true;

                            const currentPassword =
                                document.getElementById(
                                    "current-password"
                                );

                            if (currentPassword) {
                                currentPassword.focus();
                            }

                        }
                    );

                    cancelPasswordButton.addEventListener(
                        "click",
                        function () {

                            passwordForm.reset();

                            passwordForm.hidden =
                                true;

                            showPasswordButton.hidden =
                                false;

                        }
                    );

                }

                // ----------------------------------
                // MEDICAL RECORD EDITING
                // ----------------------------------

                const medicalEditButtons =
                    document.querySelectorAll(
                        ".medical-edit-button"
                    );

                const medicalEditCancelButtons =
                    document.querySelectorAll(
                        ".medical-edit-cancel"
                    );

                medicalEditButtons.forEach(
                    function (button) {

                        button.addEventListener(
                            "click",
                            function () {

                                const recordId =
                                    button.dataset.recordId;

                                const display =
                                    document.getElementById(
                                        "record-display-" +
                                        recordId
                                    );

                                const editForm =
                                    document.getElementById(
                                        "record-edit-" +
                                        recordId
                                    );

                                if (
                                    display &&
                                    editForm
                                ) {

                                    display.hidden =
                                        true;

                                    editForm.hidden =
                                        false;

                                }

                            }
                        );

                    }
                );

                medicalEditCancelButtons.forEach(
                    function (button) {

                        button.addEventListener(
                            "click",
                            function () {

                                const recordId =
                                    button.dataset.recordId;

                                const display =
                                    document.getElementById(
                                        "record-display-" +
                                        recordId
                                    );

                                const editForm =
                                    document.getElementById(
                                        "record-edit-" +
                                        recordId
                                    );

                                if (
                                    display &&
                                    editForm
                                ) {

                                    editForm.hidden =
                                        true;

                                    display.hidden =
                                        false;

                                }

                            }
                        );

                    }
                );

                // ----------------------------------
                // MEDICAL RECORD DELETE CONFIRMATION
                // ----------------------------------

                const medicalDeleteForms =
                    document.querySelectorAll(
                        ".medical-delete-form"
                    );

                medicalDeleteForms.forEach(
                    function (form) {

                        form.addEventListener(
                            "submit",
                            function (event) {

                                const confirmed =
                                    window.confirm(
                                        "Are you sure you want to delete this medical record? This action cannot be undone."
                                    );

                                if (!confirmed) {
                                    event.preventDefault();
                                }

                            }
                        );

                    }
                );


                
            }
        );

    </script>

</body>

</html>
