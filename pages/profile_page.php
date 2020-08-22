<?php 
    session_start();
    if (!isset($_SESSION['logged_in']) && !isset($_SESSION['logged_in_user']))
        header("Location: ../index.php");
?>

<html>
<head>
<link rel="shortcut icon" type="image/x-icon" href="../media/resources/favicon.png" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> 
    <link rel="stylesheet" href="../inc_css/profile_page.css">
</head>
<body style="padding-top: 70px;">
    <?php include_once "navigation.php";?>
    <div id="user-details" class="container container-fluid">
        <div>
            <!-- user images -->
            <h1>Your photos:</h1>
            <img id="main_picture" class="rounded-circle img-circle" height="180" width="180" onclick="callin(1)">
            <img id="sub_picture1" class="" height="180" width="180" onclick="callin(2)">
            <img id="sub_picture2" class="" height="180" width="180" onclick="callin(3)">
            <img id="sub_picture3" class="" height="180" width="180" onclick="callin(4)">
            <img id="sub_picture4" class="" height="180" width="180" onclick="callin(5)"><br />
            <hr/>
            <button class="btn btn-info" onclick="send_picture_to_databaseall()">Save image</button><br />
            <!-- user info -->
            <h1>Profile details</h1><hr/>
            <div class="user-details">
                <div class="info_div">
                    <div class="center_div_contents">
                        <input id="sin_name0" class="form-control standerd_input_signup" type="text" name="fname" oninput="sin_name(0)"  placeholder="Firstname"><br />
                        <p id="sign_p0"></p>
                        <input id="sin_name1" class="form-control standerd_input_signup" type="text" name="lname" oninput="sin_name(1)"  placeholder="Lastname"><br />
                        <p id="sign_p1"></p>
                        <input id="sin_email_db" class="form-control standerd_input_signup" type="email" name="email" oninput="sin_email()" placeholder="Email"><br />
                        <p id="sign_p2"></p>
                        <input id="sin_username_db" class="form-control standerd_input_signup" type="text" name="username" oninput="sin_username()" placeholder="Username"><br />
                        <p id="sign_p3"></p>
                        
                        <input id="sin_password" class="form-control standerd_input_signup" type="password" name="passworda" oninput="db_valid_check()" placeholder="old Password"><br />
                        <p id="sign_p4"></p>
                        <input id="sin_passworda" class="form-control standerd_input_signup" type="password" name="passwordb" oninput="sin_password()" placeholder="Password"><br />
                        <p id="sign_p5"></p>
                        <input id="sin_match_pass" class="form-control standerd_input_signup" type="password" name="passwordc" oninput="sin_password_match(6)" placeholder="Re_enter Password"><br />
                        <p id="sign_p6"></p>
                        <button class="btn btn-primary"onclick="save_changes()">Save</button>
                        <button class="btn btn-danger"onclick="delete_account()">Delete</button>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-6">
                    <label for="gender">Gender:</label>
                    <select class="form-control" id="your_gender" oninput="your_gender_in()">
                        <!-- <option value="nothing">select</option> -->
                        <option value="male">male</option>
                        <option value="female">female</option>
                        <option value="other">other</option>
                    </select>
                    </div>
                </div>
                <div class="form-group row">
                <div class="col-lg-6">
                    <label for="preferences">Sexual preferences:</label>                    
                    <select class="form-control" id="their_gender" oninput="their_gender_in()"> 
                        <option value="nothing">select</option>
                        <option value="other">Other</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>
                </div>

                <div class="form-group row">  
                    <div class="col-lg-6">
                    <label for="age">Age:</label>
                    <input class="form-control" id="set_age" type="text" name="age" oninput="my_age_in()" onblur="mid_age_enter_sin()" placeholder="18">
                        <p id="errorhandleage"></p>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-lg-6">
                    <label for="gender">Location</label>
                    <div >
                        <input class="form-control" id="my_location" class="bio_input" ></textarea><br />
                    </div>
                        <p id="errorhandle_location"></p><hr/>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-lg-6">
                    <label for="gender">Short bio about yourself:</label>
                    <div >
                        <textarea class="form-control" id="my_bio" class="bio_input" oninput="mid_about_me_in()" ></textarea><br />
                        <button id="save_button" class="btn btn-primary" onclick="save_data()">save</button>                
                    </div>
                        <p id="errorhandlebio"></p><hr/>
                    </div>
                </div>
                <label for="tags">Tags list:</label>
                <div style="width: 300px">
                <!-- you will need to remove this-->
                <div id="fooBar" style="float: left;width: 100px">
                </div>
            <div >
                <h3>Your interests:</div>
                <h4 id="show_my_tags" class="text-center"></h4>
            </div>
            </div>
            </div>
        </div> 
    </div>
    <div>
        <input id="select_file1"type="file" style="display: none;" onchange="previewFile(1)"><br>
        <input id="select_file2"type="file" style="display: none;" onchange="previewFile(2)"><br>
        <input id="select_file3"type="file" style="display: none;" onchange="previewFile(3)"><br>
        <input id="select_file4"type="file" style="display: none;" onchange="previewFile(4)"><br>
        <input id="select_file5"type="file" style="display: none;" onchange="previewFile(5)"><br>
    </div>
    
    <footer class="container-fluid text-center">
        <p>Page footer</p>
    </footer>    
</body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="../inc_js/get_user_location.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=yorapi_ky&callback=initMap&libraries=places&v=weekly" defer></script>
    <script src="../inc_js/profile_interest.js"></script>
    <script src="../inc_js/profile_page.js"></script>
    <script src="../inc_js/edit_account.js"></script>
    <script src="../inc_js/logout.js"></script>
	
</html>