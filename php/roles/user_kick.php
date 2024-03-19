<?php
global $location;
global $indexLocation;
include $location . 'page_locations.php';;

if (isset($_SESSION['permission']) && $_SESSION['permission'] === '0'){
    // Redirect to User dashboard if a user navigates here
    header("Location:$indexLocation");
    exit();
}
?>