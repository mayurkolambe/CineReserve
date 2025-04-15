<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/PHPMailer-master/src/PHPMailer.php';
require __DIR__ . '/PHPMailer-master/src/SMTP.php';
require __DIR__ . '/PHPMailer-master/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include("config.php"); // ✅ To allow DB queries

// ✅ If user_email not set, but user ID is present, fetch it
if (!isset($_SESSION['user_email']) && isset($_SESSION['user'])) {
    $uid = $_SESSION['user'];
    $result = mysqli_query($con, "SELECT username FROM tbl_login WHERE user_id = '$uid'");
    if ($row = mysqli_fetch_assoc($result)) {
        $_SESSION['user_email'] = $row['username'];
    }
}

// ✅ Now check if email is finally set
// ✅ If OTP is already sent and not yet expired, skip sending again
if (isset($_SESSION['otp_expiry']) && time() < $_SESSION['otp_expiry']) {
    header("Location: bank.php");
    exit();
}



// ✅ Continue sending OTP
$otp = rand(100000, 999999);
$_SESSION['otp'] = $otp;
$_SESSION['otp_expiry'] = time() + 60;

$user_email = $_SESSION['user_email'];

$mail = new PHPMailer();
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'mk25062018@gmail.com';
$mail->Password = 'qrcfpmmgnbvudxce'; // App password
$mail->SMTPSecure = 'tls';
$mail->Port = 587;

$mail->setFrom('mk25062018@gmail.com', 'Movie Booking');
$mail->addAddress($user_email);

$mail->isHTML(true);
$mail->Subject = 'Your OTP for Booking Confirmation';
$mail->Body    = "<h3>Your OTP is: <strong>$otp</strong></h3><p>Enter it to confirm your booking.</p>";

if ($mail->send()) {
    header("Location: bank.php");
    exit();
} else {
    echo "Mailer Error: " . $mail->ErrorInfo;
}
?>
