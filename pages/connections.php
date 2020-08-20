<?php 
    session_start();
    if (!isset($_SESSION['logged_in']) && !isset($_SESSION['logged_in_user']))
        header("Location: ../index.php");
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

<!-- <button onclick="del_div()">button</button> -->
<div class="container text-center">
    <!-- <div class="row" > -->
        <div class="col-sm-2 well" id="main_div">
            <h3>Friends list:</h3>
            <p id="showme"></p>
        </div >
    <!-- </div> -->
    <div class="col-sm-7" id="likes_container_div">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default text-left">
                    <div class="panel-body">
                        <strong>Like Requests:</strong>  
                    </div>
                </div>
            </div>
            <div id="hold_all">
                <div id="likes_container_div">
					<h1 id="show_requests" style="text-align:center" class="label label-danger"></h1>
                <!-- <div class="set_size" id="profiles_get"> -->
                </div>
            </div>
        </div>
    </div>
</div>


</body>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="../inc_js/view_profile_model.js"></script>
<script src="../inc_js/loged_in_handler.js"></script>
<script src="../inc_js/search_function.js"></script>
<script src="../inc_js/like_request.js"></script>
<script src="../inc_js/connections.js"></script>
<script src="../inc_js/logout.js"></script>
</html>


