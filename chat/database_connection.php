<?php 
include '../config/database.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$connect = new PDO($dsn, $user, $password);

date_default_timezone_set('Africa/Johannesburg');

function fetch_user_last_activity($user_id, $connect)
{
    try{
        $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = $connect->prepare("SELECT * FROM `login_details` WHERE id = ? 
                                    ORDER BY last_activity DESC LIMIT 1");
        $query->execute([$user_id]);
        //print_r($result); shit be empty
        $result = $query->fetchAll();
        foreach($result as $row)
        {
            return $row['last_activity'];
        }
    }
    catch(PDOException $e)
    {
        echo "------------->>--.$e<br/><br/><br/>";
    }
}


function fetch_user_chat_history($from_user_id, $to_user_id, $connect)
{
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = $connect->prepare("SELECT * FROM chat_message WHERE from_user_id = ? AND to_user_id =? OR from_user_id =? AND to_user_id =? ORDER BY timestamp DESC");
    $query->execute([$from_user_id, $to_user_id, $to_user_id,$from_user_id]);
    $result = $query->fetchAll();
    
    $output = '<ul class="list-unstyled">';
    foreach($result as $row)
    {

    $user_name = '';
        if($row['from_user_id'] == $from_user_id)
        {
       
             $user_name = '<b class="text-success">You</b>';
            
        }
         else
        {
            $d= $row['from_user_id'];
            // die();
            $user_name = '<b class="text-danger">'.get_user_name($d, $connect).'</b>';
        }
        $output .='
        <li style="border-bottom:1px dotted #ccc">
        <p>'.$user_name.' -'.$row["chat_message"].'
         <div align= "right">
         - <small><em>' .$row['timestamp'].'</em></small>
         </div>
         </p>
         </li>
        ';
    }

    $zero='0';
    $one ='1';
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = $connect->prepare("UPDATE chat_message SET `status`=? WHERE from_user_id =? AND to_user_id=? AND `status`=?");
    $query->execute([$zero,$to_user_id,$from_user_id,$one]);
    $output.='</ul>';
    return  $output;
}

function get_user_name($user_id, $connect)
{
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = $connect->prepare("SELECT UserName FROM accounts_basic WHERE id=? ");
    $query->execute([$user_id]);
    $result = $query->fetchAll();
    foreach($result as $row)
    {
        return $row['UserName'];
    }
}

function count_unseen_message($from_user_id, $to_user_id, $connect)
{
    $one= '1';
    try{
        $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = $connect->prepare("SELECT * FROM chat_message WHERE from_user_id= ? AND to_user_id =? AND `status`=?");
        $query->execute([$from_user_id,$to_user_id,$one]);

        $count = $query->rowCount();
        $output ='';
        if ($count > 0)
        {
            $output = '<span class = "label label-success">'.$count.'</span>';
        }
        return $output;

    }
    catch(PDOException $e)
    {
        echo "///>$e";
    }
}
?>