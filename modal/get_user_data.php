<?php
	include_once "../config/connect_class.php";
	$data = file_get_contents("php://input");
	
	session_start();

		if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{
		
			$connection = new connect($DB_DSN, $DB_USER, $DB_PASSWORD);
			$my_connection = $connection->get_connection();
			
			$get_user = $my_connection->prepare("SELECT FirstName, LastName FROM accounts_basic WHERE UserName = :username");
			$get_user->bindValue(':username', $data);
			$get_user->execute();
			$basic_shit = $get_user->fetchAll(PDO::FETCH_ASSOC);

			$get_user = $my_connection->prepare("SELECT * FROM accounts_bio WHERE UserName = :username");
			$get_user->bindValue(':username', $data);
			$get_user->execute();
			$profile = $get_user->fetch(PDO::FETCH_ASSOC);

			$get_images = $my_connection->prepare("SELECT * FROM images WHERE UserName = :username");
			$get_images->bindValue(':username', $data);
			$get_images->execute();
			$images = $get_images->fetchAll(PDO::FETCH_ASSOC);
			

			/* fetch user location */
			$query= $my_connection->prepare("SELECT * FROM location WHERE UserName in (:usernamea, :usernameb)");
			$query->bindValue(':usernamea', $_SESSION["logged_in_user"]);
			$query->bindValue(':usernameb',  $data);
			$query->execute();
			$location = $query->fetchAll(PDO::FETCH_ASSOC);
		
			if (count($location) == 2){
				if (isset($location[0]["address"]))
					$origins = str_replace(" ","+",$location[0]["address"]);
				else 
					$origins=$location[0]["lat"].",".$location[0]["lon"];
				if (isset($location[1]["address"]))
					$destinations = str_replace(" ","+",$location[1]["address"]);
				else 
					$destinations=$location[1]["lat"].",".$location[1]["lon"];
					
				$data = file_get_contents("https://maps.googleapis.com/maps/api/distancematrix/json?units=matric&origins=".$origins."&destinations=".$destinations."&key=AIzaSyCyPPJAN_R1wNuzKbSa2SIjLk3i_nKl0Ak");
				$location_data["location"] = json_decode($data)->rows[0]->elements[0]->distance->text;
			}else{
				$location_data["location"] = "Not specified";
			}
			
			$more_data = array_merge($profile, $images, $basic_shit, $location_data);

			echo json_encode($more_data);
			// echo json_encode(array($interests));
		}