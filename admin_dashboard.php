<?php
session_start();
$location = '';

global $db_location;
global $cnxn;
global $viewingID;

// Logout and return to login.php if ?logout=true
include 'php/roles/logout_check.php';
// Ensure a user is logged in
include 'php/roles/user_check.php';
// Ensure an admin is logged in
include 'php/roles/admin_check.php';

echo '
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
<body>';

include 'php/nav_bar.php';
include 'db_picker.php';
include $db_location;

$appWasDeleted = false;
$userWasDeleted = false;
$announceWasDeleted = false;

// soft deletes a database entry
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if($_POST["submit-from"] == 1) {
        $id = $_POST["id"];
        $sqlDeleteApp = "UPDATE applications SET is_deleted = 1 WHERE application_id = $id";
        $appWasDeleted = true;
        $deleteAppResult = @mysqli_query($cnxn, $sqlDeleteApp);
    } elseif ($_POST["submit-from"] == 2) {
        $id = $_POST["id"];

        // Ensure a user is logged in
        include 'php/roles/user_check.php';
        // Ensure an admin is logged in
        include 'php/roles/admin_check.php';

        $sqlDeleteUser = "UPDATE users SET is_deleted = 1 WHERE user_id = $id";
        $userWasDeleted = true;
        //echo $sql4;
        $deleteUserResult = @mysqli_query($cnxn, $sqlDeleteUser);
    }else if($_POST["submit-from"] == 3) {
        $id = $_POST["id"];
        $perm = $_POST["perm"];

        // Ensure a user is logged in
        include 'php/roles/user_check.php';
        // Ensure an admin is logged in
        include 'php/roles/admin_check.php';

        $sqlMakeUserAdmin = "UPDATE users SET permission = $perm WHERE user_id = $id";
        $makeAdminResult = @mysqli_query($cnxn, $sqlMakeUserAdmin);

    }else if($_POST["submit-from"] == 4) {
        $announceID = $_POST["announcement-id"];

        // Ensure a user is logged in
        include 'php/roles/user_check.php';
        // Ensure an admin is logged in
        include 'php/roles/admin_check.php';

        $sqlDeleteAnnouncement = "UPDATE announcements SET is_deleted = 1 WHERE announcement_id = $announceID";
        $deletedAnnouncementResult = @mysqli_query($cnxn, $sqlDeleteAnnouncement);
        $announceWasDeleted = true;
    }
}

$role = 1;

// fetches specific data from database tables
// $sqlApps = "SELECT * FROM applications WHERE is_deleted = 0 ORDER BY application_id DESC";
$sqlApps = "SELECT * FROM `applications` JOIN `users` WHERE `applications`.`user_id` = `users`.`user_id` AND 
                                        `applications`.is_deleted = 0 AND `users`.is_deleted = 0";
$sqlAnnounce = "SELECT * FROM announcements WHERE is_deleted = 0 ORDER BY date_created DESC"; // 5 most recent announcements
$sqlUsers = "SELECT * FROM users"; // 5 users (deleted users get filtered out in dash-users.js so admin can see deleted too)
$appsResult = @mysqli_query($cnxn, $sqlApps);
$announceResult = @mysqli_query($cnxn, $sqlAnnounce);
$usersResult = @mysqli_query($cnxn, $sqlUsers);

// Fill in apps array
$apps[] = array();
$users[] = array();

$appCount = 0;
while ($row = mysqli_fetch_assoc($appsResult)) {
    $apps[$appCount] = $row;
    $appCount++;
}

$userCount = 0;
while ($row = mysqli_fetch_assoc($usersResult)) {
    $users[$userCount] = $row;
    $userCount++;
}

?>


<main>
    <div class="container p-3 position-relative" id="main-container">
        <div id="toastContainer"  class="position-absolute start-50 top-0 translate-middle-x mt-3 alert-hide">
            <p class="pt-2 px-5" id="toastText"></p>
        </div>
        <div class="row dashboard-top">
            <div class="app-list-admin">
                <h3>Recent Applications</h3>
                <div class="row">
                    <div class="col-md-4 pt-2">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text">Start Date</span>
                            <input type="date" class="form-control" id="app-start-date" name="search-start-date">
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
                    <div class="col py-2">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </span>
                            <input id="app-search-bar" type="text" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="basic-addon1">
                        </div>
                    </div>
                </div>

