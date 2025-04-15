<div class="footer">
	<div class="wrap">
		<div class="footer-top">
			<div class="col_1_of_4 span_1_of_4">
				<div class="footer-nav">
					<ul>
						<li><a href="index.php" style="text-decoration:none;">Home</a></li>
						<li><a href="movies_events.php" style="text-decoration:none;">Movies</a></li>
						<li><a href="login.php" style="text-decoration:none;">Login</a></li>
					</ul>
				</div>
			</div>
			<div class="col_1_of_4 span_1_of_4">
				<div class="textcontact">
					<p>Theatre Assistance<br>
					Online Movie Theatre Booking System<br>
					Ph: 6969786969<br>
					</p>
				</div>
			</div>
			<div class="col_1_of_4 span_1_of_4">
				<div class="call_info">
					<p class="txt_3">Call us toll free:</p>
					<p class="txt_4">1 200 696 39669</p>
				</div>
			</div>
			<div class="col_1_of_4 span_1_of_4">
				<div class="social">
					<a href="#"><img src="images/fb.png" alt="Facebook"/></a>
					<a href="#"><img src="images/tw.png" alt="Twitter"/></a>
					<a href="#"><img src="images/dribble.png" alt="Dribble"/></a>
					<a href="#"><img src="images/pinterest.png" alt="Pinterest"/></a>
				</div>
			</div>
			<div class="clear"></div>
		</div>
	</div>
</div>
</body>
</html>

<style>
.content {
	padding-bottom: 0px !important;
}
#form111 {
	width: 500px;
	margin: 50px auto;
}
#search111 {
	padding: 8px 15px;
	background-color: #fff;
	border: 0px solid #dbdbdb;
}
#button111 {
	position: relative;
	padding: 6px 15px;
	left: -8px;
	border: 2px solid #ca072b;
	background-color: #ca072b;
	color: #fafafa;
}
#button111:hover {
	background-color: #b70929;
	color: white;
}
</style>

<script src="js/auto-complete.js"></script>
<link rel="stylesheet" href="css/auto-complete.css">
<script>
	var demo1 = new autoComplete({
		selector: '#search111',
		minChars: 1,
		source: function(term, suggest) {
			term = term.toLowerCase();
			<?php
			$qry2 = mysqli_query($con, "SELECT * FROM tbl_movie");
			$string = "";
			while($ss = mysqli_fetch_array($qry2)) {
				$string .= "'".addslashes(strtoupper($ss['movie_name']))."'" . ",";
			}
			?>
			var choices = [<?php echo rtrim($string, ','); ?>];
			var suggestions = [];
			for (i = 0; i < choices.length; i++) {
				if (~choices[i].toLowerCase().indexOf(term)) suggestions.push(choices[i]);
			}
			suggest(suggestions);
		}
	});
</script>