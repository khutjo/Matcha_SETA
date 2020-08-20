<?php

include "connect.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

class setup_data_base extends connect {

    function create(){
    $this->conn->exec("CREATE DATABASE IF NOT EXISTS Matcha_db");
        $sql = "CREATE TABLE IF NOT EXISTS Matcha_db.accounts_basic (
                ID INT NOT NULL AUTO_INCREMENT,
                LastName varchar(15) NOT NULL,
                FirstName varchar(15) NOT NULL,
                Email varchar(55) NOT NULL,
                UserName varchar(15) NOT NULL,
                `PassWord` varchar(515) NOT NULL,
                last_login varchar(512) DEFAULT 'never',
                PRIMARY KEY (ID))";
        $this->conn->exec($sql);
        $sql = "CREATE TABLE IF NOT EXISTS Matcha_db.unverified (
                ID INT NOT NULL AUTO_INCREMENT,
                LastName varchar(15) NOT NULL,
                FirstName varchar(15) NOT NULL,
                Email varchar(55) NOT NULL,
                UserName varchar(15) NOT NULL,
                `PassWord` varchar(515) NOT NULL,
                enter_key varchar(512) NOT NULL,
                otp_pin varchar(512) NOT NULL,
                PRIMARY KEY (ID))";
        $this->conn->exec($sql);
        $sql = "CREATE TABLE IF NOT EXISTS Matcha_db.forgot_password (
                ID INT NOT NULL AUTO_INCREMENT,
                UserName varchar(15) NOT NULL,
                Email varchar(55) NOT NULL,
                enter_key varchar(512) NOT NULL,
                otp_pin varchar(512) NOT NULL,
                PRIMARY KEY (ID))";
        $this->conn->exec($sql);
  
        $sql = "CREATE TABLE IF NOT EXISTS Matcha_db.accounts_bio (
                ID INT NOT NULL AUTO_INCREMENT,
                UserName varchar(15) NOT NULL,
                gender varchar(15) DEFAULT 'other',
                age INT NOT NULL DEFAULT 18,
                preferences varchar(55) DEFAULT 'other',
                biography varchar(500) DEFAULT 'I am not a bot i promise',
                have_pro_pic varchar(5) DEFAULT 'false',
                fame_rating INT DEFAULT 0,
                PRIMARY KEY (ID))";
        $this->conn->exec($sql);

        $sql = "CREATE TABLE IF NOT EXISTS Matcha_db.images(
                ID INT NOT NULL AUTO_INCREMENT,
                UserName varchar(15) NOT NULL,
                set_id INT NOT NULL,
                `state` varchar(15),
                profile_picture blob(10000000) NOT NULL,
                PRIMARY KEY (ID))";
        $this->conn->exec($sql);

        /* Creates chat table */

        $sql = "CREATE TABLE IF NOT EXISTS Matcha_db.chats(
                ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                UserName VARCHAR(25) NOT NULL,
                sender VARCHAR(25) NOT NULL,
                `message` TEXT NOT NULL,
                time_sent TIMESTAMP
                )";
        $this->conn->exec($sql);

        $sql = "CREATE TABLE IF NOT EXISTS Matcha_db.people_you_like(
                ID INT NOT NULL AUTO_INCREMENT,
                UserName varchar(15) NOT NULL,
                liked varchar(15) NOT NULL,
                PRIMARY KEY (ID))";
        $this->conn->exec($sql);
        
        $sql = "CREATE TABLE IF NOT EXISTS Matcha_db.connections(
                ID INT NOT NULL AUTO_INCREMENT,
                user1 varchar(15) NOT NULL,
                user2 varchar(15) NOT NULL,
                PRIMARY KEY (ID))";
        $this->conn->exec($sql);
        $sql = "CREATE TABLE IF NOT EXISTS Matcha_db.block_list(
                ID INT NOT NULL AUTO_INCREMENT,
                blocker varchar(15) NOT NULL,
                blocked varchar(15) NOT NULL,
                PRIMARY KEY (ID))";
        $this->conn->exec($sql);

        // $sql = "CREATE TABLE IF NOT EXISTS Matcha_db.blocked(
        //         ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        //         UserName VARCHAR(25) NOT NULL,
        //         blocked VARCHAR(25) NOT NULL,
        //         )";
        // $this->conn->exec($sql);
        
        /* creates tags table */
        $sql = "CREATE TABLE IF NOT EXISTS Matcha_db.my_tags(
                ID INT NOT NULL AUTO_INCREMENT,
                UserName varchar(15) NOT NULL,
                set_tag varchar(15) NOT NULL,
                PRIMARY KEY (ID))";
        $this->conn-> exec($sql);
        $sql = "CREATE TABLE IF NOT EXISTS Matcha_db.tags_library(
                ID INT NOT NULL AUTO_INCREMENT,
                set_tag varchar(15) NOT NULL,
                PRIMARY KEY (ID))";
        $this->conn->exec($sql);
		
	// 	$sql = "INSERT INTO Matcha_db.tags_library (`set_tag`) VALUE (?)";
        // $stmt = $this->conn->prepare($sql);
        // $stmt->execute(["sports"]);
        // $stmt->execute(["coding"]);
        // $stmt->execute(["cars"]);
        // $stmt->execute(["guns"]);
        // $stmt->execute(["movies"]);
        // $stmt->execute(["music"]);
        // $stmt->execute(["games"]);
        // $stmt->execute(["pc muster_race"]);
        // $stmt->execute(["console_peasent"]);
        // $stmt->execute(["gold diggers"]);
        // $stmt->execute(["hit and run"]);
        // $stmt->execute(["one night stand"]);
        // $stmt->execute(["dancing"]);

        $sql = "CREATE TABLE IF NOT EXISTS Matcha_db.chat_message(
                `chat_message_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `to_user_id` int(11) NOT NULL,
                `from_user_id` int(11) NOT NULL,
                `chat_message` text NOT NULL,
                `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `status` int NOT NULL
                )";
         $this->conn->exec($sql);

        $sql = "CREATE TABLE IF NOT EXISTS Matcha_db.login_details(
                `login_details_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `id` int(11) NOT NULL,
                `last_activity` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `is_type` enum('no','yes') NOT NULL
              )";
        $this->conn->exec($sql);

        $sql= "CREATE TABLE IF NOT EXISTS Matcha_db.views(
                views_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                viewer_id int(11) NOT NULL,
                id_of_viewed_p int NOT NULL,
                vd_user_name text NOT NULL,
                v_user_name text NOT NULL)";
        $this->conn->exec($sql);

        $sql= "CREATE TABLE IF NOT EXISTS Matcha_db.notification(
                id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                user_1_id int(11) NOT NULL,
                user_2_id int(11) NOT NULL,
                user_1_name text NOT NULL,
                messages text NOT NULL,
                to_read text NOT NULL,
                `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
                )";
        $this->conn->exec($sql);
		$this->conn->exec($sql);
		$sql = "CREATE TABLE IF NOT EXISTS Matcha_db.location(
			`id` int(11) AUTO_INCREMENT PRIMARY KEY,
			`UserName` text not null,
			`city` text not null,
			`country` text not null,
			`street` text not null,
			`lat` text not null,
			`lon` text not null,
			`last_time` timestamp default current_timestamp
			)";
		$this->conn->exec($sql);
    }
}

$setup = new setup_data_base($dsn_new, $user, $password);

$setup->create();
echo "<br />database setup";
?>
<!DOCTYPE html>
<html>
<body>
    <br />
<a href="http://localhost:8080/phpmyadmin/sql.php">Go To Database</a>    
</body>
</html>