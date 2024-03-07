<?php
$location = $_SESSION['location'];
$permission = 0;
$firstName = '';

if (isset($_SESSION['permission'])){
    $permission = $_SESSION['permission'];
}
if (isset($_SESSION['fname'])){
    $firstName = $_SESSION['fname'];
}
?>

<nav class="navbar navbar-expand-md sticky-top py-1 ">
    <div class="container-fluid">
        <img src="<?php echo $location?>images/GRC_Logo-Rich-Black.png" alt="GreenRiver College logo" id="grc-logo">
        <button type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu" class="navbar-toggler"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse mx-1" id="navbar-menu">
            <ul class="navbar-nav nav-underline">
                <li><a href="<?php echo $location?>index.php" class="nav-link">User Dashboard</a></li>
                <!--<li><a href="<?php echo $location?>signup_form.php" class="nav-link">Sign-up</a></li>-->
                <li><a href="<?php echo $location?>application_form.php" class="nav-link">New Application</a></li>
                <li><a href="<?php echo $location?>contact_form.php" class="nav-link">Contact</a></li>
                <?php checkPermission() ?>
                <li class="d-flex justify-content-end" id="dark-mode-list-item">
                    <div class="dark-switch-outer">
                        <input type="checkbox" id="dark-mode-switch">
                        <label for="dark-mode-switch">
                            <i class="fas fa-sun"></i>
                            <i class="fas fa-moon"></i>
                        </label>
                    </div>
                </li>
                <li class="d-flex justify-content-end">
                    <div class="">
                        <button class='app-button-inner btn btn-sm btn-update' type='button' data-bs-toggle='modal' data-bs-target='#logout-modal'>LogOut</button>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <?php showWelcome() ?>
</nav>

    <div class='modal fade' id='logout-modal' tabindex='-1' role='dialog' aria-labelledby='make-admin-message' aria-hidden='true'>
        <div class='modal-dialog modal-dialog-centered' role='document'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h4 class='modal-title' id='delete-warning'>Log Out?</h4>
                </div>
                <div class='modal-body'>
                    <p>Would you like to log out?</p>
                </div>
                <div class='modal-footer'>
                    <button type='button' class='modal-close-secondary' data-bs-dismiss='modal'>Cancel</button>
                    <button type='submit' class='modal-delete'><a href='index.php?logout=true'>Logout</a></button>

                </div>
            </div>
        </div>
    </div>

<?php
function checkPermission(){
    global $permission;
    global $location;

    if ($permission === '1'){
        echo "<li class='nav-item dropdown'>
                    <button class='btn btn-secondary btn-lg' id='navbarDropdown' role='button' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                        <i class='fa-solid fa-caret-down me-2'></i>
                        Admin
                    </button>
                    <div class='dropdown-menu' aria-labelledby='navbarDropdown'>
                        <a class='dropdown-item' href='{$location}admin_dashboard.php'>Admin Dashboard</a>
                        <a class='dropdown-item' href='{$location}admin_announcement.php'>Make Announcement</a>
                    </div>
                </li>";
    }
}

function showWelcome(){
    global $firstName;
    echo "<div class='welcome-outer text-end' >
              Welcome, {$firstName}!
          </div>";
}
?>