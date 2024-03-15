<?php
//$loginLocation =  'http://localhost:63342/Sprint4/login.php';
//$loginLocation =  'https://dragonfly.greenriverdev.com/sprint5/login.php'; //cpanel

global $location;
global $loginLocation;
include $location . 'page_locations.php';;

$viewingID = null;
if (isset($_SESSION['user_id'])){
    $viewingID = $_SESSION['user_id'];
}else{
    // Redirect back to login if nobody is logged in
    header("Location:$loginLocation");
}
?>