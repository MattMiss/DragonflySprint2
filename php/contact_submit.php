<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Submit</title>
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
                    <h3>Message failed to send, please try again.</h3>
                    <a class='link' href='../contact_form.php'>Go to contact form</a>
                </div>
            ";
}

if(! empty($_POST)) {
    // removing
    foreach ($_POST as $value) {
        $value = trim($value);

        if(empty($value)) {
            echo "
                <div class='form-error'>
                    <h3>Message failed to send, please try again.</h3>
                    <a class='link' href='../contactForm.html'>Return to contact form</a>
                </div>
            ";
            return;
        }
    }

    // constants
    $MIN_MESSAGE = 25;
    $MAX_MESSAGE = 100;

    $fname = $_POST['firstName'];
    $lname = $_POST['lastName'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // sanitization
    $fname = strip_tags(filter_var($fname, FILTER_SANITIZE_ADD_SLASHES));
    $lname = strip_tags(filter_var($lname, FILTER_SANITIZE_ADD_SLASHES));
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $message = strip_tags(filter_var($message, FILTER_SANITIZE_ADD_SLASHES));

    if(! preg_match("/[^\s@]+@[^\s@]+\.[^\s@]+/", $email) ) {
        echoError();
        return;
    }

    if(! strlen($message) > $MIN_MESSAGE && ! strlen($message) <= $MAX_MESSAGE) {
        echoError();
        return;
    }

    // mailing
    $name = ucfirst($fname) . " contact_submit.php" . ucfirst($lname);
    //$to = "Yadira Cervantes<cervantes.yadira@student.greenriver.edu>";
    $to = "Matt Miss<miss.matthew@student.greenriver.edu>";
    $subject = "Message from " . $name;
    $from = $name . '<' . $_POST['email'] . '>';
    $headers = 'From: ' . $from . "\r\n" .
        'Reply-To: ' . $from . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

    if (mail($to, $subject, $message, $headers)) {
        echo "
               
            <main>
                <div class='container p-3'>
                    <h3 class='receipt-message p-3 mb-0'>Success! Your message has been sent.</h3>
                    <div class='form-receipt-container p-3'>
                        <ul class='receipt-content list-group list-group-flush'>
                            <li class='list-group-item'>
                                Name: $name
                            </li>
                            <li class='list-group-item'>
                                Email: $email
                            </li>
                            <li class='list-group-item'>
                                $message 
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
} else {
    echo "<div class='content'>
              <h2>Please fill out the form.</h2>
              <a class='link' href='../contact_form.php'>Go back</a>
          </div>
          ";
}
?>
    </div>
</main>

<?php include '../php/footer.php' ?>

<script src="../js/main.js"></script>
</body>
</html>