<!--                start of app table -->
                <table class="dash-table admin-app">
                    <thead>
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
                                    URL
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
                    </tr>
                    </thead>
                    <tbody class="table-body" id="dash-apps-list">
                    <!-- List gets populated with applications from the database here with dash-apps.js -->
                    </tbody>
                </table>
                <div class="col text-center pt-2 pb-2" id="more-apps">
                    <button type="button" class="submit-btn"  onclick="loadMoreApps()">More</button>
                </div>
            </div>
        </div>

        <div class="row dashboard-top">
            <div class="reminders-list pt-4">
                <h3>Announcements</h3>
                <table class="dash-table admin-announcement">
                    <thead>
                        <tr>
                            <th scope="col" class="announce-date-col">Date</th>
                            <th scope="col" class="announce-position-col">Position</th>
                            <th scope="col" class="announce-employer-col">Employer</th>
                            <th scope="col" class="announce-url-col">URL</th>
                            <th scope="col" class="w-btn"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php createAdminAnnouncements($announceResult);?>
                    </tbody>
                </table>
            </div>
        </div>


        <div class="row dashboard-top">
            <div class="user-list pt-4">
                <div class="row">
                    <div class="col">
                        <h3>Users</h3>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-5 py-2">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </span>
                            <input id="users-search-bar" type="text" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="User Search Bar">
                        </div>
                    </div>
                    <div class="col-md-7 py-2">
                        <div class="row">
                            <div class="col-8 ">
                                <div class="input-group">
                                    <span class="input-group-text">Status</span>
                                    <select class="form-select" id="user-status-select">
                                        <option selected value="any">Any</option>
                                        <option value="Seeking Job">Seeking Job</option>
                                        <option value="Seeking Internship">Seeking Internship</option>
                                        <option value="Not Actively Searching">Not Actively Searching</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-check form-check-reverse pt-1">
                                    <input class="form-check-input pt-1" type="checkbox" value="" id="user-deleted-check">
                                    <label class="form-check-label pe-1" for="user-deleted-check" id="user-deleted-label">
                                        Include Deleted Users?
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="dash-table admin-user">
                    <thead>
                    <tr>
                        <th scope="col" class="user-role-col">
                            <div class="row clickable" id="user-role-order-btn">
                                <div class="col-auto pe-0 my-auto">
                                    Role
                                </div>
                                <div class="col-auto ps-2 my-auto">
                                    <div class="order-icons">
                                        <div class="order-icons">
                                            <i class="fa-solid fa-sort" id="user-role-field-icon"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </th>
                        <th scope="col" class="user-name-col">
                            <div class="row clickable" id="user-name-order-btn">
                                <div class="col-auto pe-0 my-auto">
                                    Name
                                </div>
                                <div class="col-auto ps-2 my-auto">
                                    <div class="order-icons">
                                        <div class="order-icons">
                                            <i class="fa-solid fa-sort" id="user-name-field-icon"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </th>
                        <th scope="col" class="user-email-col">
                            <div class="row clickable" id="user-email-order-btn">
                                <div class="col-auto pe-0 my-auto">
                                    Email
                                </div>
                                <div class="col-auto ps-2 my-auto">
                                    <div class="order-icons">
                                        <div class="order-icons">
                                            <i class="fa-solid fa-sort" id="user-email-field-icon"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </th><th scope="col" class="user-status-col">
                            <div class="row clickable" id="user-status-order-btn">
                                <div class="col-auto pe-0 my-auto">
                                    Status
                                </div>
                                <div class="col-auto ps-2 my-auto">
                                    <div class="order-icons">
                                        <div class="order-icons">
                                            <i class="fa-solid fa-sort" id="user-status-field-icon"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </th>
                        <th scope="col" class="user-buttons-col"></th>
                    </tr>
                    </thead>
                    <tbody id="dash-users-list">
                        <!-- List gets populated with users from the database here with dash-users.js -->
                    </tbody>
                </table>
