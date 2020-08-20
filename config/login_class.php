<?php

include "connect.php";
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class login_test extends connect {
    public $user;
    public $clear;

    function get_account($username, $password){
        $sql = "SELECT * FROM `accounts_basic` WHERE UserName=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$username]);
        $this->user = $stmt->fetch();
        if ($this->user && password_verify($password ,$this->user['PassWord'])){
            $sql = "DELETE FROM `forgot_password` WHERE UserName=?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$this->user['UserName']]);
            $this->clear = "it's_cool";
            $_SESSION['id'] = $this->user['ID'];
            $_SESSION['user_id'] = $this->user['ID'];
            $_SESSION['UserName'] = $this->user['UserName'];
       //     $_SESSION['login_details_id'] = $this->conn->lastInsertId();

       $sql = "INSERT INTO `login_details` SET id =?";
       $query= $this->conn->prepare($sql);
       echo"see";
       $query->execute([$_SESSION['id']]);
       $_SESSION['login_details_id'] = $this->conn->lastInsertId();
       echo"now";
        }
        else {
            $this->clear = "not_cool";
        }
        // $sql = "INSERT INTO `login_details` SET id =?";
        // $stmt= $this->conn->prepare($sql);
        // echo"see";
        // $stmt->execute([$_SESSION['id']]);
        // $_SESSION['login_details_id'] = $this->conn->lastInsertId();
        // echo"now";
    }
}

class login_set_timestamp extends connect {
    
    function __construct ($dsn, $user, $password, $user_name){
    parent::__construct($dsn, $user, $password);
    $sql = "UPDATE `accounts_basic` SET `last_login`=? WHERE username=?";
    $stmt = $this->conn->prepare($sql);
   // date_default_timezone_set('UTC+2');
   date_default_timezone_set('Africa/Johannesburg');
    $stmt->execute([date('r', 36000 + time()), $user_name]);
    }

    function get_login_time($user){
    $sql = "SELECT last_login FROM accounts_basic WHERE UserName=?";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([$user]);
    $time = $stmt->fetch()[0];
    $time = (36000 + time()) - strtotime($time);
    if ($time < 10){
        return ("online");
    }else {
    return ("offline");
    }
    
}
}

?>