<?php
session_start();
if(!isset($_SESSION['user'])){
    header('location:login.php');
    exit();
}
include('config.php');
extract($_POST);

// OTP Verification
if ($otp == "123456") {
    $bookid = "BKID" . rand(1000000, 9999999);
    mysqli_query($con, "INSERT INTO tbl_bookings 
        VALUES (NULL, '$bookid', '{$_SESSION['theatre']}', '{$_SESSION['user']}', '{$_SESSION['show']}', '{$_SESSION['screen']}', 
        '{$_SESSION['seats']}', '{$_SESSION['amount']}', '{$_SESSION['date']}', CURDATE(), '1')");
    $_SESSION['success'] = "Booking Successful!";
} else {
    $_SESSION['error'] = "Payment Failed!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Booking Status</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 100px;
            color: #444;
        }
        .spinner {
            font-size: 24px;
            color: blue;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <h2><strong>Transaction is being processed...</strong></h2>
    <p class="spinner">
        Please Wait <i class="fa fa-spinner fa-pulse fa-fw"></i><br>
        <small>(Do not RELOAD or CLOSE this page)</small>
    </p>
    <h3>
        <?php 
        echo isset($_SESSION['success']) ? $_SESSION['success'] : $_SESSION['error']; 
        ?>
    </h3>

    <script>
        setTimeout(function(){ 
            window.location = "profile.php"; 
        }, 3000);
    </script>
</body>
</html>
