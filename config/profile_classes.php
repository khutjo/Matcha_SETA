<?php

include "connect.php";

class get_infomation extends connect {
    public $user;
    public $profile_info;
    public $profile_pictures;

    function __construct ($dsn, $user, $password, $user_name){
        parent::__construct($dsn, $user, $password);
        $sql = "SELECT * FROM `accounts_bio` WHERE UserName=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$user_name]);
        $this->user = $stmt->fetch();
        parent::__construct($dsn, $user, $password);
        $sql = "SELECT * FROM `accounts_basic` WHERE UserName=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$user_name]);
        $this->profile_info = $stmt->fetch();
        $sql = "SELECT * FROM `images` WHERE UserName=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$user_name]);
        $this->profile_pictures = $stmt->fetchAll();
    }

    function set_my_gen($gender){
        
        $sql = "UPDATE `accounts_bio` SET `gender`=? WHERE UserName=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$gender, $this->user["UserName"]]);
    }
    function set_thier_gen($gender){
        
        $sql = "UPDATE `accounts_bio` SET `preferences`=? WHERE UserName=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$gender, $this->user["UserName"]]);
    }
    function set_my_age($age){
        
        $sql = "UPDATE `accounts_bio` SET `age`=? WHERE UserName=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$age, $this->user["UserName"]]);
    }
    function set_my_bio($bio){
        $sql = "UPDATE `accounts_bio` SET `biography`=? WHERE UserName=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$bio, $this->user["UserName"]]);
    }
    function add_picture($state, $base64, $set_id){
        $sql = "UPDATE `images` SET `profile_picture`=? WHERE UserName=? AND set_id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$base64,$this->user["UserName"], $set_id]);
        if ($set_id == 1){
        $sql = "UPDATE `accounts_bio` SET have_pro_pic=? WHERE UserName=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(["true",$this->user["UserName"]]);
        }
    }
    function update_lname($lname){
        $sql = "UPDATE `accounts_basic` SET `LastName`=? WHERE UserName=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$lname, $this->user["UserName"]]);
    }
    function update_fname($fname){
        $sql = "UPDATE `accounts_basic` SET `FirstName`=? WHERE UserName=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$fname, $this->user["UserName"]]);
    }
    function update_email($email){
        $sql = "UPDATE `accounts_basic` SET `Email`=? WHERE UserName=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$email, $this->user["UserName"]]);
    }
    function update_password($password){
        $sql = "UPDATE `accounts_basic` SET `PassWord`=? WHERE UserName=?";
        $stmt = $this->conn->prepare($sql);
        $password = password_hash($password, PASSWORD_DEFAULT);
        $stmt->execute([$password, $this->user["UserName"]]);
    }
    function update_username($username){
        $sql = "UPDATE `accounts_basic` SET `UserName`=? WHERE UserName=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$username, $this->user["UserName"]]);
        $sql = "UPDATE `accounts_bio` SET `UserName`=? WHERE UserName=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$username, $this->user["UserName"]]);$sql = "UPDATE `accounts_basic` SET `UserName`=? WHERE UserName=?";
        $sql = "UPDATE `images` SET `UserName`=? WHERE UserName=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$username, $this->user["UserName"]]);
    }

    /* retreives user account details */
    function get_details($username)
    {
        $sql = "SELECT FirstName, LastName, UserName, Email FROM accounts_basic WHERE UserName=:username";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":username", $username, PDO::PARAM_STR);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return ($results);
    }
}//end of class get_information

class delete_this_account extends connect{

    function __construct ($dsn, $user, $password, $user_name){
        parent::__construct($dsn, $user, $password);
        $sqla = "DELETE FROM `accounts_basic` WHERE UserName=?";
        $sqlb = "DELETE FROM `accounts_bio` WHERE UserName=?";
        $sqlc = "DELETE FROM `images` WHERE UserName=?";
        $stmt = $this->conn->prepare($sqla);
        $stmt->execute([$user_name]);
        $stmt = $this->conn->prepare($sqlb);
        $stmt->execute([$user_name]);
        $stmt = $this->conn->prepare($sqlc);
        $stmt->execute([$user_name]);
        echo "account deleted";
    }
}



class get_tag_info extends connect{
    public $tag_lib;
    public $my_tags;

    function __construct ($dsn, $user, $password, $username){
        parent::__construct($dsn, $user, $password);
        $sql = "SELECT * FROM `tags_library`";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $this->tag_lib = $stmt->fetchAll();
        // $this->get_my_tags($username); 
        $sql = "SELECT * FROM `my_tags` WHERE UserName=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$username]);
        $this->my_tags = $stmt->fetchAll(); 
    }

    function add_tag($username, $tag){
        $sql = "SELECT * FROM `my_tags` WHERE UserName=? AND set_tag=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$username, $tag]);
        $find = $stmt->fetch();
        if ($find && $find["set_tag"] == $tag){
            $sql = "DELETE FROM `my_tags` WHERE UserName=? AND set_tag=?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$username, $tag]);
            // echo $tag,"removed";
        }else {
            $sql = "INSERT INTO `my_tags`(`UserName`, `set_tag`) VALUES (?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$username, $tag]);
            // echo $tag,"added";
        }
        $sql = "SELECT * FROM `my_tags` WHERE UserName=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$username]);
        $this->my_tags = $stmt->fetchAll(); 
    }
}