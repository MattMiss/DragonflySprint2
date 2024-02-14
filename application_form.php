<?php
session_start();
$_SESSION['header-title'] = 'ATT - Application Form';
include 'header.php'?>
<main>
    <div class="container p-3" id="main-container">
        <h3 class="form-header">Application Form</h3>
        <!--        <h2 class="pt-3">Application Form</h2>-->
        <div class="form-container">
            <form method="post" action="application_submit.php" class="form-body my-3">
                <div class="mb-4">
                    <label for="job-name" class="form-label">Job Name*</label>
                    <input type="text" class="form-control" id="job-name" name="job-name" maxlength="60" required>
                </div>
                <div class="mb-4">
                    <label for="employer-name" class="form-label">Employer Name*</label>
                    <input type="text" class="form-control" id="employer-name" name="employer-name" maxlength="60" required>
                </div>
                <div class="mb-4">
                    <label for="job-url" class="form-label">Job Description URL*</label>
                    <input type="text" class="form-control" id="job-url" name="job-url" maxlength="500" required>
                </div>
                <div class="mb-4">
                    <label for="job-description" class="form-label">Job Description</label>
                    <textarea class="form-control" id="job-description" name="job-description"
                              placeholder="Little summary of the role of the job..." maxlength="500" rows="3"></textarea>
                </div>
                <div class="mb-4">
                    <label for="today" class="form-label">Date of Application*</label>
                    <input type="date" class="form-control" id="today" name="app-date" required>
                </div>
                <div class="mb-4">
                    <label for="application-status" class="form-label mb-3">Application Status*</label><br>
                    <!--<div class="form-check">
                        <input class="form-check-input" type="radio" name="application-status" id="need-to-apply" value="need-to-apply" required>
                        <label class="form-check-label" for="need-to-apply">Need to Apply</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="application-status" id="applied" value="applied">
                        <label class="form-check-label" for="applied">Applied</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="application-status" id="interviewing" value="interviewing">
                        <label class="form-check-label" for="interviewing">Interviewing</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="application-status" id="rejected" value="rejected">
                        <label class="form-check-label" for="rejected">Rejected</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="application-status" id="accepted" value="accepted">
                        <label class="form-check-label" for="accepted">Accepted</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="application-status" id="inactive" value="inactive">
                        <label class="form-check-label" for="inactive">Inactive/Expired</label>
                    </div>
                    -->

                    <select name="application-status" id="application-status">
                        <option value="select">Select an option</option>
                        <option value="need-to-apply">Need to apply</option>
                        <option value="applied">Applied</option>
                        <option value="interviewing">Interviewing</option>
                        <option value="rejected">Rejected</option>
                        <option value="accepted">Accepted</option>
                        <option value="inactive">Inactive/Expired</option>
                    </select>
                    <div id="application-wrong"></div>
                </div>
                <div class="mb-4">
                    <label for="follow-updates" class="form-label">Updates</label>
                    <textarea class="form-control" id="follow-updates" name="follow-updates"
                              placeholder="Who have you spoken with or interviewed with?" maxlength="500" rows="3"></textarea>
                </div>

                <div class="mb-4">
                    <label for="two-weeks" class="form-label">Follow up date*</label>
                    <input type="date" class="form-control" id="two-weeks" name="followup-date" required>
                </div>

                <button type="submit" class="submit-btn">Submit</button>
            </form>
        </div>
    </div>
</main>


<?php include 'footer.php' ?>
<!-- Special Javascript to allow special application things work -->
<script src="js/applicationscript.js"></script>
</body>
</html>