<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

    session_start();
    if (!isset($_SESSION['logged_in']) && !isset($_SESSION['logged_in_user']))
        header("Location: ../index.php");
    $username = $_SESSION['logged_in_user'];
?><!DOCTYPE html>
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
  <!-- <div class="container"> -->
    <!-- Site navigation bar -->
<?php include_once "navigation.php";?>
<div class="container text-center">   
 
  <div class="row">
    <div class="col-sm-3 well">
      <div class="well">
        <p><a href="profile_page.php"><?php echo $username;?></a></p>
        <img id="profile_pic" src="" class="img-circle" height="100" width="100" alt="Avatar">
      </div>
      <div class="well">
        <label for="interests">Interests</label>
        <p id="interest"></p>
      </div>

    </div>
    <div class="col-sm-7" >
      <div class="row">
        <div class="col-sm-12">
          <div class="panel panel-default text-left">
            <div class="panel-body">
              <strong>Suggestions:</strong>  
            </div>
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
              <button class="btn btn-success" onclick="filter(1)">By age</button>
            </div>
            <div class="well">
              <button class="btn btn-info" onclick="filter(2)">By location</button>
            </div>
            <div class="well">
              <button class="btn btn-primary" onclick="filter(3)">By fame rating</button>
            </div>
            <div class="well">
              <button class="btn btn-warning" onclick="filter(4)">By visit</button>
            </div>
          </div>
        </div>
      </div>
    </div>

</div>

<footer class="container-fluid text-center">
  <p>No More Suggestions</p>
</footer>

</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="../inc_js/view_profile_model.js"></script>
<!-- <script src="../inc_js/loged_in_handler.js"></script> -->
<script src="../inc_js/search_function.js"></script>
<script src="../inc_js/geolocation.js"></script>
<script src="../inc_js/main_page.js"></script>
<script src="../inc_js/logout.js"></script>

</html>
