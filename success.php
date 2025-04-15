<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('location:login.php');
    exit();
}
include('config.php');

// Prevent page access without OTP verification
if (!isset($_SESSION['success']) || $_SESSION['success'] !== "OTP Verified Successfully!") {
    $_SESSION['error'] = "Unauthorized access.";
    header('location:bank.php');
    exit();
}

// Process booking
$bookid = "BKID" . rand(1000000, 9999999);

// Prepare seat data
$seat_count = $_SESSION['seats'];
$selected_seats = $_SESSION['selectedSeats'] ?? "[]"; // Default to empty JSON array if not set

// Insert booking
$insert_query = "INSERT INTO tbl_bookings 
    VALUES (NULL, '$bookid', '{$_SESSION['theatre']}', '{$_SESSION['user']}', '{$_SESSION['show']}', '{$_SESSION['screen']}', 
    '$seat_count', '{$_SESSION['amount']}', '{$_SESSION['date']}', CURDATE(), '1', '$selected_seats')";

$result = mysqli_query($con, $insert_query);

if (!$result) {
    // Debug the SQL error
    $error = mysqli_error($con);
    
    // Check if it's a column issue
    if (strpos($error, "column count") !== false) {
        // Try without the selected_seats column
        $insert_query = "INSERT INTO tbl_bookings 
            VALUES (NULL, '$bookid', '{$_SESSION['theatre']}', '{$_SESSION['user']}', '{$_SESSION['show']}', '{$_SESSION['screen']}', 
            '$seat_count', '{$_SESSION['amount']}', '{$_SESSION['date']}', CURDATE(), '1')";
        $result = mysqli_query($con, $insert_query);
        
        if (!$result) {
            die("Error: " . mysqli_error($con));
        }
    } else {
        die("Error: " . $error);
    }
}

// Set final message
$_SESSION['success'] = "🎉 Booking Successful! Your ID is $bookid.";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Processing Payment...</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            text-align: center;
            margin-top: 100px;
            background-color: #f9f9f9;
            color: #333;
        }
        .spinner {
            font-size: 22px;
            color: #007bff;
            margin: 30px 0;
        }
        .confirmation-box {
            display: inline-block;
            background: white;
            padding: 30px 50px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="confirmation-box">
        <h2>Confirming your payment...</h2>
        <p class="spinner">
            <i class="fa fa-spinner fa-pulse fa-fw"></i><br>
            Please do not refresh or close the page.
        </p>
        <h3>
            <?php 
            echo $_SESSION['success']; 
            ?>
        </h3>
    </div>

    <script>
        setTimeout(function(){ 
            window.location = "profile.php"; 
        }, 4000);
    </script>
</body>
</html>