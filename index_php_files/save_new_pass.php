<?php
include '../config/signup_classes.php';
session_start();
$data = file_get_contents('php://input');

if ($data){
    $send_to_db = new save_password($dsn, $user, $password, $data, $_SESSION["enter_key"], $_SESSION["otp"]);
    if ($send_to_db->saved == 1){
        unset($_SESSION["enter_key"]);
        unset($_SESSION["otp"]);
        session_destroy();
    }
}