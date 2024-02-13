<?php
session_start();
$_SESSION['header-title'] = 'ATT - Admin Announcement';
include 'header.php'?>
<main>
    <div class="container p-3" id="main-container">
        <h3 class="form-header">Admin Announcement Form</h3>
        <div class="form-container">
            <form method="post" action="adminannouncementPHP.php" class="form-body my-3">
                <div class="mb-4">
                    <label for="announcement-title" class="form-label">Title*</label>
                    <input type="text" class="form-control" id="announcement-title" name="announcement-title"
                           placeholder="Name of Position" required>
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
                           placeholder="From Who" required>
                </div>
                <div class="mb-4">
                    <label for="additional-text" class="form-label">More Information</label>
                    <textarea class="form-control" id="additional-text" name="additional-text"
                              placeholder="Type here..." rows="3"></textarea>
                </div>
                <div class="mb-4">
                    <label for="announcement-url" class="form-label">URL*</label>
                    <input type="url" class="form-control" id="announcement-url" name="announcement-url"
                           placeholder="e.g. https://www.example.com" required>
                </div>
                <div class="mb-4">
                    <label for="sent-to" class="form-label">Send to*</label>
                    <input type="email" class="form-control" id="sent-to" name="sent-to"
                           placeholder="e.g. example@email.com" required>
                </div>

                <button id="submit-btn" type="submit" class="submit-btn">Submit</button>
            </form>
        </div>
    </div>
</main>


<?php include 'footer.php' ?>
<script src="js/contactscript.js"></script>
</body>
</html>