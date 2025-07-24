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
$date = $_POST['date'];
$question = mysqli_real_escape_string($conn, $_POST['question']);
$AnswerID = $_POST['AnswerID'];
$Answer = mysqli_real_escape_string($conn, $_POST['Answer']);
$QuestionID = $_POST['QuestionID'];
$length1 = $_POST['length1'];
$length2 = $_POST['length2'];

switch($mode){
	case "checkUpdates":

	$getQuestionsLength = "SELECT count(Question) FROM ForumQuestions WHERE QuestionTopic = '$topic';";
	$getAnswersLength = "SELECT count(Answer) FROM ForumAnswers WHERE AnswerTopic = '$topic';";

	$result1 = $conn->query($getQuestionsLength);
	$result2 = $conn->query($getAnswersLength);

	$row1 = $result1->fetch_assoc();
	$row2 = $result2->fetch_assoc();
	$lengthOne = $row1["count(Question)"];
	$lengthTwo = $row2["count(Answer)"];

	if ($lengthOne != $length1 || $lengthTwo != $length2){
		echo "updates";
	}
	else echo "noUpdates";

	break;

	case "addQuestion":

	session_start();

	$user = $_SESSION['user'];
	$newQuestion = "INSERT INTO ForumQuestions (QuestionTopic, Question, QuestionDate, QuestionPerson) VALUES ('$topic', '$question', '$date', '$user');";
	$result = $conn->query($newQuestion);

	if ($result) echo "Successful";
	else echo "Not Successful";

	break;

	case "addAnswer":

	session_start();

	$user = $_SESSION['user'];
	$newAnswer = "INSERT INTO ForumAnswers (AnswerID, Answer, AnswerTopic, AnswerPerson) VALUES ('$QuestionID', '$Answer', '$topic', '$user');";
	$result = $conn->query($newAnswer);

	if ($result) echo "Successful";
	else echo "Not Successful";

	break;

	case "getQuestions":

	$getQuestions = "SELECT Question, QuestionDate, QuestionID FROM ForumQuestions WHERE QuestionTopic = '$topic';";
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

	$getAnswers = "SELECT Answer FROM ForumAnswers WHERE AnswerID = '$AnswerID';";
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
}

$conn->close();
?>
