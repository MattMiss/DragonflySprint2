<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign-up Submit</title>
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
<body>

<?php
session_start();
$_SESSION['location'] = '../';
include '../php/nav_bar.php' ?>

<main>
    <div class="container p-3" id="main-container">
<?php

function echoError() {
    echo "
            <div class='form-error'>
                <h3>Sign-up failed, please try again.</h3>
                <a class='link' href='../signup_form.php'>Go to sign-up form</a>
            </div>
         ";
}

if(! empty($_POST)) {
    // removing
    foreach ($_POST as $value) {
        $value = trim($value);

        if (empty($value)) {
            echoError();
            return;
        }
    }

    $db_location = '';
    include '../db_picker.php';
    include '../' . $db_location;

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
    if(strlen($password) < $MIN_PASSWORD || strlen($password) > $MAX_PASSWORD) {
        echoError();
        return;
    }

    if( $password !== $passwordConfirm) {
        echoError();
        return;
    }

    if(! preg_match("/^(?=.*\d)(?=.*[a-zA-Z])[a-zA-Z\d!@#$%&*_\-.]{8,16}$/", $password)) {
        echoError();
        return;
    }

    //  status

    if(! in_array($status, $RADIO_VALUES)) {
        echoError();
        return;
    }

    $name = ucfirst($fname) . " " . ucfirst($lname);

    $sql = "INSERT INTO `users` (`fname`, `lname`, `email`, `password`, `cohortNum`, `status`, `roles`) VALUES ('$fname', 
            '$lname', '$email', '$password', '$cohortNum', '$status', '$roles')";

    //echo $sql;

    $result = @mysqli_query($cnxn, $sql);

    echo "
        <main>
            <div class='container p-3'>
            <h3 class='receipt-message p-3 mb-0'>Success! Your account has been created.</h3>
            <div class='form-receipt-container p-3'>
                <ul class='receipt-content list-group list-group-flush'>
                    <li class='list-group-item'>
                        Name: $name
                    </li>
                    <li class='list-group-item'>
                        Email: $email
                    </li>
                    <li class='list-group-item'>
                        Password: " . str_pad('',strlen($password),'*') . "
                    </li>
                    <li class='list-group-item'>
                        Cohort Number: $cohortNum
                    </li>
                    <li class='list-group-item'>
                        Status: $status
                    </li>
                    <li class='list-group-item message-box'>
                        " . stripslashes($roles) . "
                    </li>
                    <li class='align-self-center'>
                        <a class='link' href='../index.php'>Return home</a>
                    </li>
                </ul>
        
            </div>
            </div>
        </main>
    ";
} else {
    echo "<div class='content'>
              <h2>Please fill out the form.</h2>
              <a class='link' href='../signup_form.php'>Go back</a>
          </div>
          ";
}
?>
    </div>
</main>

<?php include '../php/footer.php' ?>

<script src="../js/main.js"></script>
<script src="../js/signupscript.js"></script>
</body>
</html>

