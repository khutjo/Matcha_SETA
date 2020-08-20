<?php
include "connect.php";

session_start();

function email_concat($enter_key, $otp){
    $head = "Verify your matcher email with this OTP:".$otp;
    $mid = "\nor ";
    $hype_link = "http://localhost/Matcha-master/index_php_files/link_Verify.php?enter_key=".$enter_key."&otp=".$otp;
    return (wordwrap($head.$mid.$hype_link));
}

function forgot_password_email_concat($enter_key, $otp){
    $head = "A password reset was requested for your matcha account if its not you disregard this email";
    $mid = "\n else click on the link ";
    $hype_link = "http://localhost/Matcha-master/index_php_files/forgot_password.php?enter_key=".$enter_key."&otp=".$otp;
    return (wordwrap($head.$mid.$hype_link));
}

class email_test extends connect {

    function check_db_email($email){
        $sql = "SELECT Email FROM accounts_basic WHERE Email=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        if ($user && $user['Email'] == $email){
            return (1);
        }
        $sql = "SELECT Email FROM unverified WHERE Email=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        if ($user && $user['Email'] == $email){
            return (1);
        }
        return (0);
    }
}

class username_test extends connect {

    function check_db_username($username){
        $sql = "SELECT UserName FROM accounts_basic WHERE UserName=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$username]);
        $user = $stmt->fetch();
        if ($user && $user['UserName'] == $username){
            return (1);
        }
        $sql = "SELECT UserName FROM unverified WHERE UserName=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$username]);
        $user = $stmt->fetch();
        if ($user && $user['UserName'] == $username){
            return (1);
        }
        return (0);
    }
}

class add_to_unverified extends connect {

    function add_user($fname, $lname, $email, $username, $password){
        $enter_key = substr(md5(time()),  -6, 6);
        $password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO `unverified`(`LastName`, `FirstName`, `Email`
        , `UserName`, `PassWord`, `enter_key`, `otp_pin`) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$fname, $lname, $email, $username, $password,$enter_key, "not set"]);
        $_SESSION["matcher"] = $enter_key;
        echo "inserted";
    }
}

class send_mail_verify extends connect {
    public $user;

    function __construct($dsn, $user, $password){
        parent::__construct($dsn, $user, $password);
        $sql = "SELECT * FROM `unverified` WHERE enter_key=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$_SESSION["matcher"]]);
        $this->user = $stmt->fetch();
        if ($this->user){
            $enter_key = substr(md5(time()),  -6, 6);
            $otp = substr(md5(time()),  -12, 6);
            $otp_hesh = password_hash($otp, PASSWORD_DEFAULT);
            $sql = "UPDATE `unverified` SET enter_key=?, otp_pin=? WHERE enter_key=?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$enter_key, $otp_hesh, $this->user['enter_key']]);
            mail($this->user["Email"], "Verify account", email_concat($enter_key, $otp));
            $_SESSION["matcher"] = $enter_key;
        // echo $enter_key," = ";
            return (1);
        }else{
            return (0);
        }

    }
}

class resend_verification_email extends connect {

    function __construct ($dsn, $user, $password){
        parent::__construct($dsn, $user, $password);
        $sql = "SELECT * FROM `unverified` WHERE enter_key=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$_SESSION["matcher"]]);
        $user = $stmt->fetch();
        if ($user){
        $enter_key_new = substr(md5(time()),  -6, 6);
        $otp = substr(md5(time()),  -12, 6);
        $otp_hash = password_hash($otp, PASSWORD_DEFAULT);
        $sql = "UPDATE `unverified` SET enter_key=?, otp_pin=? WHERE enter_key=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$enter_key_new, $otp_hash, $_SESSION["matcher"]]);
        mail($user["Email"], "Verify account", email_concat($enter_key_new,$otp));
        $_SESSION["matcher"] = $enter_key_new;
        echo "cool";
    }
        // echo $enter_key_new;
    }
}

function get_inmage_64(){
    $myfile = fopen("../media/resources/nopropic.png", "r") or die("Unable to open file!");
    $base64 = base64_encode(fread($myfile,filesize("../media/resources/nopropic.png")));
    fclose($myfile);
    return ("data:image/png;base64,".$base64);
}

