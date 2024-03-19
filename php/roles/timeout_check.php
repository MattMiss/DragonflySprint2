<?php
global $location;
global $timedOutLocation;
include $location . 'page_locations.php';;

$maxIdleTime = 1800;    // 1800 secs = 30 mins
$maxLoggedInTime = 28800;   // 28800 secs = 8 hours

// Log out and return to Login Screen if idle time or
// total logged in time of the SESSION is past the max
if ((time()-$_SESSION['login_time_stamp'] > $maxLoggedInTime) ||
    (time()-$_SESSION['idle_time_stamp'] > $maxIdleTime)){
    header("Location:$timedOutLocation");
    exit();
}else{
    $_SESSION['idle_time_stamp'] = time();
}