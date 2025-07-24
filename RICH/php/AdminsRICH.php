<?php
$servername = "mysqlcluster9.registeredsite.com";
$username = "rich_main";
$password = "Ey_123123";
$dbname = "rich_users";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

#Login/Register Form Variables

$mode = mysqli_real_escape_string($conn, $_POST['mode']);
$fn = mysqli_real_escape_string($conn, $_POST['fn']);
$ln = mysqli_real_escape_string($conn, $_POST['ln']);
$dob = mysqli_real_escape_string($conn, $_POST['dob']);
$grade = mysqli_real_escape_string($conn, $_POST['grade']);
$Email = mysqli_real_escape_string($conn, $_POST['email']);
$pass = mysqli_real_escape_string($conn, $_POST['pass']);
$passC = mysqli_real_escape_string($conn, $_POST['passC']);


switch($mode){
	case "Register":
	$createAccount = "INSERT INTO Admins (FirstName, LastName, DOB, EmailAddress, Pass) VALUES ('$fn', '$ln', '$dob', '$Email', '$pass');";
	#$createAccount = $conn->prepare("CALL spCreateAdminAccount(?, ?, ?, ?, ?)");
	#$createAccount->bind_param("sssss", $fn, $ln, $dob, $Email, $pass);
	if (mysqli_query($conn, $createAccount)){
	  echo "New record created successfully";
	} else {
	  echo "Error: " . $createAccount . "<br>" . mysqli_error($conn);
	}
	$createAccount->execute();
	$createAccount->close();

	break;

	case "CheckEmail":

	$verifyEmail = $conn->prepare("SELECT EmailAddress FROM Admins WHERE EmailAddress = (?)");
	$verifyEmail->bind_param("s", $Email);
	$verifyEmail->execute();
	$result = $verifyEmail->get_result()->fetch_assoc();

	if ($result->num_rows > 0){

		echo "exists";
	}

	else{
		echo "Email Doesn't Exist";
	}

	$verifyEmail->close();

	break;

	case "Login":

	$login = $conn->prepare("SELECT EmailAddress, Pass FROM Admins WHERE EmailAddress = (?) AND Pass = (?)");
	$login->bind_param("ss", $Email, $pass);
	$login->execute();
	$row = $login->get_result()->fetch_assoc();

	if ($Email == $row['EmailAddress'] && $pass == $row['Pass']){
		echo "User Exists";
		session_start();
		$_SESSION['admin'] = $Email;
    $_SESSION['passAdmin'] = $pass;
	}

	else{
		echo "User Doesn't Exist";
	}

	$login->close();

	break;

	case "getAllStudents":

	session_start();

	$getAllStudents = $conn->prepare("SELECT * FROM Students");
	$getAllStudents->execute();
	$result = $getAllStudents->get_result();
	$students = array();

	if ($result->num_rows > 0){
		while ($row = $result->fetch_assoc()){
			array_push($students, $row);
		}
		echo json_encode($students);
	}
	else echo "No results";

	$getAllStudents->close();

	break;

	case "deleteStudent":

	$deleteStudent = $conn->prepare("DELETE FROM Students WHERE EmailAddress = (?)");
	$deleteStudent->bind_param("s", $Email);
	$deleteStudent->execute();
	$deleteStudent->close();

	break;

	case "updateStudent":

	$updateStudent = $conn->prepare("UPDATE Students SET FirstName = (?), LastName = (?), DOB = (?), GradeLevel = (?), Pass = (?) WHERE EmailAddress = (?)");
	$updateStudent->bind_param("ssssss", $fn, $ln, $dob, $grade, $pass, $Email);
	$updateStudent->execute();
	$updateStudent->close();

	break;

	case "getAdminInfo":

	session_start();

	$adminInfo = $conn->prepare("SELECT FirstName FROM Admins WHERE EmailAddress = (?)");
	$adminInfo->bind_param("s", $_SESSION['admin']);
	$adminInfo->execute();

	$row = $adminInfo->get_result()->fetch_assoc();

	$firstName = $row['FirstName'];

	//echo $firstName;

	echo "Admin";

	$adminInfo->close();

	break;

	case "viewStudent":

	session_start();

	$_SESSION['studentEmail'] = $Email;

	break;

	case "getEmail":

	session_start();

	echo $_SESSION['studentEmail'];

	break;

	case "getProfileData":

	session_start();

	$getProfileData = $conn->prepare("SELECT FirstName, LastName, DOB, EmailAddress, GradeLevel FROM Students WHERE EmailAddress = (?)");
	$getProfileData->bind_param("s", $Email);
	$getProfileData->execute();
	$row = $getProfileData->get_result()->fetch_assoc();

	$profileData = array();
	array_push($profileData, $row);

	echo json_encode($profileData);

	$getProfileData->close();

	break;

	case "incrementGame":

	$incrementGame = $conn->prepare("UPDATE Statistics SET GameCounter = GameCounter + 1");
	$incrementGame->execute();
	$incrementGame->close();

	break;

	case "incrementResult":

	$gameResult = mysqli_real_escape_string($conn, $_POST['gameResult']);
	$s = "UPDATE Statistics SET " . "`" . $gameResult . "`" . " = " . "`" . $gameResult . "`" . " + 1 WHERE ID = 1";
	//echo $s;
	$incrementResult = $conn->prepare($s);
	$incrementResult->execute();
	$incrementResult->close();

	break;

	case "getCounters":

	$resultsCounter = $conn->prepare("SELECT * FROM Statistics WHERE ID = 1");
	$resultsCounter->execute();
	$row = $resultsCounter->get_result()->fetch_assoc();

	$resultsData = array();
	array_push($resultsData, $row);

	echo json_encode($resultsData);

	$resultsCounter->close();

	break;

	case "Logout":

	session_start();

	if (isset($_SESSION['admin']) && isset($_SESSION['passAdmin'])){
		unset($_SESSION['admin']);
  	unset($_SESSION['passAdmin']);
  	session_destroy();
		echo "LoggedOut";
	}
	else {
		echo "NoUser";
	}
	break;

}

$conn->close();
?>
