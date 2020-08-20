<?php
include "../config/profile_classes.php";
$data = file_get_contents("php://input");
$dataa = file_get_contents("php://input");
session_start();

$data = explode('=', $data);

$user_info = new get_infomation($dsn, $user, $password, $_SESSION["logged_in_user"]);

if ($data[0] == "my_gen"){
$user_info->set_my_gen($data[1]);
echo $data[1];
}else if ($data[0] == "their_gen"){
    $user_info->set_thier_gen($data[1]);
    echo $data[1];
}else if ($data[0] == "my_age"){
    $user_info->set_my_age($data[1]);
    // echo "ok";
}else if ($data[0] == "my_gender"){
    echo $user_info->user["gender"];
    // echo "male";
}else if ($data[0] == "their_gender"){
    echo $user_info->user["preferences"];
    // echo "male";
}else if ($data[0] == "get_age"){
    echo $user_info->user["age"];
    // echo "18";
}else if ($data[0] == "get_bio"){
    echo $user_info->user["biography"];
}else if ($data[0] == "get_pic"){
    echo $user_info->profile_pictures[0]["profile_picture"];
}else if ($data[0] == "get_pic1"){
    echo $user_info->profile_pictures[1]["profile_picture"];
}else if ($data[0] == "get_pic2"){
    echo $user_info->profile_pictures[2]["profile_picture"];
}else if ($data[0] == "get_pic3"){
    echo $user_info->profile_pictures[3]["profile_picture"];
}else if ($data[0] == "get_pic4"){
    echo $user_info->profile_pictures[4]["profile_picture"];
}else {
    // $data[1] = strip_tags(stripslashes(trim(preg_replace('/[+]/', " ", $data[1]))));
    $user_info->set_my_bio($dataa);
    echo $dataa;
}
// echo $_SESSION["logged_in_user"];