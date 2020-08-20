<?php
include "../config/connect_class.php";
session_start();
$data = file_get_contents('php://input');
$fil_data = explode('=', $data);
$likes = new liking_system($dsn, $user, $password, $_SESSION["logged_in_user"]);

if ($data == "get_conns=get"){
    // $likes->get_like_connection_num(1, $_SESSION["logged_in_user"]);
    echo $likes->fnum;
}else if ($data == "get_likes=get"){
    $likes->get_people_that_like_you($_SESSION["logged_in_user"]);
    echo $likes->num;
}else if ($fil_data[0] == "get_bio_data"){
    $likes->get_likes_bio($fil_data[1]);
}else if ($fil_data[0] == "get_like_picture"){
    $likes->get_people_that_like_you($_SESSION["logged_in_user"]);
    echo $likes->profiles[$fil_data[1]]["UserName"],"=",
    $likes->profiles[$fil_data[1]]["profile_picture"];
}else if ($fil_data[0] == "get_conn_data"){
    echo $likes->friends[$fil_data[1]]["UserName"],"=",
    $likes->friends[$fil_data[1]]["profile_picture"];
}else if ($fil_data[0] == "get_last_time"){
    echo $likes->get_login_time($fil_data[1]);
}else if ($fil_data[0] == "unlike_x_account"){
    $likes->unlike_account($_SESSION["logged_in_user"], $fil_data[1]);
}else if ($fil_data[0] == "block_x_account"){
    $likes->block_account($_SESSION["logged_in_user"], $fil_data[1]);
}else if ($fil_data[0] == "accept_request"){
    $likes->add_to_connection($_SESSION["logged_in_user"], $fil_data[1]);
}else if ($fil_data[0] == "reject_request"){
// echo $data;
    $likes->remove_from_likes($_SESSION["logged_in_user"], $fil_data[1]);
}

