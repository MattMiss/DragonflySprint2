<?php
session_start();
$location = '';
$pageTitle ='Signup Form';

// Logout and return to login.php if ?logout=true
include 'php/roles/logout_check.php';
// Redirect users to user dashboard
include 'php/roles/user_kick.php';
// Redirect admins to admin dashboard
include 'php/roles/admin_kick.php';

include 'header.php';
include 'php/nav_bar.php'
?>
<main>
    <div class="container p-3" id="main-container">
        <h3 class="form-header p-3 mb-0">Sign-up</h3>
        <div class="form-container mb-5">
            <div class="form-body">
                <form  onsubmit="return validateForm()" method="POST" action="php/signup_submit.php" class="my-3">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name*</label>
                        <div class="row">
                            <div class="col-sm">
                                <input type="text" id="input-first-name" class="form-control" name="firstName" placeholder="First name"
                                       aria-label="First name" maxlength="30">
                            </div>
                            <div class="col-sm pt-sm-0 pt-2">
                                <input type="text" id="input-last-name" class="form-control" name="lastName" placeholder="Last name"
                                       aria-label="Last name" maxlength="30">
                            </div>
                        </div>
                        <small id="name-error" class="warning">Please enter your first and last name</small>
                    </div>

                    <div class="mb-4">
                        <label for="input-email" class="form-label">Email*</label>
                        <input type="email" class="form-control" id="input-email" name="email"
                               placeholder="e.g. example@email.com" maxlength="60">

                        <small id="email-note">Note: an @greenriver.edu email is preferred</small>
                        <small id="email-error" class="warning">Please enter a valid email</small>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label for="input-password" class="form-label">Password*</label>
                            <input type="text" class="form-control" id="input-password" name="password" minlength="8" maxlength="16">
                        </div>
                        <div class="col">
                            <label for="input-password-confirm" class="form-label">Re-enter Password*</label>
                            <input type="text" class="form-control" id="input-password-confirm" name="password-confirm" minlength="8" maxlength="16">
                        </div>

                        <small id="password-error" class="warning">Please enter a valid password, refer to the requirements below</small>
                    </div>
                    <ul class="mb-3">
                        <li>Between 8-16 characters</li>
                        <li>Must include at least 1 number</li>
                        <li>Both passwords must match</li>
                        <li>OPTIONAL: include special characters: !@#$%&*_-.</li>
                    </ul>

                    <div class="mb-3">
                        <label for="input-cohort-num" class="form-label">Cohort Number*</label>
                        <input type="number" class="form-control" id="input-cohort-num" name="cohort-num" min="1" max="100" placeholder="1-100">
                        <small id="cohort-error" class="warning">Please enter a number between 1 and 100</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status*</label>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" id="seekingInternship" name="status" value="Seeking Internship">
                            <label for="seekingInternship" class="form-check-label">Seeking Internship</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" id="seekingJob" name="status" value="Seeking Job">
                            <label for="seekingJob" class="form-check-label">Seeking Job</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" id="notSearching" name="status" value="Not Actively Searching">
                            <label for="notSearching" class="form-check-label">Not Actively Searching</label>
                        </div>
                        <small id="status-error" class="warning">Please select a status</small>
                    </div>

                    <div class="mb-3">
                        <label for="input-roles" class="form-label">What roles are you looking for?</label>
                        <textarea class="form-control" id="input-roles" name="roles"
                                  minlength="0" maxlength="500" placeholder="Type here..."></textarea>
                        <small id="roles-error" class="warning">You have exceeded the maximum character limit of 500</small>
                    </div>

                    <button type="submit" class="submit-btn">Submit</button>
                </form>
            </div>
        </div>
    </div>
</main>


<?php include 'php/footer.php' ?>
<!-- Special Javascript to allow special signup things work -->
<script src="js/signupscript.js"></script>
<script src="js/main.js"></script>
</body>
</html>