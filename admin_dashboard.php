<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Load theme from localstorage -->
    <script src="js/themescript.js"></script>
    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="styles/styles.css"/>
    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<?php
session_start();
$_SESSION['location'] = '';

include 'php/nav_bar.php';
include 'db_picker.php';
include $db_location;

// soft deletes a database entry
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if($_POST["submit-from"] == 1) {
        $id = $_POST["id"];
        $sql4 = "UPDATE applications SET is_deleted = 1 WHERE application_id = $id";
        $result4 = @mysqli_query($cnxn, $sql4);
    } elseif ($_POST["submit-from"] == 2) {
        $id = $_POST["id"];
        $sql4 = "UPDATE users SET is_deleted = 1 WHERE user_id = $id";
        $result4 = @mysqli_query($cnxn, $sql4);
    }
}

// fetches specific data from database tables
$sql = "SELECT * FROM applications WHERE is_deleted = 0 ORDER BY application_id DESC LIMIT 5"; // 5 most recent announcements
$sql2 = "SELECT * FROM announcements WHERE is_deleted = 0 ORDER BY id DESC LIMIT 3"; // 3 most recent announcements
$sql3 = "SELECT * FROM users WHERE is_deleted = 0 LIMIT 7";
$result = @mysqli_query($cnxn, $sql);
$result2 = @mysqli_query($cnxn, $sql2);
$result3 = @mysqli_query($cnxn, $sql3);
?>

<main>
    <div class="container p-3" id="main-container">
        <div class="row dashboard-top">
            <div class="app-list col col-8">
                <h3>Recent Applications</h3>
                <div class="row">
                    <div class="col-md-4 pt-2">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text">Start Date</span>
                            <input type="date" class="form-control" id="app-start-date" name="search-start-date">
<!--                            <i class="fa-regular fa-calendar"></i>-->
                        </div>
                    </div>
                    <div class="col-md-4 pt-2">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text">End Date</span>
                            <input type="date" class="form-control" id="app-end-date" name="search-end-date">
                        </div>
                    </div>
                    <div class="col-md-4 text-end pt-2">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text">Status</span>
                            <select class="form-select" id="app-status-select">
                                <option selected value="any">Any</option>
                                <option value="accepted">Accepted</option>
                                <option value="applied">Applied</option>
                                <option value="inactive">Inactive</option>
                                <option value="interviewing">Interviewing</option>
                                <option value="need-to-apply">Need-to-apply</option>
                                <option value="rejected">Rejected</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col pt-2">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </span>
                            <input id="app-search-bar" type="text" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="basic-addon1">
                        </div>
                    </div>
                </div>
                <table class="dash-table">
                    <thead>
                    <tr>
                        <th scope="col" class="w-20">Date</th>
                        <th scope="col">Title</th>
                        <th scope="col" class="w-20">Status</th>
                        <th scope="col" class="w-btn"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    createTable($result);
                    ?>
                    </tbody>
                </table>
                <p class="title mx-auto" style="display: block; width:100px; color: green">More</p>
            </div>

            <div class="reminders col">
                <h3>Recent Announcements</h3>
                <div>
                    <hr>
                    <?php
                    createReminders($result2);
                    ?>

                    <div>
                        <hr>
                        <div class="incomplete-app">
                            <a class="" href="admin_announcement.php">Add Announcement</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row py-3">
            <div class="col-9 d-flex justify-content-center" id="new-app-container">
                <button class="submit-btn">New Application</button>
            </div>
            <div class="col-3 d-flex justify-content-center" id="update-account-container">
                <button id="update-acc-btn" class="submit-btn"><i class="fa-solid fa-gear px-1"></i>Update Account</button>
            </div>
        </div>

        <div class="row dashboard-top">
            <div class="user-list">
                <h3>Users</h3>
                <table class="dash-table">
                    <thead>
                    <tr>
                        <th scope="col" class="w-40">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col" class="w-btn"></th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                            createUserTable($result3);
                        ?>
                    </tbody>
                </table>
                <p class="title mx-auto" style="display: block; width:100px; color: green">More</p>
            </div>
        </div>

        <div class="row welcome-info">
            <hr>
            <p>Welcome to the Green River College Software Development Application Tracking Tool (ATT). The purpose of this tool is to provide a centralized place to track your job/internship applications that can be helpful in your application journey! </p>
            <hr>
        </div>

        <div class="row text-wrap">
            <div class="software-dev-img col-3">
                <img src="images/it-software-dev.jpg" alt="5" class="img-fluid col-3" style="width: 500px">
            </div>

            <div class="about-program col-9">
                <h5>About Our Program</h5>
                <p>Prepare for an exciting career in tech with a Bachelor of Applied Science in Software Development. Affordable tuition, instructors who care, access to tech industry mentors, and project-based learning make our applied bachelor’s program a popular destination for computing majors throughout the Seattle-Tacoma region. This degree prepares graduates for high-demand jobs such as software developer, web developer, software developer in test, and quality assurance (QA) analyst. Learn more at <a class="link" href="https://www.greenriver.edu/students/academics/degrees-programs/bachelor-of-applied-science/bachelors-in-software-development/">GreenRiver.edu</a></p>
            </div>
        </div>

</main>


<?php include 'php/footer.php' ?>
<script src="js/main.js"></script>
</body>
</html>

<?php


