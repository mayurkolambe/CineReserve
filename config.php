<?php
    $host = "127.0.0.1";
    $user = "root";                     
    $pass = "C0dingisfun!";                                  
    $db = "movietheatredb";
    $port = 3306;
    $con = mysqli_connect($host, $user, $pass, $db, $port) or die(mysqli_connect_error());

?>