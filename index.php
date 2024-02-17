<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard Homepage</title>
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

include 'php/nav_bar.php';
include "/home/dragonfl/db.php";

$sql = "SELECT * FROM applications";
$result = @mysqli_query($cnxn, $sql);

echo "

<main style='position: relative'>
<!--    <div id='alertPlaceholder' style='position: absolute; left: 50%; transform: translate(-50%, 0)'></div> -->
    <div class='container p-3' id='main-container'>
        <div class='row dashboard-top'>
            <div class='app-list col-md-9'>
                <h3>Recent Applications</h3>
                <div class='row'>
                    <div class='col-md-4 pt-2'>
                        <div class='input-group input-group-sm'>
                            <span class='input-group-text'>Start Date</span>
                            <input type='date' class='form-control' id='app-start-date' name='search-start-date'>
                        </div>
                    </div>
                    <div class='col-md-4 pt-2'>
                        <div class='input-group input-group-sm'>
                            <span class='input-group-text'>End Date</span>
                            <input type='date' class='form-control' id='app-end-date' name='search-end-date'>
                        </div>
                    </div>
                    <div class='col-md-4 text-end pt-2'>
                        <div class='input-group input-group-sm'>
                            <span class='input-group-text'>Status</span>
                            <select class='form-select' id='app-status-select'>
                                <option selected>Any</option>
                                <option value='accepted'>Accepted</option>
                                <option value='accepted'>Applied</option>
                                <option value='accepted'>Inactive</option>
                                <option value='accepted'>Interviewing</option>
                                <option value='accepted'>Need-to-apply</option>
                                <option value='accepted'>Rejected</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class='row'>
                    <div class='col pt-2'>
                        <div class='input-group mb-3'>
                            <span class='input-group-text' id='basic-addon1'>
                                <i class='fa-solid fa-magnifying-glass'></i>
                            </span>
                            <input type='text' class='form-control' placeholder='Search' aria-label='Search' aria-describedby='basic-addon1'>
                        </div>
                    </div>
                </div>
                <table class='dash-table'>
                    <thead>
                    <tr>
                        <th scope='col' class='w-20'>
                            <div class='row'>
                                <div class='col-auto pe-0 m-auto'>
                                    Date
                                </div>
                                <div class='col ps-2'>
                                    <div class='order-icons'>
                                        <i class='fa-solid fa-caret-up'></i>
                                        <i class='fa-solid fa-caret-down'></i>
                                    </div>
                                </div>
                            </div>
                        </th>
                        <th scope='col'>
                            <div class='row'>
                                <div class='col-auto pe-0 m-auto'>
                                    Job Title
                                </div>
                                <div class='col ps-2'>
                                    <div class='order-icons'>
                                        <i class='fa-solid fa-caret-up'></i>
                                        <i class='fa-solid fa-caret-down'></i>
                                    </div>
                                </div>
                            </div>
                        </th>
                        <th scope='col'>
                            <div class='row'>
                                <div class='col pe-0 m-auto'>
                                    Employer
                                </div>
                                <div class='col ps-2'>
                                    <div class='order-icons'>
                                        <i class='fa-solid fa-caret-up'></i>
                                        <i class='fa-solid fa-caret-down'></i>
                                    </div>
                                </div>
                            </div>
                        </th>
                        <th scope='col' class='w-20'>
                            <div class='row'>
                                <div class='col-auto pe-0 m-auto'>
                                    Status
                                </div>
                                <div class='col ps-2'>
                                    <div class='order-icons'>
                                        <i class='fa-solid fa-caret-up'></i>
                                        <i class='fa-solid fa-caret-down'></i>
                                    </div>
                                </div>
                            </div>
                        </th>
                        <th scope='col' class='w-btn'></th>
                    </tr>
                    </thead>
                    <tbody class='table-body'>
                    <!--
                    <tr class='app-list-item'>
                        <td>01/22/2024</td>
                        <td>Costco</td>
                        <td class='status status-applied'><i class='fa-solid fa-circle'></i><span>Applied</span></td>
                        <td class='app-button-outer'>
                            <button class='app-button-inner btn btn-sm btn-update'><i class='fa-solid fa-pen'></i></button>
                            <button class='app-button-inner btn btn-sm btn-delete' data-bs-toggle='modal' data-bs-target='#confirmModal'><i class='fa-solid fa-trash'></i></button>
                        </td>
                    </tr>
                    -->
                    ";

createApp($result);

