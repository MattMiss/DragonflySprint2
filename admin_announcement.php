

<?php
session_start();
$_SESSION['location'] = '';

global $db_location;
global $cnxn;
global $viewingID;

// Logout and return to login.php if ?logout=true
include 'php/roles/logout_check.php';
// Ensure a user is logged in
include 'php/roles/user_check.php';
// Ensure an admin is logged in
include 'php/roles/admin_check.php';

echo
'<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Announcement</title>
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