<?php

//action.php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../config/database.php';
include 'database_connection.php';

session_start();

$user_id = $_SESSION['id'];
try{
    $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // $query = $conn->prepare("SELECT * FROM `accounts_basic` WHERE accounts_basic.id != ?");
    // $query->execute([$user_id]);
$un = $_SESSION['logged_in_user'];
    $query = $conn->prepare("SELECT * FROM connections
    LEFT JOIN accounts_basic on accounts_basic.UserName = connections.user1 OR accounts_basic.UserName = connections.user2
    WHERE (connections.user1 = ? OR connections.user2 = ?) AND accounts_basic.UserName != ?");
    $query->execute([$un,$un,$un]);
    $result = $query->fetchAll();

    $output = '<table class= "table table-bordered table-striped">
    <tr>
        <td><strong>Username</strong></td>
        <td><strong>Status</strong></td>
        <td><strong>Action</strong></td>
    </tr>
    ';
    date_default_timezone_set('Africa/Johannesburg');
    foreach($result as $row)
    {
      $status = '';
      $current_timestamp= strtotime(date('Y-m-d H:i:s') . '-10 second');
      $current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
      $user_last_activity = fetch_user_last_activity($row['ID'], $conn);
      if($user_last_activity > $current_timestamp)
      {
          $status = '<span class="label label-success">Online</span>';
      }
      else //if($user_last_activity <= $current_timestamp)
      {
        $status = '<span class=" label label-danger">Offline</span>';
      }
      $output .= '
      <tr>
        <td>'.$row['UserName'].''.count_unseen_message($row['ID'],$_SESSION['id'],$conn).'</td>
        <td>'.$status.'</td>
        <td><button type="button" name="send_chat" class="btn btn-info btn-xs 
        start_chat" data-touserid="'.$row['ID'].'" 
        data-tousername="'.$row['UserName'].'">Start 
        Chat</button></td>
      </tr>
      '; 
    }

    $output .= '</table>';

    echo $output;
}
catch(PDOException $e)
{
    echo "let see this one now.$e";
}
?>