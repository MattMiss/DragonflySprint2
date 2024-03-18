<?php
session_start();
$location = '../';
$pageTitle = 'Edited User';

global $db_location;
global $cnxn;
global $use_local;
global $viewingID;

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
include '../php/nav_bar.php';
?>
<main>
    <div class="container p-3" id="main-container">
        <?php

        function echoError() {
            echo "
            <div class='form-error'>
                <h3>Update failed, please try again.</h3>
                <a class='link' href='../user_edit.php'>Go to edit form</a>
            </div>
         ";
        }

        if(! empty($_POST)) {
            $isNewPass = $_POST['new-pass-select'] === 'new';

            if ($isNewPass){
                // removing
                foreach ($_POST as $value) {
                    $value = trim($value);
                    if (empty($value)) {
                        echoError();
                        return;
                    }
                }
            }else{
                // Check everything but the password field
                if (empty(trim($_POST['firstName'])) || empty(trim($_POST['lastName'])) ||
                    empty(trim($_POST['email'])) || empty(trim($_POST['cohort-num'])) ||
                    empty(trim($_POST['status'])) || empty(trim($_POST['roles']))){
                    echoError();
                    return;
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
            $MIN_ROLES = 5;
            $MAX_ROLES = 250;
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
                echoError();
                return;
            }

            // cohort number
            if(! $cohortNum >= $MIN_COHORT_NUM && ! $cohortNum <= $MAX_COHORT_NUM) {
                echoError();
                return;
            }

            // roles
            if(! strlen($roles) >= $MIN_ROLES && ! strlen($roles) <= $MAX_ROLES) {
                echoError();
                return;
            }

            // email
            if(! preg_match("/[^\s@]+@[^\s@]+\.[^\s@]+/", $email) ) {
                echoError();
                return;
            }

            // password
            if ($isNewPass){
                if((strlen($password) < $MIN_PASSWORD || strlen($password) > $MAX_PASSWORD)) {
                    echoError();
                    return;
                }

                if($password !== $passwordConfirm) {
                    echoError();
                    return;
                }

                if(! preg_match("/^(?=.*\d)(?=.*[a-zA-Z])[a-zA-Z\d!@#$%&*_\-.]{8,16}$/", $password)) {
                    echoError();
                    return;
                }
            }

            //  status

            if(! in_array($status, $RADIO_VALUES)) {
                echoError('Status error');
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


            $passField = $isNewPass ? "<li class='list-group-item'><span class='form-label'>Password:</span> " .
                str_pad('',strlen($password),'*') . "</li>" : "";

            echo "
            <div class='container p-3'>
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
            $formLocation = '../user_edit.php';
            include 'empty_form_msg.php';
        }
        ?>
    </div>
</main>

<?php include '../php/footer.php' ?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="../js/main.js"></script>
<script src="../js/signupscript.js"></script>
</body>
</html>

