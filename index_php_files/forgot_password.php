<?php
include '../config/signup_classes.php';
// session_start();
$data = file_get_contents('php://input');

if ($data){
    $check_db_for_email = new forgot_password($dsn, $user, $password, $data);
}else if (isset($_GET["otp"]) && isset($_GET["enter_key"])){

    $enter = new check_enter_key($dsn, $user, $password, $_GET["otp"], $_GET["enter_key"]);
    if ($enter->found == 1){
        $_SESSION["enter_key"] = $_GET["enter_key"];
        $_SESSION["otp"] = $_GET["otp"];
     
        ?>
            <!DOCTYPE html>
            <html>
            <head>
            <link rel='shortcut icon' type='image/x-icon' href='../media/resources/favicon.png' />  
            <link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css'>
            <link rel='stylesheet' href='../inc_css/forgot_password.css'>
            
            </head>
            <body>
                <div class='enter_otp'>
                    <p class='title_p'>Enter New Password</p>
                    <input id='sin_password' class='standerd_input_signup' type='password' name='fname' oninput='sin_password()'  placeholder='Password'><br />            
                    <p id='sin_pass' class="label label-danger"></p>
                    <input id='sin_pass_match' class='standerd_input_signup' type='password' name='fname' oninput='sin_match()'  placeholder='Re-enter Password'><br />
                    <p id='sin_match' class="label label-danger"></p>
                    <button id='conform' class='btn btn-primary' onclick='confirm_password()'>Save</button>    
                </div>
            </body>
            <script src='../inc_js/forgot_password.js'></script>
            </html>";
        <?php    
    }else{
        header('location:../index.php');
    }
}else {header('location:../index.php');}