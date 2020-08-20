<?php
include "../config/profile_classes.php";
$data = file_get_contents("php://input");
session_start();

$data_password = explode('=', $data);
$new_data = explode('=', $data);
$user_info = new get_infomation($dsn, $user, $password, $_SESSION["logged_in_user"]);


if ($data == "firstname=get"){
    echo $user_info->profile_info["FirstName"];
}else if ($data == "lastname=get"){
    echo $user_info->profile_info["LastName"];
}else if ($data == "email=get"){
    echo $user_info->profile_info["Email"];
}else if ($data == "username=get"){
    echo $user_info->profile_info["UserName"];
}else if ($data_password[0] == "password"){
     if (password_verify($data_password[1], $user_info->profile_info["PassWord"])){
        echo "valid";
     }else{
        echo "nope";
     }
}else if ($new_data[0] == "add_lname"){
    $user_info->update_lname($new_data[1]);
    echo $new_data[1];
}else if ($new_data[0] == "add_fname"){
    $user_info->update_fname($new_data[1]);
    echo $new_data[1];
}else if ($new_data[0] == "add_email"){
    $user_info->update_email($new_data[1]);
    echo $new_data[1]; 
}else if ($new_data[0] == "add_password"){
    $user_info->update_password($new_data[1]);
    echo $new_data[1];
}else if ($new_data[0] == "add_uname"){
    $user_info->update_username($new_data[1]);
    unset($_SESSION["logged_in_user"]);
    $_SESSION["logged_in_user"] = $new_data[1];
    echo ($new_data[1]);
}
// echo ">",$data_password[0],"<";