<?php
session_start();
$_SESSION['location'] = '';
$location = $_SESSION['location'];

$indexLocation =  'http://localhost:63342/Sprint4/index.php'; // local (may need to change port number)
//$indexLocation =  'https://dragonfly.greenriverdev.com/sprint5/index.php'; //cpanel
$adminLocation =  'http://localhost:63342/Sprint4/admin_dashboard.php';
//$adminLocation =  'https://dragonfly.greenriverdev.com/sprint5/admin_dashboard.php'; //cpanel

if (isset($_SESSION['user_id'])){
    // Redirect Already Logged In Users to User Dashboard
    include 'php/roles/user_kick.php';
    // Redirect Already Logged In Admins to Admin Dashboard
    include 'php/roles/admin_kick.php';
}

global $cnxn;
global $db_location;

include 'db_picker.php';
include $db_location;

// get user email, id and password from db
$email = "";
$pass = "";
$failedMsg = "";
$isLogin = true;

if ($_SERVER["REQUEST_METHOD"] == "POST" && ! empty($_POST)) {
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $sqlUserPass = "SELECT `user_id`, `email`, password, permission, fname  FROM users WHERE `email`='$email' AND `password`='$pass' AND `users`.is_deleted = 0 ";

    $result = mysqli_query($cnxn, $sqlUserPass);

    if(mysqli_num_rows($result)===1) {
        $row = mysqli_fetch_assoc($result);
        if($row['email']===$email && $row['password']===$pass){
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['permission'] = $row['permission'];
            $_SESSION['fname'] = $row['fname'];
            if ($row['permission'] === '0'){
                // Redirect Users to User Dashboard
                header("Location:$indexLocation");
            }else{
                // Redirect Admins to Admin Dashboard
                header("Location:$adminLocation");
            }
            exit();
        }else{
            $failedMsg = "Incorrect email or password, please try again.";
        }
    }else{
        $failedMsg = "Incorrect email or password, please try again.";
    }
}


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
    <body>";

include 'php/nav_bar.php';

echo "<main>
        <div class='container p-3' id='main-container'>
            <h3 class='form-header'>Login</h3>
            <div class='form-container'>
                <div class='form-body'>
            <form id='login-form' class='p-5' method='POST' action='#'>
                <p style='color: red'>{$failedMsg}</p>
                <div class='mb-4'>
                    <label for='input-email' class='form-label'>Email*</label>
                    <input type='email' class='form-control' id='input-email' name='email' placeholder='e.g. example@email.com' required>
                </div>
                
                <div class='mb-4'>
                    <label for='input-password' class='form-label'>Password*</label>
                    <input type='password' class='form-control' id='input-password' name='password' minlength='8' maxlength='16' required>
                </div>
                <div class='d-flex justify-content-end gap-2'>
                    <span>Don't have an account? </span>
                    <a href='signup_form.php'>Sign Up!</a>
                </div>
                <button type='submit' class='submit-btn pt-1'>Login</button>
            </form>
        </div>
    </main>";
?>

<?php include 'php/footer.php'?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</body>
</html>