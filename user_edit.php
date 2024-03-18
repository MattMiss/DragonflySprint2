<?php
session_start();
$location = '';
$pageTitle = 'Edit User';

global $db_location;
global $cnxn;
global $viewingID;

// Logout and return to login.php if ?logout=true
include 'php/roles/logout_check.php';
// Check for user_id in SESSION and redirect to login if null
include 'php/roles/user_check.php';

include 'header.php';
include 'db_picker.php';
include $db_location;

// identify whether it is a user or admin
$permission = null;
if (isset($_SESSION['permission']) && $_SESSION['permission'] == 1){
    $permission = $_SESSION['permission'];
}

if ($permission == 1) {
    // if admin, ID gotten from button
    $id = $_POST['user_id'];
    $_SESSION['edit-uid'] = $id;
    $sql = "SELECT * FROM `users` WHERE `user_id` = $id;";
} else {
    $_SESSION['edit-uid'] = $viewingID;
    // if user, ID gotten from session
    $sql = "SELECT * FROM `users` WHERE `user_id` = $viewingID;";
}

$result = @mysqli_query($cnxn, $sql);

while ($row = mysqli_fetch_assoc($result))
{
    $fname = $row['fname'];
    $lname = $row['lname'];
    $email = $row['email'];
    $cohortNum = $row['cohortNum'];
    $status = $row['status'];
    $roles = $row['roles'];
    $password = $row['password'];
}
include 'php/nav_bar.php' ?>

<main>
    <div class="container p-3" id="main-container">
        <h3 class="form-header p-3 mb-0">Edit User</h3>
        <div class="form-container mb-5">
            <div class="form-body">
                <form method="post" action="php/edit_account_update.php" onsubmit="return validateForm()" class="my-3">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name*</label>
                        <div id="name" class="row mb-4">
                            <div class="col-sm">
                                <input type="text" id="input-first-name" class="form-control" name="firstName" placeholder="First name"
                                       aria-label="First name" maxlength="30" required
                                        value="<?php echo $fname?>">
                            </div>
                            <div class="col-sm pt-sm-0 pt-2">
                                <input type="text" id="input-last-name"class="form-control" name="lastName" placeholder="Last name"
                                       aria-label="Last name" maxlength="30" required
                                       value="<?php echo $lname?>">
                            </div>
                        </div>
                        <small id="name-error" class="warning">Please enter your first and last name</small>
                    </div>

                    <div class="mb-3">
                        <label for="input-email" class="form-label">Email*</label>
                        <input type="email" class="form-control" id="input-email" name="email"
                               placeholder="e.g. example@email.com" maxlength="60" required
                               value="<?php echo $email?>">
                        <small id="email-note">Note: an @greenriver.edu email is preferred</small>
                        <small id="email-error" class="warning">Please enter a valid email</small>
                    </div>

                    <div class="mb-3">
                        <label for="user-edit-pass-select" class="form-label">Password</label>
                        <select class="form-select" id="user-edit-pass-select" name="new-pass-select">
                            <option selected value="same">Keep the Same</option>
                            <option value="new">Set New Password</option>
                        </select>
                    </div>

                    <div class="row mb-3 hidden" id="user-edit-new-pass">
                        <div class="col">
                            <label for="input-password" class="form-label">New Password*</label>
                            <input type="password" class="form-control" id="input-password" name="password" minlength="8" maxlength="16" value="">
                        </div>

                        <div class="col">
                            <label for="input-password-confirm" class="form-label">Re-enter New Password*</label>
                            <input type="password" class="form-control" id="input-password-confirm" name="password-confirm" minlength="8" maxlength="16" value="">
                        </div>
                        <small id="password-error" class="warning">Please enter a valid password, refer to the requirements below</small>
                    </div>
                    <ul class="mb-3 hidden" id="user-edit-pass-reqs">
                        <li>Between 8-16 characters</li>
                        <li>Must include at least 1 number</li>
                        <li>Both passwords must match</li>
                        <li>OPTIONAL: include special characters: !@#$%&*_-.</li>
                    </ul>
                    <div class="mb-3">
                        <label for="input-cohort-num" class="form-label">Cohort Number*</label>
                        <input type="number" class="form-control" id="input-cohort-num" name="cohort-num" min="1" max="100"
                               placeholder="1-100" required value="<?php echo $cohortNum?>">
                        <small id="cohort-error" class="warning">Please enter a number between 1 and 100</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" id="seekingInternship" name="status" value="Seeking Internship"
                                <?php if ($status == "Seeking Internship") {
                                    echo"checked='checked'";
                                }?>>
                            <label for="seekingInternship" class="form-check-label">Seeking Internship</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" id="seekingJob" name="status" value="Seeking Job"
                                <?php if ($status == "Seeking Job") {
                                    echo"checked='checked'";
                                }?>>
                            <label for="seekingJob" class="form-check-label">Seeking Job</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" id="notSearching" name="status" value="Not Actively Searching"
                                <?php if ($status == "Not Actively Searching") {
                                    echo"checked='checked'";
                                }?>>
                            <label for="notSearching" class="form-check-label">Not Actively Searching</label>
                        </div>
                        <small id="status-error" class="warning">Please select a status</small>
                    </div>

                    <div class="mb-3">
                        <label for="input-roles" class="form-label">What roles are you looking for?*</label>
                        <textarea class="form-control" id="input-roles" name="roles"
                                  minlength="5" maxlength="500" placeholder="Type here..."
                                  required><?php echo $roles?></textarea>
                        <small id="roles-error" class="warning">You have exceeded the maximum character limit of 500</small>
                    </div>

                    <button type="submit" class="submit-btn">Submit</button>
                </form>
            </div>
        </div>
    </div>
</main>




<?php include 'php/footer.php' ?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="js/user-edit.js"></script>
<!-- Special Javascript to allow special signup things work -->
<script src="js/signupscript.js"></script>
<script src="js/main.js"></script>
</body>
</html>
