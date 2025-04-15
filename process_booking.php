<?php
session_start();
if(!isset($_SESSION['user'])) {
    header('location:login.php');
    exit();
}

include('config.php');

// Check if form is submitted from seat selection
if(isset($_POST['selectedSeats'])) {
    // Store booking information
    $_SESSION['screen'] = $_POST['screen'];
    $_SESSION['seats'] = $_POST['seats'];  // Number of seats
    $_SESSION['selectedSeats'] = $_POST['selectedSeats'];  // JSON string of seat IDs
    $_SESSION['amount'] = $_POST['amount'];
    $_SESSION['date'] = $_POST['date'];
    $_SESSION['theatre'] = $_POST['theatre'] ?? $_SESSION['theatre'] ?? '';
    $_SESSION['show'] = $_POST['show'] ?? $_SESSION['show'] ?? '';
    
    // Continue to payment form
    include('header.php');
?>
<link rel="stylesheet" href="validation/dist/css/bootstrapValidator.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script type="text/javascript" src="validation/dist/js/bootstrapValidator.js"></script>
<?php include('form.php'); $frm=new formBuilder(); ?> 

<div class="content">
    <div class="wrap">
        <div class="content-top">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="panel panel-default" style="border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                            <div class="panel-heading" style="background-color: #337ab7; color: white; border-radius: 10px 10px 0 0;">
                                <h3 class="panel-title" style="font-size: 22px;">
                                    <i class="fa fa-credit-card"></i> Payment Details
                                </h3>
                            </div>
                            <div class="panel-body">
                                <!-- Booking Summary Box -->
                                <div class="well" style="background-color: #f8f9fa; border-radius: 8px;">
                                    <h4><i class="fa fa-film"></i> Booking Summary</h4>
                                    <table class="table table-borderless">
                                        <tr>
                                            <td><strong>Seats:</strong></td>
                                            <td><?php echo $_SESSION['seats']; ?></td>
                                            <td><strong>Date:</strong></td>
                                            <td><?php echo date('d M Y', strtotime($_SESSION['date'])); ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Amount:</strong></td>
                                            <td><i class="fa fa-inr"></i> <?php echo $_SESSION['amount']; ?></td>
                                            <td><strong>Screen:</strong></td>
                                            <td><?php echo $_SESSION['screen']; ?></td>
                                        </tr>
                                    </table>
                                </div>

                                <form action="send_otp.php" method="post" id="form1">
                                    <div style="margin-bottom:50px">
                                        <!-- Card Icons displayed above the Name field -->
                                        <div class="text-center" style="margin: 0 0 20px 0;">
                                            <i class="fa fa-cc-visa fa-2x" style="margin: 0 5px;"></i>
                                            <i class="fa fa-cc-mastercard fa-2x" style="margin: 0 5px;"></i>
                                            <i class="fa fa-cc-amex fa-2x" style="margin: 0 5px;"></i>
                                            <i class="fa fa-cc-discover fa-2x" style="margin: 0 5px;"></i>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="control-label"><i class="fa fa-user"></i> Name on Card</label>
                                            <input type="text" class="form-control" name="name" placeholder="Shubham Patil">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label"><i class="fa fa-credit-card"></i> Card Number</label>
                                            <input type="text" class="form-control" name="number" id="cardNumber" required 
                                                title="Enter 16 digit card number" maxlength="19" 
                                                placeholder="XXXX XXXX XXXX XXXX">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label"><i class="fa fa-calendar"></i> Expiration Date</label>
                                                    <input type="text" class="form-control" name="date" id="expiryDate" placeholder="MM/YY">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label"><i class="fa fa-lock"></i> CVV</label>
                                                    <input type="password" class="form-control" name="cvv" maxlength="3" placeholder="•••">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success btn-lg btn-block">
                                                <i class="fa fa-check-circle"></i> Make Payment
                                            </button>
                                        </div>
                                        
                                        <div class="text-center" style="margin-top: 20px;">
                                            <p><small><i class="fa fa-lock"></i> Your payment information is secure.</small></p>
                                            <img src="https://www.pngkey.com/png/detail/216-2169146_payment-options-visa-mastercard-maestro.png" alt="Payment Options" style="max-height: 30px;">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="clear"></div>    
    </div>
</div>
<?php include('footer.php'); ?>

<script>
// Format card number while typing (add spaces)
// Format card number while typing (add spaces)
$(document).ready(function() {
    $('#cardNumber').on('input', function() {
        // Remove non-digits and spaces
        var val = $(this).val().replace(/\s+/g, '').replace(/[^0-9]/gi, '');
        
        // Limit to 16 digits max
        if (val.length > 16) {
            val = val.substring(0, 16);
        }
        
        // Format with spaces every 4 digits
        var parts = [];
        for (i=0; i<val.length; i+=4) {
            parts.push(val.substring(i, Math.min(i+4, val.length)));
        }
        
        if (parts.length) {
            $(this).val(parts.join(' '));
        } else {
            $(this).val(val);
        }
    });

    
    
    // Improved expiry date formatting
    $('#expiryDate').on('input', function() {
        var val = $(this).val().replace(/\s+/g, '').replace(/[^0-9]/gi, '');
        
        // Handle month input
        if (val.length >= 1) {
            // First digit of month must be 0 or 1
            if (val[0] > 1) {
                val = '0' + val[0];
            }
            
            // If first digit is 1, second digit can only be 0-2
            if (val.length >= 2) {
                if (val[0] == 1 && val[1] > 2) {
                    val = val[0] + '2' + val.substring(2);
                }
            }
        }
        
        // Format with slash after month
        if (val.length > 2) {
            $(this).val(val.substring(0, 2) + '/' + val.substring(2, 4));
        } else {
            $(this).val(val);
        }
    });
    
    // Validate form
    $('#form1').bootstrapValidator({
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: { 
            name: {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'The Name is required and can\'t be empty'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z ]+$/,
                        message: 'The Name can only consist of alphabets'
                    }
                }
            },
            number: {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'The Card Number is required and can\'t be empty'
                    },
                    callback: {
                        message: 'Please enter a valid 16-digit card number',
                        callback: function(value, validator) {
                            // Remove spaces
                            var cardNumber = value.replace(/\s+/g, '');
                            
                            // Check if empty
                            if (cardNumber.length === 0) {
                                return {
                                    valid: false,
                                    message: 'The card number is required'
                                };
                            }
                            
                            // Check length requirement - MUST be exactly 16 digits
                            if (cardNumber.length !== 16) {
                                return {
                                    valid: false,
                                    message: 'The card number must be exactly 16 digits (currently ' + cardNumber.length + ' digits)'
                                };
                            }
                            
                            // Check if all characters are digits
                            if (!/^\d+$/.test(cardNumber)) {
                                return {
                                    valid: false,
                                    message: 'The card number can only contain digits'
                                };
                            }
                            
                            // Luhn Algorithm check
                            let sum = 0;
                            let shouldDouble = false;
                            for (let i = cardNumber.length - 1; i >= 0; i--) {
                                let digit = parseInt(cardNumber.charAt(i));
                                
                                if (shouldDouble) {
                                    digit *= 2;
                                    if (digit > 9) digit -= 9;
                                }
                                
                                sum += digit;
                                shouldDouble = !shouldDouble;
                            }
                            
                            if (sum % 10 !== 0) {
                                return {
                                    valid: false,
                                    message: 'Invalid card number'
                                };
                            }
                            
                            return true;
                        }
                    }
                }
            },
            date: {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'The Expiry Date is required and can\'t be empty'
                    },
                    regexp: {
                        regexp: /^(0[1-9]|1[0-2])\/([0-9]{2})$/,
                        message: 'Enter a valid expiry date (MM/YY)'
                    },
                    callback: {
                        message: 'Card is expired',
                        callback: function(value, validator) {
                            if (!value) return true;
                            
                            // Get the current date
                            const currentDate = new Date();
                            const currentMonth = currentDate.getMonth() + 1; // getMonth returns 0-11
                            const currentYear = currentDate.getFullYear() % 100; // Get last two digits
                            
                            // Parse the input date
                            const parts = value.split('/');
                            const month = parseInt(parts[0]);
                            const year = parseInt(parts[1]);
                            
                            // Check if card is expired
                            if (year < currentYear || (year === currentYear && month < currentMonth)) {
                                return false;
                            }
                            
                            return true;
                        }
                    }
                }
            },
            cvv: {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'The CVV is required and can\'t be empty'
                    },
                    stringLength: {
                        min: 3,
                        max: 3,
                        message: 'The CVV must be 3 characters long'
                    },
                    regexp: {
                        regexp: /^[0-9]+$/,
                        message: 'Enter a valid CVV'
                    }
                }
            }
        }
    });
});
</script>
<?php
} else {
    // If direct access without form submission, redirect to prevent errors
    header('location:index.php');
    exit();
}
?>