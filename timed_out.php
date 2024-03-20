<?php
session_start();
ob_start();

$location = '';
$pageTitle = 'Session Timed Out';

global $loginLocation;
include $location . 'page_locations.php';;
$header = '3; URL=' . $loginLocation; // Redirect after 3 seconds

// Check for user_id in SESSION and redirect to login if null
include 'php/roles/user_check.php';

session_unset();
session_destroy();


// Header is slightly different to include the <meta> refresh tag to redirect back to login.php
echo "<!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <!--<meta http-equiv='refresh' content='$header'/>-->
            <title>$pageTitle</title>
            <!-- Load theme from localstorage -->
            <script src='js/themescript.js'></script>
            <!-- Latest compiled and minified CSS -->
            <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css' rel='stylesheet'>
            <!-- Font Awesome -->
            <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css'>
            <link rel='stylesheet' href='styles/styles.css'>
            <!-- Latest compiled JavaScript -->
            <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js'></script>
        </head>
        <body>";

include 'php/nav_bar.php';

echo "<main>
    <div class='container p-3' id='main-container'>
        <div class='empty-form-msg pt-5 d-flex flex-column justify-content-center'>
            <h4 class='align-self-center'>You have been logged out due to inactivity. You will be redirected to the login screen shortly.</h4>
            <form class='m-auto' method='post' action='$loginLocation'>
                <button class='btn-log-in-out'>
                    <i class='fa-solid fa-arrow-right-from-bracket pe-2'></i>Login
                </button>
            </form>
        </div>
    </div>
</main>";

 include 'php/footer.php' ?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="js/main.js"></script>
</body>
</html>