<!--                <p class="title mx-auto" style="display: block; width:100px; color: green">More</p>-->
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

        <!---------------------------------------  MODALS  -------------------------------------------------->
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
                                <span class='form-label'>User: </span>
                                <span id="edit-modal-user"></span>
                            </li>
                            <li class='list-group-item pb-3'>
                                <span class='form-label'>Email: </span>
                                <span id="edit-modal-email"></span>
                            </li>
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
                                <a id="edit-modal-url" href="" target="_blank" rel="noopener noreferrer">Apply Here</a>
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

        <!-- Edit User Modal -->
        <div class='modal fade' id='user-edit-modal' tabIndex='-1' role='dialog' aria-labelledby='job-title' aria-hidden='true'>
            <div class='modal-dialog modal-dialog-centered' role='document'>
                <div class='modal-content'>
                    <div class='modal-header'>
                        <h3 class='modal-title' id='job-title'>User Details</h3>
                        <button type='button' class='modal-close-primary close' data-bs-dismiss='modal' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                    </div>
                    <div class='modal-body'>
                        <ul class='list-group-item'>
                            <li class='list-group-item pb-1'>
                                <span class='form-label'>Permission: </span>
                                <span id="user-edit-modal-permission"></span>
                            </li>
                            <li class='list-group-item pb-1'>
                                <span class='form-label'>Deleted: </span>
                                <span id="user-edit-modal-deleted"></span>
                            </li>
                            <li class='list-group-item pb-1'>
                                <span class='form-label'>First Name: </span>
                                <span id="user-edit-modal-fname"></span>
                            </li>
                            <li class='list-group-item pb-1'>
                                <span class='form-label'>Last Name: </span>
                                <span id="user-edit-modal-lname"></span>
                            </li>
                            <li class='list-group-item pb-1'>
                                <span class='form-label'>Email: </span>
                                <span id="user-edit-modal-email"></span>
                            </li>
                            <li class='list-group-item pb-1'>
                                <span class='form-label'>Password: </span>
                                <span id="user-edit-modal-password"></span>
                            </li>
                            <li class='list-group-item pb-1'>
                                <span class='form-label'>Cohort Number: </span>
                                <span id="user-edit-modal-cohort"></span>
                            </li>
                            <li class='list-group-item pb-1'>
                                <span class='form-label'>Job Status: </span>
                                <span id="user-edit-modal-job-status"></span>
                            </li>
                            <li class='list-group-item'>
                                <span class='form-label'>Desired Roles: </span>
                                <p id="user-edit-modal-roles" style="margin: 0"></p>
                            </li>
                        </ul>
                    </div>
                    <div class='modal-footer'>
                        <button type='button' id="user-edit-modal-admin" class="btn btn-make-admin" data-bs-dismiss='modal'></button>
                        <button type='button' class='modal-close-secondary' data-bs-dismiss='modal'>Close</button>
                        <form method="post" action="user_edit.php" target="_blank">
                            <input id="edit-modal-user-id" type="hidden" name="user-id" value="">
                            <button type="submit" class="modal-edit">Edit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Delete Modal -->
        <div class='modal fade' id='user-delete-modal' tabindex='-1' role='dialog' aria-labelledby='delete-app-message' aria-hidden='true'>
            <div class='modal-dialog modal-dialog-centered' role='document'>
                <div class='modal-content'>
                    <div class='modal-header'>
                        <h4 class='modal-title' id='delete-warning'>Delete User?</h4>
                    </div>
                    <div class='modal-body'>
                        <p>Are you sure you want to delete <span id="user-delete-modal-name"></span>? Deleted users can be recovered later.</p>
                    </div>
                    <div class='modal-footer'>
                        <form method='POST' action='#'>
                            <input type='hidden' value='2' name='submit-from'>
                            <input type='hidden' id="delete-user-id" value='' name='id'>
                            <button type='button' class='modal-close-secondary' data-bs-dismiss='modal'>Cancel</button>
                            <button type='submit' class='modal-delete'>Delete User</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Toggle User Admin Modal -->
        <div class='modal fade' id='toggle-admin-modal' tabindex='-1' role='dialog' aria-labelledby='make-admin-message' aria-hidden='true'>
            <div class='modal-dialog modal-dialog-centered' role='document'>
                <div class='modal-content'>
                    <div class='modal-header'>
                        <h4 class='modal-title' id='toggle-admin-title'>Make Admin?</h4>
                    </div>
                    <div class='modal-body'>
                        <p><span id="toggle-admin-modal-name"></span></p>
                    </div>
                    <div class='modal-footer'>
                        <form method='POST' action='#'>
                            <input type='hidden' value='3' name='submit-from'>
                            <input type='hidden' id="toggle-admin-user-id" value='' name='id'>
                            <input type='hidden' id="toggle-admin-user-perm" value='' name='perm'>
                            <button type='button' class='modal-close-secondary' data-bs-dismiss='modal'>Cancel</button>
                            <button type='submit' class='modal-delete' id='toggle-admin-btn'>Make Admin</button>
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
                        <form method="post" action="announcement_edit.php" target="_blank">
                            <input id="edit-announce-modal-id" type="hidden" name="announce-id" value="">
                            <button type="submit" class="modal-edit">Edit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Announcement Delete Modal -->
        <div class='modal fade' id='delete-announcement-modal' tabindex='-1' role='dialog' aria-labelledby='delete-announce' aria-hidden='true'>
            <div class='modal-dialog modal-dialog-centered' role='document'>
                <div class='modal-content'>
                    <div class='modal-header'>
                        <h4 class='modal-title' id='delete-warning'>Delete Announcement?</h4>
                    </div>
                    <div class='modal-body'>
                        <p>Are you sure you want to delete announcement for <span id="delete-announce-title"></span>?</p>
                    </div>
                    <div class='modal-footer'>
                        <form method='POST' action='#'>
                            <input type='hidden' value='4' name='submit-from'>
                            <input type='hidden' id='delete-announcement-id' value='' name='announcement-id'>
                            <button type='button' class='modal-close-secondary' data-bs-dismiss='modal'>Cancel</button>
                            <button type='submit' class='modal-delete'>Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

