<?php include('header.php'); ?>
</div>

<style>
.movie-poster {
	width: 100%;
	height: 300px;
	object-fit: contain;
	background-color: #000;
	transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.movie-poster:hover {
	transform: scale(1.05);
	box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
}
</style>

<div class="content">
	<div class="wrap">
		<div class="content-top">
			<center><h1 style="color:#555;">NOW SHOWING</h1></center>

			<div class="row" style="display: flex; flex-wrap: wrap; gap: 20px; justify-content: center;">
			<?php
          	$today = date("Y-m-d");
          	$qry2 = mysqli_query($con, "SELECT * FROM tbl_movie WHERE status='0' ORDER BY movie_id DESC");

          	if(mysqli_num_rows($qry2) > 0) {
				while($m = mysqli_fetch_array($qry2)) {
			?>
					<div class="col_1_of_4 span_1_of_4" style="width: 22%; min-width: 200px; box-sizing: border-box;">
						<div class="imageRow">
							<div class="single">
								<a href="about.php?id=<?php echo $m['movie_id']; ?>">
									<img src="<?php echo htmlspecialchars($m['image']); ?>" 
									     alt="<?php echo htmlspecialchars($m['movie_name']); ?>" 
									     class="movie-poster" />
								</a>
							</div>
							<div class="movie-text" style="margin-top: 10px;">
								<h4 class="h-text" style="margin-bottom: 5px;">
									<a href="about.php?id=<?php echo $m['movie_id']; ?>" style="text-decoration:none; color: #333;">
										<?php echo htmlspecialchars($m['movie_name']); ?>
									</a>
								</h4>
								Cast: <span class="color2"><?php echo htmlspecialchars($m['cast']); ?></span>
							</div>
						</div>
					</div>
			<?php
				}
			} else {
			?>
				<div class="alert alert-info" style="text-align:center;">
					<strong>No movies currently showing.</strong> Please check back later.
				</div>
			<?php
			}
			?>
			</div>
			<div class="clear"></div>
		</div>
	</div>
</div>

<?php include('footer.php'); ?>
