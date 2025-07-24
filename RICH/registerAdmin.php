<?php
  require ("classes/connect.php");
  require ("classes/uid.php");

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
    $sql = "SELECT * FROM SuperAdm WHERE EmailAddress = '$username' OR EmailAddress = '$email';";
    $DB = new Database;

    $DB ->read($sql);
    if ($result) {
      $queryData = mysqli_num_rows($result);
      if ($queryData > 0){
        $result = "true";
      }
      else{
        $result = "false";
      }
    }
    else{
      $result = "false";
    }

    return $result;
  }

  function evaluate($superfirst, $superlast, $superemail, $superpassword, $superpassword_match, $conn){
    if(userExists($conn, $superemail, $superemail) == "true"){
      return "User Already Exists.";
    }
    else{
      if(checkPasswordLength($superpassword) == "true"){
        return "Password must be at least 8 characters";
      }
      else{
        if (checkMatch($superpassword, $superpassword_match) == "true") {
          return "Passwords don't match";
        }
        else{
          createuser($superfirst, $superlast, $superemail, $superpassword, $conn);
        }
      }
    }
  }

  function createuser($superfirst, $superlast, $superemail, $superpassword, $conn){
    $status = "active";
    $userid = createuid();
    $DB = new Database;
    $Check = new Uid();

    $goodid = $Check -> checkUid($userid);
    while ($goodid == "b") {
      $userid = createuid();
      $goodid = $Check -> checkUid($userid);
    }
    $hashedPwd = password_hash($superpassword, PASSWORD_DEFAULT);


    $sql = "INSERT INTO SuperAdm (Uid, FirstName, LastName, EmailAddress, Pass) VALUES ('$userid', '$superfirst', '$superlast', '$superemail', '$hashedPwd');";

    
    $DB ->save($sql);

    header("location: registerAdmin.php?s=t");
    die();
  }

  function createuid(){
    $length = rand(4, 10);
    $number = "";
    for ($i=0; $i < $length; $i++) { 
      $new_rand = rand(0, 9);
      $number = $number . $new_rand;
    }
    return $number;
  }

  if (isset($_POST)) {
    if (isset($_POST['Superbtnsubmit'])) {
      $DB = new Database;
      $conn = $DB->connect();

      $superfirst = addslashes($_POST['Superfirst']);
      $superlast = addslashes($_POST['Superlast']);
      $superemail = addslashes($_POST['Superemail']);
      $superpassword = addslashes($_POST['Superpass']);
      $superpassword_match = addslashes($_POST['Supercpass']);

      evaluate($superfirst, $superlast, $superemail, $superpassword, $superpassword_match, $conn);
    }   
  }

  else{
    echo "No";
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>RICH &mdash; Reach Into Cultural Heights</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico" />

  <link href="https://fonts.googleapis.com/css?family=Amatic+SC:400,700|Work+Sans:300,400,700" rel="stylesheet">
  <link rel="stylesheet" href="fonts/icomoon/style.css">

  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/magnific-popup.css">
  <link rel="stylesheet" href="css/jquery-ui.css">
  <link rel="stylesheet" href="css/owl.carousel.min.css">
  <link rel="stylesheet" href="css/owl.theme.default.min.css">
  <link rel="stylesheet" href="css/bootstrap-datepicker.css">
  <link rel="stylesheet" href="css/animate.css">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/mediaelement@4.2.7/build/mediaelementplayer.min.css">



  <link rel="stylesheet" href="fonts/flaticon/font/flaticon.css">

  <link rel="stylesheet" href="css/aos.css">

  <link rel="stylesheet" href="css/style.css">

  <style type="text/css">
    #successlog{
      background-color: lightgreen;
      color: green;
      padding: 15px;
      font-size: 18px;
      margin: 0 auto;
      border-radius: 5px;
      margin-bottom: 10px;
    }
  </style>
