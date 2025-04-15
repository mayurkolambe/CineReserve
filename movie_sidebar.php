<div class="listview_1_of_3 images_1_of_3">
    <h2 style="color:#555;">Films in Theaters</h2>
    
    <?php
    $today = date("Y-m-d");
    $qry2 = mysqli_query($con, "SELECT * FROM tbl_movie WHERE status='0' ORDER BY rand() LIMIT 5");
    
    if(mysqli_num_rows($qry2) > 0) {
        while($m = mysqli_fetch_array($qry2)) {
    ?>
        <div class="content-left">
            <div class="listimg listimg_1_of_2">
                <a href="about.php?id=<?php echo $m['movie_id']; ?>">
                    <img src="<?php echo htmlspecialchars($m['image']); ?>" alt="<?php echo htmlspecialchars($m['movie_name']); ?>">
                </a>
            </div>
            <div class="text list_1_of_2">
                <div class="extra-wrap1">
                    <a href="about.php?id=<?php echo $m['movie_id']; ?>" class="link4" style="text-decoration:none; font-size:18px;">
                        <?php echo htmlspecialchars($m['movie_name']); ?>
                    </a><br>
                    <span class="data">Release Date: <?php echo htmlspecialchars($m['release_date']); ?></span><br>
                    Cast: <span class="data"><?php echo htmlspecialchars($m['cast']); ?></span><br>
                    Description: <span class="color2" style="text-decoration:none;">
                        <?php echo htmlspecialchars(substr($m['desc'], 0, 100)) . (strlen($m['desc']) > 100 ? '...' : ''); ?>
                    </span><br>
                </div>
            </div>
            <div class="clear"></div>
        </div>
    <?php
        }
    } else {
    ?>
        <div class="alert alert-info">
            <p>No films currently showing.</p>
        </div>
    <?php
    }
    ?>
</div>
<div class="clear"></div>