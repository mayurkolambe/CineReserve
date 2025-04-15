<?php
session_start();

include('config.php');
include('header.php');

if(!isset($_SESSION['user'])) {
    header('location:login.php');
    exit();
}

// Make sure we have a movie ID
if(!isset($_SESSION['movie'])) {
    header('location:index.php');
    exit();
}

$qry2 = mysqli_query($con, "SELECT * FROM tbl_movie WHERE movie_id='" . $_SESSION['movie'] . "'");
$movie = mysqli_fetch_array($qry2);

if(!$movie) {
    header('location:index.php');
    exit();
}
?>

<div class="content">
    <div class="wrap">
        <div class="content-top">
            <div class="section group">
                <div class="about span_1_of_2">
                    <h3><?php echo $movie['movie_name']; ?></h3>
                    <div class="about-top">
                        <div class="grid images_3_of_2">
                            <img src="<?php echo $movie['image']; ?>" alt=""/>
                        </div>
                        <div class="desc span_3_of_2">
                            <p class="p-link" style="font-size:15px"><b>Cast : </b><?php echo $movie['cast']; ?></p>
                            <p class="p-link" style="font-size:15px"><b>Release Date : </b><?php echo date('d-M-Y',strtotime($movie['release_date'])); ?></p>
                            <p style="font-size:15px"><?php echo $movie['desc']; ?></p>
                            <a href="<?php echo $movie['video_url']; ?>" target="_blank" class="watch_but">Watch Trailer</a>
                        </div>
                        <div class="clear"></div>
                    </div>

                    <?php
                    // Make sure we have a show ID
                    if(!isset($_SESSION['show'])) {
                        echo "<p class='alert alert-danger'>No show selected. Please select a show first.</p>";
                        exit();
                    }
                    
                    $s = mysqli_query($con, "SELECT * FROM tbl_shows WHERE s_id='" . $_SESSION['show'] . "'");
                    $shw = mysqli_fetch_array($s);
                    
                    if(!$shw) {
                        echo "<p class='alert alert-danger'>Selected show not found.</p>";
                        exit();
                    }

                    $t = mysqli_query($con, "SELECT * FROM tbl_theatre WHERE id='" . $shw['theatre_id'] . "'");
                    $theatre = mysqli_fetch_array($t);

                    $ttm = mysqli_query($con, "SELECT * FROM tbl_show_time WHERE st_id='" . $shw['st_id'] . "'");
                    $ttme = mysqli_fetch_array($ttm);

                    $sn = mysqli_query($con, "SELECT * FROM tbl_screens WHERE screen_id='" . $ttme['screen_id'] . "'");
                    $screen = mysqli_fetch_array($sn);

                    // Basic date setup - focusing on simplicity
                    $today = date('Y-m-d');
                    $start_date = $shw['start_date'];
                    $end_date = !empty($shw['end_date']) ? $shw['end_date'] : date('Y-m-d', strtotime('+30 days')); // Default to 30 days if no end date

                    // Default to today or start date (whichever is later)
                    $default_date = (strtotime($start_date) > strtotime($today)) ? $start_date : $today;

                    // Get the date from URL or use default
                    $selected_date = isset($_GET['date']) ? $_GET['date'] : $default_date;

                    // Validate selected date is within range and not in the past
                    if(strtotime($selected_date) < strtotime($today)) {
                        $selected_date = $today; // Don't allow dates in the past
                    } elseif(!empty($end_date) && strtotime($selected_date) > strtotime($end_date)) {
                        $selected_date = $end_date; // Don't allow dates beyond end date
                    }
                    
                    // // Add this right after the date validation code
                    // echo "<div style='background:#f8f9fa;padding:10px;margin:10px 0;border:1px solid #ddd;'>";
                    // echo "Date Debug:<br>";
                    // echo "URL Date: " . (isset($_GET['date']) ? $_GET['date'] : 'Not Set') . "<br>";
                    // echo "Today: " . $today . "<br>";
                    // echo "Start Date: " . $start_date . "<br>";
                    // echo "End Date: " . $end_date . "<br>";
                    // echo "Default Date: " . $default_date . "<br>";
                    // echo "Selected Date Before Validation: " . (isset($_GET['date']) ? $_GET['date'] : 'Not Set') . "<br>";
                    // echo "Is date valid? " . (strtotime($selected_date) >= strtotime($default_date) && strtotime($selected_date) <= strtotime($end_date) ? 'Yes' : 'No') . "<br>";
                    // echo "Final Selected Date: " . $selected_date . "<br>";
                    // echo "</div>";
                    

                    // Add this before the availability query
                    // echo "<div style='background:#f8f9fa;padding:10px;margin:10px 0;border:1px solid #ddd;'>";
                    // echo "Debug Info:<br>";
                    // echo "Selected Date: " . $selected_date . "<br>";
                    // echo "Show ID: " . $_SESSION['show'] . "<br>";
                    // echo "</div>";

                    $av = mysqli_query($con, "SELECT SUM(no_seats) FROM tbl_bookings WHERE show_id='" . $_SESSION['show'] . "' AND ticket_date='$selected_date'");
                    $avl = mysqli_fetch_array($av);

                    // Add this
                    // echo "<div style='background:#f8f9fa;padding:10px;margin:10px 0;border:1px solid #ddd;'>";
                    // echo "Query Result: " . var_export($avl, true) . "<br>";
                    // echo "</div>";

                    $availableSeats = $screen['seats'] - (is_null($avl[0]) ? 0 : $avl[0]);
                    ?>

                    <form action="seat_selection.php" method="get">
                        <table class="table table-hover table-bordered text-center">
                            <tr>
                                <td class="col-md-6">Theatre</td>
                                <td><?php echo $theatre['name'] . ", " . $theatre['place']; ?></td>
                            </tr>
                            <tr>
                                <td>Screen</td>
                                <td><?php echo $screen['screen_name']; ?></td>
                            </tr>
                            <tr>
                                <td>Date</td>
                                <td>
                                    <!-- Simple date picker with calendar icon -->
                                    <div class="input-group date-picker">
                                        <input type="text" id="datepicker" class="form-control" value="<?php echo date('d-m-Y', strtotime($selected_date)); ?>" readonly>
                                        <span class="input-group-addon">
                                            <i class="glyphicon glyphicon-calendar"></i>
                                        </span>
                                    </div>
                                    <input type="hidden" id="selected_date" name="date" value="<?php echo $selected_date; ?>">
                                </td>
                            </tr>
                            <tr>
                                <td>Show Time</td>
                                <td><?php echo date('h:i A', strtotime($ttme['start_time'])) . " " . $ttme['name']; ?> Show</td>
                            </tr>
                            <tr>
                                <td>Ticket Price</td>
                                <td>Rs. <?php echo $screen['charge']; ?> per seat</td>
                            </tr>
                            <tr>
                                <td>Available Seats</td>
                                <td><?php echo $availableSeats; ?> / <?php echo $screen['seats']; ?></td>
                            </tr>
                        </table>
                        
                        <input type="hidden" name="show" value="<?php echo $_SESSION['show']; ?>"/>
                        <input type="hidden" name="screen" value="<?php echo $screen['screen_id']; ?>"/>
                        
                        <table class="table">
                            <tr>
                                <td colspan="2">
                                    <?php if($availableSeats <= 0) { ?>
                                        <button type="button" class="btn btn-danger" style="width:100%">House Full</button>
                                    <?php } else { ?>
                                        <button type="submit" class="btn btn-info" style="width:100%">Select Seats</button>
                                    <?php } ?>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
                <?php include('movie_sidebar.php'); ?>
            </div>
        </div>
    </div>
</div>

<!-- Add jQuery UI for datepicker if not already included -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize datepicker
    $("#datepicker").datepicker({
    dateFormat: 'dd-mm-yy',
    minDate: new Date('<?php echo $today; ?>'),
    maxDate: new Date('<?php echo $end_date; ?>'),
    changeMonth: true,
    changeYear: true,
    onSelect: function(dateText, inst) {
        // Convert the selected date to YYYY-MM-DD format for the hidden field
        var selectedDate = $(this).datepicker('getDate');
        var formattedDate = $.datepicker.formatDate('yy-mm-dd', selectedDate);
        
        // Update the hidden field
        $("#selected_date").val(formattedDate);
        
        // Reload the page with the new date
        window.location.href = 'booking.php?date=' + formattedDate;
    }
});
    
    // Make the entire date field clickable to show the calendar
    $(".date-picker").click(function() {
        $("#datepicker").datepicker("show");
    });
});
</script>

<?php include('footer.php'); ?>