<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include('config.php');

date_default_timezone_set('Asia/Kolkata');
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <title>OMTBS</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
    <link rel="stylesheet" href="css/flexslider.css" type="text/css" media="all" />
    <link rel="stylesheet" href="css/tsc_tabs.css" type="text/css" media="all" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src='js/jquery.color-RGBa-patch.js'></script>
    <script src='js/example.js'></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
        /* Modern Header Styling */
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .header {
            background-color: #1b1b1b;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        
        .header-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }
        
        .header-top {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 0;
    position: relative;
}
        
        /* Increased logo size */
        /* Create a fixed height container for the logo */
.logo {
    flex: 0 0 auto;
    padding-right: 20px;
    display: flex;
    align-items: center;
    height: 70px; /* Set a fixed height for the logo container */
    overflow: visible; /* Allow logo to overflow without affecting layout */
}

/* Position the logo with absolute positioning */
.logo img {
    max-height: 300px; /* Your desired logo size */
    width: auto;
    vertical-align:  bottom ;
    top: 33px;
    position: relative; /* Allow positioning without breaking the flow */
    z-index: 10; /* Ensure logo appears above other elements if needed */
}
        
.navigation {
    flex: 1;
    text-align: right;
    align-self: center; /* Ensure it stays vertically centered */
}
        
        /* Fixed navigation menu alignment */
        .nav-menu {
            list-style: none;
            margin: 0;
            padding: 0;
            display: inline-flex;
            align-items: center;
        }
        
        .nav-menu li {
            margin: 0 15px;
            display: flex;
            align-items: center;
        }
        
        .nav-menu li:last-child {
            margin-right: 0;
        }
        
        .nav-menu a {
            color: #fff;
            text-decoration: none;
            font-size: 16px;
            font-weight: 500;
            transition: color 0.3s;
            padding: 5px 0;
            position: relative;
            white-space: nowrap;
        }
        
        .nav-menu a:hover {
            color: #ca072b;
        }
        
        .nav-menu a:after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 0;
            background-color: #ca072b;
            transition: width 0.3s;
        }
        
        .nav-menu a:hover:after {
            width: 100%;
        }
        
        /* Search Bar Container */
        .search-container {
            background-color: #1b1b1b;
            padding: 15px 0;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .search-form {
            max-width: 600px;
            margin: 0 auto;
            display: flex;
            justify-content: center;
        }
        
        .search-input {
            flex: 1;
            padding: 10px 15px;
            border: none;
            border-radius: 4px 0 0 4px;
            font-size: 16px;
            outline: none;
            max-width: 400px;
        }
        
        .search-button {
            background-color: #ca072b;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 0 4px 4px 0;
            cursor: pointer;
            font-size: 16px;
            font-weight: 500;
            transition: background-color 0.3s;
        }
        
        .search-button:hover {
            background-color: #b70929;
        }
        
        /* Mobile Menu Toggle */
        .menu-toggle {
            display: none;
            background: none;
            border: none;
            color: white;
            font-size: 24px;
            cursor: pointer;
            padding: 5px;
        }
        
        /* Updated User Account styling - all on one line */
        .auth-links {
            display: flex;
            align-items: center;
        }
        
        .auth-links a {
            margin-left: 15px;
        }
        
        .auth-links a:first-child {
            margin-left: 0;
        }
        
        /* Responsive Styles */
        @media (max-width: 860px) {
            .header-top {
                flex-wrap: wrap;
            }
            
            .logo {
                flex: 1;
                text-align: left;
            }
            
            .menu-toggle {
                display: block;
                order: 3;
            }
            
            .navigation {
                flex-basis: 100%;
                order: 4;
                text-align: left;
                display: none;
                margin-top: 15px;
            }
            
            .nav-menu {
                flex-direction: column;
                width: 100%;
                align-items: flex-start;
            }
            
            .nav-menu li {
                margin: 10px 0;
                width: 100%;
                border-bottom: 1px solid rgba(255,255,255,0.1);
                padding-bottom: 10px;
            }
            
            .auth-links {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .auth-links a {
                margin: 5px 0;
                margin-left: 0;
            }
            
            .navigation.active {
                display: block;
            }
            
            .search-container {
                order: 5;
            }
            
            .search-form {
                flex-direction: column;
                align-items: center;
            }
            
            .search-input {
                border-radius: 4px;
                width: 100%;
                margin-bottom: 10px;
                max-width: none;
            }
            
            .search-button {
                width: 100%;
                border-radius: 4px;
            }
        }
    </style>
</head>
<body>
<div class="header">
    <div class="header-container">
        <div class="header-top">
            <div class="logo">
                <a href="index.php">
                    <img src="images/Removal-992.png" alt="Online Movie Theatre Booking System">
                </a>
            </div>

            <button class="menu-toggle" id="menuToggle">☰</button>

            <nav class="navigation" id="mainNav">
                <ul class="nav-menu">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="movies_events.php">Movies</a></li>
                    <?php if(isset($_SESSION['user'])) {
                        $us = mysqli_query($con, "SELECT * FROM tbl_registration WHERE user_id='" . mysqli_real_escape_string($con, $_SESSION['user']) . "'");
                        $user = mysqli_fetch_array($us);
                    ?>
                    <li><a href="profile.php"><?php echo htmlspecialchars($user['name']); ?></a></li>
                    <li><a href="logout.php">Logout</a></li>
                    <?php } else { ?>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="registration.php">Register</a></li>
                    <?php } ?>
                </ul>
            </nav>
        </div>
    </div>
    
    <div class="search-container">
        <div class="header-container">
            <form action="process_search.php" class="search-form" method="post" onsubmit="return validateSearch();">
                <input type="text" placeholder="Enter A Movie Name" class="search-input" id="search111" name="search" required>
                <button type="submit" class="search-button" id="button111">Search</button>
            </form>
        </div>
    </div>
</div>

<script>
// Simple mobile menu toggle
document.getElementById('menuToggle').addEventListener('click', function() {
    document.getElementById('mainNav').classList.toggle('active');
});

// Search validation
function validateSearch() {
    if(document.getElementById('search111').value.trim() === "") {
        alert("Please enter movie name...");
        return false;
    }
    return true;
}
</script>