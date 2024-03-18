<?php
session_start();
ob_start();

$location = '../';
$pageTitle = 'Admin Announcement Submit';

global $cnxn;
global $db_location;
global $use_local;

// Log user out if idle time or logged in time is past max
include '../php/roles/timeout_check.php';
// Logout and return to login.php if ?logout=true
include '../php/roles/logout_check.php';
// Ensure a user is logged in
include '../php/roles/user_check.php';
// Ensure an admin is logged in
include '../php/roles/admin_check.php';

include '../header.php';
include '../php/nav_bar.php';



?>
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
        include '../db_picker.php';
        if ($use_local){
            include '../' . $db_location;
        }else{
            include $db_location;
        }

        $title = $_POST['announcement-title'];
        $jobType = $_POST['job-or-intern'];
        $location = $_POST['location'];
        $employer = $_POST['employer'];
        $addltext = $_POST['additional-text'];
        $url = $_POST['announcement-url'];

        $sendToSelect = $_POST['send-to-select'];
        $discardInactiveUsers = isset($_POST['discard-inactive-users']) && ($_POST['discard-inactive-users'] === 'true');

        // $sentto = $_POST['sent-to'];
//        $fname = $_POST['first-name'] == 'default' ? '' : $_POST['first-name'];
//        $lname = $_POST['last-name'] == 'default' ? '' : $_POST['last-name'];

        // sanitization
        $title = strip_tags(filter_var($title, FILTER_SANITIZE_ADD_SLASHES));
        $jobType = strip_tags(filter_var($jobType, FILTER_SANITIZE_ADD_SLASHES));
        $location = strip_tags(filter_var($location, FILTER_SANITIZE_ADD_SLASHES));
        $employer = strip_tags(filter_var($employer, FILTER_SANITIZE_ADD_SLASHES));
        $addltext = strip_tags(filter_var($addltext, FILTER_SANITIZE_ADD_SLASHES));
        $url = strip_tags(filter_var($url, FILTER_SANITIZE_ADD_SLASHES));
        // $sentto = filter_var($sentto, FILTER_SANITIZE_ADD_SLASHES);
        $today = date("Y-m-d");

        // run queries
        $sql = "INSERT INTO announcements (title, job_type, location, ename, additional_info, jurl, sent_to, date_created, is_deleted) 
                VALUES ('$title', '$jobType', '$location', '$employer', '$addltext', '$url', '$sendToSelect', '$today', 0)";
        $result = @mysqli_query($cnxn, $sql);

        $sql2 = "SELECT fname, lname, email, permission, status FROM users WHERE is_deleted = 0";
        $result2 = @mysqli_query($cnxn, $sql2);


//        if(! preg_match("/[^\s@]+@[^\s@]+\.[^\s@]+/", $sentto) ) {
//            echoError();
//            return;
//        }

        // mailing

        // static variables
        $addltext = wordwrap($addltext, 70); // formatted message
        $subject = $title . " " . $jobType . " at " . $employer ; // announcement title, job type, and company
        $from = 'Admin<admin@greenriver.edu>';
        $headers = 'From: ' . $from . "\r\n" .
            'Reply-To: ' . $from . "\r\n" .
            'X-Mailer: PHP/' . phpversion();
        $message = "Location: " . $location .
            "\nURL: ". $url .
            "\nAdditional Info: \n" . $addltext;

        $isSent = false;

        // checks if result2 is null/empty
        if($result2) {
            // loops throw result2 array
            foreach ($result2 as $row) {
                $includeUser = false;
                $permission = $row['permission'];

                if ($sendToSelect === 'all'){
                    if (!($discardInactiveUsers && ($row['status'] === 'Not Actively Searching'))){
                        $includeUser = true;
                    }
                }else if (($permission === '1') && ($sendToSelect === 'admins')) {
                    $includeUser = true;
                }else if (($sendToSelect === 'jobs') && ($row['status'] === 'Seeking Job')){
                    $includeUser = true;
                }else if (($sendToSelect === 'interns') && ($row['status'] === 'Seeking Internship')){
                    $includeUser = true;
                }

                if ($includeUser){
                    $fname = $row['fname'];
                    $lname = $row['lname'];
                    $email = $row['email'];

                    $name = $fname . " " . $lname; // user's name
                    $to = $name . "<" . $email . ">"; // user's name and email

                    if(mail($to, $subject, $message, $headers)) {
                        $isSent = true;
                    }
                }

            }
        }

        if ($isSent) {
            echo "
            <h3 class='receipt-message p-3 mb-0'>Success! Your announcement has been sent.</h3>
            <div class='form-receipt-container p-3'>
                <ul class='receipt-content list-group list-group-flush'>
                    <li class='list-group-item text-break'>
                        <span class='form-label'>Title:</span> $title
                    </li>
                    <li class='list-group-item text-break'>
                        <span class='form-label'>Job Type:</span> $jobType
                    </li>
                    <li class='list-group-item text-break'>
                        <span class='form-label'>Location:</span> $location
                    </li>
                    <li class='list-group-item text-break'>
                        <span class='form-label'>Employer:</span> $employer
                    </li>
                    <li class='list-group-item text-break'>
                        <span class='form-label'>More Information:</span> $addltext
                    </li>
                    <li class='list-group-item text-break'>
                        <span class='form-label'>URL:</span> $url
                    </li>
                    <!--
                    <li class='list-group-item text-break'>
                        Sent To: 
                    </li>
                    -->
                </ul>
            </div>
            ";
        }

    }
} else {
    $formLocation = '../admin_announcement.php';
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

