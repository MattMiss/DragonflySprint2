<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Announcement Submit</title>
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
if(! empty($_POST)) {
    $finished = 0;
    // removing
    foreach ($_POST as $key => $value) {
        $value = trim($value);

        if (empty($value)){
            if($key !== 'additional-text'){
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
    if(!isset($_POST['job-or-intern'])) {
        $finished++;
        if ($finished == 1) {
            echo "
                <div class='content'>
                    <h2>Failed to send.</h2>
                    ";
        }
        echo"<h2>Please fill out job or intern button.</h2>";
    }
    if($finished > 0) {
        echo "
                <a class='link' href='../admin_announcement.php'>Go back</a>
            </div>
            ";
    } else {
        //require '/home/dragonfl/db.php';  //cpanel
        require '../db_local.php';  //Local

        $title = $_POST['announcement-title'];
        $jobType = $_POST['job-or-intern'];
        $location = $_POST['location'];
        $employer = $_POST['employer'];
        $addltext = $_POST['additional-text'];
        $url = $_POST['announcement-url'];
        $sentto = $_POST['sent-to'];

        // sanitization
        $title = strip_tags(filter_var($title, FILTER_SANITIZE_ADD_SLASHES));
        $jobType = strip_tags(filter_var($jobType, FILTER_SANITIZE_ADD_SLASHES));
        $location = strip_tags(filter_var($location, FILTER_SANITIZE_ADD_SLASHES));
        $employer = strip_tags(filter_var($employer, FILTER_SANITIZE_ADD_SLASHES));
        $addltext = strip_tags(filter_var($addltext, FILTER_SANITIZE_ADD_SLASHES));
        $url = strip_tags(filter_var($url, FILTER_SANITIZE_ADD_SLASHES));
        $sentto = filter_var($sentto, FILTER_SANITIZE_ADD_SLASHES);

        $today = date("Y-m-d");


        $sql = "INSERT INTO `announcements` (`title`, `job_type`, `location`, `ename`, `additional_info`, `jurl`, `sent_to`, `date_created`, 
                             `is_deleted`) VALUES ('$title', '$jobType', '$location', '$employer', '$addltext', '$url', '$sentto', '$today', 0)";

        $result = @mysqli_query($cnxn, $sql);


        echo "
            <h3 class='receipt-message p-3 mb-0'>Success! Your announcement has been sent.</h3>
            <div class='form-receipt-container p-3'>
                <ul class='receipt-content list-group list-group-flush'>
                    <li class='list-group-item text-break'>
                        Title: $title
                    </li>
                    <li class='list-group-item text-break'>
                        Job Type: $jobType
                    </li>
                    <li class='list-group-item text-break'>
                        Location: $location
                    </li>
                    <li class='list-group-item text-break'>
                        Employer: $employer
                    </li>
                    <li class='list-group-item text-break'>
                        More Information: $addltext
                    </li>
                    <li class='list-group-item text-break'>
                        URL: $url
                    </li>
                    <li class='list-group-item text-break'>
                        Sent To: $sentto
                    </li>
                </ul>
            </div>
            ";

        /*
        if(! preg_match("/[^\s@]+@[^\s@]+\.[^\s@]+/", $sentto) ) {
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
            <div class='form-receipt-container'>
                <div class='content'>
                    <h3>Success! Your announcement has been sent.</h3>
                    <ul class='list-group'>
                        <li class='list-group-item text-break'>
                            Title: $title
                        </li>
                        <li class='list-group-item text-break'>
                            Job Type: $jobType
                        </li>
                        <li class='list-group-item text-break'>
                            Location: $location
                        </li>
                        <li class='list-group-item text-break'>
                            Employer: $employer
                        </li>
                        <li class='list-group-item text-break'>
                            More Information: $addltext
                        </li>
                        <li class='list-group-item text-break'>
                            URL: $url
                        </li>
                        <li class='list-group-item text-break'>
                            Sent To: $sentto
                        </li>
                    </ul>
                </div>
            </div>
            ";

        }
        */
    }
}else {
    echo "<div class='content'>
      <h2>Please fill out the form.</h2>
      <a class='link' href='../admin_announcement.php'>Go back</a>
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

