<?php include('header.php');
if(!isset($_SESSION['user']))
{
	header('location:login.php');
}

// Get user information
$user_query = mysqli_query($con, "SELECT * FROM tbl_registration WHERE user_id='".$_SESSION['user']."'");
$user_data = mysqli_fetch_array($user_query);
?>
<div class="content">
	<div class="wrap">
		<div class="content-top">
				<div class="section group">
					<div class="about span_1_of_2">
						<!-- User profile section -->
						<div class="user-profile-header">
							<h3 style="color:#333;" class="text-center">MY PROFILE</h3>
							<div class="profile-card">
								<div class="profile-info">
									<div class="avatar">
										<i class="glyphicon glyphicon-user" style="font-size: 60px; color: #ccc;"></i>
									</div>
									<div class="user-details">
										<h4><?php echo $user_data['name']; ?></h4>
										<p><i class="glyphicon glyphicon-envelope"></i> <?php echo $user_data['email']; ?></p>
										<p><i class="glyphicon glyphicon-phone"></i> <?php echo $user_data['phone']; ?></p>
										<button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editProfileModal">
											<i class="glyphicon glyphicon-pencil"></i> Edit Profile
										</button>
									</div>
								</div>
							</div>
						</div>
						
						<!-- Booking history section -->
						<h3 style="color:#333; margin-top: 30px;" class="text-center">MY BOOKINGS</h3>
						<?php include('msgbox.php');?>
						
						<!-- Booking filters -->
						<div class="booking-filters">
							<div class="btn-group" role="group" aria-label="Booking filters">
								<button type="button" class="btn btn-default active" id="filter-all">All Bookings</button>
								<button type="button" class="btn btn-default" id="filter-upcoming">Upcoming</button>
								<button type="button" class="btn btn-default" id="filter-past">Past</button>
							</div>
							<div class="search-box">
								<input type="text" id="booking-search" class="form-control" placeholder="Search bookings...">
							</div>
						</div>
						
						<?php
						$bk=mysqli_query($con,"select * from tbl_bookings where user_id='".$_SESSION['user']."' ORDER BY ticket_date DESC");
						if(mysqli_num_rows($bk))
						{
						?>
						<div class="table-responsive booking-table">
							<table class="table table-hover table-striped">
								<thead>
									<tr>
										<th>Booking ID</th>
										<th>Movie</th>
										<th>Date</th>
										<th>Show</th>
										<th>Seats</th>
										<th>Location</th>
										<th>Amount</th>
										<th>Status</th>
										<th>Ticket</th>
									</tr>
								</thead>
								<tbody>
								<?php
								while($bkg=mysqli_fetch_array($bk))
								{
									$m=mysqli_query($con,"select * from tbl_movie where movie_id=(select movie_id from tbl_shows where s_id='".$bkg['show_id']."')");
									$mov=mysqli_fetch_array($m);
									$s=mysqli_query($con,"select * from tbl_screens where screen_id='".$bkg['screen_id']."'");
									$srn=mysqli_fetch_array($s);
									$tt=mysqli_query($con,"select * from tbl_theatre where id='".$bkg['t_id']."'");
									$thr=mysqli_fetch_array($tt);
									$st=mysqli_query($con,"select * from tbl_show_time where st_id=(select st_id from tbl_shows where s_id='".$bkg['show_id']."')");
									$stm=mysqli_fetch_array($st);
									
									// Fixed: Determine if the booking is upcoming or past
									$today = date('Y-m-d');
									$booking_class = (strtotime($bkg['ticket_date']) >= strtotime($today)) ? 'upcoming-booking' : 'past-booking';
								?>
									<tr class="<?php echo $booking_class; ?>">
										<td>
											<span class="booking-id"><?php echo $bkg['ticket_id'];?></span>
										</td>
										<td>
											<strong><?php echo $mov['movie_name'];?></strong>
										</td>
										<td>
											<?php echo date('D, d M Y', strtotime($bkg['ticket_date']));?>
										</td>
										<td>
											<?php echo date('h:i A', strtotime($stm['start_time']));?> 
											<small>(<?php echo $stm['name'];?>)</small>
										</td>
										<td>
											<span class="badge"><?php echo $bkg['no_seats'];?></span>
											<a href="#" data-toggle="popover" data-placement="top" title="Seat Details" data-content="<?php 
												if(!empty($bkg['seat_numbers'])) {
													$seats = json_decode($bkg['seat_numbers'], true);
													if(is_array($seats)) {
														echo 'Seats: ' . implode(', ', $seats);
													} else {
														echo "Not specified";
													}
												} else {
													echo "Not specified";
												}
											?>"><i class="glyphicon glyphicon-info-sign"></i></a>
										</td>
										<td>
											<?php echo $thr['name'];?><br>
											<small><?php echo $srn['screen_name'];?></small>
										</td>
										<td>
											<strong>₹<?php echo $bkg['amount'];?></strong>
										</td>
										<td>
											<?php 
											// Fixed: Correctly checking if the booking date is in the past
											if(strtotime($bkg['ticket_date']) < strtotime($today)) { 
											?>
												<span class="label label-default">Completed</span>
											<?php } else if($bkg['status'] == 0) { ?>
												<span class="label label-danger">Cancelled</span>
											<?php } else { ?>
												<span class="label label-success">Confirmed</span>
											<?php } ?>
										</td>
										<td>
											<?php 
											// Fixed: Logic for displaying ticket options
											if(strtotime($bkg['ticket_date']) >= strtotime($today) && $bkg['status'] == 1) { 
											?>
												<!-- Only show cancel option for upcoming and active bookings -->
												<div class="btn-group">
													<button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
														<i class="glyphicon glyphicon-cog"></i> <span class="caret"></span>
													</button>
													<ul class="dropdown-menu dropdown-menu-right" role="menu">
														<li><a href="#" class="view-ticket" data-booking="<?php echo $bkg['book_id'];?>">
															<i class="glyphicon glyphicon-eye-open"></i> View Ticket</a>
														</li>
														<li><a href="#" class="cancel-booking" data-booking="<?php echo $bkg['book_id'];?>" data-toggle="modal" data-target="#cancelModal">
															<i class="glyphicon glyphicon-remove"></i> Cancel Booking</a>
														</li>
													</ul>
												</div>
											<?php } else if(strtotime($bkg['ticket_date']) >= strtotime($today) && $bkg['status'] == 0) { ?>
												<button class="btn btn-danger btn-sm" disabled>Cancelled</button>
											<?php } else { ?>
												<button class="btn btn-default btn-sm view-ticket" data-booking="<?php echo $bkg['book_id'];?>">
													<i class="glyphicon glyphicon-eye-open"></i> View
												</button>
											<?php } ?>
										</td>
									</tr>
								<?php
								}
								?>
								</tbody>
							</table>
						</div>
						<?php
						}
						else
						{
						?>
						<div class="no-bookings">
							<div class="empty-state">
								<i class="glyphicon glyphicon-film" style="font-size: 48px; color: #ddd;"></i>
								<h3 style="color:#999;" class="text-center">No Bookings Found!</h3>
								<p class="text-center">You haven't booked any movie tickets yet.</p>
								<div class="text-center" style="margin-top: 20px;">
									<a href="index.php" class="btn btn-primary">Browse Movies</a>
								</div>
							</div>
						</div>
						<?php
						}
						?>
					</div>			
					<?php include('movie_sidebar.php');?>
				</div>
				<div class="clear"></div>		
			</div>
	</div>
