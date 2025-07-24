<?php 
	class Login{
		public function checkUserId($uid){
			$sql = "SELECT Uid FROM SuperAdm WHERE Uid = '$uid'";

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

		public function checkAdminId($uid){
			$sql = "SELECT Uid FROM SchoolAdmins WHERE Uid = '$uid'";

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