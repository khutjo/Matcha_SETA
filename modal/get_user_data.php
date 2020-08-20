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
			$get_loc = $my_connection->prepare("SELECT street, city, country FROM location WHERE UserName = :username");
			$get_loc->bindValue(':username', $data);
			$get_loc->execute();
			$location = $get_loc->fetchAll(PDO::FETCH_ASSOC);

			$more_data = array_merge($profile, $images, $basic_shit, $location);

			echo json_encode($more_data);
			// echo json_encode(array($interests));
		}