<?php
include('config.php');
session_start();

// Check if user is logged in
if(!isset($_SESSION['user'])) {
    header('location:login.php');
    exit;
}

// Get user data
$user_id = $_SESSION['user'];

// Check if form was submitted
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Get form data
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Check if fields are empty
    if(empty($name) || empty($phone)) {
        $_SESSION['error'] = "Name and phone number are required";
        header('location:profile.php');
        exit;
    }
    
    // Validate phone number (basic check - can be enhanced)
    if(!preg_match('/^\d{10}$/', $phone)) {
        $_SESSION['error'] = "Phone number must be 10 digits";
        header('location:profile.php');
        exit;
    }
    
    // First, update basic info
    $update_query = "UPDATE tbl_registration SET 
                     name = '$name',
                     phone = '$phone'
                     WHERE user_id = '$user_id'";
    
    if(mysqli_query($con, $update_query)) {
        // Basic info updated successfully
        
        // Check if user wants to change password
        if(!empty($current_password)) {
            
            // Verify current password
            $password_query = mysqli_query($con, "SELECT * FROM tbl_login WHERE user_id = '$user_id'");
            $password_data = mysqli_fetch_array($password_query);
            
            if($password_data['password'] == $current_password) {
                
                // Check if new password is provided
                if(!empty($new_password)) {
                    
                    // Check if new password and confirm password match
                    if($new_password == $confirm_password) {
                        
                        // Update password
                        $password_update = "UPDATE tbl_login SET 
                                          password = '$new_password'
                                          WHERE user_id = '$user_id'";
                        
                        if(mysqli_query($con, $password_update)) {
                            $_SESSION['success'] = "Profile and password updated successfully";
                        } else {
                            $_SESSION['error'] = "Failed to update password: " . mysqli_error($con);
                        }
                        
                    } else {
                        $_SESSION['error'] = "New passwords do not match";
                    }
                    
                } else {
                    $_SESSION['success'] = "Profile updated successfully";
                }
                
            } else {
                $_SESSION['error'] = "Current password is incorrect";
            }
            
        } else {
            $_SESSION['success'] = "Profile updated successfully";
        }
        
    } else {
        $_SESSION['error'] = "Failed to update profile: " . mysqli_error($con);
    }
    
    // Redirect back to profile page
    header('location:profile.php');
    exit;
}

// If not a POST request, redirect to profile page
header('location:profile.php');
exit;
?>