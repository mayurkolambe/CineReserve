<?php
session_start();
if(!isset($_SESSION['user'])) {
    header('location:login.php');
    exit();
}

include('config.php');

// Get OTP from form
$entered_otp = $_POST['customerpin'];
$stored_otp = $_SESSION['otp'] ?? null;
$otp_time = $_SESSION['otp_expiry'] ?? 0;

// Check if OTP is expired (5 minutes)
if (time() - $otp_time > 300) {
    $_SESSION['error'] = "OTP expired. Please request again.";
    header("Location: bank.php");
    exit();
}

// Check if OTP is valid
if ($entered_otp == $stored_otp) {
    // Set success message for next page
    $_SESSION['success'] = "OTP Verified Successfully!";

    // Redirect to success page for booking confirmation
    header("Location: success.php");
    exit();
} else {
    $_SESSION['error'] = "Invalid OTP. Please try again.";
    header("Location: bank.php");
    exit();
}
?>