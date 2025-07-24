<?php 
  	require ("connect.php");
  	require ("uid.php");
	
	$DB = new Database;
    $conn = $DB->connect();

    if(isset($_POST['btnsubmit'])){
    	$school = addslashes($_POST['sc']);
		$sc_role = addslashes($_POST['sc_role']);

		if ($sc_role == "Administrator") {
			$sql = "SELECT * FROM Schools WHERE SchoolName = '$school';";
			$resl = $DB->read($sql);
	        if ($resl) {
	        	$queryDataI = mysqli_num_rows($resl);
	        	if ($queryDataI > 0){
	        		while ($row = mysqli_fetch_assoc($resl)) {
	        			$x = htmlspecialchars($row['Uid']);
		        		$sls = "SELECT * FROM SchoolAdmins WHERE SchoolUid = '$x';";
						$reslt = $DB->read($sls);
				        if ($reslt) {
				        	$queryDataT = mysqli_num_rows($reslt);
				        	if ($queryDataT > 0){
				        		header("location: ../beforeregister.php?error=rs");
								die();
							}
							else{
								header("location: ../registerSA.php?sid=$x");
								die();
								echo "no";
							}
						}
					}
				}
				else{
					$schoolid = createid();
					$today = date("m-d-y");
					$newsql = "INSERT INTO Schools (Uid, SchoolName, Joined, Status) VALUES ('$schoolid', '$school', '$today', 'Active');";
					$DB->save($newsql);
					header("location: ../registerSA.php?sid=$schoolid");
					die();
				}
			}
		}
		else{
			$sql = "SELECT * FROM Schools WHERE SchoolName = '$school';";
			$resl = $DB->read($sql);
	        if ($resl) {
	        	$queryDataI = mysqli_num_rows($resl);
	        	if ($queryDataI > 0){
	        		while ($row = mysqli_fetch_assoc($resl)) {
	        			$sid = htmlspecialchars($row['Uid']);
		        		header("location: ../register.php?sid=$sid");
						die();
					}
				}
				else{
					$schoolid = createid();
					$today = date("m-d-y");
					$newsql = "INSERT INTO Schools (Uid, SchoolName, Joined, Status) VALUES ('$schoolid', '$school', '$today', 'Active');";
					$DB->save($newsql);
					header("location: ../register.php?sid=$schoolid");
					die();
				}
			}
		}
    }

    function createid(){
		$length = rand(4, 19);
		$number = "";
		for ($i=0; $i < $length; $i++) { 
			$new_rand = rand(0, 9);
			$number = $number . $new_rand;
		}
		return $number;
	}
?>