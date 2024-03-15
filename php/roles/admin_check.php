<?php
global $viewingID;
global $cnxn;
global $location;

//$indexLocation = 'http://localhost:63342/Sprint4/index.php';
//$indexLocation =  'https://dragonfly.greenriverdev.com/sprint5/index.php'; //cpanel

global $location;
global $indexLocation;
include 'page_locations.php';;

$permission = null;
if (isset($_SESSION['permission']) && $_SESSION['permission'] == 1){
    $permission = $_SESSION['permission'];
}else{
    // Redirect back to login if nobody is logged in
    header("Location:$indexLocation");
}

if ($permission !== '1'){
    // Redirect back to dashboard if a non admin user is logged in
    header("Location:$indexLocation");
}