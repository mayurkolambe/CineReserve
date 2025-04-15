<?php
include('config.php');
session_start();

$email = $_POST["Email"];
$pass = $_POST["Password"];

// Secure query (but ideally use prepared statements to prevent SQL injection)
$qry = mysqli_query($con, "SELECT * FROM tbl_login WHERE username='$email' AND password='$pass'");

if (mysqli_num_rows($qry)) {
    $usr = mysqli_fetch_array($qry);

    if ($usr['user_type'] == 2) {
        $_SESSION['user'] = $usr['user_id'];
        
        // ✅ Store email in session so it can be used later (for OTP)
        $_SESSION['user_email'] = $usr['username']; // assuming username is the email

        if (isset($_SESSION['show'])) {
            header('Location: booking.php');
        } else {
            header('Location: index.php');
        }
    } else {
        $_SESSION['error'] = "Login Failed!";
        header("Location: login.php");
    }

} else {
    $_SESSION['error'] = "Login Failed!";
    header("Location: login.php");
}
?>
