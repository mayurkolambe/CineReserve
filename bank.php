<?php
session_start();

if(!isset($_SESSION['user'])) {
    header('location:login.php');
    exit();
}

// Ensure we have all necessary booking data
if(!isset($_SESSION['screen']) || !isset($_SESSION['seats']) || !isset($_SESSION['amount'])) {
    header('location:index.php');
    exit();
}

// Extract POST data from form
extract($_POST);

// Get the last 4 digits of the card number
// Remove any spaces first, then get the last 4 digits
$cardNumber = str_replace(' ', '', $number);
$lastFour = substr($cardNumber, -4);
$maskedCardNumber = "xxxx xxxx xxxx " . $lastFour;
?>
<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0 minimal-ui"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta name="apple-mobile-web-app-capable" content="yes"/>
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta http-equiv="cache-control" content="max-age=0" />
<meta http-equiv="cache-control" content="no-cache" />
<meta http-equiv="expires" content="0" />
<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
<meta http-equiv="pragma" content="no-cache" />
<title>OMTBS - OTP Verification</title>
<link href="css/bank.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f5f7fa;
    margin: 0;
    padding: 20px;
    color: #333;
}
#mainContainer {
    max-width: 500px;
    margin: 30px auto;
    background-color: #fff;
    border-radius: 12px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    padding: 28px;
}
.text-center h2 {
    color: #1a365d;
    margin: 0 0 5px 0;
    font-size: 22px;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
}
.bank-icon {
    margin-right: 10px;
    color: #2563eb;
}
.divider {
    border: none;
    height: 1px;
    background-color: #e5e7eb;
    margin: 18px 0;
}
.mercDetails {
    display: grid;
    grid-template-columns: 40% 60%;
    row-gap: 14px;
    margin: 20px 0;
    font-size: 15px;
}
.mercDetails dt {
    color: #64748b;
    font-weight: normal;
}
.mercDetails dd {
    color: #1e293b;
    font-weight: 600;
    margin-left: 0;
}
.page-heading {
    margin-bottom: 25px;
}
.form-heading {
    font-size: 18px;
    margin-bottom: 8px;
    color: #1a365d;
    font-weight: 600;
}
.form-subheading {
    color: #4a5568;
    margin-top: 0;
    font-size: 14px;
    line-height: 1.4;
}
.form-control {
    width: 100%;
    padding: 14px;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    font-size: 16px;
    margin-top: 5px;
    box-sizing: border-box;
    letter-spacing: 1px;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}
.form-control:focus {
    border-color: #3b82f6;
    outline: none;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
}
label {
    display: block;
    margin-bottom: 5px;
    color: #4a5568;
    font-size: 14px;
    font-weight: 500;
}
.button {
    background-color: #2563eb;
    border: none;
    color: white;
    padding: 14px 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 0;
    cursor: pointer;
    border-radius: 8px;
    transition: background-color 0.2s;
    width: 100%;
    font-weight: 600;
}
.button:hover {
    background-color: #1d4ed8;
}
.resendBtn {
    text-align: right;
    margin-top: 16px;
}
.request-link {
    color: #2563eb;
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
}
.request-link:hover {
    text-decoration: underline;
}
.tryAgain {
    display: inline-block;
    margin-top: 24px;
    color: #64748b;
    text-decoration: none;
    font-size: 14px;
}
.tryAgain:hover {
    color: #2563eb;
}
.alert {
    padding: 14px;
    margin-bottom: 20px;
    border-radius: 8px;
}
.alert-danger {
    background-color: #fee2e2;
    color: #b91c1c;
    border: 1px solid #fecaca;
}
.secure-badge {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-top: 24px;
    color: #64748b;
    font-size: 13px;
    padding-top: 16px;
    border-top: 1px dashed #e5e7eb;
}
.secure-badge i {
    margin-right: 6px;
    color: #059669;
}
.card-info {
    font-family: monospace;
    letter-spacing: 1px;
}
.bank-logo {
    text-align: center;
    margin-bottom: 10px;
}
.bank-logo img {
    height: 40px;
}
.otp-container {
    background-color: #f8fafc;
    border-radius: 8px;
    padding: 20px;
    margin: 20px 0;
    border: 1px solid #e2e8f0;
}
</style>
</head>

<body>

<div id="mainContainer">
  <div class="bank-logo">
    <!-- Placeholder for a bank logo -->
    <div class="text-center"><h2><i class="fa fa-university bank-icon"></i> SECURE PAYMENT</h2></div>
  </div>
  <hr class="divider">
  <dl class="mercDetails">
  	<dt>Merchant:</dt> <dd>Movie Theatre Booking</dd>
    <dt>Amount:</dt> <dd><strong>INR <?php echo $_SESSION['amount'];?></strong></dd>
    <dt>Card Number:</dt> <dd class="card-info"><?php echo $maskedCardNumber;?></dd>
    <dt>Date:</dt> <dd><?php echo date('d M Y, H:i'); ?></dd>
  </dl>
  <hr class="divider">

  <form name="form1" id="form1" method="post" action="verify_otp.php" onsubmit="return ValidateForm();">

<fieldset class="page2" style="border:none; padding:0; margin:0;">
<?php if(isset($_SESSION['error'])): ?>
<div class="alert alert-danger">
    <i class="fa fa-exclamation-circle"></i> <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
</div>
<?php endif; ?>

<div class="otp-container">
  <div class="page-heading">
    <h6 class="form-heading">Authenticate Payment</h6>
    <p class="form-subheading">For your security, we've sent a One-Time Password (OTP) to your email address ending with <strong>***@gmail.com</strong></p>
  </div>

  <div>
    <label for="customerpin">Enter One Time Password (OTP)</label>
    <input type="tel" id="customerpin" name="customerpin" class="form-control optPass" value="" maxlength="6" autocomplete="off" placeholder="Enter 6-digit OTP"/>
  </div>

  <div style="margin-top: 16px;">
    <button type="submit" class="button next">COMPLETE PAYMENT</button>
  </div>

  <div class="resendBtn requestOTP">
    <a class="request-link" href="resend_otp.php"><i class="fa fa-refresh"></i> Resend OTP</a>
  </div>
</div>

<div class="secure-badge">
    <i class="fa fa-lock"></i> Transaction secured with 256-bit encryption
</div>

<p>
<a class="tryAgain" href="booking.php"><i class="fa fa-arrow-left"></i> Return to booking</a>
</p>
</fieldset>
</form>
</div>

<script src="bank/script/jquery-1.9.1.js"></script>
<script>
document.onmousedown = rightclickD;
function rightclickD(e) {
  e = e || event;
  if (e.button == 2) {
    alert('Function Disabled...');
    return false;
  }
}

function ValidateForm() {
    var regPin = RegExp("^[0-9]{4,6}$");
    var pin = document.form1.customerpin.value;
    if(pin == "" || !pin.match(regPin)) { 
        alert("Please enter a valid 6 digit One Time Password (OTP) received on your registered email address.");
        document.form1.customerpin.focus();
        return false; 
    } else {
        return true;
    }
}
</script>

</body>
</html>