class verify_OTP extends connect {
    public $velid;
    function __construct ($dsn, $user, $password, $enter_key, $otp_pin){
        parent::__construct($dsn, $user, $password);
        $sql = "SELECT * FROM `unverified` WHERE enter_key=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$enter_key]);
        $user = $stmt->fetch();
        if ($user && password_verify($otp_pin, $user["otp_pin"])){
            $sql = "INSERT INTO `accounts_basic`(`LastName`, `FirstName`, `Email`, `UserName`, `PassWord`, `last_login`) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$user["LastName"], $user["FirstName"], $user["Email"], $user["UserName"], $user["PassWord"], "never"]);
            $sql = "INSERT INTO `accounts_bio`(`UserName`) VALUES (?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$user["UserName"]]);
            $sql = "INSERT INTO `images` (`UserName`, `set_id`, `state`, profile_picture) VALUES (?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$user["UserName"], 1, "main_blank", get_inmage_64()]);
            $stmt->execute([$user["UserName"], 2, "sub_blank_1", get_inmage_64()]);
            $stmt->execute([$user["UserName"], 3, "sub_blank_2", get_inmage_64()]);
            $stmt->execute([$user["UserName"], 4, "sub_blank_3", get_inmage_64()]);
            $stmt->execute([$user["UserName"], 5, "sub_blank_4", get_inmage_64()]);
            $sql = "DELETE FROM `unverified` WHERE otp_pin=?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$user["otp_pin"]]);
            $_SESSION["is_velidated"] = "true";
            $this->velid = 1;
            echo "all_set";
        }else{
            $this->velid = 0;
            echo "no";
        }
    }
}

class forgot_password extends connect {

    function __construct ($dsn, $user, $password, $email){
        parent::__construct($dsn, $user, $password);
        $sql = "SELECT * FROM `accounts_basic` WHERE Email=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        if ($user && $user["Email"] == $email){
            $enter_key = substr(md5(time()),  -6, 6);
            $otp_email = substr(md5(time()),  -12, 6);
            $otp_pin = password_hash($otp_email, PASSWORD_DEFAULT);
            $sql = "SELECT * FROM `forgot_password` WHERE Email=?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$email]);
            $user_forgot = $stmt->fetch();
            if ($user_forgot && $user_forgot["Email"] == $email){
                $sql = "UPDATE `forgot_password` SET `enter_key`=?,`otp_pin`=? WHERE Email=?";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([$enter_key, $otp_pin, $email]);
            }else {
                $sql = "INSERT INTO `forgot_password` (`UserName`, `Email`, `enter_key`, `otp_pin`) VALUES (?, ?, ?, ?)";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([$user["UserName"],$email, $enter_key, $otp_pin]);
            }
            mail($email, "Password reset", forgot_password_email_concat($enter_key, $otp_email));
            echo "its_cool";
        }else {
            echo "dont_know_you";
        }
    }
}

class check_enter_key extends connect {
    public $found = 0;

    function __construct ($dsn, $user, $password, $otp, $enterkey){
        parent::__construct($dsn, $user, $password);
        $sql = "SELECT * FROM `forgot_password` WHERE enter_key=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$enterkey]);
        $user = $stmt->fetch();
        if ($user && password_verify($otp, $user["otp_pin"])){
            $this->found = 1;
        }
    }
}

class save_password extends connect {
    public $saved = 0;

    function __construct ($dsn, $user, $password, $pass_in, $enterkey, $otp){
        parent::__construct($dsn, $user, $password);
        $sql = "SELECT * FROM `forgot_password` WHERE enter_key=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$enterkey]);
        $user = $stmt->fetch();
        if ($user  && password_verify($otp, $user["otp_pin"])){
            $pass_in = password_hash($pass_in, PASSWORD_DEFAULT);
            $sql = "UPDATE `accounts_basic` SET `PassWord`=? WHERE UserName=?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$pass_in,$user["UserName"]]);
            $sql = "DELETE FROM `forgot_password` WHERE enter_key=?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$enterkey]);
            $this->saved = 1;
            echo "its_cool";
        }else {echo "nope";}
    }
}
/*  */