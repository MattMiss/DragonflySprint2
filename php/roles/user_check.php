<?php
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