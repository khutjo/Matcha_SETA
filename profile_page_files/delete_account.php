<?php

include "../config/profile_classes.php";
$data = file_get_contents("php://input");
session_start();

if ($data == "delete=my_account"){
    $delete = new delete_this_account($dsn, $user, $password, $_SESSION["logged_in_user"]);
}
// echo $_SESSION["logged_in_user"],$data;