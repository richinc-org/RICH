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

$mode = $_POST['mode'];
$topic = $_POST['topic'];
$AnswerID = $_POST['AnswerID'];
$Answer = mysqli_real_escape_string($conn, $_POST['Answer']);
$AssignmentID = $_POST['AssignmentID'];
$AssignmentName = mysqli_real_escape_string($conn, $_POST['AssignmentName']);
$turnedIN = $_POST['turnedIN'];

switch($mode){

	case "addSurveyResponse":

	session_start();

	$user = $_SESSION['user'];
	$newAnswer = "INSERT INTO Survey (AssignmentID, AssignmentName, Answer, AnswerTopic, AnswerPerson, TurnedIN) VALUES ('$AssignmentID', '$AssignmentName', '$Answer', '$topic', '$user', '$turnedIN');";
	$result = $conn->query($newAnswer);

	if ($result) echo "Successful";
	else echo "Not Successful";

	break;

	case "getTurnedIN":

	session_start();

	$user = $_SESSION['user'];
	$status = "SELECT TurnedIN FROM Survey WHERE AssignmentID = '".$AssignmentID."' AND AnswerPerson = '".$user."'";
	//echo $status;
	$result = $conn->query($status);
	$row = $result->fetch_assoc();

	$value = $row['TurnedIN'];

	echo $value;

	break;

	case "getBadges":

	session_start();

	$user = $_SESSION['user'];
	$badges = "SELECT AnswerTopic FROM Survey WHERE AnswerPerson = '".$user."'";
	//echo $status;
	$result = $conn->query($badges);

	$badgesArray = array();
	if ($result->num_rows > 0){
		while ($row = $result->fetch_assoc()){
			array_push($badgesArray, $row);
		}
		echo json_encode($badgesArray);
	}

	break;

	case "getBadgesAdmin":

	session_start();

	$user = $_SESSION['user'];
	$badges = "SELECT AnswerTopic FROM Survey WHERE AnswerPerson = '".$_POST['email']."'";
	//echo $status;
	$result = $conn->query($badges);

	$badgesArray = array();
	if ($result->num_rows > 0){
		while ($row = $result->fetch_assoc()){
			array_push($badgesArray, $row);
		}
		echo json_encode($badgesArray);
	}

	break;

}

$conn->close();
?>