echo "
                    </tbody>
                </table>
                <div class='table-page-btns'>
                    <button type='button' class='btn'><i class='fa-solid fa-angle-left'></i></button>
                    <button type='button' class='btn'>1</button>
                    <button type='button' class='btn'><i class='fa-solid fa-angle-right'></i></button>
                </div>
            </div>
            <div class='reminders col '>
                <h3>Reminders</h3>
                <div>
                    <h6>Follow Up</h6>
                    <hr>
                    <div class='reminder'>
                        <i class='fa-regular fa-comment'></i>
                        <a href='#'>Follow up with <span>Costco</span></a>
                        <p>Applied on: <span>1/22/24</span></p>
                    </div>
                    <div class='reminder'>
                        <i class='fa-regular fa-comment'></i>
                        <a href='#'>Follow up with <span>Meta</span></a>
                        <p>Applied on: <span>12/22/23</span></p>
                    </div>
                </div>
                <div style='padding-top: 20px;'>
                    <h6>Incomplete Apps</h6>
                    <hr>
                    <div class='incomplete-app'>
                        <i class='fa-solid fa-pen'></i>
                        <a href='#'>Incomplete applications <span>(3)</span></a>
                    </div>
                </div>
            </div>
        </div>
        <div class='row py-3'>
            <div class='col-9 d-flex justify-content-center' id='new-app-container'>
                <a class='submit-btn' href='application_form.php'>New Application</a>
            </div>
            <div class='col-3 d-flex justify-content-center' id='update-account-container'>
                <button id='update-acc-btn' class='submit-btn'><i class='fa-solid fa-gear px-1'></i>Update Account</button>
            </div>
        </div>
        <div class='row welcome-info'>
            <hr>
            <p>Welcome to the Green River College Software Development Application Tracking Tool (ATT). The purpose of this tool is to provide a centralized place to track your job/internship applications that can be helpful in your application journey! </p>
            <hr>
        </div>
        <div class='row text-wrap'>
            <div class='software-dev-img col-3'>
                <img src='images/it-software-dev.jpg' alt='5' class='img-fluid col-3' style='width: 500px'>
            </div>

            <div class='about-program col-9'>
                <h5>About Our Program</h5>
                <p>Prepare for an exciting career in tech with a Bachelor of Applied Science in Software Development. Affordable tuition, instructors who care, access to tech industry mentors, and project-based learning make our applied bachelor’s program a popular destination for computing majors throughout the Seattle-Tacoma region. This degree prepares graduates for high-demand jobs such as software developer, web developer, software developer in test, and quality assurance (QA) analyst. Learn more at <a class='link' href='https://www.greenriver.edu/students/academics/degrees-programs/bachelor-of-applied-science/bachelors-in-software-development/'>GreenRiver.edu</a></p>
            </div>
        </div>
    </div>
    <div class='modal fade' id='confirmModal' tabindex='-1'>
        <div class='modal-dialog modal-dialog-centered'>
            <div class='modal-content'>
                <div class='modal-body text-center'>
                    <span id='modalText'>Are you sure you want to delete?</span>
                </div>
                <div class='modal-footer'>
                    <button type='button' class='btn btn-danger' data-bs-dismiss='modal'>No</button>
                    <button type='button' class='btn btn-success' data-bs-dismiss='modal' id='deleteAppBtn'>Yes</button>
                </div>
            </div>
        </div>
    </div>
</main>
";

include 'php/footer.php'?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="js/contactscript.js"></script>
<script src="js/main.js?time=<?php echo mktime(); ?>"></script>
<script src="js/dashboard.js?time=<?php echo mktime(); ?>"></script>
</body>
</html>

<?php

function createApp($info) {
    while ($row = mysqli_fetch_assoc($info)) {
        $id = $row["application_id"];
        $jname = $row["jname"];
        $ename = $row["ename"];
        $jurl = $row["jurl"];
        $jdescription = $row["jdescription"];
        $adate = $row["adate"];
        $astatus = $row["astatus"];
        $fupdates = $row["fupdates"];
        $followupdate = $row["followupdate"];
        $app_info = json_encode($row);

        echo "
            <tr class='app-list-item' id='app-$id'>
                <td>$adate</td>
                <td>$jname</td>
                <td>$ename</td>
                <td class='status status-$astatus'><i class='fa-solid fa-circle'></i><span style='text-transform: capitalize'>$astatus</span></td>
                <td class='app-button-outer'>
                    <form method='post' action='application_edit.php'>
                        <input type='hidden' name='application-id' value='$id'/>
                        <button type='submit' class='app-button-inner btn btn-sm btn-update'><i class='fa-solid fa-pen'></i></button>
                     </form>
                    <button class='app-button-inner btn btn-sm btn-delete' data-bs-toggle='modal' data-bs-target='#confirmModal' onclick='deleteAppBtnClicked($app_info)'><i class='fa-solid fa-trash'></i></button>
                </td>
            </tr>
        ";
    };
}


?>