<?php
include '../config/database.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

error_reporting(E_ALL);

function insert2db($user_1,$user_2,$user_name,$message,$read)
{
            include '../config/database.php';
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);
    try
    {
        $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query= $conn->prepare("INSERT INTO `notification` SET user_1_id =? ,user_2_id=?, user_1_name =?, messages=?, to_read=?");
        $query->execute([$user_1,$user_2,$user_name,$message,$read]);
        //user 1 is ksambo and username
    }
    catch(PDOException $e)
    {
        echo "help $e";
    }

}

function counter($id)
{
    include '../config/database.php';
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $un_read = "unread";
    try{

        //user id 
        $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query= $conn->prepare("SELECT * FROM `notification` WHERE user_2_id=? AND to_read =?");
        $query->execute([$id,$un_read]);

        $result= $query->rowCount();

        
    }
    catch(PDOException $e)
    {
        echo "help $e";
    }

    return $result;
}

function all_n($id)
{
    include '../config/database.php';
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $un_read = "unread";
    try{

        //user id 
        $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query= $conn->prepare("SELECT * FROM `notification` WHERE user_2_id=? AND to_read =?");
        $query->execute([$id,$un_read]);

        $results= $query->fetchAll();

        
    }
    catch(PDOException $e)
    {
        echo "result of notification $e";
    }

    return $results;
}

?>