<?php 
    session_start();
    if (!isset($_SESSION['logged_in']) && !isset($_SESSION['logged_in_user']))
        header("Location: ../index.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Search Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="../inc_css/model_view_div.css">
</head>
<body style="padding-top: 70px;">
    <!-- Site navigation bar -->
    <?php include_once "navigation.php";?>
    <!-- <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>                        
            </button>
            <a class="navbar-brand" href="main_page.php">
                <span class="glyphicon glyphicon-home"></span>
            </a>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
                <li class="nav-item"><a class="nav-link" href="main_page.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="../chat/chat.php">Messages</a></li>
                <li class="nav-item"><a class="nav-link" href="connections.php">Connections</a></li>
                <li class="nav-item"><a class="nav-link" href="search.php">Search</a></li>        
                <li><a href="profile_page.php"><span class="glyphicon glyphicon-user"></span> My Account</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="nav-item"><h4><a class="nav-link label btn btn-primary" id="logout-btn" >Logout <span class="glyphicon glyphicon-log-out"></span></a></h4>
                </li>
            </ul>
            </div>
        </div>
    </nav> -->

<div class="container">   
 
  <div class="row">
    <div class="col-sm-3 well">
        <h3>Search parameters</h3>
        <div class="well text-left">
            <h4>Age gap</h4>
            <div class="form-check">
                <input class="form-check-input" id="checkbox_age_1" type="checkbox" onclick="search_for_age(1)" >
                <label class="form-check-label">18 - 29</label>
            </div>
            <div class="form-check">
                <input id="checkbox_age_2" class="form-check-input" type="checkbox" onclick="search_for_age(2)">
                <label class="form-check-label">30 - 39</label>
            </div>
            <div class="form-check">
                <input id="checkbox_age_3" class="form-check-label" type="checkbox" onclick="search_for_age(3)">
                <label class="form-check-label">40 - 49</label>
            </div>
            <div class="form-check">
                <input id="checkbox_age_4" class="form-check-input" type="checkbox" onclick="search_for_age(4)">
                <label class="form-check-label">50 - 59</label>
            </div>
            <div class="form-check">
                <input id="checkbox_age_5" class="form-check-input" type="checkbox" onclick="search_for_age(5)">
                <label class="form-check-label">60 - ?</label>
            </div>
        </div>

        <div class="well text-left">
            <h4>Fame Rating</h4>
            <div class="form-check">
                <input id="checkbox_famerating_1" clas="form-check-input" type="checkbox" onclick="search_for_famerating(1)" >
                <label class="form-check-label">Peasant</label>
            </div>
            <div class="form-check">
                <input id="checkbox_famerating_2" class="form-check-input" type="checkbox" onclick="search_for_famerating(2)">
                <label class="form-check-label">Human</label>
            </div>
            <div class="form-check">
                <input id="checkbox_famerating_3" class="form-check-input" type="checkbox" onclick="search_for_famerating(3)">
                <label class="form-check-label">Noble</label>
            </div>
            <div class="form-check">
                <input id="checkbox_famerating_4" class="form-check-input" type="checkbox" onclick="search_for_famerating(4)">
                <label class="form-check-label">God</label>
            </div>
        </div>

                <div class="well text-left">
            <h4>Distance</h4>
            <div class="form-check">
                <input id="checkbox_distance_1" clas="form-check-input" type="checkbox" onclick="search_for_distance(1)" >
                <label class="form-check-label">close</label>
            </div>
            <div class="form-check">
                <input id="checkbox_distance_2" class="form-check-input" type="checkbox" onclick="search_for_distance(2)">
                <label class="form-check-label">in the middle</label>
            </div>
            <div class="form-check">
                <input id="checkbox_distance_3" class="form-check-input" type="checkbox" onclick="search_for_distance(3)">
                <label class="form-check-label">far</label>
            </div>
        </div>


        <div class="well text-left">
            <h4>Interests</h4>
            <div class="form-check">
                <input id="checkbox_tags_1" class="form-check-input" type="checkbox" name="sports" onclick="search_for_tag(1)">
                <label>Sports</label>
            </div>
            <div class="form-check">
                <input id="checkbox_tags_2" class="form-check-input" type="checkbox" name="coding" onclick="search_for_tag(2)">
                <label>Coding</label>
            </div>
            <div class="form-check">
                <input id="checkbox_tags_3" class="form-check-input" type="checkbox" name="cars" onclick="search_for_tag(3)" >
                <label>Cars</label>
            </div>
            <div class="form-check">
                <input id="checkbox_tags_4" class="form-check-input" type="checkbox" name="guns" onclick="search_for_tag(4)" >
                <label>Guns</label>
            </div>
            <div class="form-check">
                <input id="checkbox_tags_5" class="form-check-input" type="checkbox" name="movies" onclick="search_for_tag(5)" >
                <label>Movies</label>
            </div>
            <div class="form-check">
                <input id="checkbox_tags_6" class="form-check-input" type="checkbox" name="music" onclick="search_for_tag(6)" >
                <label>Music</label>
            </div>
            <div class="form-check">
                <input id="checkbox_tags_7" class="form-check-input" type="checkbox" name="games" onclick="search_for_tag(7)" >
                <label>Games</label>
            </div>
            <div class="form-check">
                <input id="checkbox_tags_8" class="form-check-input" type="checkbox" name="pc muster_race" onclick="search_for_tag(8)" >
                <label>Glorious PC master race</label>
            </div>
            <div class="form-check">
                <input id="checkbox_tags_9" class="form-check-input" type="checkbox" name="console_peasent" onclick="search_for_tag(9)" >
                <label>Filthy console peasent</label>
            </div>
            <div class="form-check">
                <input id="checkbox_tags_10" class="form-check-input" type="checkbox" name="gold diggers" onclick="search_for_tag(10)" >
                <label>Gold diggers</label>
            </div>
            <div class="form-check">
                <input id="checkbox_tags_11" class="form-check-input" type="checkbox" name="hit and run" onclick="search_for_tag(11)">
                <label>Hit and run</label>
            </div>
            <div class="form-check">
                <input id="checkbox_tags_12" class="form-check-input" type="checkbox" name="one night stand" onclick="search_for_tag(12)">
                <label>One night stand</label>
            </div>
            <div >
                <input id="checkbox_tags_13" class="form-check-input" type="checkbox" name="dancing" onclick="search_for_tag(13)" >
                <label>Dancing</label>
            </div>
        </div>
        <div class="well text-center">
        <button class="btn btn-warning" onclick="del_all_search()">Clear</button>
        <button class="btn btn-info" onclick="search_for_this()">Search</button>
        </div>

    </div>
    <div class="col-sm-7" >
      <div class="row">
        <div class="col-sm-12">
          <div class="panel panel-default text-left">
            <div class="panel-body">
              <strong>Results:</strong>  
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
          <div class="col-sm-2 well text-center">
            <div class="thumbnail">
              <strong><h4>Order by:</h4></strong>
            </div>      
            <div class="well">
              <button class="btn btn-primary" onclick="order('age')">By age</button>
            </div>
            <div class="well">
              <button class="btn btn-success" onclick="order('location')">By location</button>
            </div>
            <div class="well">
              <button class="btn btn-info" onclick="order('fame_rating')">By fame rating</button>
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
<script src="../inc_js/loged_in_handler.js"></script>
<script src="../inc_js/search_function.js"></script>
<script src="../inc_js/logout.js"></script>
</html>
