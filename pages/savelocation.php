<?php
	require_once "../config/database.php";
	require_once "../config/connect.php";
	
	session_start();
	$user = $_SESSION['logged_in_user'];
	if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST))
	{
		$connection = new connect($dsn_new, $DB_USER, $password);
		$line = $connection->get_connection();
		$check_location = $line->prepare("DELETE from matcha_db.location where UserName = ?");
		$check_location->execute([$user]);
		echo $user;
		
		$insert_location_data = $line->prepare("insert into matcha_db.location set city=?, country=?, street = ?, UserName = ?, lon = ?, lat = ?");
		$insert_location_data->execute([$_POST['city'], $_POST['country'], $_POST['street'] , $user, $_POST['lon'], $_POST['lat']]);
	}