function createTable($info) {
    while ($row = mysqli_fetch_assoc($info)) {
        $id = $row["application_id"];
        $jname = $row["jname"];
        $ename = $row["ename"];
        $jurl = $row["jurl"];
        $jdescription = $row["jdescription"];
        $adate = $row["adate"];
        $astatus = $row["astatus"];
        $fupdates = $row["fupdates"];
        $followupdate = $row["followupdate"];
//            $app_info = json_encode($row);

        echo "
                <tr class='app-list-item' id='$id'>
                    <td>$adate</td>
                    <td>$ename</td>
                    <td class='status status-$astatus'><i class='fa-solid fa-circle'></i><span>$astatus</span></td>
                    <td class='app-button-outer'>
                            <button class='app-button-inner btn btn-sm btn-update'><i class='fa-solid fa-pen'></i></button>
                            <button class='app-button-inner btn btn-sm btn-delete' type='button' data-bs-toggle='modal' data-bs-target='#delete-modal-$id'><i class='fa-solid fa-trash'></i></button>

                    </td>
                </tr>
                
                <div class='modal fade' id='delete-modal-$id' tabindex='-1' role='dialog' aria-labelledby='delete-app-message' aria-hidden='true'>
                    <div class='modal-dialog modal-dialog-centered' role='document'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h4 class='modal-title' id='delete-warning'>Are you sure you want to delete this application?</h4>
                            </div>
                            <div class='modal-body'>
                                <p>Deleted applications can be recovered later.</p>
                            </div>
                            <div class='modal-footer'>
                                <form method='POST' action='#'>
                                    <input type='hidden' value='1' name='submit-from'>
                                    <input type='hidden' value='$id' name='id'>
                                    <button type='button' class='modal-close-secondary' data-bs-dismiss='modal'>Cancel</button>
                                    <button type='submit' class='modal-delete'>Delete Application</button>
                                </form>   
                            </div>
                        </div>
                    </div>
                </div>
            ";
    }
}

function createReminders($info) {
    while ($row = mysqli_fetch_assoc($info)) {
        $id = $row["id"];
        $title = $row["title"];
        $jtype = $row["job_type"];
        $location = $row["location"];
        $ename = $row["ename"];
        $jobInfo = $row["additional_info"];
        $jurl = $row["jurl"];
        $recipient = $row["sent_to"];
        $date = $row["date_created"];
//            $app_info = json_encode($row);

        echo "
                <div class='reminder py-2'>
                    <i class='fa-solid fa-bullhorn me-2'></i>
                    <button class='announcement-modal-btn' type='button' data-bs-toggle='modal' data-bs-target='#announcement-modal-$id'>$title $jtype at <span>$ename</span></button>
                    <p>Created on: <span>$date</span></p>
                </div>

                <div class='modal fade' id='announcement-modal-$id' tabindex='-1' role='dialog' aria-labelledby='job-title' aria-hidden='true'>
                    <div class='modal-dialog' role='document'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h5 class='modal-title' id='job-title'>$title</h5>
                                <button type='button' class='modal-close-primary close' data-bs-dismiss='modal' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span>
                                </button>
                            </div>
                            <div class='modal-body'>
                                <ul class='list-group-item'>
                                    <li class='list-group-item pb-1'>
                                        <span class='form-label'>Company:</span> $ename
                                    </li>
                                    <li class='list-group-item pb-1'>
                                        <span class='form-label'>Address:</span> $location
                                    </li>
                                    <li class='list-group-item pb-1'>
                                        <span class='form-label'>URL:</span>
                                        <a href='$jurl'>$jurl</a>
                                    </li>
                                    <li class='list-group-item'>
                                        <span class='form-label'>More Information:</span>
                                        <p>$jobInfo</p>
                                    </li>
                                </ul>
                            </div>
                            <div class='modal-footer'>
                                <button type='button' class='modal-close-secondary' data-bs-dismiss='modal'>Close</button>
                                <button type='button' class='modal-edit'>Edit</button>
                            </div>
                        </div>
                    </div>
                </div>
                
            ";
    }

    function createUserTable($info) {
        while ($row = mysqli_fetch_assoc($info)) {
            $id = $row["user_id"];
            $fname = $row["fname"];
            $lname = $row["lname"];
            $email = $row["email"];

            echo "
                <tr id='user-$id' class='user-list-item'>
                    <td>$fname $lname</td>
                    <td>$email</td>
                    <td class='app-button-outer'>
                        <button class='app-button-inner btn btn-sm btn-update'><i class='fa-solid fa-pen'></i></button>
                        <button class='app-button-inner btn btn-sm btn-delete' type='button' data-bs-toggle='modal' data-bs-target='#user-delete-modal-$id'><i class='fa-solid fa-trash'></i></button>
                    </td>
                </tr>
                
                <div class='modal fade' id='user-delete-modal-$id' tabindex='-1' role='dialog' aria-labelledby='delete-app-message' aria-hidden='true'>
                    <div class='modal-dialog modal-dialog-centered' role='document'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h4 class='modal-title' id='delete-warning'>Are you sure you want to delete this user?</h4>
                            </div>
                            <div class='modal-body'>
                                <p>Deleted users can be recovered later.</p>
                            </div>
                            <div class='modal-footer'>
                                <form method='POST' action='#'>
                                    <input type='hidden' value='2' name='submit-from'>
                                    <input type='hidden' value='$id' name='id'> 
                                    <button type='button' class='modal-close-secondary' data-bs-dismiss='modal'>Cancel</button>
                                    <button type='submit' class='modal-delete'>Delete User</button>
                                </form>   
                            </div>
                        </div>
                    </div>
                </div>
            ";
        }
    }
}
?>