<?php
include "../config/profile_classes.php";

if (!isset($_SESSION))
    session_start();

$data = file_get_contents("php://input");

$user_info = new get_infomation($dsn, $user, $password, $_SESSION["logged_in_user"]);
$set_id = substr($data, 0, 1);
// echo $user_info->profile_pictures[-1 + $set_id]["profile_picture"];

echo "\nj\n";
$data = substr($data, 1 + (-1 * strlen($data)));

// echo $data;
if ($user_info->profile_pictures[-1 + $set_id]["profile_picture"] != $data){
    echo "we got out";
    $user_info->add_picture("picture_set", $data, $set_id);
}
// $ ->add_picture($user_info->profile_pictures[3]["state"], $user_info->profile_pictures[3]["profile_picture"], 5);

