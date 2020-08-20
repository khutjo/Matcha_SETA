<?php
include "../config/connect_class.php";
$data = file_get_contents("php://input");
session_start();

$data = explode("=", $data);

// echo "your_ghhood";
$check_block_list_db = new block_list_verify($dsn, $user, $password, $_SESSION["logged_in_user"] ,$data[1]);