
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Notification</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <script src="main.js"></script>
</head>
<body>
<h1>Notification</h1>
<?php

include "notification.php";
include '../config/database.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if (!isset($_SESSION))
session_start();
$get_id=$_GET['id'];
$change ="read";
try{

    //user id 
    $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query= $conn->prepare("SELECT * FROM `accounts_basic`
    LEFT JOIN `notification` ON `accounts_basic`.ID = `notification`.user_2_id
    WHERE `accounts_basic`.UserName = ? and to_read=?");
    $query->execute(['unread',$_SESSION["logged_in_user"]]);

    $results= $query->fetchAll();

    foreach ($results as $notice){ 
        echo $notice['messages'];
        echo " at  ";
        echo $notice['date'];
        echo "<br/>";
        // $query=$conn->prepare("UPDATE `notification` SET to_read=? WHERE user_2_id=?");
        // $query->execute([$change,$notice['user_2_id']]);
    }
    
}
catch(PDOException $e)
{
    echo "result of notification $e";
}

?>
    <a href="main_page.php">go back</a>
</body>
</html>
