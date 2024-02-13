<?php
session_start();
$_SESSION['header-title'] = 'Change Title Here';
include 'header.php'?>
<main>
    <div class="container p-3" id="main-container">
        <div class="row dashboard-top">
            <div class="app-list col-md-9">
                <h3>Recent Applications</h3>
                <table class="dash-table">
                    <thead>
                    <tr>
                        <th scope="col" class="w-20">Date</th>
                        <th scope="col">Title</th>
                        <th scope="col" class="w-20">Status</th>
                        <th scope="col" class="w-btn"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="app-list-item">
                        <td>01/22/2024</td>
                        <td>Costco</td>
                        <td class="status status-applied"><i class="fa-solid fa-circle"></i><span>Applied</span></td>
                        <td class="app-button-outer">
                            <button class="app-button-inner btn btn-sm btn-update"><i class="fa-solid fa-pen"></i></button>
                            <button class="app-button-inner btn btn-sm btn-delete" data-bs-toggle="modal" data-bs-target="#confirmModal"><i class="fa-solid fa-trash"></i></button>
                        </td>
                    </tr>
                    <tr class="app-list-item">
                        <td>01/19/2024</td>
                        <td>REI</td>
                        <td class="status status-accepted"><i class="fa-solid fa-circle"></i><span>Accepted</span></td>
                        <td class="app-button-outer">
                            <button class="app-button-inner btn btn-sm btn-update"><i class="fa-solid fa-pen"></i></button>
                            <button class="app-button-inner btn btn-sm btn-delete" data-bs-toggle="modal" data-bs-target="#confirmModal"><i class="fa-solid fa-trash"></i></button>
                        </td>
                    </tr>
                    <tr class="app-list-item">
                        <td>01/15/2024</td>
                        <td>Starbucks</td>
                        <td class="status status-interviewing"><i class="fa-solid fa-circle"></i><span>Interviewing</span></td>
                        <td class="app-button-outer">
                            <button class="app-button-inner btn btn-sm btn-update"><i class="fa-solid fa-pen"></i></button>
                            <button class="app-button-inner btn btn-sm btn-delete" data-bs-toggle="modal" data-bs-target="#confirmModal"><i class="fa-solid fa-trash"></i></button>
                        </td>
                    </tr>
                    <tr class="app-list-item">
                        <td>01/10/2024</td>
                        <td>Microsoft</td>
                        <td class="status status-rejected"><i class="fa-solid fa-circle"></i><span>Rejected</span></td>
                        <td class="app-button-outer">
                            <button class="app-button-inner btn btn-sm btn-update"><i class="fa-solid fa-pen"></i></button>
                            <button class="app-button-inner btn btn-sm btn-delete" data-bs-toggle="modal" data-bs-target="#confirmModal"><i class="fa-solid fa-trash"></i></button>
                        </td>
                    </tr>
                    <tr class="app-list-item">
                        <td >01/02/2024</td>
                        <td>T-Mobile</td>
                        <td class="status status-need-apply"><i class="fa-solid fa-circle"></i><span>Need to Apply</span></td>
                        <td class="app-button-outer">
                            <button class="app-button-inner btn btn-sm btn-update"><i class="fa-solid fa-pen"></i></button>
                            <button class="app-button-inner btn btn-sm btn-delete" data-bs-toggle="modal" data-bs-target="#confirmModal"><i class="fa-solid fa-trash"></i></button>
                        </td>
                    </tr>
                    <tr class="app-list-item">
                        <td >12/01/2023</td>
                        <td>Netflix</td>
                        <td class="status status-inactive"><i class="fa-solid fa-circle"></i><span>Inactive</span></td>
                        <td class="app-button-outer">
                            <button class="app-button-inner btn btn-sm btn-update"><i class="fa-solid fa-pen"></i></button>
                            <button class="app-button-inner btn btn-sm btn-delete" onclick="deleteAppBtnClicked()" data-bs-toggle="modal" data-bs-target="#confirmModal"><i class="fa-solid fa-trash"></i></button>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <p class="title mx-auto" style="display: block; width:100px; color: green">More</p>

            </div>
            <div class="reminders col ">
                <h3>Reminders</h3>
                <div>
                    <h6>Follow Up</h6>
                    <hr>
                    <div class="reminder">
                        <i class="fa-regular fa-comment"></i>
                        <a href="#">Follow up with <span>Costco</span></a>
                        <p>Applied on: <span>1/22/24</span></p>
                    </div>
                    <div class="reminder">
                        <i class="fa-regular fa-comment"></i>
                        <a href="#">Follow up with <span>Meta</span></a>
                        <p>Applied on: <span>12/22/23</span></p>
                    </div>
                </div>
                <div style="padding-top: 20px;">
                    <h6>Incomplete Apps</h6>
                    <hr>
                    <div class="incomplete-app">
                        <i class="fa-solid fa-pen"></i>
                        <a href="#">Incomplete applications <span>(3)</span></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row py-3">
            <div class="col-9 d-flex justify-content-center" id="new-app-container">
                <button class="submit-btn">New Application</button>
            </div>
            <div class="col-3 d-flex justify-content-center" id="update-account-container">
                <button id="update-acc-btn" class="submit-btn"><i class="fa-solid fa-gear px-1"></i>Update Account</button>
            </div>
        </div>
        <div class="row welcome-info">
            <hr>
            <p>Welcome to the Green River College Software Development Application Tracking Tool (ATT). The purpose of this tool is to provide a centralized place to track your job/internship applications that can be helpful in your application journey! </p>
            <hr>
        </div>
        <div class="row text-wrap">
            <div class="software-dev-img col-3">
                <img src="images/it-software-dev.jpg" alt="5" class="img-fluid col-3" style="width: 500px">
            </div>

            <div class="about-program col-9">
                <h5>About Our Program</h5>
                <p>Prepare for an exciting career in tech with a Bachelor of Applied Science in Software Development. Affordable tuition, instructors who care, access to tech industry mentors, and project-based learning make our applied bachelor’s program a popular destination for computing majors throughout the Seattle-Tacoma region. This degree prepares graduates for high-demand jobs such as software developer, web developer, software developer in test, and quality assurance (QA) analyst. Learn more at <a class="link" href="https://www.greenriver.edu/students/academics/degrees-programs/bachelor-of-applied-science/bachelors-in-software-development/">GreenRiver.edu</a></p>
            </div>
        </div>
    </div>
    <div class="modal fade" id="confirmModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    Are you sure you want to delete?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">No</button>
                    <button type="button" class="btn btn-success">Yes</button>
                </div>
            </div>
        </div>
    </div>
</main>


<?php include 'footer.php' ?>
<script src="js/contactscript.js"></script>
</body>
</html>