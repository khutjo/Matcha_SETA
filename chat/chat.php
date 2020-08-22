<?php  
    session_start();
    /* if not logged in, redirect user back to login page */
    if (!isset($_SESSION['logged_in']) || !isset($_SESSION['logged_in_user']))
        header("Location: ../index.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>chat</title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> 
</head>        
<body>

<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>                        
            </button>
            <a class="navbar-brand" href="../pages/main_page.php">
                <span class="glyphicon glyphicon-home"></span>
            </a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
                <li class="nav-item"><a class="nav-link" href="../pages/main_page.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="chat.php">Messages</a></li>
                <li class="nav-item"><a class="nav-link" href="../pages/connections.php">Connections</a></li>
                <li class="nav-item"><a class="nav-link" href="../pages/search.php">Search</a></li>                      
                <li class="nav-item"><a class="nav-link" href="../pages/profile_page.php"><span class="glyphicon glyphicon-user"></span> My Account</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="nav-item">
                    <h4>
                        <a class="nav-link label btn btn-primary" id="logout-btn" >Logout
                            <span class="glyphicon glyphicon-log-out"></span>
                        </a>
                    </h4>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class= "container">
    <h2>chat session</h2>
    <div class= "table-responsive">
        <h4>
            <p ><span class="glyphicon glyphicon-user"><?php print($_SESSION['UserName']);?></p>
        </h4>
        <div id ="user_details"></div>
    </div>
</div>
<div id= "user_model_details"></div>
<div id= "user_model_details"></div>
<footer class="container-fluid text-center">
    <p>Page footer</p>
</footer>
<script src="../inc_js/get_user_location.js"></script>
<script src="../inc_js/logout.js"></script>
</body>
</html>

<script>
$(document).ready(function(){

fetch_user();

setInterval(function(){
    update_last_activity();
    fetch_user();
    update_chat_history_data();////
},5000);

function fetch_user()
{
    $.ajax({
        url:"fetch_user.php",
        method:"POST",
        success:function(data){
            $('#user_details').html(data); //#user_details accessing the html id <-
        }

    })
}

function update_last_activity()
{
    $.ajax({
        url:"update_last_activity.php",
        success:function()
        {
        }
    })
}

function make_chat_dialog_box(to_user_id, to_user_name)
{
    console.log("make chat dialog box");
    var modal_content= '<div id="user_dialog_'+to_user_id+'" class="user_dialog" title="You have chat with '+to_user_name+'">';
    modal_content +=  '<div style="height:400px; border:1px solid #ccc; overflow-y: scroll; margin-bottom:24px; padding:16px;" class="chat_history" data-touserid="'+to_user_id+'" id="chat_history_'+to_user_id+'">';
    modal_content += fetch_user_chat_history(to_user_id);
    modal_content += '</div>';
    modal_content += '<div class= "form-group">';
    modal_content += '<textarea name="chat_message_'+to_user_id+'" id="chat_message_'+to_user_id+'" class="form-control"></textarea>';
    modal_content += '</div><div class ="form-group" align="right">';
    modal_content += '<button type="button" id="'+to_user_id+'" class="btn btn-info send_chat">Send</button></div></div>';
    $('#user_model_details').html(modal_content);
   // $('body').html(modal_content);
}

 $(document).on('click', '.start_chat', function(){
  var to_user_id = $(this).data('touserid');
  var to_user_name = $(this).data('tousername');
  make_chat_dialog_box(to_user_id, to_user_name);
  $("#user_dialog_"+to_user_id).dialog({
   autoOpen:false,
   width:400
  });
  $('#user_dialog_'+to_user_id).dialog('open');
 });

$(document).on('click', '.send_chat', function(){
  var to_user_id = $(this).attr('id');
  var chat_message = $('#chat_message_'+to_user_id).val();
  $.ajax({
   url:"insert_chat.php",
   method:"POST",
   data:{to_user_id:to_user_id, chat_message:chat_message},
   success:function(data)
   {
    $('#chat_message_'+to_user_id).val('');
    $('#chat_history_'+to_user_id).html(data);
   }
  })
 });

function fetch_user_chat_history(to_user_id)
{
    $.ajax({
        url:"fetch_user_chat_history.php",
        method:"POST",
        data:{to_user_id:to_user_id},
        success:function(data)
        {
           $('#chat_history_'+to_user_id).html(data); 
        }
    })
}

function update_chat_history_data()
{
    $('.chat_history').each(function(){
        var to_user_id = $(this).data('touserid');
        fetch_user_chat_history(to_user_id);
    });
}

});
</script>