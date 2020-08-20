<?php
include_once "../config/connect_class.php";
	$data = file_get_contents("php://input");
	session_start();

    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $connection = new connect($DB_DSN, $DB_USER, $DB_PASSWORD);
        $conn = $connection->get_connection();

        /* fetch user interests or tags */
        $get_interests = $conn->prepare("SELECT * FROM my_tags WHERE UserName = :username");
        $get_interests->bindValue(':username', $data);
        $get_interests->execute();
        $interests = $get_interests->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($interests);
    }