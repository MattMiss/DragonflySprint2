<?php
global $location;
global $adminLocation;
include $location . 'page_locations.php';;

if (isset($_SESSION['permission']) && $_SESSION['permission'] === '1'){
    // Redirect to admin dashboard if an admin navigates here
    header("Location:$adminLocation");
}
?>