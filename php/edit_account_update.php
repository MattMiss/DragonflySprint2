<?php
session_start();
ob_start();

$location = '../';
$pageTitle = 'Edited User';

global $db_location;
global $cnxn;
global $use_local;
global $viewingID;

// Log user out if idle time or logged in time is past max
include '../php/roles/timeout_check.php';
// Logout and return to login.php if ?logout=true
include '../php/roles/logout_check.php';
// Check for user_id in SESSION and redirect to login if null
include '../php/roles/user_check.php';

// Set the editing UID so it doesn't save over the admins info if the viewingID is the admins.
$editUID = '';
if (isset($_SESSION['edit-uid'])){
    $editUID = $_SESSION['edit-uid'];
}

include '../header.php';
?>

<?php

function echoError($errorMsg) {
    include '../php/nav_bar.php';
    echo "
            <main>
                <div class='container p-3' id='main-container'>
                    <div class='form-error pt-5'>
                        <h3>Update failed, please try again.</h3>
                        <p>$errorMsg</p>
                        <a class='link' href='../signup_form.php'>Go to sign-up form</a>
                    </div>
                </div>
            </main>
         ";
    include '../php/footer.php';
}

if(! empty($_POST)) {
    $isNewPass = $_POST['new-pass-select'] === 'new';

    if ($isNewPass){
        foreach ($_POST as $key => $value) {
            $value = trim($value);
            if (empty($value)) {
                if ($key !== 'roles') {
                    echoError('A required field was left empty.');
                    return;
                }
            }
        }
    }else{
        foreach ($_POST as $key => $value) {
            $value = trim($value);
            if (empty($value)) {
                if ($key !== 'password' && $key !== 'password-confirm' && $key !== 'roles') {
                    echoError('As required field was left empty.');
                    return;
                }
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
    $password = $_POST['password'];
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
    $password = strip_tags($password);
    $passwordConfirm = strip_tags($passwordConfirm);


    // validation

    // names
    if (! (strlen($fname) >= $MIN_NAME && strlen($fname) <= $MAX_NAME) || ! (strlen($lname) >= $MIN_NAME && strlen($lname) <= $MAX_NAME)) {
        echoError('Name must be within ' . $MIN_NAME . ' and ' . $MAX_NAME . ' characters long.');
        return;
    }

    // cohort number
    if(! $cohortNum >= $MIN_COHORT_NUM && ! $cohortNum <= $MAX_COHORT_NUM) {
        echoError('Cohort number must be between ' . $MIN_COHORT_NUM . ' and ' . $MAX_COHORT_NUM . '.');
        return;
    }

    // roles
    if(strlen($roles) > 0 && ! strlen($roles) <= $MAX_ROLES) {
        echoError('Length of roles text must be less than ' . $MAX_ROLES . ' characters.');
        return;
    }

    // email
    if(! preg_match("/[^\s@]+@[^\s@]+\.[^\s@]+/", $email) ) {
        echoError('Must use a real email.');
        return;
    }

    // password
    if ($isNewPass){
        if((strlen($password) < $MIN_PASSWORD || strlen($password) > $MAX_PASSWORD)) {
            echoError('Password must be between ' . $MIN_PASSWORD . 'and ' . $MAX_PASSWORD);
            return;
        }

        if($password !== $passwordConfirm) {
            echoError('Both password fields must match.');
            return;
        }

        if(! preg_match("/^(?=.*\d)(?=.*[a-zA-Z])[a-zA-Z\d!@#$%&*_\-.]{8,16}$/", $password)) {
            echoError('Password does not meet criteria.');
            return;
        }
    }

    //  status

    if(! in_array($status, $RADIO_VALUES)) {
        echoError('A status must be selected');
        return;
    }

    $name = ucfirst($fname) . " " . ucfirst($lname);

    $hashPass = password_hash($passwordConfirm, PASSWORD_DEFAULT);

    $sql = '';

    if ($isNewPass){
        $sql = "UPDATE `users` 
                        SET `fname` = '$fname', `lname` = '$lname', `email` = '$email', `password` = '$hashPass',
                            `cohortNum` = '$cohortNum', `status` = '$status', `roles` = '$roles'
                        WHERE `user_id` = '$editUID';";

    }else{
        $sql = "UPDATE `users` 
                        SET `fname` = '$fname', `lname` = '$lname', `email` = '$email',
                            `cohortNum` = '$cohortNum', `status` = '$status', `roles` = '$roles'
                        WHERE `user_id` = '$editUID';";

    }

    $result = @mysqli_query($cnxn, $sql);



    // Wait to include the navbar until after the new fname is set
    // so the navbar is also changed to the new name
    include '../php/nav_bar.php';

    $passField = $isNewPass ? "<li class='list-group-item'><span class='form-label'>Password:</span> " .
        str_pad('',strlen($password),'*') . "</li>" : "";

    echo "
             <main>
                <div class='container p-md-3 p-2' id='main-container'>
                    <h3 class='receipt-message p-3 mb-0'>Success! Account has been edited.</h3>
                    <div class='form-receipt-container p-3'>
                        <ul class='receipt-content list-group list-group-flush'>
                            <li class='list-group-item'>
                                <span class='form-label'>Name:</span> $name
                            </li>
                            <li class='list-group-item'>
                                <span class='form-label'>Email:</span> $email
                            </li>
                            {$passField}
                            <li class='list-group-item'>
                                <span class='form-label'>Cohort Number:</span> $cohortNum
                            </li>
                            <li class='list-group-item'>
                                <span class='form-label'>Status:</span> $status
                            </li>
                            <li class='list-group-item message-box'>
                                " . stripslashes($roles) . "
                            </li>
                        </ul>
                    </div>
                </div>
            </main>
    ";
} else {
    include '../php/nav_bar.php';
    $formLocation = '../user_edit.php';
    include 'empty_form_msg.php';
}
?>


<?php include '../php/footer.php' ?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="../js/main.js"></script>
</body>
</html>

