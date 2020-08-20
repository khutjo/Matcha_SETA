<?php

include "database.php";

class connect {
    protected $conn;
    
    function __construct($dsnn, $user, $password){
        try{
            $this->conn = new PDO($dsnn, $user, $password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOException $e) {
            echo "<script type='text/javascript'>alert('unable to create account now try again later (947)');</script>";
        }
	}

	public function get_connection()
	{
		return ($this->conn);
	}
	
	function __destruct()
	{
		$this->conn = NULL;
	}
}

?>