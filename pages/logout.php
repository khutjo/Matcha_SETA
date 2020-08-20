<?php

session_start();
if (isset($_POST) && $_POST['logout'] == true && $_POST['check'] == 'OK') 
{
    echo($_SESSION['logout']);
    unset($_SESSION["logged_in"]);
    unset($_SESSION["logged_in_user"]);
    session_destroy();
}
    
if (!isset($_SESSION['logged_in']) && !isset($_SESSION['logged_in_user']))
        header("Location: ../index.php");
?>