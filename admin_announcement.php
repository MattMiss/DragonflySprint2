<!DOCTYPE html>
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
<body>

<?php
session_start();
$_SESSION['location'] = '';
include 'php/nav_bar.php' ?>
<main>
    <div class="container p-3" id="main-container">
        <h3 class="form-header">Admin Announcement Form</h3>
        <div class="form-container">
            <form method="post" action="php/admin_announcement_submit.php" class="form-body my-3">
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
                    <div class="row">
                        <div class="col-8">
                            <input type="email" class="form-control" id="sent-to" name="sent-to"
                                   placeholder="e.g. example@email.com" required>
                        </div>
                        <div class="col-1 m-auto text-center">
                            Or
                        </div>
                        <div class="col-3 text-end">
                            <button type="button" class='submit-btn' data-bs-toggle='modal' data-bs-target='#selectUserModal' onclick=''>Select A User</button>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="first-name" name="first-name" value="default">
                <input type="hidden" id="last-name" name="last-name" value="default">

                <button id="submit-btn" type="submit" class="submit-btn">Submit</button>
            </form>
        </div>
    </div>
    <div class='modal modal-xl fade' id='selectUserModal' tabindex='-1'>
        <div class='modal-dialog modal-dialog-centered'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h3>Choose A User</h3>
                </div>
                <div class='modal-body text-center'>
                    <table class='dash-table'>
                        <thead>
                        <tr>
                            <th scope='col'>
                                First
                            </th>
                            <th scope='col'>
                                Last
                            </th>
                            <th scope='col'>
                                Status
                            </th>
                            <th scope='col'>
                                Cohort
                            </th>
                            <th scope='col'>
                                Email
                            </th>
                            <th scope='col'>
                                Roles
                            </th>
                        </tr>
                        </thead>
                        <tbody class='table-body'>
                        <?php
                        createUsers();
                        ?>

                        </tbody>
                    </table>
                </div>
                <div class='modal-footer'>
                    <button type='button' class='btn btn-danger m-auto' data-bs-dismiss='modal'>Cancel</button>
                </div>
            </div>
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

<?php
function createUsers(){
    $db_location = '';
    include 'db_picker.php';
    include $db_location;

    $sql = "SELECT * FROM users";
    $result = @mysqli_query($cnxn, $sql);

    while ($row = mysqli_fetch_assoc($result)){
        $id = $row['user_id'];
        $fname = $row['fname'];
        $lname = $row['lname'];
        $status = $row['status'];
        $cohortNum = $row['cohortNum'];
        $email = $row['email'];
        $roles = $row['roles'];
        $user_info = json_encode($row);
        echo "
                <tr onclick='userSelected($user_info)'>
                    <td>$fname</td>
                    <td>$lname</td>
                    <td>$status</td>
                    <td>$cohortNum</td>
                    <td>$email</td>
                    <td>$roles</td>
                </tr>
             ";
    }
}

?>