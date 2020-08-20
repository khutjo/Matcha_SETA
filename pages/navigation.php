<!--  site navigation bar  -->
<nav class="navbar navbar-inverse navbar-fixed-top">
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
        <li class="nav-item">
          <div class="btn-group dropleft">
            <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Notification
            <span class ="badge badge-light"><?php 
              include "notification.php";
                $id =$_SESSION['id'];
              echo counter($id);?>   
              
              </span>
            </button>
            <ul class="dropdown-menu">
              <?php
                if(counter($id)>0){
                  foreach(all_n($id) as $i){
              ?>

                <li><a class ="dropdown-item" href="view.php?id=<?php echo $i['id']?>">
                <small><i><?php echo $i['date']?></i></small><br/>
                  <?php echo $i['messages']?>
                </a></li>
              
                <?php }
                } else{
                    echo "NO one likes you";
              }
              ?>
            </ul>
          </div>
        </li>
      </ul>
      
      <ul class="nav navbar-nav navbar-right">
        <li class="nav-item"><h4><a class="nav-link label btn btn-primary" id="logout-btn" >Logout <span class="glyphicon glyphicon-log-out"></span></a></h4>
        </li>
      </ul>
    </div>
  </div>
</nav>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<!-- <script src="../inc_js/logout.js"></script> -->