</head>
<body>

  <div class="site-wrap">

    <div class="site-mobile-menu">
      <div class="site-mobile-menu-header">
        <div class="site-mobile-menu-close mt-3">
          <span class="icon-close2 js-menu-toggle"></span>
        </div>
      </div>
      <div class="site-mobile-menu-body"></div>
    </div> <!-- .site-mobile-menu -->

    <div style="padding-bottom: 50px;" class="text-center">
      <a href = "index.html"><img class = "img-fluid" src="images/LOGO.png"  href="index.html" alt="..."></a>


      <div id = "piaContainer" class="container">

        <div class = "col-md-8 mx-auto no-sidebar" >
          <div class="shapely-content">
            <br><br>

            <!--
            <form>
            <div class="form-group">
            <label for="optionSelect">Select Parent or Student</label>
            <select class="form-control" id="registerOptions">
            <option> Choose </option>
            <option value = "parent">Parent</option>
            <option value = "student">Student</option>
          </select>
        </div>
      </form>
    -->

    <h1 class= "text-center"> Admin Registration </h1><br>

    <div id = "adminForm">
      <?php 
        if (isset($_GET)) {
          if (isset($_GET['s']) == 't') {
      ?>
            <p id="successlog">Super Admin Account Created Successfully!</p>
      <?php
          }
        }
      ?>
      <form action="" method="POST">
        <div class="form-group">
          <label style="float:left;" for="firstName">First Name (required):</label>
          <input type = "text" class="form-control" id="firstName" name="Superfirst" required></input>
        </div>
        <div class="form-group">
          <label style="float:left;" for="lastName"> Last Name (required):</label>
          <input type = "text" class="form-control" id="lastName" name="Superlast" required></input>
        </div>
        <div class="form-group">
          <label style="float:left;" for="email"> Email Address:</label>
          <input type = "email" class="form-control" id="email" name="Superemail" required></input>
        </div>
        <div class="form-group">
          <label style="float:left;" for="password">Password:</label>
          <input type = "password" class="form-control" id="pass" name="Superpass" required></input>
        </div>
        <div class="form-group">
          <label style="float:left;" for="passwordC">Confirm Password:</label>
          <input type = "password" class="form-control" id="passC" name="Supercpass" required></input>
        </div>
        <div>
          <button style="width:100%;" type="submit" name="Superbtnsubmit"> Create Account </button>
        </div>
      </form>
    </div>
  </div>
</div>
</div>
</div>


<footer class="site-footer">
  <div class="container">

    <div class="row">
      <div class="col">
        <p class="text-center">
          <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
          Copyright &copy; <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script>document.write(new Date().getFullYear());</script> All Rights Reserved | This template is made by <a href="https://colorlib.com" target="_blank" >Colorlib</a>
          <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
        </p>
      </div>

    </div>
  </div>
</footer>
</div>

<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/jquery-migrate-3.0.1.min.js"></script>
<script src="js/jquery-ui.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/jquery.stellar.min.js"></script>
<script src="js/jquery.countdown.min.js"></script>
<script src="js/jquery.magnific-popup.min.js"></script>
<script src="js/bootstrap-datepicker.min.js"></script>
<script src="js/aos.js"></script>


<script src="js/mediaelement-and-player.min.js"></script>

<script src="js/main.js"></script>


<script>

//addStudentAccount("test", "user", "1996-09-11", "Twelve", "Matter", "heo@mail.com", "Test1234", "Test1234");
//checkEmailUniqueness("essam@test.com");
var gender;
var check;
var mode;
var isUserUnique;
var isEmailUnique;

function checkGender(){
  gender = document.getElementById("gender").value;
  //alert(gender);
}

function createAdminAccount(){
  check = true;

  var firstName = document.getElementById("firstName").value;
  var lastName = document.getElementById("lastName").value;
  var dob = document.getElementById("dob").value;
  var email = document.getElementById("email").value;
  var pass = document.getElementById("pass").value;
  var passC = document.getElementById("passC").value;

  checkEmailUniqueness(email);

  if (pass != passC){
    check = false;
    emptyPasswords();
    alert("Passwords Don't Match");
  }

  if (isEmailUnique == false){
    check = false;
    emptyPasswords();
    emptyEmailField();
    alert("User Already Exists");
  }

  if (check == true){
    alert("Account Created Sucessfully!");
    addAdminAccount(firstName, lastName, dob, email, pass, passC);
  }
  return check;
}

function emptyPasswords(){
  document.getElementById("pass").value = "";
  document.getElementById("passC").value = "";
}

function emptyEmailField(){
  document.getElementById("email").value = "";
}

function Check(){
  return check;
}

function addAdminAccount(firstName, lastName, dob, email, pass, passC){
  mode = "Register";
  //type = "Admin";

  var xhttp = new XMLHttpRequest();
  var url = "php/AdminsRICH.php";
  var params = "mode=" + mode + "&fn=" + firstName
  + "&ln=" + lastName + "&dob=" + dob + "&email=" + email + "&pass=" + pass
  + "&passC=" + passC;

  xhttp.open("POST", url, true);

  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200){

    }
  };

  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send(params);
}

function checkEmailUniqueness(email){
  mode = "CheckEmail";

  var xhttp = new XMLHttpRequest();
  var url = "php/AdminsRICH.php";
  var params = "mode=" + mode + "&email=" + email;

  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200){
      var String1 = "exists";

      var result = String1.localeCompare(this.responseText);
      if (result == 0){
        isEmailUnique = false;
      }
      else isEmailUnique = true;
    }
  };

  xhttp.open("POST", url, true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send(params);
}

</script>

</body>
</html>
