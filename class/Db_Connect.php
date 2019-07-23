<?php
class Db_Connect{

	private $conn;

	//Blank Constructor
	function __construct(){

	}

	//Database Connection
	function databaseConnect(){

		$this->conn = new PDO("mysql:host=localhost;dbname=mailer","root","");
		return $this->conn;
	}
}
?>