</main>

<?php include 'php/footer.php' ?>
<script>
    let apps = <?php echo json_encode($apps) ?>;
    let users = <?php echo json_encode($users) ?>;
    let role = <?php echo $role ?>;
    let userID = <?php echo $viewingID ?>;
    let appWasDeleted = <?php echo json_encode($appWasDeleted) ?>;
    let userWasDeleted = <?php echo json_encode($userWasDeleted) ?>;
    let announceWasDeleted = <?php echo json_encode($announceWasDeleted) ?>;
</script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="js/main.js"></script>
<script src="js/dash-functions.js"></script>
<script src="js/dash-apps.js"></script>
<script src="js/dash-users.js"></script>
<script src="js/dash-announcements.js"></script>
</body>
</html>



<?php

function createAdminAnnouncements($info) {
    $isEmpty = true;
    while ($row = mysqli_fetch_assoc($info)) {
        $id = $row["announcement_id"];
        $title = $row["title"];
        $jtype = $row["job_type"];
        $location = $row["location"];
        $ename = $row["ename"];
        $jobInfo = $row["additional_info"];
        $jurl = $row["jurl"];
        $recipient = $row["sent_to"];
        $date = $row["date_created"];
        $announce = json_encode($row);
        $isEmpty = false;

        echo "
            <tr id='$id'>
                <td>$date</td>
                <td>$title $jtype</td>
                <td>$ename</td>
                <td class='job-url'><a href='$jurl' target='_blank'>Apply Link</a></td>
                <td class='app-button-outer'>
                        <button class='app-button-inner btn btn-sm btn-update' type='button' onclick='showViewAnnouncementModal($announce)'><i class='fa-solid fa-pen'></i></button>
                        <button class='app-button-inner btn btn-sm btn-delete' type='button' onclick='showDeleteAnnouncementModal($announce)'><i class='fa-solid fa-trash'></i></button>
                </td>
            </tr>
            ";
    }
    if ($isEmpty){
        echo "
            <tr>
                <td></td>
                <td></td>
                <td>No Announcements</td>
                <td></td>
                <td></td>
            </tr>";
    }
}
?>


