<?php
global $location;
global $loginLocation;
include $location . 'page_locations.php';

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location:$loginLocation");
    exit();
}
?>

