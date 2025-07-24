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
$topic = mysqli_real_escape_string($conn, $_POST['topic']);
$date = $_POST['date'];
$question = mysqli_real_escape_string($conn, $_POST['question']);
$AnswerID = $_POST['AnswerID'];
$Answer = mysqli_real_escape_string($conn, $_POST['Answer']);
$EntryID = $_POST['EntryID'];
$length1 = $_POST['length1'];
$length2 = $_POST['length2'];
$avatar = mysqli_real_escape_string($conn, $_POST['avatar']);

switch($mode){
	case "checkUpdates":

	$getQuestionsLength = "SELECT count(Entry) FROM BoardQuestions WHERE EntryTopic = '$topic';";
	$getAnswersLength = "SELECT count(Answer) FROM BoardAnswers WHERE AnswerTopic = '$topic';";

	$result1 = $conn->query($getQuestionsLength);
	$result2 = $conn->query($getAnswersLength);

	$row1 = $result1->fetch_assoc();
	$row2 = $result2->fetch_assoc();
	$lengthOne = $row1["count(Entry)"];
	$lengthTwo = $row2["count(Answer)"];

	if ($lengthOne != $length1 || $lengthTwo != $length2){
		echo "updates";
	}
	else echo "noUpdates";

	break;

	case "addQuestion":

	session_start();

	$user = $_SESSION['user'];
	$fullName = $_SESSION['firstname'] . ' ' . $_SESSION['lastname'];
	$newQuestion = "INSERT INTO BoardQuestions (EntryTopic, Entry, EntryDate, Email, FullName, Avatar) VALUES ('$topic', '$question', '$date', '$user', '$fullName', '$avatar');";
	$result = $conn->query($newQuestion);

	if ($result) echo "Successful";
	else echo "Not Successful";

	break;

	case "addAnswer":

	session_start();

	$user = $_SESSION['user'];
	$fullName = $_SESSION['firstname'] . ' ' . $_SESSION['lastname'];
	$newAnswer = "INSERT INTO BoardAnswers (AnswerID, Answer, AnswerTopic, Email, FullName, Avatar) VALUES ('$EntryID', '$Answer', '$topic', '$user', '$fullName', '$avatar');";
	$result = $conn->query($newAnswer);

	if ($result) echo "Successful";
	else echo "Not Successful";

	break;

	case "getQuestions":

	$getQuestions = "SELECT Entry, EntryDate, EntryID, FullName, Avatar FROM BoardQuestions WHERE EntryTopic = '$topic';";
	$result = $conn->query($getQuestions);

	$Questions = array();

	if ($result->num_rows > 0){
		while ($row = $result->fetch_assoc()){
			array_push($Questions, $row);
		}
		echo json_encode($Questions);
	}
	else echo "No results";

	break;

	case "getAnswers":

	$getAnswers = "SELECT Answer, FullName, Avatar FROM BoardAnswers WHERE AnswerID = '$AnswerID';";
	$result = $conn->query($getAnswers);

	$Answers = array();

	if ($result->num_rows > 0){
		while ($row = $result->fetch_assoc()){
			array_push($Answers, $row);
		}
		echo json_encode($Answers);
	}
	else echo "No results";

	break;

	case "addTopic":

	session_start();

	$addTopic = "INSERT INTO BoardTopics (Topic) VALUES ('$topic');";
	$result = $conn->query($addTopic);

	if ($result) echo "Successful";
	else echo "Not Successful";

	break;

	case "getTopics":

	$getTopics = "SELECT * FROM BoardTopics;";
	$result = $conn->query($getTopics);

	$Topics = array();

	if ($result->num_rows > 0){
		while ($row = $result->fetch_assoc()){
			array_push($Topics, $row);
		}
		echo json_encode($Topics);
	}
	else echo "No results";

	break;

}

$conn->close();
?>
