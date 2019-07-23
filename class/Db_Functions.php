<?php
/**
* Author: Lynford A. Lagondi
*/
	class Db_Functions{

		private $conn;

		//===========Constructor to link Database======
		function __construct(){

			require_once 'Db_Connect.php';
			$database = new Db_Connect();
			$this->conn = $database->databaseConnect();
		}	
		//==========End of Database link==================

		//=======Get all Custmer with email===========
		public function getAllCustomer($start,$limit){

			$SQL = "SELECT * FROM customer LIMIT $start, $limit";
			$stmt = $this->conn->prepare($SQL);
			$stmt->execute(array($start,$limit));
			$result = $stmt->fetchAll();
			return $result;
		}
		//===================End===================================
	}
?>