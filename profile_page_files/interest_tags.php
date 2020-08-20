<?php

include "../config/profile_classes.php";
$data = file_get_contents("php://input");
$datqa = file_get_contents("php://input");

session_start();

$tag_data = new get_tag_info($dsn, $user, $password, $_SESSION["logged_in_user"]);

// echo ($data);
$data = explode('=', $data);

function get_my_tags($arr){
        $num = count($arr);
    for ($x = 0; $x < $num; $x++) {
        echo $arr[$x][2],"<br/>";
    } 
}

if ($data[0] == "set_tag"){
    echo count($tag_data->tag_lib);
    // print_r($tag_data->my_tags);
}else if ($data[0] == "get_tag_name"){
    echo $tag_data->tag_lib[$data[1]]["set_tag"];
}else if ($data[0] == "set_db_tag"){
    $tags = str_replace("+"," ",$data[1]);
    $tag_data->add_tag($_SESSION["logged_in_user"], $tags);
    get_my_tags($tag_data->my_tags);

    // echo $tag_data->tag_lib[$data[1]]["set_tag"];
}else if ($data[0] == "get_my_tags"){
    get_my_tags($tag_data->my_tags);
}

// echo $datqa;