<?php
session_start();
$location = '';
$pageTitle = 'Edit Application';

global $db_location;
global $cnxn;
global $viewingID;

// Logout and return to login.php if ?logout=true
include 'php/roles/logout_check.php';
// Ensure a user is logged in
include 'php/roles/user_check.php';
// Redirect admins to admin dashboard
include 'php/roles/admin_kick.php';

$indexLocation =  'http://localhost:63342/Sprint4/index.php'; // local (may need to change port number)
//$indexLocation =  'https://dragonfly.greenriverdev.com/sprint5/index.php'; //cpanel

// Redirect back to index if a user navigates here without supplying an app_id
$app_id = $_POST['application-id'];
if (!$app_id){
    header("Location:$indexLocation");
}

include 'header.php';
include 'db_picker.php';
include $db_location;


$sqlApp = "SELECT * FROM `applications` WHERE `application_id` = $app_id";

$appResult = @mysqli_query($cnxn, $sqlApp);

while ($row = mysqli_fetch_assoc($appResult))
{
    $jname = $row['jname'];
    $ename = $row['ename'];
    $jurl = $row['jurl'];
    $jdescription = $row['jdescription'];
    $adate = $row['adate'];
    $astatus = $row['astatus'];
    $fupdates = $row['fupdates'];
    $followupdate = $row['followupdate'];
    $user_id = $row['user_id'];

    if ($viewingID !== $user_id){
        // TODO: user ID doesnt match here, dont load the app
    }
}



include 'php/nav_bar.php' ?>
<main>
    <div class="container p-3" id="main-container">
        <h3 class="form-header">Edit Application</h3>
        <div class="form-container">
            <form method="post" action="php/application_update.php" onsubmit="return validateForm()" class="form-body my-3">
                <div class="mb-4">
                    <label for="job-name" class="form-label">Job Name*</label>
                    <input type="text" class="form-control" id="job-name" name="job-name" maxlength="60" required
                        value = "<?php echo $jname?>">
                </div>
                <div class="mb-4">
                    <label for="employer-name" class="form-label">Employer Name*</label>
                    <input type="text" class="form-control" id="employer-name" name="employer-name" maxlength="60"
                           required value = "<?php echo $ename?>">
                </div>
                <div class="mb-4">
                    <label for="job-url" class="form-label">Job Description URL*</label>
                    <input type="text" class="form-control" id="job-url" name="job-url" maxlength="500" required
                           value = "<?php echo $jurl?>">
                </div>
                <div class="mb-4">
                    <label for="job-description" class="form-label">Job Description</label>
                    <textarea class="form-control" id="job-description" name="job-description"
                              placeholder="Little summary of the role of the job..." maxlength="500"
                              rows="3"><?php echo $jdescription?></textarea>
                </div>
                <div class="mb-4">
                    <label for="app-date" class="form-label">Date of Application*</label>
                    <input type="date" class="form-control" id="app-date" name="app-date" required
                           value = <?php echo $adate?>>
                </div>
                <div class="mb-4">
                    <label for="application-status" class="form-label mb-3">Application Status*</label><br>
                    <select name="application-status" id="application-status">
                        <option value="select">Select an option</option>
                        <option value="need-to-apply"
                            <?php if ($astatus == "need-to-apply") {
                                echo"selected";
                            }?>>Need to apply</option>
                        <option value="applied"
                            <?php if ($astatus == "applied") {
                                echo"selected";
                            }?>>Applied</option>
                        <option value="interviewing"
                            <?php if ($astatus == "interviewing") {
                                echo"selected";
                            }?>>Interviewing</option>
                        <option value="rejected"
                            <?php if ($astatus == "rejected") {
                                echo"selected";
                            }?>>Rejected</option>
                        <option value="accepted"
                            <?php if ($astatus == "accepted") {
                                echo"selected";
                            }?>>Accepted</option>
                        <option value="inactive"
                            <?php if ($astatus == "inactive") {
                                echo"selected";
                            }?>>Inactive/Expired</option>
                    </select>
                    <div id="application-wrong" style="color:red"></div>
                </div>
                <div class="mb-4">
                    <label for="follow-updates" class="form-label">Updates</label>
                    <textarea class="form-control" id="follow-updates" name="follow-updates"
                              placeholder="Who have you spoken with or interviewed with?" maxlength="500"
                              rows="3"><?php echo $fupdates?></textarea>
                </div>

                <div class="mb-4">
                    <label for="followup-date" class="form-label">Follow up date*</label>
                    <input type="date" class="form-control" id="followup-date" name="followup-date" required
                           value = <?php echo $followupdate?>>
                </div>

                <input type="hidden" name="application-id" value="<?php echo $app_id; ?>" />

                <button type="submit" class="submit-btn">Submit</button>
            </form>
        </div>
    </div>
</main>


<?php include 'php/footer.php' ?>
<script src="js/main.js"></script>
<!-- Special Javascript to allow special application things work -->
<script src="js/applicationscript.js"></script>
</body>
</html>