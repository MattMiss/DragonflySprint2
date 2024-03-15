<?php
session_start();
$location = '../';

global $db_location;
global $cnxn;
global $use_local;
global $viewingID;

// Logout and return to login.php if ?logout=true
include '../php/roles/logout_check.php';
// Ensure a user is logged in
include '../php/roles/user_check.php';
// Redirect admins to admin dashboard
include '../php/roles/admin_kick.php';

echo
'<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Application Submit</title>
        <!-- Load theme from localstorage -->
        <script src="../js/themescript.js"></script>
        <!-- Latest compiled and minified CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Font awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <link rel="stylesheet" href="../styles/styles.css"/>
        <!-- Latest compiled JavaScript -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    </head>
<body>';

include '../php/nav_bar.php' ?>

<main>
    <div class="container p-3" id="main-container">

<?php
if(! empty($_POST)) {
    $finished = 0;
    // removing
    foreach ($_POST as $key => $value) {
        $value = trim($value);

        if (empty($value)){
            if($key !== 'job-description' && $key !== 'follow-updates'){
                $finished++;
                if ($finished == 1) {
                    echo "
                <div class='content'>
                    <h2>Failed to send.</h2>
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
                <a class='link' href='../application_form.php'>Go to application form</a>
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

        // sanitization
        $jname = strip_tags(filter_var($jname, FILTER_SANITIZE_ADD_SLASHES));
        $ename = strip_tags(filter_var($ename, FILTER_SANITIZE_ADD_SLASHES));
        $jurl = strip_tags(filter_var($jurl, FILTER_SANITIZE_ADD_SLASHES));
        $adate = filter_var($adate, FILTER_SANITIZE_NUMBER_INT);
        $astatus = strip_tags(filter_var($astatus, FILTER_SANITIZE_ADD_SLASHES));
        $fupdates = strip_tags(filter_var($fupdates, FILTER_SANITIZE_ADD_SLASHES));
        $followupdate = filter_var($followupdate, FILTER_SANITIZE_NUMBER_INT);

        // TODO: Replace user_id = 1 with the user_id of user creating the app
        $sql = "INSERT INTO `applications` (`user_id`, `jname`, `ename`, `jurl`, `jdescription`, `adate`, `astatus`, `fupdates`, 
                `followupdate`) VALUES ($viewingID, '$jname', '$ename', '$jurl', '$jdescription', '$adate', '$astatus', '$fupdates',
                                        '$followupdate')";

//        echo $sql;

        $result = @mysqli_query($cnxn, $sql);

        echo "
                <h3 class='receipt-message p-3 mb-0'>Success! Your application has been created.</h3>
                <div class='form-receipt-container p-3'>
                    <ul class='receipt-content list-group list-group-flush'>
                        <li class='list-group-item'>
                            Name: $jname
                        </li>
                        <li class='list-group-item'>
                            Employer Name: $ename
                        </li>
                        <li class='list-group-item'>
                            Job Url: $jurl
                        </li>
                        <li class='list-group-item'>
                            Job Description: $jdescription
                        </li>
                        <li class='list-group-item'>
                            App Date: $adate
                        </li>
                        <li class='list-group-item'>
                            Application Status: ". str_replace('-', ' ', $astatus) ."
                        </li>
                        <li class='list-group-item'>
                            Followup Updates: $fupdates
                        </li>
                        <li class='list-group-item'>
                            Followup Date: $followupdate
                        </li>
                        <li class='align-self-center'>
                            <a class='link' href='../index.php'>Return home</a>
                        </li>
                    </ul>
                </div>
         
        ";


    }
}else {
    $formLocation = '../application_form.php';
    include 'empty_form_msg.php';
}
?>
    </div>
</main>

<?php include '../php/footer.php' ?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="../js/main.js"></script>
</body>
</html>

