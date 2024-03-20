<?php
session_start();
ob_start();

$location = '';
$pageTitle = 'Contact Form';

// If user is logged in, Log user out if idle time or logged in time is past max
if (isset($_SESSION['user_id'])){
    $uID = $_SESSION['user_id'];

    include 'php/roles/timeout_check.php';
}
// Logout and return to login.php if ?logout=true
include 'php/roles/logout_check.php';
// Redirect admins to admin dashboard
include 'php/roles/admin_kick.php';

include 'header.php';

include 'php/nav_bar.php' ?>
    <main>
        <div class="container p-3" id="main-container">
            <h3 class="form-header">Contact</h3>
            <div class="form-container">
                <div class="form-body">
                    <form method="post" action="php/contact_submit.php" onsubmit="return validateForm()" name="contact" class="my-3">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name*</label>
                            <small id="contact-name-error" class="warning ps-1">Please enter your first and last name</small>
                            <div class="row">
                                <div class="col-sm">
                                    <input type="text" id="contact-first-name" class="form-control" name="firstName" placeholder="First name"
                                           aria-label="First name" maxlength="30">
                                </div>
                                <div class="col-sm pt-sm-0 pt-2">
                                    <input type="text" id="contact-last-name" class="form-control" name="lastName" placeholder="Last name"
                                           aria-label="Last name" maxlength="30">
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="contact-email" class="form-label">Email*</label>
                            <small id="contact-email-error" class="warning ps-1">Please enter a valid email</small>
                            <input type="email" class="form-control" id="contact-email" name="email" placeholder="e.g. example@email.com">
                        </div>

                        <div class="mb-4">
                            <label for="contact-message" class="form-label">Message*</label>
                            <small id="contact-message-error" class="warning ps-1">Please enter a message between 25 and 1000 characters</small>
                            <textarea class="form-control" id="contact-message" name="message" placeholder="Type your message here..." rows="4" minlength="25" maxlength="1000"></textarea>
                        </div>


                        <button type="submit" class="submit-btn">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </main>

<?php include 'php/footer.php' ?>
<!-- Special Javascript to allow special contact things work -->
<script src="js/contactscript.js"></script>
</body>
</html>