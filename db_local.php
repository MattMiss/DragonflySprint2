<?php
    // $username = 'dragonfl';
    // $password = '4Oiq##R80Pzx8F';
    // $hostname = '45.79.205.30';
    $username = 'root';
    $password = '';
    $hostname = 'localhost';
    $database = 'dragonfl_app_tracker';
    $port = '3306';
    $cnxn = @mysqli_connect($hostname, $username, $password, $database, $port) or
    die("Error Connecting to DB: " . mysqli_connect_error());
    // echo 'connected to Database!';
?>