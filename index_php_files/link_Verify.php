<?php

include "../config/signup_classes.php";

if (isset($_GET["enter_key"]) && isset($_GET["otp"])){
    $resend = new verify_OTP($dsn, $user, $password, $_GET["enter_key"], $_GET["otp"]);
    if ($resend->velid == 1){
        header('location:../index.php');
    }
}
?>
<html>
<head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
<link rel="stylesheet" href="../inc_css/verify_email.css">
<!-- <script src="../inc_js/email_verify.js"></script> -->
</head>
<body>
    <div class="enter_otp">
        <p class="title_p">Verify Email</p>
        <p class="sender_p">verification email sent to <?php echo $send->user['Email'];?></p>
        <input id="otp_in" class="standerd_input_signup" type="text" name="fname" oninput="verify_otp(0)"  placeholder="OTP"><br />
        <p id="infrom_mail"></p>
        <button id="button_id" class="btn btn-primary" onclick="verify_otp(1)">signup</button>
        <button id="resend_id" class="btn btn-primary" onclick="resend_email()">Resend</button>    
    </div>
</body>
<script >
    window.onload = function(e){
        window.alert("account failed to validate");
        location.replace("../index.php");
    }
</script>

</html>