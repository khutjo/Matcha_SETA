<?php

include "../config/login_class.php";

if (!isset($_SESSION))
    session_start();

$set_time = new login_set_timestamp($dsn, $user, $password, $_SESSION["logged_in_user"]);
    