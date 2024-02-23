<?php
$location = $_SESSION['location'];
?>

<nav class="navbar navbar-expand-md sticky-top py-1 ">
    <div class="container-fluid">
        <img src="<?php echo $location?>images/GRC_Logo-Rich-Black.png" alt="GreenRiver College logo" id="grc-logo">
        <button type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu" class="navbar-toggler"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse mx-1" id="navbar-menu">
            <ul class="navbar-nav nav-underline">
                <li><a href="<?php echo $location?>index.php" class="nav-link">User Dashboard</a></li>
                <li><a href="<?php echo $location?>signup_form.php" class="nav-link">Sign-up</a></li>
                <li><a href="<?php echo $location?>application_form.php" class="nav-link">New Application</a></li>
                <li><a href="<?php echo $location?>contact_form.php" class="nav-link">Contact</a></li>
                <li class="nav-item dropdown">
                    <button class="btn btn-secondary btn-lg" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa-solid fa-caret-down me-2"></i>
                        Admin
                    </button>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="<?php echo $location?>admin_dashboard.php">Admin Dashboard</a>
                        <a class="dropdown-item" href="<?php echo $location?>admin_announcement.php">Make Announcement</a>
                    </div>
                </li>
<!--                <li>-->
<!--                    <ul class="navbar-nav nav-underline">-->
<!--                        <li><a href="--><?php ////echo $location?><!--admin_dashboard.php" class="nav-link">Admin Dashboard</a></li>-->
<!--                        <li class="nav-item dropdown">-->
<!--                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->
<!--                                Admin-->
<!--                            </a>-->
<!--                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">-->
<!--                                <a class="dropdown-item" href="--><?php //echo $location?><!--admin_dashboard.php">Admin Dashboard</a>-->
<!--                                <a class="dropdown-item" href="--><?php //echo $location?><!--admin_announcement.php">Make Announcement</a>-->
<!--                            </div>-->
<!--                        </li>-->
<!--                       <li><a href="--><?php ////echo $location?><!--admin_announcement.php" class="nav-link">Admin Announcement</a></li>-->
<!--                    </ul>-->
<!--                </li>-->
                <li class="d-flex justify-content-end" id="dark-mode-list-item">
                    <div class="dark-switch-outer">
                        <input type="checkbox" id="dark-mode-switch">
                        <label for="dark-mode-switch">
                            <i class="fas fa-sun"></i>
                            <i class="fas fa-moon"></i>
                        </label>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>