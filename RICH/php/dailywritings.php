<?php
	session_start();
  	require ("../classes/connect.php");
  	require ("../classes/uid.php");
	
	$DB = new Database;
    $conn = $DB->connect();
	
	if(isset($_POST['save'])){
		$title = addslashes($_POST['artTitle']);
		$text = addslashes($_POST['articletext']);
		$principle = addslashes($_POST['principle']);
		$author = addslashes($_SESSION["userName"]);
		$useruid = $_SESSION['uid'];

		$aid = addslashes($_POST['id']);
		if ($aid == "") {
			$aid = createid();
		}

		if (emptyArticleInput($title, $text) !== false) {
			header("location: ../Account/weekly-writings.php?error=emptyinput");
			die();
		}
		if (idExists($conn, $title, $text, $author, $aid) !== false) {
			header("location: ../Account/weekly-writings.php");
			die();
		}
		createNewSavedArticle($conn, $useruid, $title, $text, $principle, $author, $aid);
	}
	else if(isset($_POST['submit'])){

		$title = addslashes($_POST['artTitle']);
		$text = addslashes($_POST['articletext']);
		$principle = addslashes($_POST['principle']);
		$author = addslashes($_SESSION["userName"]);
		$useruid = $_SESSION['uid'];

		$aid = addslashes($_POST['id']);
		if ($aid == "") {
			$aid = createid();
		}

		/*if (emptyArticleInput($title, $text) !== false) {
			header("location: ../Account/weekly-writings.php?error=emptyinput");
			die();
		}*/

		if (storyExists($conn, $title, $text, $author, $aid) !== false) {
			header("location: ../Account/weekly-writings.php");
			die();
		}
		
		createNewArticle($conn, $useruid, $title, $text, $principle, $author, $aid);
	}
	
	function emptyArticleInput($title, $text){
		$result;
		if (empty($title) || empty($text)) {
			$result = true;
		}
		else{
			$result = false;
		}
		return $result;
	}
	
	function idExists($conn, $title, $text, $author, $aid){
		$DB = new Database;
    	$conn = $DB->connect();

		$sls = "SELECT * FROM Writings WHERE Student = '$author' AND ArticleID = '$aid';";
		$resl = $DB->read($sls);
        if ($resl) {
        	$queryDataI = mysqli_num_rows($resl);
        	if ($queryDataI > 0){
        		$result = true;
        		$today = date("m-d-y");
				$newsql = "UPDATE Writings SET Essay = '$text', Title = '$title', DateUpdated = '$today', Status = 'Saved' WHERE Student = '$author' AND ArticleID = '$aid';";
				$DB->save($newsql);
				return $result;
			}
			else{
				$result = false;
				return $result;
			}
		}
		else{
			$result = false;
			return $result;
		}
	}
	

	function storyExists($conn, $title, $text, $author, $aid){
		$DB = new Database;
    	$conn = $DB->connect();

		$sls = "SELECT * FROM Writings WHERE Student = '$author' AND ArticleID = '$aid';";
		$resl = $DB->read($sls);
        if ($resl) {
        	$queryDataI = mysqli_num_rows($resl);
        	if ($queryDataI > 0){
        		$result = true;
        		$today = date("m-d-y");
				$newsql = "UPDATE Writings SET Essay = '$text', Title = '$title', DateUpdated = '$today', Status = 'Submitted' WHERE Student = '$author' AND ArticleID = '$aid';";
				$DB->save($newsql);
				return $result;
			}
			else{
				$result = false;
				return $result;
			}
		}
		else{
			$result = false;
			return $result;
		}
	}
	
	function createNewSavedArticle($conn, $useruid, $title, $text, $principle, $author, $aid){
		$status = "Saved";
		$today = date("m-d-y");
		$sql = "INSERT INTO Writings (ArticleID, StudentID, DateAdded, Title, Essay, Principles, Student, Status) VALUES (?, ?, ?, ?, ?, ?, ?, ?);";
		$stmt = mysqli_stmt_init($conn);
		if (!mysqli_stmt_prepare($stmt, $sql)) {
			header("location: ../Account/weekly-writings.php?error=stmtfailed");
			die();
		}
		mysqli_stmt_bind_param($stmt, "ssssssss", $aid, $useruid, $today, $title, $text, $principle, $author, $status);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);

		header("location: ../Account/weekly-writings.php");
		die();
	}
	
	function createNewArticle($conn, $useruid, $title, $text, $principle, $author, $aid){
		
		$status = "Submitted";
		$today = date("m-d-y");
		$sql = "INSERT INTO Writings (ArticleID, StudentID, DateAdded, Title, Essay, Principles, Student, Status) VALUES (?, ?, ?, ?, ?, ?, ?, ?);";
		$stmt = mysqli_stmt_init($conn);
		if (!mysqli_stmt_prepare($stmt, $sql)) {
			header("location: ../Account/weekly-writings.php?error=stmtfailed");
			die();
		}
		mysqli_stmt_bind_param($stmt, "ssssssss", $aid, $useruid, $today, $title, $text, $principle, $author, $status);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);

		header("location: ../Account/weekly-writings.php");
		die();
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