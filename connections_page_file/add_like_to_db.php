<?php
include "../config/connect_class.php";
include "../pages/notification.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


session_start();
$data = file_get_contents('php://input');
$fil_data = explode('=', $data);
if ($fil_data[0] == "like_account"){
    $likes = new add_like_to_db($dsn, $user, $password, $_SESSION["logged_in_user"], $fil_data[1]);
}
else if ($fil_data[0] == "save_view"){
    // echo $fil_data[1];
    $name= $fil_data[1];
    try{
        //search for viewed user id
        $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query= $conn->prepare("SELECT id FROM accounts_basic WHERE UserName =?");
        $query->execute([$name]);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        
         $viewed_id= $result['id'];
         $viewer_name = $_SESSION['logged_in_user'];
         $viewer_id = $_SESSION['id'];
    
        $new= $conn->prepare("SELECT * FROM views WHERE viewer_id =? AND id_of_viewed_p =?");
        $new->execute([$viewer_id,$viewed_id]);
        $val =$new->rowCount();
        if($val == null)
        {
        $stmt= $conn->prepare("INSERT views SET viewer_id =? ,id_of_viewed_p=?, v_user_name =?, vd_user_name =?");
        $stmt->execute( [$viewer_id,$viewed_id, $viewer_name, $name]);
        $stmt= $conn->prepare("UPDATE accounts_bio SET fame_rating = fame_rating + 1 WHERE UserName = ?");
        $stmt->execute( [$name]);

        $message= "your profile was viewed by $viewer_name";
        insert2db($viewer_id,$viewed_id,$viewer_name,$message,$status);


        }
        else
        {
            $stmt= $conn->prepare("UPDATE views SET viewer_id =? ,id_of_viewed_p=?, v_user_name =? WHERE viewer_id =? AND id_of_viewed_p =?");
            $stmt->execute( [$viewer_id,$viewed_id, $viewer_name, $viewer_id,$viewed_id]);
        }

      }
    catch(PDOException $e)
    {
        echo ":views shits $e";
    }
}
// print_r($fil_data);