<?php
session_start();
$_SESSION['header-title'] = 'ATT - Application Form';
include 'header.php'?>

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
                <a class='link' href='applicationform.html'>Go back</a>
            </div>
            ";
    } else {
        require '/home/dragonfl/db.php';

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

        $sql = "INSERT INTO `applications` (`jname`, `ename`, `jurl`, `jdescription`, `adate`, `astatus`, `fupdates`, 
                `followupdate`) VALUES ('$jname', '$ename', '$jurl', '$jdescription', '$adate', '$astatus', '$fupdates',
                                        '$followupdate')";

        echo $sql;

        echo "
            <div class='form-receipt-container'>
                <div class='content'>
                    <h3>Success! Your application has been created.</h3>
                    <ul class='list-group'>
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
                    </ul>
                </div>
            </div>
        ";

        $result = @mysqli_query($cnxn, $sql);
    }
}else {
    echo "<div class='content'>
              <h2>Please fill out the form.</h2>
              <a class='link' href='applicationform.html'>Go back</a>
          </div>
          ";
}
?>
    </div>
</main>

<?php include 'footer.php' ?>

<script src="js/main.js"></script>
</body>
</html>

