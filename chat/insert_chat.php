<?php
include_once "../config/database.php";
include 'database_connection.php';
include '../pages/notification.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

$to_user_id  = $_POST['to_user_id'];
$from_user_id  = $_SESSION['id'];
$chat_message  = $_POST['chat_message'];
$status   = '1';

try{
    $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query=$conn->prepare("INSERT INTO chat_message SET to_user_id=?, from_user_id=?, chat_message=? , `status`=? ");
    
    if($query->execute([$to_user_id, $from_user_id, $chat_message, $status]))
    {
        echo fetch_user_chat_history($from_user_id ,$to_user_id, $conn);
        //insert notification function here
        $sender_name = $_SESSION['logged_in_user'];
        $status= 'unread';
        $message = "you recieved a message from $sender_name";
                //    $from_user_id ,$from_user_id,$sender_name, ,$status;
        insert2db($from_user_id,$to_user_id, $sender_name,$message,$status);
    }
}
catch(PDOException $e)
{
echo "let see the insert chat error.$e";
}

?>