</div>

<!-- Edit Profile Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1" role="dialog" aria-labelledby="editProfileLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="editProfileLabel">Edit Profile</h4>
			</div>
			<form id="edit-profile-form" method="post" action="update_profile.php">
				<div class="modal-body">
					<div class="form-group">
						<label for="name">Full Name</label>
						<input type="text" class="form-control" id="name" name="name" value="<?php echo $user_data['name']; ?>">
					</div>
					<div class="form-group">
						<label for="email">Email Address</label>
						<input type="email" class="form-control" id="email" name="email" value="<?php echo $user_data['email']; ?>" readonly>
						<small class="text-muted">Email address cannot be changed</small>
					</div>
					<div class="form-group">
						<label for="phone">Phone Number</label>
						<input type="text" class="form-control" id="phone" name="phone" value="<?php echo $user_data['phone']; ?>">
					</div>
					<div class="form-group">
						<label for="current_password">Current Password</label>
						<input type="password" class="form-control" id="current_password" name="current_password" placeholder="Enter current password">
					</div>
					<div class="form-group">
						<label for="new_password">New Password (leave blank to keep current)</label>
						<input type="password" class="form-control" id="new_password" name="new_password" placeholder="Enter new password">
					</div>
					<div class="form-group">
						<label for="confirm_password">Confirm New Password</label>
						<input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm new password">
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<button type="submit" class="btn btn-primary">Save Changes</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- Cancel Booking Modal -->
<div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="cancelModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="cancelModalLabel">Cancel Booking</h4>
			</div>
			<div class="modal-body">
				<div class="alert alert-warning">
					<i class="glyphicon glyphicon-exclamation-sign"></i> 
					<strong>Warning:</strong> This action cannot be undone.
				</div>
				<p>Are you sure you want to cancel this booking?</p>
				<p>Cancellation policy:</p>
				<ul>
					<li>Cancellations made more than 24 hours before show time: 100% refund</li>
					<li>Cancellations made between 12-24 hours before show time: 50% refund</li>
					<li>Cancellations made less than 12 hours before show time: No refund</li>
				</ul>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Keep My Booking</button>
				<a href="#" id="confirm-cancel" class="btn btn-danger">Yes, Cancel Booking</a>
			</div>
		</div>
	</div>
</div>

