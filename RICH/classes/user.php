<?php 
	class User{
		public function getUserInfo($uid){
			$sql = "SELECT * FROM SuperAdm WHERE Uid = '$uid'";

			$conn = new Database;
			$read = $conn->read($sql);

			$queryResult = mysqli_num_rows($read);

			if ($queryResult > 0) {
				while ($row = mysqli_fetch_assoc($read)) {
					return $row;
				}
			}
			else{
				return false;
			}
		}

		public function getAdminInfo($uid){
			$sql = "SELECT * FROM SchoolAdmins WHERE Uid = '$uid'";

			$conn = new Database;
			$read = $conn->read($sql);

			$queryResult = mysqli_num_rows($read);

			if ($queryResult > 0) {
				while ($row = mysqli_fetch_assoc($read)) {
					return $row;
				}
			}
			else{
				return false;
			}
		}
	}
?>