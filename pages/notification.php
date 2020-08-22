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

function related_profiles($name){
    include '../config/database.php';
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT `accounts_bio`.UserName, `images`.profile_picture, `accounts_bio`.age, `accounts_bio`.biography
    FROM `accounts_bio`
    LEFT JOIN `images` ON `accounts_bio`.UserName = `images`.UserName
    WHERE accounts_bio.UserName = ? AND`images`.set_id = 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$name]);
    return ($stmt->fetch());
}

function delete_notification($notice_id){
    include '../config/database.php';
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "DELETE FROM `notification` WHERE `id`=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$notice_id]);
    echo "Done";
}

$data = file_get_contents('php://input');
$fil_data = explode('=', $data);

if (isset($fil_data[1]) && $fil_data[1] == "get_full_notification"){

session_start();
    $more_data = all_n($_SESSION["id"]);
    $notice = array();
    $name = "";
    foreach ($more_data as $iter){
        $profile = related_profiles($iter["user_1_name"]);
        array_push($notice, array_merge([$iter["user_1_name"], $iter["messages"], $iter["id"], $profile["profile_picture"], $profile["age"], $profile["biography"]]));
    }
    if (count($notice))
        echo json_encode($notice);
    else
        echo "nothing";
    // var_dump(all_n($_SESSION["id"]));
}
else if (isset($fil_data[0]) && $fil_data[0] == "Delete_notice")
    delete_notification($fil_data[1])
?>