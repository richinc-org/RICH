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
$essay = mysqli_real_escape_string($conn, $_POST['essay']);
$project = mysqli_real_escape_string($conn, $_POST['projectName']);

$day = mysqli_real_escape_string($conn, $_POST['day']);
$date = mysqli_real_escape_string($conn, $_POST['date']);
$principles = mysqli_real_escape_string($conn, $_POST['pUsed']);
$added = mysqli_real_escape_string($conn, $_POST['added']);
$titles = mysqli_real_escape_string($conn, $_POST['titles']);

switch($mode){

	case "addProject":

	session_start();

	$user = $_SESSION['userName'];
	$addProject = $conn->prepare("INSERT INTO Projects (ProjectName, Essay, Student) VALUES (?, ?. ?)");
	$addProject->bind_param("sss", $project, $essay, $user);
	$addProject->execute();
	$addProject->close();

	break;

	case "getProjects":

	session_start();
	$getProjects = $conn->prepare("SELECT * FROM Projects WHERE Student = (?)");
	$getProjects->bind_param("s", $_SESSION['userName']);
	$getProjects->execute();
	$result = $getProjects->get_result();
	$projectsArray = array();

	if ($result->num_rows > 0){
		while ($row = $result->fetch_assoc()){
			array_push($projectsArray, $row);
		}
		echo json_encode($projectsArray);
	}
	$getProjects->close();

	break;

	case "getProjectsAdmin":

	$getProjects = $conn->prepare("SELECT * FROM Projects WHERE Student = (?)");
	$getProjects->bind_param("s", $_POST['email']);
	$getProjects->execute();
	$result = $getProjects->get_result();
	$projectsArray = array();

	if ($result->num_rows > 0){
		while ($row = $result->fetch_assoc()){
			array_push($projectsArray, $row);
		}
		echo json_encode($projectsArray);
	}
	$getProjects->close();

	break;

	case "getWritingsAdmin":

	$getWritings = $conn->prepare("SELECT * FROM Writings WHERE Student = (?)");
	$getWritings->bind_param("s", $_POST['email']);
	$getWritings->execute();
	$result = $getWritings->get_result();
	$writingsArray = array();

	if ($result->num_rows > 0){
		while ($row = $result->fetch_assoc()){
			array_push($writingsArray, $row);
		}
		echo json_encode($writingsArray);
	}
	$getWritings->close();

	break;

	case "addWriting":

	session_start();

	$user = $_SESSION['userName'];
	$addWriting = "INSERT INTO Writings (DayAdded, DateAdded, Title, Essay, Principles, Student, SavedOSubmitted) VALUES ('$day', '$date', '$titles', '$essay', '$principles', '$user', '$added')";
	if (mysqli_query($conn, $addWriting)){
	  echo;
	} else {
	  echo "Error: " . $addWriting . "<br>" . mysqli_error($conn);
	}
	#$addWriting->bind_param("sssssss", $day, $date, $titles, $essay, $principles, $user, $added);
	$addWriting->execute();
	$addWriting->close();

	break;
	
	case "getWritings":
	
	session_start();
	$user = $_SESSION['userName'];
	$getUserWritings = $conn->prepare("SELECT * FROM Writings WHERE SavedOSubmitted = (?) AND Student = (?)");
	$getUserWritings->bind_param("ss", $added, $user);
	$getUserWritings->execute();
	$result = $getUserWritings->get_result();
	
	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()) {
			echo $row["Title"] . "<br>";
		}
		else{
			echo "false";
		}
	}
	
	break;

	case "getWritingStatus":

	session_start();
	$user = $_SESSION['userName'];
	$getStatus = $conn->prepare("SELECT * FROM Writings WHERE DayAdded = (?) AND DateAdded = (?) AND Student = (?)");
	$getStatus->bind_param("sss", $day, $date, $user);
	$getStatus->execute();
	$result = $getStatus->get_result();

	if ($result->num_rows > 0){
		echo "false";
	}
	else{
		echo "true";
	}

	$getStatus->close();

	break;

	case "getProjectStatus":

	session_start();
	$user = $_SESSION['userName'];
	$getStatus = $conn->prepare("SELECT * FROM Projects WHERE ProjectName = (?) AND Student = (?)");
	$getStatus->bind_param("ss", $project, $user);
	$getStatus->execute();
	$result = $getStatus->get_result();

	if ($result->num_rows > 0){
		echo "false";
	}
	else{
		echo "true";
	}

	$getStatus->close();

	break;

}

$conn->close();
?>
