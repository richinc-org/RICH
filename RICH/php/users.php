<?php 
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
  require ("../classes/connect.php");

  if (isset($_POST)) {
    if ($_POST['btnsubmit']) {
      echo "hmm";
    }

   /* $first = addslashes($_POST['userfname']);
    $last = addslashes($_POST['userlname']);
    $birthday = addslashes($_POST['userdob']);
    $gender = addslashes($_POST['usergender']);
    $grade = addslashes($_POST['usergrade']);
    $uprinciple = addslashes($_POST['userprinciple']);
    $email = addslashes($_POST['useremail']);
    $username = addslashes($_POST['useremail']);
    $password = addslashes($_POST['userpassword']);
    $password_match = addslashes($_POST['usercpassword']);*/
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
    echo "yes";
    
  }

  else{
    echo "No";
  }

 /* function isEmpty($first, $last, $birthday, $gender, $grade, $uprinciple, $email, $password, $password_match){
    $result;
    if (empty($first) || empty($last) || empty($birthday) || empty($gender) || empty($grade) || empty($uprinciple) || empty($email) || empty($password) || empty($password_match)) {
      $result = "true";
    }
    else{
      $result = "false";
    }

    return $result;
  }

  function emptynew($value){
    $result;
    if(empty($value)){
      $result = "true";
    }
    else{
      $result = "false";
    }
    return $result;
  }

  function invalidName($username){
    $result;
    if (!preg_match("/^[a-zA-Z0-9_]*$/", $username)) {
      $result = "true";
    }
    else{
      $result = "false";
    }
    return $result;
  }

  function invalidEmail($email){
    $result;
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $result = "true";
    }
    else{
      $result = "false";
    }
    return $result;
  }

  function checkPasswordLength($password){
    $result;
    if (strlen($password) < 8) {
      $result = "true";
    }
    else{
      $result = "false";
    }

    return $result;
  }

  function checkMatch($password, $password_match){
    $result;
    if(strcmp($password, $password_match) != 0){
      $result = "true";
    }
    else{
      $result = "false";
    }

    return $result;
  }


  function userExists($conn, $username, $email){
    $result;
    $sql = "SELECT * FROM rich_users.Students WHERE user_name = ? OR user_email = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      header("location: ../signup.php?error=stmtfailed");
      die();
    }

    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
      $result = "true";
    }
    else{
      $result = "false";
    }

    mysqli_stmt_close($stmt);
    return $result;
  }

  function evaluate($first, $last, $gender, $username, $email, $password, $password_match, $conn){
    if(isEmpty($first, $gender, $username, $email, $password, $password_match$first, $last, $birthday, $gender, $grade, $uprinciple, $email, $password, $password_match) == "true"){
      return "Please fill in all required fields";
    }
    else{
      if(userExists($conn, $username, $email) == "true"){
        return "User Already Exists.";
      }
      else{
        if(invalidEmail($email) == "true"){
          return "Invalid Email";
        }
        else{
          if(checkPasswordLength($password) == "true"){
            return "Password must be at least 8 characters";
          }
          else{
            if (checkMatch($password, $password_match) == "true") {
              return "Passwords don't match";
            }
            else{
              createuser($first, $last, $birthday, $gender, $grade, $uprinciple, $email, $password, $password_match, $conn);
            }
          }
        }
      }
    }
  }

  function createuser($first, $last, $birthday, $gender, $grade, $uprinciple, $email, $password, $password_match, $conn){
    $status = "active";
    $userid = createuid();
    $hashedPwd = password_hash($password, PASSWORD_DEFAULT);


    $sql = "INSERT INTO rich_users.Students (Uid, FirstName, LastName, DOB, Gender, GradeLevel, Principle, EmailAddress, Pass, Avatar, Status) VALUES ('$userid', '$first', '$last', '$birthday', '$gender', '$grade', '$principle', '$email', '$hashedPwd', '', '$status');";

    $DB = new Database;
    $DB ->save($sql);

    header("location: ../register.php?error=none");
    die();
  }

  function createuid(){
    $length = rand(4, 19);
    $number = "";
    for ($i=0; $i < $length; $i++) { 
      $new_rand = rand(0, 9);
      $number = $number . $new_rand;
    }
    return $number;
  }*/
?>