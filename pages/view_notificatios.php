<?php

// include "notification.php";
include '../config/database.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if (!isset($_SESSION))
    session_start();
// $get_id=$_GET['id'];
// $change ="read";
// try{
    // "https://maps.googleapis.com/maps/api/distancematrix/json?units=matric&origins=-25.739264,28.213248&&destinations=-25.739264,28.213248&key=YOUR_API_KEY"
    
    
    
    
    $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query= $conn->prepare("SELECT count(id) as connections FROM `connections`
    WHERE `user1` = ? OR `user2` = ?");
    $query->execute([$_SESSION["logged_in_user"], $_SESSION["logged_in_user"]]);
    $connections_results= $query->fetchAll();
    $connections = $connections_results[0]["connections"];
    
    $query= $conn->prepare("SELECT * FROM `views`
    WHERE `vd_user_name` = ?");
    $query->execute([$_SESSION["logged_in_user"]]);
    $views_results= $query->fetchAll();
    $views = count($views_results);
    
    $query= $conn->prepare("SELECT * FROM `people_you_like`
    WHERE `liked` = ?");
    $query->execute([$_SESSION["logged_in_user"]]);
    $people_you_like_results= $query->fetchAll();
    $likes = count($people_you_like_results);
    

    $query= $conn->prepare("SELECT * FROM location WHERE UserName in (:usernamea, :usernameb)");
    $query->bindValue(':usernamea', $_SESSION["logged_in_user"]);
    $query->bindValue(':usernameb', "Matt_Kemp");
    $query->execute();
    $location = $query->fetchAll(PDO::FETCH_ASSOC);

    // echo $location[0]["lat"], "\n";
    // echo $location[0]["lon"], "\n";
    // echo $location[1]["lat"], "\n";
    // echo $location[1]["lon"], "\n";
    // "origins=".$location[0]["lat"].",".$location[0]["lon"]."&destinations=".$location[1]["lat"].",".$location[1]["lon"]
    // $data = file_get_contents("https://maps.googleapis.com/maps/api/distancematrix/json?units=matric&origins=".$location[0]["lat"].",".$location[0]["lon"]."&destinations=".$location[1]["lat"].",".$location[1]["lon"]."&key=AIzaSyCyPPJAN_R1wNuzKbSa2SIjLk3i_nKl0Ak");
    $data = file_get_contents("https://maps.googleapis.com/maps/api/distancematrix/json?units=matric&origins=-25.739264,28.213248&&destinations=18.62744421970849,-33.9015521302915&&key=AIzaSyCyPPJAN_R1wNuzKbSa2SIjLk3i_nKl0Ak");
    var_dump($data);


//     //user id 
    // $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    // $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // $query= $conn->prepare("SELECT * FROM `accounts_basic`
    // LEFT JOIN `notification` ON `accounts_basic`.ID = `notification`.user_2_id
    // WHERE `accounts_basic`.UserName = ? and to_read=?");
    // $query->execute(['unread',$_SESSION["logged_in_user"]]);

//     $results= $query->fetchAll();

//     foreach ($results as $notice){ 
//         echo $notice['messages'];
//         echo " at  ";
//         echo $notice['date'];
//         echo "<br/>";
//         // $query=$conn->prepare("UPDATE `notification` SET to_read=? WHERE user_2_id=?");
//         // $query->execute([$change,$notice['user_2_id']]);
//     }
    
// }
// catch(PDOException $e)
// {
//     echo "result of notification $e";
// }

// 
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <title>Get-laid.com</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" type="image/x-icon" href="../media/resources/favicon.png" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="../inc_css/popup.css">
  <link rel="stylesheet" href="../inc_css/model_view_div.css">

</head>
<body style="padding-top: 70px;">
    <!-- Site navigation bar -->
    <?php include_once "navigation.php";?>
<div id="fooBar"></div>



<div class="container text-center">   
 
  <div class="row">
    <div class="col-sm-3 well"id="main_div">
      <div class="well">
      <h2>Profile stats:</h2>
        <h4>Connections:</h4>
        <h1 id="Connections" ><?php echo $connections;?></h1>
        <h4>View:</h4>
        <h1 id="View" ><?php echo $views;?></h1>
        <h4>Likes:</h4>
        <h1 id="Likes" ><?php echo $likes;?></h1>
      </div>

    </div>
    <div class="col-sm-7" >
      <div class="row">
      <div class="col-sm-12">
                <div class="panel panel-default text-left">
                    <div class="panel-body">
                        <strong>Notifications:</strong>  
                    </div>
                </div>
            </div><div id="hold_all">
                <div id="likes_container_div">
					<h1 id="show_notifications" style="text-align:center" class="label label-danger"></h1>
                <!-- <div class="set_size" id="profiles_get"> -->
                </div>
            </div>
      </div>
      <div id="hold_all">
        <div class="set_size" id="profiles_get">
        <!-- <button onclick="get_profiles()">pressme<button> -->
        </div>
  </div>
    </div>
        <div id="hold_res">      
            <div class="col-sm-2 well">
                <div class="thumbnail">
                <strong><p>Filter by:</p></strong>
                </div>      
                <div class="well">
                <button class="btn btn-success" onclick="filter(1)">Messages</button>
                </div>
                <div class="well">
                <button class="btn btn-info" onclick="filter(2)">Views</button>
                </div>
            </div>
        </div>
    </div>
</div>

</div>

</body>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="../inc_js/view_profile_model.js"></script>
<script src="../inc_js/view_notifications.js"></script>
<script src="../inc_js/get_user_location.js"></script>
<script src="../inc_js/loged_in_handler.js"></script>
<script src="../inc_js/logout.js"></script>
</html>
