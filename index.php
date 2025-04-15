<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Booking System</title>
    <style>
        :root {
            --primary-color:rgb(76,72,209,254);
            --secondary-color: #221f1f;
            --light-color: #f5f5f5;
            --dark-color: #333;
            --gray-color: #8c8c8c;
            --border-radius: 8px;
            --box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: var(--dark-color);
            background-color: #f8f8f8;
            margin: 0;
            padding: 0;
            font-size: 16px;
        }

        .content {
            width: 100%;
           ;
        }

        .wrap {
            max-width: 1400px; /* Increased from 1200px */
            margin: 0 auto;
            padding: 0 20px;
        }

        .content-top {
            display: flex;
            flex-wrap: wrap;
            gap: 40px; /* Increased from 30px */
            margin-bottom: 50px; /* Increased from 40px */
        }

        .section-heading {
            position: relative;
            color: var(--primary-color); /* Changed to primary color */
            font-size: 28px; /* Increased from 26px */
            font-weight: 700;
            margin-bottom: 30px; /* Increased from 25px */
            padding-bottom: 12px; /* Increased from 10px */
            border-bottom: 3px solid var(--primary-color); /* Increased from 2px */
        }

        .listview_1_of_3 {
            flex: 1;
            min-width: 340px; /* Increased from 300px */
            background: var(--light-color); /* Added background color */
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            padding: 40px; /* Increased from 30px */
            margin-bottom: 30px; /* Increased from 20px */
            transition: transform 0.3s ease;
        }

        .listview_1_of_3:hover {
            transform: translateY(-5px); /* Added hover effect */
        }

        .content-left {
            display: flex;
            margin-bottom: 40px; /* Increased from 30px */
            padding-bottom: 40px; /* Increased from 30px */
            border-bottom: 1px solid #eee;
        }

        .content-left:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .listimg {
            width: 230px; /* Increased from 200px */
            margin-right: 25px; /* Increased from 20px */
            flex-shrink: 0;
        }

        .listimg img {
            width: 100%;
            height: auto;
            max-height: 350px; /* Increased from 300px */
            border-radius: 8px; /* Increased from 6px */
            object-fit: contain;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2); /* Increased shadow */
        }

        .text {
            flex: 1;
        }

        .movie-title {
            font-size: 24px; /* Increased from 20px */
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 12px; /* Increased from 10px */
        }

        .movie-cast, .movie-release-date {
            font-size: 17px; /* Increased from 15px */
            color: var(--gray-color);
            margin-bottom: 12px; /* Increased from 10px */
        }

        .movie-description {
            font-size: 17px; /* Increased from 15px */
            line-height: 1.7; /* Increased from 1.6 */
            color: #555;
            margin-top: 15px; /* Increased from 12px */
            display: -webkit-box;
            -webkit-line-clamp: 6; /* Increased from 5 to show more text */
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .middle-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(230px, 1fr)); /* Increased from 200px */
            gap: 30px; /* Increased from 25px */
        }

        .listimg1 {
            text-align: center;
            transition: transform 0.3s ease;
        }

        .listimg1:hover {
            transform: translateY(-8px); /* Increased from -5px */
        }

        .listimg1 img {
            width: 100%;
            height: auto;
            max-height: 350px; /* Increased from 300px */
            border-radius: 8px; /* Increased from 6px */
            object-fit: contain;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2); /* Increased shadow */
            margin-bottom: 12px; /* Increased from 10px */
            background-color: #f5f5f5;
        }

        .trailer-link {
            color: var(--dark-color);
            text-decoration: none;
            font-size: 18px; /* Increased from 16px */
            font-weight: 500;
            display: block;
            transition: color 0.3s ease;
            margin-top: 10px; /* Increased from 8px */
        }

        .trailer-link:hover {
            color: var(--primary-color);
        }

        .movie-sidebar {
            padding: 25px; /* Add padding */
        }

        .movie-sidebar h3 {
            font-size: 24px; /* Larger heading */
            margin-bottom: 20px;
            color: var(--dark-color);
            padding-bottom: 10px;
            border-bottom: 2px solid var(--primary-color);
        }

        .sidebar-movie-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); /* Larger grid */
            gap: 25px;
        }

        .sidebar-movie {
            text-align: center;
            margin-bottom: 25px;
            transition: transform 0.3s ease;
        }

        .sidebar-movie:hover {
            transform: translateY(-5px);
        }

        .sidebar-movie img {
            width: 100%;
            height: auto;
            max-height: 330px;
            border-radius: 8px;
            object-fit: contain;
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
            margin-bottom: 10px;
            background-color: #f5f5f5;
        }

        .sidebar-movie-title {
            font-size: 18px;
            font-weight: 500;
            margin: 12px 0 8px;
        }

        .sidebar-movie-details {
            font-size: 15px;
            color: var(--gray-color);
        }

        .clear {
            clear: both;
        }

        @media (max-width: 1200px) {
            .wrap {
                max-width: 95%;
            }
        }

        @media (max-width: 992px) {
            .listimg {
                width: 200px;
            }

            .middle-list, .sidebar-movie-container {
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            }
        }

        @media (max-width: 768px) {
            .content-top {
                flex-direction: column;
            }

            .content-left {
                flex-direction: row;
                align-items: flex-start;
            }

            .listimg {
                width: 180px;
            }

            .movie-title {
                font-size: 22px;
            }

            .movie-cast, .movie-release-date, .movie-description {
                font-size: 16px;
            }
        }

        @media (max-width: 480px) {
            .content-left {
                flex-direction: column;
            }

            .listimg {
                width: 100%;
                margin-right: 0;
                margin-bottom: 20px;
            }

            .listimg img {
                max-height: none;
            }

            .middle-list, .sidebar-movie-container {
                grid-template-columns: repeat(2, 1fr);
                gap: 15px;
            }
        }
    </style>
