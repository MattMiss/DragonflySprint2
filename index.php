<?php
session_start();
ob_start();

$location = '';
$pageTitle = 'User Dashboard Homepage';

global $cnxn;
global $viewingID;
global $db_location;

// Log user out if idle time or logged in time is past max
include 'php/roles/timeout_check.php';
// Logout and return to login.php if ?logout=true
include 'php/roles/logout_check.php';
// Check for user_id in SESSION and redirect to login if null
include 'php/roles/user_check.php';
// Redirect admins to admin dashboard
include 'php/roles/admin_kick.php';

include 'header.php';
include 'php/nav_bar.php';
include 'db_picker.php';
include $db_location;

$appWasDeleted = false;

$viewingUser = "SELECT permission FROM users WHERE user_id = $viewingID";
$viewingUserResult = @mysqli_query($cnxn, $viewingUser);
$isAdmin = mysqli_fetch_assoc($viewingUserResult)['permission'] === '1';

// soft deletes a database entry
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if ($_POST["submit-from"] == 1) {
        //echo "ID is: " . $_POST["id"];
        $id = $_POST["id"];
        $sqlDeleteApp = "UPDATE applications SET is_deleted = 1 WHERE application_id = $id";
        $appWasDeleted = true;
        $deleteAppResult = @mysqli_query($cnxn, $sqlDeleteApp);
    }
}

$role = 0;

$date = date('Y-m-d', time());
$start = date('Y-m-d', strtotime($date . '-15days'));
$finish = date('Y-m-d', strtotime($date . '+5days'));

$sqlRecentAnnounce = "SELECT * FROM announcements WHERE is_deleted = 0 AND (date_created BETWEEN '$start' AND '$date')
        ORDER BY announcement_id DESC"; // announcements from last 5 days
$sqlRecentApps = "SELECT * FROM applications WHERE is_deleted = 0 AND user_id = $viewingID AND (followupdate BETWEEN '$start' AND '$finish')
        ORDER BY application_id DESC";


$sqlApps = "SELECT * FROM applications WHERE is_deleted = 0 AND user_id = $viewingID ORDER BY application_id DESC";
//$sqlAnnounce = "SELECT * FROM announcements WHERE is_deleted = 0 ORDER BY id DESC LIMIT 5"; // announcements from last 5 days
$appsResult = @mysqli_query($cnxn, $sqlApps);
$announceResult = @mysqli_query($cnxn, $sqlRecentAnnounce);
$appReminders = @mysqli_query($cnxn, $sqlRecentApps);

$apps[] = [];

while ($row = mysqli_fetch_assoc($appsResult)) {
    $myApps[] = $row;
}

while ($row = mysqli_fetch_assoc($announceResult)) {
    $myAnnouncements[] = $row;
}

while ($row = mysqli_fetch_assoc($appReminders)) {
    $myAppReminders[] = $row;
}

?>

