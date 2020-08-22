<?php
session_start();

if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == "true"){
    header('location:pages/main_page.php');
}
?>
<html>
<head>
    <link rel="shortcut icon" type="image/x-icon" href="media/resources/favicon.png" />  
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="inc_css/main.css">
</head>
<body class="body_color">
    <?php require_once "pages/header.php"; ?>
<div class="container">

    <!-- sign in form -->
    <div id="logindiv">
        <div class="form-group col-xs-5" >
            <input class="form-input form-control" class="standerd_input_login" id="username_in" type="text" name="username" onkeydown = "if (event.keyCode == 13)
                            document.getElementById('login_button').click()" oninput="username_check()" placeholder="Username">
        </div>
        <div class="form-group col-xs-5">
            <input class="form-input form-control" class="standerd_input_login" id="password_in" type="password" name="password" oninput="password_chack()" onkeydown = "if (event.keyCode == 13)
                            document.getElementById('login_button').click()" placeholder="Password">
        </div>
        
        <div>
            <button id="login_button" class="btn btn-primary" onclick="check_data()">Login
            <span class="glyphicon glyphicon-log-in"></span>
            </button>
            <a id="login_buttona" onclick="set_forgot_loging()">Forgot password</a>
        </div>
</div>

        <div id="forgot">
        <input class="form-input form-control" class="standerd_input_login" id="forgot_login"  type="email" name="email" onkeydown = "if (event.keyCode == 13)
                            document.getElementById('logins_button').click()" placeholder="Email"><br />            
        <button id="logins_button" class="btn btn-primary" onclick="send_email()">Send</button>
        <a id="login_buttona" onclick="set_forgot_loging()">Login</a>        
    </div>
    <h4><p class="label label-danger" id="what"></p></h4>
    
    <!-- Login page image -->
    <img id="home-image">
  
    <!-- sign up form -->
    <div id="sign-up-div">
        <h3><label for="signup-form" class="label label-info">Sign-up form</label></h3><hr>
        <div class="form-group">
            <input id="sin_name0" class="form-control" type="text" name="fname" oninput="sin_name(0)"  placeholder="Firstname"><br />
            <p id="sign_p0" class="label label-danger"></p>
        </div>
        <div class="form-group">
            <input id="sin_name1" class="form-control" type="text" name="lname" oninput="sin_name(1)"  placeholder="Lastname"><br />
            <p id="sign_p1" class="label label-danger"></p>
        </div>
        <div class="form-group">
            <input id="sin_email_db"  class="form-control" type="email" name="email" oninput="sin_email()" placeholder="Email"><br />
            <p id="sign_p3" class="label label-danger"></p>
        </div>
        <div class="form-group">
            <input id="sin_username_db" class="form-control" type="text" name="username" oninput="sin_username()" placeholder="Username"><br />
            <p id="sign_p4" class="label label-danger"></p>
        </div>
        <div class="form-group">
            <input id="sin_password" class="form-control" type="password" name="passworda" oninput="sin_password()" placeholder="Password"><br />
            <p id="sign_p5" class="label label-danger"></p>
        </div>
        <div class="form-group">
            <input id="sin_match_pass" class="form-control" type="password" name="passwordb" oninput="sin_password_match(6)" placeholder="Re_enter Password"><br />
            <p id="sign_p6" class="label label-danger"></p>
        </div>
        <button class="btn btn-primary" onclick="check_signup_data()">Sign up</button>
        <h4><p id="sign_p7" class="label label-danger"></p></h4>
    </div>
    
</div>
</body>
  <script src="inc_js/index.js"></script>
</html>
