<?php
global $use_local, $indexLocation, $loginLocation, $adminLocation;

include 'db_picker.php';

// If $use_local from the db_picker file is true, use localhost urls. Else use cpanel urls
if ($use_local){
    $indexLocation =  'http://localhost:63342/Sprint4/index.php'; // local (may need to change port number)

    $adminLocation =  'http://localhost:63342/Sprint4/admin_dashboard.php';

    $loginLocation =  'http://localhost:63342/Sprint4/login.php';
}else{
    $indexLocation =  'https://dragonfly.greenriverdev.com/sprint5/index.php'; //cpanel

    $adminLocation =  'https://dragonfly.greenriverdev.com/sprint5/admin_dashboard.php'; //cpanel

    $loginLocation =  'https://dragonfly.greenriverdev.com/sprint5/login.php'; //cpanel
}
?>