<?php

include "../config/signup_classes.php";

if (!isset($_SESSION))
    session_start();
$data = file_get_contents("php://input");
// $data = "1t, 2t, 3t, 4t, 5t, 6t";
$data = explode(",", $data);

$data[0] = trim($data[0]);
$data[1] = trim($data[1]);
$data[2] = trim($data[2]);
$data[3] = trim($data[3]);
$data[4] = trim($data[4]);

$account = new add_to_unverified($dsn, $user, $password);
$account->add_user($data[0], $data[1], $data[2], $data[3], $data[4]);
// print_r($data);