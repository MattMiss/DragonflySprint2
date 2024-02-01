<html>
<head>
    <meta charset="UTF-8">
    <title>Receipt</title>
    <link href="styles.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>
<body>
<?php
if(! empty($_POST)) {
    // removing
    foreach ($_POST as $value) {
        $value = trim($value);

        if (empty($value)) {
            ?>
            <div class="content">
                <h2>Message failed to send.</h2>
            </div>

            <?php
            return;
        }
    }

    $fname = $_POST['firstName'];
    $lname = $_POST['lastName'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // sanitization
    $fname = strip_tags(filter_var($fname, FILTER_SANITIZE_ADD_SLASHES));
    $lname = strip_tags(filter_var($lname, FILTER_SANITIZE_ADD_SLASHES));
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $message = strip_tags(filter_var($message, FILTER_SANITIZE_ADD_SLASHES));

    // mailing
    $name = ucfirst($fname) . " " . ucfirst($lname);
    $to = "Yadira Cervantes<cervantes.yadira@student.greenriver.edu>";
    $subject = "Message from " . $name;
    $from = $name . '<' . $_POST['email'] . '>';
    $headers = 'From: ' . $from . "\r\n" .
        'Reply-To: ' . $from . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

//    if (mail($to, $subject, $message, $headers)) {
        ?>
            <div class="form-receipt-container">

                <div class="content">
                    <h4><?php echo 'Success! Your message has been sent.'; ?></h4>
                    <ul class="list-group">
                        <li class="list-group-item">To: John Doe</li>
                        <li class="list-group-item">
                            <?php echo "From: " . $name; ?>
                        </li>
<!--                        <li class="list-group-item">-->
<!--                            --><?php //echo "Subject: " . $subject; ?>
<!--                        </li>-->
                        <li class="list-group-item message-box">
                            <?php echo stripslashes($message); ?>
                        </li>
                    </ul>
                </div>
            </div>

        <?php
//    }
}
?>
</body>
</html>
