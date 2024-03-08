<?php
$loginLocation =  'http://localhost:63342/Sprint4/login.php';
//$loginLocation =  'https://dragonfly.greenriverdev.com/sprint5/login.php'; //cpanel

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location:$loginLocation");
}
?>

