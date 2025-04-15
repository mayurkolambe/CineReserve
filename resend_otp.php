<?php
session_start();
unset($_SESSION['otp']);
unset($_SESSION['otp_expiry']);
header("Location: send_otp.php");
exit();
