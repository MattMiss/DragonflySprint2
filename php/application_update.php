<?php
session_start();
ob_start();

$location = '../';
$pageTitle = 'Application Updated';

global $cnxn;
global $db_location;
global $use_local;

// Log user out if idle time or logged in time is past max
include '../php/roles/timeout_check.php';
// Logout and return to login.php if ?logout=true
include '../php/roles/logout_check.php';
// Ensure a user is logged in
include '../php/roles/user_check.php';
// Redirect admins to admin dashboard
include '../php/roles/admin_kick.php';

include '../header.php';
include '../php/nav_bar.php' ?>

<main>
    <div class="container p-3" id="main-container">

<?php
if(! empty($_POST)) {
    $finished = 0;
    // removing
    foreach ($_POST as $key => $value) {
        $value = trim($value);
        $value = strip_tags(filter_var($value, FILTER_SANITIZE_ADD_SLASHES));

        if (strlen($value) > 0 && strlen(trim($value)) == 0){
            if($key !== 'job-description' && $key !== 'follow-updates'){
                $finished++;
                if ($finished == 1) {
                    echo "
        <div class='content'>
            <h2>Failed to update.</h2>
            <h2>Please fill out ". str_replace('-', ' ', $key) .".</h2>
            ";
                } else {
                    echo "
            <h2>Please fill out ". str_replace('-', ' ', $key) .".</h2>
            ";
                }
            }
        }
    }
    if($finished > 0) {
        echo "
        <a class='link' href='../index.php'>Go to the home page and try again.</a>
    </div>
    ";
    } else {
        include '../db_picker.php';
        if ($use_local){
            include '../' . $db_location;
        }else{
            include $db_location;
        }


        $jname = trim($_POST['job-name']);
        $ename = trim($_POST['employer-name']);
        $jurl = trim($_POST['job-url']);
        $jdescription = trim($_POST['job-description']);
        $adate = trim($_POST['app-date']);
        $astatus = trim($_POST['application-status']);
        $fupdates = trim($_POST['follow-updates']);
        $followupdate = trim($_POST['followup-date']);
        $applicationid = trim($_POST['application-id']);

        // sanitization
        $jname = strip_tags(filter_var($jname, FILTER_SANITIZE_ADD_SLASHES));
        $ename = strip_tags(filter_var($ename, FILTER_SANITIZE_ADD_SLASHES));
        $jurl = strip_tags(filter_var($jurl, FILTER_SANITIZE_ADD_SLASHES));
        $jdescription = strip_tags(filter_var($jdescription, FILTER_SANITIZE_ADD_SLASHES));
        $adate = filter_var($adate, FILTER_SANITIZE_NUMBER_INT);
        $astatus = strip_tags(filter_var($astatus, FILTER_SANITIZE_ADD_SLASHES));
        $fupdates = strip_tags(filter_var($fupdates, FILTER_SANITIZE_ADD_SLASHES));
        $followupdate = filter_var($followupdate, FILTER_SANITIZE_NUMBER_INT);

        $sql = "UPDATE `applications` 
                SET `jname` = '$jname', `ename` = '$ename', `jurl` = '$jurl', `jdescription` = '$jdescription',
                    `adate` = '$adate', `astatus` = '$astatus', `fupdates` = '$fupdates', `followupdate` = '$followupdate'
                WHERE `application_id` = '$applicationid';";

        $result = @mysqli_query($cnxn, $sql);

        echo "
    <main>
        <div class='container p-3'>
            <h3 class='receipt-message p-3 mb-0'>Success! Your application has been updated.</h3>
            <div class='form-receipt-container p-3'>
                <ul class='receipt-content list-group list-group-flush'>
                    <li class='list-group-item'>
                        <span class='form-label'>Name:</span> $jname
                    </li>
                    <li class='list-group-item'>
                        <span class='form-label'>Employer Name:</span> $ename
                    </li>
                    <li class='list-group-item'>
                        <span class='form-label'>Job Url:</span> $jurl
                    </li>
                    <li class='list-group-item'>
                        <span class='form-label'>Job Description:</span> $jdescription
                    </li>
                    <li class='list-group-item'>
                        <span class='form-label'>App Date:</span> $adate
                    </li>
                    <li class='list-group-item'>
                        <span class='form-label'>Application Status:</span> ". str_replace('-', ' ', $astatus) ."
                    </li>
                    <li class='list-group-item'>
                        <span class='form-label'>Followup Updates:</span> $fupdates
                    </li>
                    <li class='list-group-item'>
                        <span class='form-label'>Followup Date:</span> $followupdate
                    </li>
                    <li class='align-self-center'>
                        <a class='link' href='../index.php'>Return home</a>
                    </li>
                </ul>
            </div>
        </div>
    </main>
";


    }
}else {
    $formLocation = '../index.php';
    include 'empty_form_msg.php';
}
?>
    </div>
</main>

<?php include '../php/footer.php' ?>

<script src="../js/main.js"></script>
</body>
</html>

