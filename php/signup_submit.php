<?php
session_start();
ob_start();

$location = '../';
$pageTitle = 'Signup Submit';

global $db_location;
global $cnxn;
global $use_local;
global $viewingID;

// If user is logged in, Log user out if idle time or logged in time is past max
if (isset($_SESSION['user_id'])){
    $uID = $_SESSION['user_id'];

    include '../php/roles/timeout_check.php';
}
// Logout and return to login.php if ?logout=true
include '../php/roles/logout_check.php';
// Redirect users to user dashboard
include '../php/roles/user_kick.php';
// Redirect admins to admin dashboard
include '../php/roles/admin_kick.php';

include '../header.php';
include '../php/nav_bar.php';
?>
<main>
    <div class="container p-3 text-center" id="main-container">
<?php

function echoError($errorMsg) {
    echo "
            <div class='form-error pt-5'>
                <h3>Sign-up failed, please try again.</h3>
                <p>$errorMsg</p>
                <a class='link' href='../signup_form.php'>Go to sign-up form</a>
            </div>
            </div>
            </main>
         ";

    include '../php/footer.php';
}

if(! empty($_POST)) {
    // removing
    foreach ($_POST as $key => $value) {
        $value = trim($value);
        if (empty($value)) {
            if ($key !== 'roles') {
                echoError('As required field was left empty.');
                return;
            }
        }
    }

    include '../db_picker.php';
    if ($use_local){
        include '../' . $db_location;
    }else{
        include $db_location;
    }

    // constants
    $RADIO_VALUES = array("Seeking Internship", "Seeking Job", "Not Actively Searching");
    $MIN_COHORT_NUM = 1;
    $MAX_COHORT_NUM = 100;
    $MIN_ROLES = 0;
    $MAX_ROLES = 500;
    $MIN_PASSWORD = 8;
    $MAX_PASSWORD = 16;
    $MIN_NAME = 1;
    $MAX_NAME = 30;

    // form values
    $fname = $_POST['firstName'];
    $lname = $_POST['lastName'];
    $email = $_POST['email'];
    $plainPassword = $_POST['password'];
    $passwordConfirm = $_POST['password-confirm'];
    $cohortNum = $_POST['cohort-num'];
    $status = $_POST['status'];
    $roles = $_POST['roles'];

    // sanitization
    $fname = strip_tags(filter_var($fname, FILTER_SANITIZE_ADD_SLASHES));
    $lname = strip_tags(filter_var($lname, FILTER_SANITIZE_ADD_SLASHES));
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $cohortNum = filter_var($cohortNum, FILTER_SANITIZE_NUMBER_INT);
    $roles = strip_tags(filter_var($roles, FILTER_SANITIZE_ADD_SLASHES));
    $plainPassword = strip_tags($plainPassword);
    $passwordConfirm = strip_tags($passwordConfirm);

    // validation

    // names
    if (! (strlen($fname) >= $MIN_NAME && strlen($fname) <= $MAX_NAME) || ! (strlen($lname) >= $MIN_NAME && strlen($lname) <= $MAX_NAME)) {
        echoError('Name must be within ' . $MIN_NAME . ' and ' . $MAX_NAME . ' characters long.');
        return;
    }

    // cohort number
    if(! ($cohortNum >= $MIN_COHORT_NUM && $cohortNum <= $MAX_COHORT_NUM)) {
        echoError('Cohort number must be between ' . $MIN_COHORT_NUM . ' and ' . $MAX_COHORT_NUM . '.');
        return;
    }

    // roles
    if(strlen($roles) > 0 && ! strlen($roles) <= $MAX_ROLES) {
        echoError('Length of roles text must be less than' . $MAX_ROLES . 'characters.');
        return;
    }

    // email
    if(! preg_match("/[^\s@]+@[^\s@]+\.[^\s@]+/", $email) ) {
        echoError('Must use a real email.');
        return;
    }

    // checks if email is already in use
    $checkEmail = "SELECT * FROM users WHERE email = '$email'";
    $resultCheckEmail = @mysqli_query($cnxn, $checkEmail);

    if(mysqli_num_rows($resultCheckEmail) !== 0) {
        echoError('An account associated with this email already exists.');
        return;
    }

    // password
    if(strlen($plainPassword) < $MIN_PASSWORD || strlen($plainPassword) > $MAX_PASSWORD) {
        echoError('Password must be between ' . $MIN_PASSWORD . 'and ' . $MAX_PASSWORD);
        return;
    }

    if($plainPassword !== $passwordConfirm) {
        echoError('Both password fields must match.');
        return;
    }

    if(! preg_match("/^(?=.*\d)(?=.*[a-zA-Z])[a-zA-Z\d!@#$%&*_\-.]{8,16}$/", $plainPassword)) {
        echoError('Password does not meet criteria.');
        return;
    }

    //  status

    if(! in_array($status, $RADIO_VALUES)) {
        echoError('A status must be selected');
        return;
    }

    $name = ucfirst($fname) . " " . ucfirst($lname);

    $hashPass = password_hash($plainPassword, PASSWORD_DEFAULT);

    $sql = "INSERT INTO `users` (`fname`, `lname`, `email`, `password`, `cohortNum`, `status`, `roles`) VALUES ('$fname', 
            '$lname', '$email', '$hashPass', '$cohortNum', '$status', '$roles')";

    //echo $sql;

    $result = @mysqli_query($cnxn, $sql);

    echo "
            <div class='container p-md-3 p-sm-2'>
            <h3 class='receipt-message p-3 mb-0'>Success! Your account has been created.</h3>
            <div class='form-receipt-container p-md-3 p-sm-2'>
                <ul class='receipt-content list-group list-group-flush'>
                    <li class='list-group-item'>
                        <span class='form-label'>Name:</span> $name
                    </li>
                    <li class='list-group-item'>
                        <span class='form-label'>Email:</span> $email
                    </li>
                    <li class='list-group-item'>
                        <span class='form-label'>Password:</span> " . str_pad('',strlen($plainPassword),'*') . "
                    </li>
                    <li class='list-group-item'>
                        <span class='form-label'>Cohort Number:</span> $cohortNum
                    </li>
                    <li class='list-group-item'>
                        <span class='form-label'>Status:</span> $status
                    </li>
                    <li class='list-group-item message-box'>
                        " . stripslashes($roles) . "
                    </li>
                    <li class='align-self-center'>
                        <a class='link' href='../login.php'>Please Login</a>
                    </li>
                </ul>
        
            </div>
            </div>
        </main>
    ";
} else {
    $formLocation = '../signup_form.php';
    include 'empty_form_msg.php';
}
?>
    </div>
</main>

<?php include '../php/footer.php' ?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</body>
</html>
