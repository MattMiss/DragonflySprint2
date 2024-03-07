<?php
session_start();
$_SESSION['location'] = '';
$location = $_SESSION['location'];

//$indexLocation =  'http://localhost:63342/Sprint4/index.php'; // local (may need to change port number)
$indexLocation =  'https://dragonfly.greenriverdev.com/sprint5/index.php'; //cpanel

global $db_location;
global $cnxn;

global $db_location;
//include 'php/nav_bar.php';
include 'db_picker.php';
include $db_location;


// get user email, id and password from db
$email = "";
$pass = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && ! empty($_POST)) {
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $sqlUserPass = "SELECT `user_id`, `email`, password, permission, fname  FROM users WHERE `email`='$email' AND `password`='$pass' AND `users`.is_deleted = 0 ";

    $result = mysqli_query($cnxn, $sqlUserPass);

    if(mysqli_num_rows($result)===1) {
        $row = mysqli_fetch_assoc($result);
        if($row['email']===$email && $row['password']===$pass){
//            echo "Logged in!";
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['permission'] = $row['permission'];
            $_SESSION['fname'] = $row['fname'];
            header("Location:$indexLocation");
            exit();
        }else{

        }



    } else {
        echo "
            <!DOCTYPE html>
            <html lang='en'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title>Login Page</title>
                <!-- Load theme from localstorage -->
                <script src='js/themescript.js'></script>
                <!-- Latest compiled and minified CSS -->
                <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css' rel='stylesheet'>
                <!-- Font awesome -->
                <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css'>
                <link rel='stylesheet' href='styles/styles.css'/>
                <!-- Latest compiled JavaScript -->
                <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js'></script>
            </head>
            <body>
                <nav class='navbar navbar-expand-md sticky-top py-1 '>
                    <div class='container-fluid'>
                        <img src='$location images/GRC_Logo-Rich-Black.png' alt='GreenRiver College logo' id='grc-logo'>
                        <button type='button' data-bs-toggle='collapse' data-bs-target='#navbar-menu' class='navbar-toggler'><span class='navbar-toggler-icon'></span></button>
                        <div class='collapse navbar-collapse mx-1' id='navbar-menu'>
                            <ul class='navbar-nav nav-underline'>
                                <!-- <li><a href='$location index.php' class='nav-link'>User Dashboard</a></li> -->
                                <li><a href='$location signup_form.php' class='nav-link'>Sign-up</a></li>
                                <!-- <li><a href='$location application_form.php' class='nav-link'>New Application</a></li> -->
                                <li><a href='$location contact_form.php' class='nav-link'>Contact</a></li>
                                <li class='d-flex justify-content-end' id='dark-mode-list-item'>
                                    <div class='dark-switch-outer'>
                                        <input type='checkbox' id='dark-mode-switch'>
                                        <label for='dark-mode-switch'>
                                            <i class='fas fa-sun'></i>
                                            <i class='fas fa-moon'></i>
                                        </label>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            
            <main>
                <div class='container p-3' id='main-container'>
                    <h3 class='form-header'>Login</h3>
                    <div class='form-container'>
                        <div class='form-body'>
                    <form id='login-form' class='p-5' method='POST' action='#'>
                        <p style='color: red'>Incorrect email or password, please try again.</p>
                        <div class='mb-4'>
                            <label for='input-email' class='form-label'>Email*</label>
                            <input type='email' class='form-control' id='input-email' name='email' placeholder='e.g. example@email.com' required>
                        </div>
                        
                        <div class='mb-4'>
                            <label for='input-password' class='form-label'>Password*</label>
                            <input type='password' class='form-control' id='input-password' name='password' minlength='8' maxlength='16' required>
                        </div>
                        
                        <button type='submit' class='submit-btn'>Submit</button>
                    </form>
                </div>
            </main>
        ";
    }
} else {
    echo "
        <!DOCTYPE html>
            <html lang='en'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title>Login Page</title>
                <!-- Load theme from localstorage -->
                <script src='js/themescript.js'></script>
                <!-- Latest compiled and minified CSS -->
                <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css' rel='stylesheet'>
                <!-- Font awesome -->
                <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css'>
                <link rel='stylesheet' href='styles/styles.css'/>
                <!-- Latest compiled JavaScript -->
                <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js'></script>
            </head>
        <body>
            <nav class='navbar navbar-expand-md sticky-top py-1 '>
                <div class='container-fluid'>
                    <img src='$location images/GRC_Logo-Rich-Black.png' alt='GreenRiver College logo' id='grc-logo'>
                    <button type='button' data-bs-toggle='collapse' data-bs-target='#navbar-menu' class='navbar-toggler'><span class='navbar-toggler-icon'></span></button>
                    <div class='collapse navbar-collapse mx-1' id='navbar-menu'>
                        <ul class='navbar-nav nav-underline'>
                            <!-- <li><a href='$location index.php' class='nav-link'>User Dashboard</a></li> -->
                            <li><a href='$location signup_form.php' class='nav-link'>Sign-up</a></li>
                            <!-- <li><a href='$location application_form.php' class='nav-link'>New Application</a></li> -->
                            <li><a href='$location contact_form.php' class='nav-link'>Contact</a></li>
                            <li class='d-flex justify-content-end' id='dark-mode-list-item'>
                                <div class='dark-switch-outer'>
                                    <input type='checkbox' id='dark-mode-switch'>
                                    <label for='dark-mode-switch'>
                                        <i class='fas fa-sun'></i>
                                        <i class='fas fa-moon'></i>
                                    </label>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <main>
                <div class='container p-3' id='main-container'>
                    <h3 class='form-header'>Login</h3>
                    <div class='form-container'>
                        <div class='form-body'>
                    <form id='login-form' class='p-5' method='POST' action='#'>
                      
                        <div class='mb-4'>
                            <label for='input-email' class='form-label'>Email*</label>
                            <input type='email' class='form-control' id='input-email' name='email' placeholder='e.g. example@email.com' required>
                        </div>
                        
                        <div class='mb-4'>
                            <label for='input-password' class='form-label'>Password*</label>
                            <input type='password' class='form-control' id='input-password' name='password' minlength='8' maxlength='16' required>
                        </div>
                        
                        <button type='submit' class='submit-btn'>Submit</button>
                    </form>
                </div>
            </main>
        ";
}

echo"
            </body>
        </html>
    ";
?>

<?php include 'php/footer.php'?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="js/contactscript.js"></script>
<script src="js/main.js"></script>
<script src="js/dashboard.js"></script>
</body>
</html>