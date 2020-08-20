<?php
include "../config/search_classes.php";
$data = file_get_contents("php://input");
session_start();

$fil_data = explode(" ", $data);
$fil_data_pic = explode("=", $data);

$get_from_db = new search_for($dsn, $user, $password);
$fil_data_tags = "";
if (isset($fil_data[3])){
    $fil_data_tags = explode("=", $fil_data[3]);
}
// echo json_encode($fil_data_tags);
if ($fil_data_pic[0] == "get_x_picture"){
    // echo ("hello");
    echo json_encode($get_from_db->get_my_pic($fil_data_pic[1]));

    // echo "hello";
}else if ($data == "get_my_location=get"){
    echo json_encode($get_from_db->get_my_location($_SESSION["logged_in_user"]));
    // echo "hello";
}else {
    echo json_encode($get_from_db->get_search_results($_SESSION["logged_in_user"], $fil_data[4], $fil_data[1], $fil_data[2], $fil_data_tags));
}