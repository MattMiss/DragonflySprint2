<html>
<head>
    <meta charset="UTF-8">
    <title>Receipt</title>
    <script src="js/themescript.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="styles.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<nav class="navbar navbar-expand-lg sticky-top py-1 ">
    <div class="container-fluid">
        <img src="images/GRC_Logo-Rich-Black.png" alt="GreenRiver College logo" id="grc-logo">
        <button type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu" class="navbar-toggler"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse mx-1" id="navbar-menu">
            <ul class="navbar-nav nav-underline">
                <li><a href="index.html" class="nav-link">User Dashboard</a></li>
                <li><a href="signup.html" class="nav-link">Sign-up</a></li>
                <li><a href="applicationform.html" class="nav-link">New Application</a></li>
                <li><a href="contactForm.html" class="nav-link">Contact</a></li>
                <li>
                    <ul class="navbar-nav nav-underline">
                        <li><a href="admin_dashboard.html" class="nav-link">Admin Dashboard</a></li>
                        <li><a href="admin_announcement.html" class="nav-link">Admin Announcement</a></li>
                    </ul>
                </li>
                <li class="d-flex justify-content-end" id=  "dark-mode-list-item">
                    <div class="form-check form-switch">
                        <label class="form-check-label" for="dark-mode-switch">Dark Mode</label>
                        <input class="form-check-input" type="checkbox" role="switch" id="dark-mode-switch">
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
<main>
    <div class="container p-3" id="main-container">
        <?php
        if(! empty($_POST)) {
            // removing
            foreach ($_POST as $value) {
                $value = trim($value);

                if (empty($value)) {
                    ?>
                    <div class="content">
                        <h2>Failed to send.</h2>
                    </div>

                    <?php
                    return;
                }
            }

            $title = $_POST['announcement-title'];
            $job = $_POST['job-or-intern'];
            $location = $_POST['location'];
            $employer = $_POST['employer'];
            $addltext = $_POST['additional-text'];
            $url = $_POST['url'];
            $sentto = $_POST['sent-to'];

            // sanitization
            $title = strip_tags(filter_var($title, FILTER_SANITIZE_ADD_SLASHES));
            $job = strip_tags(filter_var($job, FILTER_SANITIZE_ADD_SLASHES));
            $location = strip_tags(filter_var($location, FILTER_SANITIZE_ADD_SLASHES));
            $employer = strip_tags(filter_var($employer, FILTER_SANITIZE_ADD_SLASHES));
            $url = strip_tags(filter_var($url, FILTER_SANITIZE_ADD_SLASHES));
            $sentto = strip_tags(filter_var($sentto, FILTER_SANITIZE_ADD_SLASHES));

            ?>
            <div class="form-receipt-container">
                <div class="content">
                    <h3><?php echo 'Success! Your announcement has been sent.'; ?></h3>
                    <ul class="list-group">
                        <li class="list-group-item">
                            <?php echo "Title: " . $title; ?>
                        </li>
                        <li class="list-group-item">
                            <?php echo "Job Type: " . $job; ?>
                        </li>
                        <li class="list-group-item">
                            <?php echo "Location: " . $location; ?>
                        </li>
                        <li class="list-group-item">
                            <?php echo "Employer: " . $employer; ?>
                        </li>
                        <li class="list-group-item">
                            <?php echo "More Information: " . $addltext; ?>
                        </li>
                        <li class="list-group-item">
                            <?php echo "URL: " . $url; ?>
                        </li>
                        <li class="list-group-item">
                            <?php echo "Sent To: " . $sentto; ?>
                        </li>
                    </ul>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</main>
<footer>
    <div class="container p-3 ">
        <h6>RESOURCES:</h6>
        <ul class="list-unstyled justify-content-center resources-list list-group list-group-horizontal-sm list-group-flush">
            <li class="list-group-item p-0 m-0">
                <a href="https://www.linkedin.com/" target="_blank" class="btn btn-light
                 text-dark btn-sm">
                    <img src="images/In-Blue-Logo.png" alt="5" style="max-height: 25px">LinkedIn
                </a>
            </li>
            <li class="list-group-item p-0 m-0">
                <a href="https://www.indeed.com/" target="_blank" class="btn btn-light
                 text-dark btn-sm">
                    <img src="images/Indeed_Logo_RGB.png" alt="5" style="max-height: 25px">
                </a>
            </li>
            <li class="list-group-item p-0 m-0">
                <a href="https://www.devs.greenrivertech.net/studentResources" target="_blank" class="btn btn-light
                 text-dark btn-sm">
                    <img src="images/sdev_logo.png" alt="5" style="max-height: 25px"> Green River Tech
                </a>
            </li>
            <li class="list-group-item p-0 m-0">
                <a href="https://www.glassdoor.com/index.htm" target="_blank" class="btn btn-light
                 text-dark btn-sm">
                    <img src="images/new-glassdoor-icon-1-300x239.jpg" alt="5" style="max-height: 25px"> Glassdoor
                </a>
            </li>
            <li class="list-group-item p-0 m-0">
                <a href="https://www.levels.fyi/?compare=Amazon,Microsoft,Facebook&track=Software%20Engineer" target="_blank" class="btn btn-light
                 text-dark btn-sm">
                    <img src="images/levelsfyi.png" alt="5" style="max-height: 25px">Levels FYI
                </a>
            </li>
            <li class="list-group-item p-0 m-0">
                <a href="https://www.google.com/search?q=software+development+jobs" target="_blank" class="btn btn-light text-dark btn-sm">
                    More
                </a>
            </li>
        </ul>
    </div>
</footer>
<script src="js/main.js"></script>
</body>
</html>

