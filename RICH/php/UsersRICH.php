<?php
require("../classes/connect.php");
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

if(isset($_POST['mode'])) {
$mode = mysqli_real_escape_string($conn, $_POST['mode']);
}
if(isset($_POST['type'])) {
$type = mysqli_real_escape_string($conn, $_POST['type']);
}
if(isset($_POST['fn'])) {
$fn = mysqli_real_escape_string($conn, $_POST['fn']);
}
if(isset($_POST['ln'])) {
$ln = mysqli_real_escape_string($conn, $_POST['ln']);
}
if(isset($_POST['dob'])) {
$dob = mysqli_real_escape_string($conn, $_POST['dob']);
}
if(isset($_POST['level'])) {
$level = mysqli_real_escape_string($conn, $_POST['level']);
}
if(isset($_POST['pr'])) {
$pr = mysqli_real_escape_string($conn, $_POST['pr']);
}
if(isset($_POST['email'])) {
$Email = mysqli_real_escape_string($conn, $_POST['email']);
}
if(isset($_POST['pass'])) {
$pass = mysqli_real_escape_string($conn, $_POST['pass']);
}
if(isset($_POST['passC'])) {
$passC = mysqli_real_escape_string($conn, $_POST['passC']);
}
if(isset($_POST['avatar'])) {
$avatar = mysqli_real_escape_string($conn, $_POST['avatar']);
}
#Contact Form Variables

if(isset($_POST['name'])) {
$name = mysqli_real_escape_string($conn, $_POST['name']);
}
if(isset($_POST['mail'])) {
$mail = mysqli_real_escape_string($conn, $_POST['mail']);
}
if(isset($_POST['mail'])) {
$subject = mysqli_real_escape_string($conn, $_POST['subject']);
}
if(isset($_POST['mail'])) {
$message = mysqli_real_escape_string($conn, $_POST['message']);
}

session_start();

switch($mode){
	case "Register":
	$createAccount = "INSERT INTO Students (FirstName, LastName, DOB, GradeLevel, Principle, EmailAddress, Pass) VALUES ('$fn', '$ln', '$dob', '$level', '$pr', '$Email', '$pass')";
	if (mysqli_query($conn, $createAccount)){
	  echo "New record created successfully";
	} else {
	  echo "Error: " . $createAccount . "<br>" . mysqli_error($conn);
	}
	#$createAccount = $conn->prepare("CALL spCreateAccount(?, ?, ?, ?, ?, ?, ?)");
	#$createAccount->bind_param("sssssss", $fn, $ln, $dob, $level, $pr, $Email, $pass);
	$createAccount->execute();
	$createAccount->close();

	break;

	case "CheckEmail":

	$verifyEmail = $conn->prepare("SELECT * FROM Students WHERE EmailAddress = (?)");
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

	$login = $conn->prepare("SELECT EmailAddress, Pass, FirstName, LastName FROM Students WHERE EmailAddress = (?)");
	$db = new Database;
	$conn = $db->connect();
	$result = $db->read($login);
    if ($result) {
        $queryData = mysqli_num_rows($result);
        if ($queryData > 0){
            while ($row = mysqli_fetch_assoc($result)) {
				$pwdHashed = $row['Pass'];
				if ($Email == $row['EmailAddress']){
					if(password_verify($pass, $pwdHashed)){
						session_start();
						$_SESSION['userName'] = $Email;
						$_SESSION['pass'] = $pass;
						$_SESSION['firstname'] = $row['FirstName'];
						$_SESSION['lastname'] = $row['LastName'];
					}
				}
			}
		}
	}

	else{
		echo "User Doesn't Exist";
	}

	$login->close();

	break;

	case "getInfo":

	session_start();

	$userInfo = $conn->prepare("SELECT FirstName FROM Students WHERE EmailAddress = (?)");
	$userInfo->bind_param("s", $_SESSION['userName']);
	//$email = "dawsonjacqueline1@gmail.com";
	//$userInfo->bind_param("s", $email);
	$userInfo->execute();
	$row = $userInfo->get_result()->fetch_assoc();

	$firstName = $row['FirstName'];
	echo $firstName;

	$userInfo->close();

	break;

	case "getProfileData":

	session_start();

	$getProfileData = $conn->prepare("SELECT FirstName, LastName, DOB, GradeLevel, EmailAddress, Avatar FROM Students WHERE EmailAddress = (?)");
	$getProfileData->bind_param("s", $_SESSION['userName']);
	$getProfileData->execute();
	$row = $getProfileData->get_result()->fetch_assoc();

	$profileData = array();
	array_push($profileData, $row);

	echo json_encode($profileData);

	$getProfileData->close();

	break;

	case "addAvatar":

	session_start();
	$user = $_SESSION['userName'];

	$addAvatar = "UPDATE Students SET Avatar = '".$avatar."' WHERE EmailAddress = '".$user."';";
	$addAvatar .= "UPDATE BoardQuestions SET Avatar = '".$avatar."' WHERE Email = '".$user."';";
	$addAvatar .= "UPDATE BoardAnswers SET Avatar = '".$avatar."' WHERE Email = '".$user."';";

	$result = mysqli_multi_query($conn, $addAvatar);

	if ($result) echo "Successful";
	else echo "Not Successful";

	break;

	case "Logout":

	session_start();

	if (isset($_SESSION['userName']) && isset($_SESSION['pass'])){
		unset($_SESSION['userName']);
  		unset($_SESSION['pass']);
		unset($_SESSION['Submissions']);
		unset($_SESSION['courseArray']);
		unset($_SESSION['courseList']);
  		session_destroy();
		echo "LoggedOut";
	}
	else {
		echo "NoUser";
	}
	break;

	case "refresh":

	session_start();

	unset($_SESSION['Submissions']);
	unset($_SESSION['courseArray']);
	unset($_SESSION['courseList']);

	break;

	case "sendMail":

	$headers .= 'From: ' . $mail . "\r\n";
	$message = wordwrap($message,70);

	mail("contact@richinc.org", $subject, $message, $headers);
	echo "Test";

	break;

	default:
		//echo "default";
}

$conn->close();
?>
