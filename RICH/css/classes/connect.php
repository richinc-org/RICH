<?php 

	class Database{

		private $servername = "mysqlcluster9.registeredsite.com";
		private $serverusername = "rich_main";
		private $dbpassword = "Ey_123123";
		private $dbname = "rich_users";

		function connect(){
			$error = "";
			$connection = mysqli_connect($this->servername, $this->serverusername, $this->dbpassword, $this->dbname);
			// Check connection
			if (!$connection) {
			  $error = die("Connection failed: " . mysqli_connect_error());
			}

			if(!$error == ""){
				echo $error;
			}
			else{
				return $connection;
			}
		}

		function read($query){
			$conn = $this->connect();
			$result = mysqli_query($conn, $query);
			return $result;
		}

		function save($query){
			$conn = $this->connect();
			$result = mysqli_query($conn, $query);
		}

	}
	
?>