</head>
<body>
<?php
// Error reporting - consider turning this off in production
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
// Include header file
include('header.php');
// Check if database connection exists
if (!isset($con) || !$con) {
    die("<div class='wrap' style='text-align:center;margin-top:50px;'><h2>Database connection failed. Please check your configuration.</h2></div>");
}
?>
<div class="content">
    <div class="wrap">
                <div class="content-top">
            <div class="listview_1_of_3 images_1_of_3">
                <h2 class="section-heading">Upcoming Movies</h2>
                <?php 
                $qry3 = mysqli_query($con, "SELECT * FROM tbl_news LIMIT 5");
                
                if (!$qry3) {
                    echo "<p>Error: " . mysqli_error($con) . "</p>";
                } else {
                    if (mysqli_num_rows($qry3) > 0) {
                        while($n = mysqli_fetch_array($qry3)) {
                            // Sanitize output to prevent XSS
                            $name = htmlspecialchars($n['name'], ENT_QUOTES, 'UTF-8');
                            $cast = htmlspecialchars($n['cast'], ENT_QUOTES, 'UTF-8');
                            $date = htmlspecialchars($n['news_date'], ENT_QUOTES, 'UTF-8');
                            $description = htmlspecialchars($n['description'], ENT_QUOTES, 'UTF-8');
                            $image_path = htmlspecialchars($n['attachment'], ENT_QUOTES, 'UTF-8');
                            ?>
                            <div class="content-left">
                                <div class="listimg listimg_1_of_2">
                                    <img src="admin/<?php echo $image_path; ?>" alt="<?php echo $name; ?>">
                                </div>
                                <div class="text list_1_of_2">
                                    <div class="extra-wrap">
                                        <div class="movie-title"><?php echo $name; ?></div>
                                        <div class="movie-cast"><strong>Cast:</strong> <?php echo $cast; ?></div>
                                        <div class="movie-release-date"><strong>Release Date:</strong> <?php echo $date; ?></div>
                                        <div class="movie-description"><?php echo $description; ?></div>
                                    </div>
                                </div>
                                <div class="clear"></div>
                            </div>
                            <?php
                        }
                    } else {
                        echo "<div class='no-content'>No upcoming movies available at this time.</div>";
                    }
                }
                ?>
            </div> 
            <div class="listview_1_of_3 images_1_of_3">
                <h2 class="section-heading">Movie Trailers</h2>
                <div class="middle-list">
                    <?php 
                    $qry4 = mysqli_query($con, "SELECT * FROM tbl_movie ORDER BY rand() LIMIT 6");
                    
                    if (!$qry4) {
                        echo "<p>Error: " . mysqli_error($con) . "</p>";
                    } else {
                        if (mysqli_num_rows($qry4) > 0) {
                            while($nm = mysqli_fetch_array($qry4)) {
                                // Sanitize output
                                $movie_name = htmlspecialchars($nm['movie_name'], ENT_QUOTES, 'UTF-8');
                                $video_url = htmlspecialchars($nm['video_url'], ENT_QUOTES, 'UTF-8');
                                $image = htmlspecialchars($nm['image'], ENT_QUOTES, 'UTF-8');
                                ?>
                                <div class="listimg1">
                                    <a target="_blank" href="<?php echo $video_url; ?>" rel="noopener noreferrer">
                                        <img src="<?php echo $image; ?>" alt="<?php echo $movie_name; ?>" />
                                    </a>
                                    <a target="_blank" href="<?php echo $video_url; ?>" class="trailer-link" rel="noopener noreferrer">
                                        <?php echo $movie_name; ?>
                                    </a>
                                </div>
                                <?php
                            }
                        } else {
                            echo "<div class='no-content'>No movie trailers available at this time.</div>";
                        }
                    }
                    ?>
                </div>
            </div> 
            <div class="listview_1_of_3 images_1_of_3 movie-sidebar">
                <h2 class="section-heading">Films in Theatres</h2>
                <div class="sidebar-movie-container">
                    <?php
                    // Include the original movie_sidebar.php content inline with enhanced styling
                    $today = date("Y-m-d");
                    $qry5 = mysqli_query($con, "SELECT * FROM tbl_movie WHERE status='0' AND `release_date` <= '$today' ORDER BY rand() LIMIT 6");
                    if ($qry5 && mysqli_num_rows($qry5) > 0) {
                        while($m = mysqli_fetch_array($qry5)) {
                            $movie_id = htmlspecialchars($m['movie_id'], ENT_QUOTES, 'UTF-8');
                            $movie_name = htmlspecialchars($m['movie_name'], ENT_QUOTES, 'UTF-8');
                            $cast = htmlspecialchars($m['cast'], ENT_QUOTES, 'UTF-8');
                            $image = htmlspecialchars($m['image'], ENT_QUOTES, 'UTF-8');
                            ?>
                            <div class="sidebar-movie">
                                <a href="about.php?id=<?php echo $movie_id; ?>">
                                    <img src="<?php echo $image; ?>" alt="<?php echo $movie_name; ?>" />
                                    <div class="sidebar-movie-title"><?php echo $movie_name; ?></div>
                                    <div class="sidebar-movie-details">Cast: <?php echo $cast; ?></div>
                                </a>
                            </div>
                            <?php
                        }
                    } else {
                        echo "<div class='no-content'>No movies currently in theatres.</div>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include('footer.php'); ?>
<?php include('searchbar.php'); ?>
</body>
</html>
