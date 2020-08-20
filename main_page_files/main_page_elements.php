<?php

include "../config/main_classes.php";
$data = file_get_contents("php://input");
if (!isset($_SESSION))
session_start();


$data = explode("=", $data);
// $_SESSION["logged_in_user"] = "rootggga";
$user_info = new get_my_data($dsn, $user, $password, $_SESSION["logged_in_user"]);

// print_r($user_info->get_other_profile_info);

// $num =  explode("+", $data[1]);
if ($data[0] == "get_my_pic"){
    echo $user_info->profile_pictures[0]["profile_picture"];
    // echo $_SESSION["logged_in_user"]; 
}else if ($data[0] == "get_profile_basic"){
    // print_r($data);
    $user_info->get_their_profiles($data[1]);
    echo json_encode($user_info->get_other_profile_info);
}else if ($data[0] == "get_profile_bio"){
    // echo $_SESSION["logged_in_user"];
    $user_info->get_other_profile_info($data[1]);
    
}else if ($data[0] == "get_my_interest_num"){
    $user_info->my_interest($_SESSION["logged_in_user"]);
    echo $user_info->in_num;
}else if ($data[0] == "interest_num"){
    
    $user_info->my_interest($_SESSION["logged_in_user"]);
    // print_r($user_info->interest);
    echo $user_info->interest[$data[1]]["set_tag"];
}

