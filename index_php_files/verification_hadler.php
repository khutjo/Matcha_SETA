<?php

include "../config/signup_classes.php";

$data = file_get_contents("php://input");

// echo "cool";
$data = explode(',', $data);

if ($data[0] === "resend"){
    $resend = new resend_verification_email($dsn, $user, $password);
}
if ($data[0] === "verify"){
    // echo "all_set";
    $resend = new verify_OTP($dsn, $user, $password, $_SESSION["matcher"], $data[1]); 
}
if ($data[0] === "valid"){
    // echo "all_set";
    if (isset($_SESSION["is_velidated"]) && $_SESSION["is_velidated"] == "true"){
        unset($_SESSION["is_velidated"]);
        echo "validated";
    }
}
// "6bc3ff");//