<?php
session_start();
$location = '';
$pageTitle = 'Contact Form';

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
                        <label for="name" class="form-label">Name*</label>
                        <div id="name" class="row mb-4">
                            <div class="col-sm">
                                <input type="text" class="form-control" name="firstName" placeholder="First name" aria-label="First name" required>
                            </div>
                            <div class="col-sm pt-sm-0 pt-2">
                                <input type="text" class="form-control" name="lastName" placeholder="Last name" aria-label="Last name" required>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="input-email" class="form-label">Email*</label>
                            <input type="email" class="form-control" id="input-email" name="email" placeholder="e.g. example@email.com" required>
                        </div>

                        <div class="mb-4">
                            <label for="input-message" class="form-label">Message*</label>
                            <textarea class="form-control" id="input-message" name="message" placeholder="Type your message here..." rows="4" minlength="25" maxlength="1000" required></textarea>
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
<script src="js/main.js"></script>
</body>
</html>