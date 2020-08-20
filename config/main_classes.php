<?php

include "connect.php";

class get_my_data extends connect{
    public $user;
    public $profile_info;
    public $profile_picture;
    public $get_other_profile_info;
    public $get_other_profile_pictures;

    function __construct ($dsn, $user, $password, $user_name){
        parent::__construct($dsn, $user, $password);
        $sql = "SELECT * FROM `accounts_bio` WHERE UserName=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$user_name]);
        $this->user = $stmt->fetch();
        $sql = "SELECT * FROM `accounts_basic` WHERE UserName=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$user_name]);
        $this->profile_info = $stmt->fetch();
        $sql = "SELECT * FROM `images` WHERE UserName=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$user_name]);
        $this->profile_pictures = $stmt->fetchAll();
    }
    function add_tags(){
        $sql =  "SELECT * FROM `my_tags` WHERE UserName = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$this->user['UserName']]);
        $str = $stmt->fetchALL();
 
    }
    // get_profile_basic=0am i  lucky0QuintonFemalemale[]
    function get_their_profiles($filter){
        // echo "  ",$filter,$this->user["UserName"],
        // "  ",$this->user["preferences"],"  ",
        // $this->user["gender"],"  ";
        $my_tags = $this->add_tags();
        $age_sql= " ORDER BY `accounts_bio`.age ASC";
        $famerating_sql= " ORDER BY `accounts_bio`.fame_rating ASC";
        // $visitage_sql= "ORDER BY `accounts_bio`.age ASC";
        $sql = "SELECT accounts_basic.UserName, accounts_bio.age, location.lon, 
        location.lat, accounts_bio.biography, images.profile_picture FROM `accounts_bio`
        LEFT JOIN `images` ON `accounts_bio`.UserName = `images`.UserName
        LEFT JOIN `accounts_basic` ON `accounts_basic`.UserName = `images`.UserName
        LEFT JOIN `location` ON `location`.UserName = `images`.UserName
        WHERE `accounts_bio`.UserName NOT IN (?) AND `images`.set_id=1
        AND `accounts_bio`.gender = ? AND `accounts_bio`.preferences = ?";
        // AND `accounts_bio`.fame_rating > 10";
        if ($filter == 1){
            $sql = $sql.$age_sql;
        }else if ($filter == 3){
            $sql = $sql.$famerating_sql;
        }else if ($filter == 4){
            $sql = "SELECT accounts_basic.UserName, images.profile_picture,
            accounts_bio.age,accounts_bio.biography FROM `views`
            LEFT JOIN `accounts_basic` ON `views`.v_user_name = `accounts_basic`.UserName
            LEFT JOIN `accounts_bio` ON `accounts_basic`.UserName = `accounts_bio`.UserName
            LEFT JOIN `images` ON `accounts_bio`.UserName = `images`.UserName
            WHERE `images`.set_id = 1 AND `views`.vd_user_name = ?
            ORDER BY `views`.views_id DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$this->user["UserName"]]);
            // echo $this->user["UserName"];
            $this->get_other_profile_info = $stmt->fetchAll();
        }else if (!is_numeric($filter)){
            echo "am i  lucky";
            $sql = "SELECT accounts_basic.UserName, images.profile_picture,
            accounts_bio.age,accounts_bio.biography FROM `accounts_bio`
            LEFT JOIN `accounts_basic` ON `accounts_bio`.UserName = `accounts_basic`.UserName
            LEFT JOIN `images` ON `accounts_basic`.UserName = `images`.UserName
            LEFT JOIN `my_tags` ON `my_tags`.UserName = `images`.UserName
            WHERE `accounts_bio`.UserName NOT IN (?) AND `accounts_bio`.gender = ? AND `accounts_bio`.preferences = ?";
            // // AND my_tags.set_tag = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$this->user["UserName"], $this->user["preferences"], $this->user["gender"]]);//, $filter]);
            // echo $this->user["UserName"], $this->user["preferences"], $this->user["gender"], $filter;
            $this->get_other_profile_info = $stmt->fetchAll();
        }

        if (is_numeric($filter) && $filter != 4){
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$this->user["UserName"], $this->user["preferences"], $this->user["gender"]]);
        $this->get_other_profile_info = $stmt->fetchAll();
        }
        // print_r($this->get_other_profile_info);
    }

    function get_other_profile_info($user){
        $sql = "SELECT * FROM `accounts_bio` WHERE UserName=?";
        // ORDER BY fame_rateing ASC
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$user]);
        $user = $stmt->fetch();
        echo $user["biography"],"=",$user["age"];
    }
    function my_interest($user){
        $sql = "SELECT * FROM `my_tags` WHERE UserName=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$user]);
        $this->interest = $stmt->fetchALL();
        $this->in_num = count($this->interest);
    }
}