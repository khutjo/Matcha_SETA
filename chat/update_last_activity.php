<?php

include '../config/database.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

//$now= NOW();
//echo $login = $_SESSION['login_details_id'];
date_default_timezone_set('Africa/Johannesburg');
// echo $now= date('Y-m-d h:i:s');
$login = $_SESSION['login_details_id'];


//date_default_timezone_set('UTC + 2');
// $current_timestamp= strtotime(date('Y-m-d h:i:s H:i:s') . '-10 second');
//       $current_timestamp = date('Y-m-d h:i:s', $current_timestamp);

try{
    echo"see";
    $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "here";
    $query=$conn->prepare("UPDATE login_details SET last_activity = ? WHERE login_details_id = ?");
    $query->execute([$now,$login]);
    echo"now";
}
catch(PDOException $e)
{
    echo "let see this one now.$e";
}
// echo $login = $_SESSION['login_details_id'];

?>