<main>
<!--    <div id="alertPlaceholder" style="position: absolute; left: 50%; transform: translate(-50%, 0)"></div> -->
    <div class="container p-3 position-relative" id="main-container">
        <div id="toastContainer"  class="position-absolute start-50 top-0 translate-middle-x mt-3 alert-hide">
            <p class="pt-2 px-5" id="toastText"></p>
        </div>
        <div class="row dashboard-top">
            <div class="app-list col-md-9">
                <h3>Recent Applications</h3>
                <div class="row">
                    <div class="col-md-4 pt-2">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text">Start Date</span>
                            <input type="date" class="form-control date-input" id="app-start-date" name="search-start-date">
                        </div>
                    </div>
                    <div class="col-md-4 pt-2">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text">End Date</span>
                            <input type="date" class="form-control date-input" id="app-end-date" name="search-end-date">
                        </div>
                    </div>
                    <div class="col-md-4 text-end pt-2">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text">Status</span>
                            <select class="form-select status-select" id="app-status-select">
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
                    <thead class="table-head">
                    <tr>

                        <th scope="col" class="app-date-col">
                            <div class="row clickable" id="date-order-btn">
                                <div class="col-auto pe-0 my-auto">
                                    Date
                                </div>
                                <div class="col-auto ps-2 my-auto">
                                    <div class="order-icons">
                                        <i class="fa-solid fa-sort" id="date-field-icon"></i>
                                    </div>
                                </div>
                            </div>
                        </th>
                        <th scope="col" class="app-job-col">
                            <div class="row clickable" id="job-order-btn">
                                <div class="col-auto pe-0 my-auto">
                                    Job Title
                                </div>
                                <div class="col-auto ps-2 my-auto">
                                    <div class="order-icons">
                                        <div class="order-icons">
                                            <i class="fa-solid fa-sort" id="job-field-icon"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </th>
                        <th scope="col" class="app-employer-col">
                            <div class="row clickable" id="employer-order-btn">
                                <div class="col-auto pe-0 my-auto">
                                    Employer
                                </div>
                                <div class="col-auto ps-2 my-auto">
                                    <div class="order-icons">
                                        <div class="order-icons">
                                            <i class="fa-solid fa-sort" id="employer-field-icon"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </th>
                        <th scope="col" class="app-status-col" id="status-order-btn">
                            <div class="row clickable">
                                <div class="col-auto pe-0 my-auto">
                                    Status
                                </div>
                                <div class="col-auto ps-2 my-auto">
                                    <div class="order-icons">
                                        <div class="order-icons">
                                            <i class="fa-solid fa-sort" id="status-field-icon"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </th>
                        <th scope="col" class="w-btn"></th>
                    </tr>
                    </thead>
                    <tbody class="table-body" id="dash-apps-list">

                        <!-- List gets populated with applications from the database here-->

                    </tbody>
                </table>
                <div class="col text-center pt-2 pb-2" id="more-apps">
                    <button type="button" class="submit-btn"  onclick="loadMoreApps()">More</button>
                </div>
                <div class="col d-flex justify-content-center pt-2" id="new-app-container">
                    <a class="submit-btn" href="application_form.php">New Application</a>
                </div>
            </div>

            <div class="reminders col ">
                <h3>Reminders</h3>
                <div>
                    <h6>Announcements</h6>
                    <hr>
                    <div id="my-announcements">

                        <!-- List gets populated with announcements from the database here-->

                    </div>
                </div>
                <div style="padding-top: 20px;">
                    <h6>Follow Up</h6>
                    <hr>
                    <div id="my-app-reminders">

                        <!-- List gets populated with application follow-up reminders from the database here-->

                    </div>
                </div>
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
    </div>

    <!-----------------------------  MODALS  ----------------------------------->
    <!-- Delete App Modal -->
    <div class='modal fade' id='app-delete-modal' tabindex='-1' role='dialog' aria-labelledby='delete-app-message' aria-hidden='true'>
        <div class='modal-dialog modal-dialog-centered' role='document'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h4 class='modal-title' id='delete-warning'>Delete Application?</h4>
                </div>
                <div class='modal-body'>
                    <p>Are you sure you want to delete application for<span id="app-delete-modal-company"></span>? Deleted applications can be recovered later.</p>
                </div>
                <div class='modal-footer'>
                    <form method='POST' action='#'>
                        <input type='hidden' value='1' name='submit-from'>
                        <input id='delete-id' type='hidden' value='' name='id'>
                        <button type='button' class='modal-close-secondary' data-bs-dismiss='modal'>Cancel</button>
                        <button type='submit' class='modal-delete'>Delete Application</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit App Modal -->
    <div class='modal fade' id='edit-modal' tabIndex='-1' role='dialog' aria-labelledby='job-title' aria-hidden='true'>
        <div class='modal-dialog modal-dialog-centered' role='document'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h3 class='modal-title' id='job-title'>Application Details</h3>
                    <button type='button' class='modal-close-primary close' data-bs-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                </div>
                <div class='modal-body'>
                    <ul class='list-group-item'>
                        <li class='list-group-item pb-1'>
                            <span class='form-label'>Job Name: </span>
                            <span id="edit-modal-jname"></span>
                        </li>
                        <li class='list-group-item pb-1'>
                            <span class='form-label'>Employer Name: </span>
                            <span id="edit-modal-ename"></span>
                        </li>
                        <li class='list-group-item pb-1'>
                            <span class='form-label'>URL:</span>
                            <a id="edit-modal-url" href="" target="_blank" rel="noopener noreferrer">Apply Now!</a>
                        </li>
                        <li class='list-group-item'>
                            <span class='form-label'>Job Description: </span>
                            <p id="edit-modal-description" style="margin: 0"></p>
                        </li>
                        <li class='list-group-item pb-1'>
                            <span class='form-label'>Application date: </span>
                            <span id="edit-modal-adate"></span>
                        </li>
                        <li class='list-group-item pb-1'>
                            <span class='form-label'>Status: </span>
                            <span id="edit-modal-astatus-icon" class="status">
                                            <i class='fa-solid fa-circle'></i>
                                        </span>
                            <span id="edit-modal-astatus" style="text-transform: capitalize"></span>
                        </li>
                        <li class='list-group-item'>
                            <span class='form-label'>Followup date: </span>
                            <span id="edit-modal-fdate"></span>
                        </li>
                        <li class='list-group-item pb-1'>
                            <span class='form-label'>Followup updates: </span>
                            <p id="edit-modal-updates" style="margin: 0"></p>
                        </li>
                    </ul>
                </div>
                <div class='modal-footer'>
                    <button type='button' class='modal-close-secondary' data-bs-dismiss='modal'>Close</button>
                    <form method="post" action="application_edit.php" target="_blank">
                        <input id="edit-modal-appid" type="hidden" name="application-id" value="">
                        <button type="submit" class="modal-edit">Edit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- View Announcement Modal -->
    <div class='modal fade' id='view-announcement-modal' tabindex='-1' role='dialog' aria-labelledby='view-announcement' aria-hidden='true'>
        <div class='modal-dialog' role='document'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title' id='view-announce-title'>$title</h5>
                    <button type='button' class='modal-close-primary close' data-bs-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <div class='modal-body'>
                    <ul class='list-group-item'>
                        <li class='list-group-item pb-1'>
                            <span class='form-label'>Company: </span><span id="view-announce-employer"></span>
                        </li>
                        <li class='list-group-item pb-1'>
                            <span class='form-label'>Address: </span><span id="view-announce-address"></span>
                        </li>
                        <li class='list-group-item pb-1'>
                            <span class='form-label'>URL: </span>
                            <a id="view-announce-jurl" href='' target='_blank'>Apply Here</a>
                        </li>
                        <li class='list-group-item'>
                            <span class='form-label'>More Information: </span><span id="view-announce-info"></span>
                        </li>
                    </ul>
                </div>
                <div class='modal-footer'>
                    <button type='button' class='modal-close-secondary' data-bs-dismiss='modal'>Close</button>
                </div>
            </div>
        </div>
    </div>

</main>
<?php include 'php/footer.php'?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="js/contactscript.js"></script>
<script>
    const results = {
        myApps : <?php echo json_encode($myApps) ?>,
        myAnnouncements : <?php echo json_encode($myAnnouncements) ?>,
        myAppReminders : <?php echo json_encode($myAppReminders) ?>,
        allAnnouncements : [],
        role : <?php echo $role ?>,
        users : '',
        appWasDeleted : <?php echo json_encode($appWasDeleted) ?>,
        userWasDeleted : false,
        userWasUnDeleted : false,
        announceWasDeleted : false
    }
</script>
<script src="js/main.js"></script>
<script src="js/dash-functions.js"></script>
<script src="js/dash-apps.js"></script>
<script src="js/dash-announcements.js"></script>
</body>
</html>
