<?php

include "../config/signup_classes.php";

// session_start();
$data = file_get_contents("php://input");


$pattern = "/[a-zA-Z0-9.]+@[a-zA-Z-0-9.]+[a-zA-Z-0-9.]+/";
$neg_pattern_a = "/[^a-zA-Z0-9.]+[a-zA-Z0-9.]+@[a-zA-Z-0-9.]+\.[a-zA-Z-0-9.]+/";
$neg_pattern_b = "/[a-zA-Z0-9.]+@[a-zA-Z-0-9.]+\.[a-zA-Z-0-9.]+[^a-zA-Z0-9.]+/";
$data = trim($data);



if (preg_match($pattern, $data) &&
    !preg_match($neg_pattern_a, $data) &&
    !preg_match($neg_pattern_b, $data)){
    $email = new email_test($dsn, $user, $password);
    if ($email->check_db_email($data)){
        echo "in use";
    }else {
        echo "its cool";
    }
}else{
    echo "invalid email";
}
