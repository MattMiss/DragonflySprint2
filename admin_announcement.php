<?php
session_start();
$location = '';
$pageTitle = 'Admin Announcement';

global $db_location;
global $cnxn;
global $viewingID;

// Logout and return to login.php if ?logout=true
include 'php/roles/logout_check.php';
// Ensure a user is logged in
include 'php/roles/user_check.php';
// Ensure an admin is logged in
include 'php/roles/admin_check.php';

include 'header.php';
include 'php/nav_bar.php';
include 'db_picker.php';
include $db_location;

?>

<main>
    <div class="container p-3" id="main-container">
        <h3 class="form-header">Admin Announcement Form</h3>
        <div class="form-container">
            <form method="post" action="php/admin_announcement_submit.php" class="form-body my-3">
                <div class="mb-4">
                    <label for="announcement-title" class="form-label">Title*</label>
                    <input type="text" class="form-control" id="announcement-title" name="announcement-title"
                           placeholder="Position Name" required>
                </div>
                <div class="mb-4">
                    <label class="form-label">Job or Internship*</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="job-or-intern" id="job" value="job" required>
                        <label class="form-check-label" for="job">Job</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="job-or-intern" id="internship" value="internship">
                        <label class="form-check-label" for="internship">Internship</label>
                    </div>
                </div>
                <div class="mb-4">
                    <label for="location" class="form-label">Location*</label>
                    <input type="text" class="form-control" id="location" name="location"
                           placeholder="Address" required>
                </div>
                <div class="mb-4">
                    <label for="employer" class="form-label">Employer*</label>
                    <input type="text" class="form-control" id="employer" name="employer"
                           placeholder="Company Name" required>
                </div>
                <div class="mb-4">
                    <label for="additional-text" class="form-label">More Information</label>
                    <textarea class="form-control" id="additional-text" name="additional-text"
                              placeholder="Type here..." rows="5"></textarea>
                </div>
                <div class="mb-4">
                    <label for="announcement-url" class="form-label">URL*</label>
                    <input type="url" class="form-control" id="announcement-url" name="announcement-url"
                           placeholder="e.g. https://www.example.com" required>
                </div>
                <div class="mb-4">
                    <label for="announce-send-to-select" class="form-label">Send Announcement To</label>
                    <select class="form-select" id="announce-send-to-select" name="send-to-select">
                        <option selected value="all">Everyone</option>
                        <option value="interns">Users Looking For Internships</option>
                        <option value="jobs">Users Looking For Jobs</option>
                        <option value="admins">Admins Only</option>
                    </select>
                </div>
                <div class="mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="discard-inactive-users" id="discard-inactive-users" value="true" checked>
                        <label class="form-check-label" for="discard-inactive-users">Leave out users who are not actively searching</label>
                    </div>
                </div>
                <input type="hidden" id="first-name" name="first-name" value="default">
                <input type="hidden" id="last-name" name="last-name" value="default">

                <button id="submit-btn" type="submit" class="submit-btn" data-bs-target="#announcement-modal">Submit</button>
            </form>
        </div>
    </div>
</main>


<?php include 'php/footer.php' ?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="js/announcement.js"></script>
<script src="js/contactscript.js"></script>
<script src="js/main.js"></script>
</body>
</html>