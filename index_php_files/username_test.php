<?php
include "../config/signup_classes.php";

// session_start();
$data = file_get_contents("php://input");

$username = new username_test($dsn, $user, $password);
$pattern = "/[^a-zA-Z0-9&!_]+/";

$data = trim($data);

if (!preg_match($pattern, $data)){
    if (strlen($data) < 5){
        echo "too short";
    }else if (strlen($data) > 15){
        echo "too long";
    }else if ($username->check_db_username($data)){
        echo "in use";
    }else {
        echo "its cool";
    }
}else{
    echo "invalid email";
}