<!-- View Ticket Modal -->
<div class="modal fade" id="ticketModal" tabindex="-1" role="dialog" aria-labelledby="ticketModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="ticketModalLabel">Movie Ticket</h4>
			</div>
			<div class="modal-body" id="ticket-details">
				<!-- Ticket content will be loaded dynamically -->
				<div class="text-center">
					<i class="glyphicon glyphicon-refresh spinning"></i> Loading ticket...
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" id="print-ticket"><i class="glyphicon glyphicon-print"></i> Print Ticket</button>
			</div>
		</div>
	</div>
</div>

<style>
/* Profile styles */
.user-profile-header {
	margin-bottom: 30px;
}

.profile-card {
	background: #f9f9f9;
	border-radius: 5px;
	padding: 20px;
	box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.profile-info {
	display: flex;
	align-items: center;
}

.avatar {
	width: 80px;
	height: 80px;
	background: #eee;
	border-radius: 50%;
	display: flex;
	align-items: center;
	justify-content: center;
	margin-right: 20px;
}

.user-details h4 {
	margin-top: 0;
	color: #333;
}

/* Booking styles */
.booking-filters {
	margin: 20px 0;
	display: flex;
	justify-content: space-between;
	align-items: center;
}

.search-box {
	width: 250px;
}

.booking-table {
	margin-top: 20px;
}

.booking-id {
	font-family: monospace;
	font-weight: bold;
}

.no-bookings {
	padding: 40px 0;
	text-align: center;
}

.empty-state {
	padding: 30px;
	background: #f9f9f9;
	border-radius: 5px;
}

/* Animation for loading */
.spinning {
	animation: spin 1s infinite linear;
}

@keyframes spin {
	from { transform: scale(1) rotate(0deg); }
	to { transform: scale(1) rotate(360deg); }
}
</style>

<script type="text/javascript">
$(document).ready(function(){
	// Initialize popovers
	$('[data-toggle="popover"]').popover();
	
	// Booking filters
	$('#filter-all').click(function() {
		$(this).addClass('active').siblings().removeClass('active');
		$('.upcoming-booking, .past-booking').show();
	});
	
	$('#filter-upcoming').click(function() {
		$(this).addClass('active').siblings().removeClass('active');
		$('.upcoming-booking').show();
		$('.past-booking').hide();
	});
	
	$('#filter-past').click(function() {
		$(this).addClass('active').siblings().removeClass('active');
		$('.past-booking').show();
		$('.upcoming-booking').hide();
	});
	
	// Search functionality
	$('#booking-search').on('keyup', function() {
		var value = $(this).val().toLowerCase();
		$('.booking-table tbody tr').filter(function() {
			$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
		});
	});
	
	// Cancel booking
	$('.cancel-booking').click(function() {
		var bookingId = $(this).data('booking');
		$('#confirm-cancel').attr('href', 'cancel.php?id=' + bookingId);
	});
	
	// View ticket
	$('.view-ticket').click(function() {
		var bookingId = $(this).data('booking');
		// In a real system, you would load ticket data from the server
		// Here we'll just show a dummy ticket for demonstration
		$('#ticketModal').modal('show');
		
		// Simulate loading
		setTimeout(function() {
			$('#ticket-details').html('<div class="ticket-container">' +
				'<div class="ticket-header">' +
					'<h3>Movie Ticket</h3>' +
					'<p>Booking ID: <strong>' + $(".booking-id").text() + '</strong></p>' +
				'</div>' +
				'<div class="ticket-body">' +
					'<div class="row">' +
						'<div class="col-md-8">' +
							'<h4>Movie: Name Here</h4>' +
							'<p>Date: April 16, 2025</p>' +
							'<p>Time: 7:00 PM</p>' +
							'<p>Screen: Screen 2</p>' +
							'<p>Seats: A4, A5</p>' +
						'</div>' +
						'<div class="col-md-4 text-right">' +
							'<img src="https://via.placeholder.com/150" alt="QR Code">' +
						'</div>' +
					'</div>' +
				'</div>' +
				'<div class="ticket-footer">' +
					'<p>Present this ticket at the cinema entrance</p>' +
					'<p>Enjoy the movie!</p>' +
				'</div>' +
			'</div>');
		}, 1000);
	});
	
	// Print ticket
	$('#print-ticket').click(function() {
		var printContents = document.getElementById('ticket-details').innerHTML;
		var originalContents = document.body.innerHTML;
		document.body.innerHTML = printContents;
		window.print();
		document.body.innerHTML = originalContents;
		$('#ticketModal').modal('show');
	});
	
	// Profile form validation
	$('#edit-profile-form').submit(function(e) {
		var newPassword = $('#new_password').val();
		var confirmPassword = $('#confirm_password').val();
		
		if (newPassword && newPassword !== confirmPassword) {
			e.preventDefault();
			alert('New passwords do not match!');
		}
	});
});
</script>

<?php include('footer.php');?>