<?php
include "../config/login_class.php";
session_start();
$data = file_get_contents("php://input");

$data = explode(",", $data);

$talk_to_db = new login_test($dsn, $user, $password);
$talk_to_db->get_account($data[0], $data[1]);

if ($talk_to_db->clear == "it's_cool"){
    $_SESSION["logged_in"] = "true";
    $_SESSION["logged_in_user"] = $data[0];
}
echo $talk_to_db->clear;
// echo "it's_cool";
?>