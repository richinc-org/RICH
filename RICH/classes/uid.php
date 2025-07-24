<?php 
	class Uid{
		public function checkUID($uid){
			$firstsql = "SELECT * FROM Students WHERE Uid = '$uid';";
	        $DB = new Database;
	        $DB ->read($firstsql);
	        $result = "";
	        if ($result) {
				$queryData = mysqli_num_rows($result);
				if ($queryData > 0){
					$result = "b";
					return $result;
				}
				else{
					$result = "g";
					return $result;
				}
			}
			else{
				$result = "g";
				return $result;
			}			
		}
	}
?>