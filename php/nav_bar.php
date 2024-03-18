<?php
global $location;
global $isLogin;

$uID = -1;
$permission = 0;
$firstName = '';


if (isset($_SESSION['user_id'])){
    $uID = $_SESSION['user_id'];

    // Log user out if idle time or logged in time is past max
    include 'php/roles/timeout_check.php';
}

if (isset($_SESSION['permission'])){
    $permission = $_SESSION['permission'];
}
if (isset($_SESSION['fname'])){
    $firstName = $_SESSION['fname'];
}

$theme = 'light';
if (isset($_COOKIE['theme'])){
    $theme = $_COOKIE['theme'];
}

?>

<nav class="navbar navbar-expand-md sticky-top py-1 ">
    <div class="container-fluid">
        <img src="<?php echo $location?>images/GRC_Logo-Rich-Black.png" alt="GreenRiver College logo" id="grc-logo" class="<?php if($theme === 'dark'){echo 'hidden';}?>">
        <img src="<?php echo $location?>images/GRC_Logo_White.png" alt="GreenRiver College logo" id="grc-logo-white" class="<?php if($theme === 'light'){echo 'hidden';}?>">
        <button type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu" class="navbar-toggler"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse mx-1" id="navbar-menu">
            <ul class="navbar-nav nav-underline">
                <?php if (!isset($_SESSION['user_id'])) showAnonNav() ?>
                <?php if ($permission === '0') showUserNav(); ?>
                <?php if ($permission === '1') showAdminNav(); ?>

            </ul>
        </div>
    </div>
    <div class='welcome-outer text-end d-flex justify-content-end' >
        <?php showWelcome(); ?>
    </div>
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
                <button type='button' class='btn btn-danger modal-close-secondary' data-bs-dismiss='modal'>Cancel</button>
                <button type='submit' class='modal-delete'><a href='?logout=true'>Logout</a></button>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
    let uID = <?php echo $uID; ?>
</script>
<script src="../js/navbar.js"></script>

<?php
function showAdminNav(){
    global $location;

    echo "<li><a href='{$location}admin_dashboard.php' class='nav-link'>Admin Dashboard</a></li>
            <li><a href='{$location}admin_announcement.php' class='nav-link'>Make Announcement</a></li>";

}

function showUserNav(){
    global $location;

    echo "<li><a href='{$location}index.php' class='nav-link'>User Dashboard</a></li>
            <li><a href='{$location}application_form.php' class='nav-link'>New Application</a></li>
            <li><a href='{$location}contact_form.php' class='nav-link'>Contact</a></li>";
}

function showAnonNav(){
    global $location;

    echo "
          <li><a href='$location signup_form.php' class='nav-link'>Sign-up</a></li>
          <li><a href='$location contact_form.php' class='nav-link'>Contact</a></li>";
}

function showWelcome(){
    global $firstName;
    global $location;
    $loggedIn = isset($_SESSION['user_id']);
    $uID = -1;
    if (isset($_SESSION['user_id'])){
        $uID = $_SESSION['user_id'];
    }

    // Set welcome message to user first name if logged in
    $welcomeMsg = $loggedIn ? 'Welcome, ' . $firstName . '!' : 'User';

    $userEditLoc = $location . 'user_edit.php';

    $loggedInDropdownItems = "<form method='post' action='$userEditLoc'>  
                                  <input type='hidden' name='user_id' value=$uID>
                                  <button class='btn-log-in-out'>
                                      <i class='fa-solid fa-gear pe-1'></i>Account
                                  </button>
                              </form>
                              <button class='btn-log-in-out pb-1' type='button' data-bs-toggle='modal' data-bs-target='#logout-modal'>
                                  <i class='fa-solid fa-arrow-right-from-bracket pe-1'></i>Logout
                              </button>";

    $loggedOutDropdownItems = "<button class='btn-log-in-out m-auto pb-1' type='button' disabled>
                                   <i class='fa-solid fa-gear pe-1'></i>Account
                               </button>
                               <button class='btn-log-in-out m-auto pb-1' type='button'>
                                   <i class='fa-solid fa-arrow-right-from-bracket pe-1'></i><a href='$location login.php'>Login</a>
                               </button>";
    $dropdownItems = $loggedIn ? $loggedInDropdownItems : $loggedOutDropdownItems;

    $dateFormatListItem = $loggedIn ? "<li class=''>
                                <div class='d-flex justify-content-between date-list pe-3'>
                                    <span class='user-menu-label ps-3'>DATE FORMAT</span>
                                    <select class='form-select' id='date-format-select' aria-label='Date Format Select'>
                                        <option selected value='mm-dd-yy'>MM-DD-YY</option>
                                        <option value='dd-mm-yy'>DD-MM-YY</option>
                                        <option value='yy-mm-dd'>YY-MM-DD</option>
                                    </select>
                                </div>       
                           </li>" : "";

    echo "
        <div class='dropdown'>
            <button class='btn dropdown-toggle' id='user-dropdown' type='button' data-bs-toggle='dropdown' data-bs-auto-close='outside' aria-expanded='false'>
                {$welcomeMsg}
            </button>
            
             <ul class='dropdown-menu text-end'>
                <li>
                    <h6 class='text-center'>Account</h6>
                </li>
                <li class='pb-4'>
                    <div class='dropdown-item d-flex justify-content-around'>
                        {$dropdownItems}
                    </div>       
                </li>
                <li>
                    <h6 class='text-center'>Preferences</h6>
                </li>
                <li class='pb-2'>
                    <div class='d-flex align-items-center pe-1'>
                        <span class='user-menu-label ps-3'>THEME</span>
                        <div class='dropdown-item dark-switch-outer text-center d-flex flex-row' id='dark-mode-list-item'>
                            <input type='checkbox' id='dark-mode-switch'>
                            <label for='dark-mode-switch'>
                                <i class='fas fa-sun'></i>
                                <i class='fas fa-moon'></i>
                            </label>
                        </div>
                    </div>       
                </li>
                {$dateFormatListItem}
             </ul>
        </div>
    ";
}

function showLoginButton(){
    global $location;
    echo "
        <button class='btn-log-in-out m-auto pb-1' type='button'><a href='$location login.php'>Login</a></button>      
    ";
}

?>