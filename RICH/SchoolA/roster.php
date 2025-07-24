<?php
  session_start();
  ob_start();
  require("../classes/connect.php");
  require("../classes/login.php");
  require("../classes/user.php");

  $page = "roster";

  if (isset($_SESSION["Adminuid"])) {
    $Adminuid = $_SESSION["Adminuid"];
    $Adminschool = $_SESSION["Adminschool"];
    $login = new Login;
    $resultsIn = $login->checkAdminId($Adminuid);

    if ($resultsIn) {
      $user = new User;
      $user_data = $user->getAdminInfo($Adminuid);

      if ($user_data) {
        $firstn = stripslashes($user_data["FirstName"]);
        $lastn = stripslashes($user_data["LastName"]);
        $firstn = htmlspecialchars($firstn);
        $lastn = htmlspecialchars($lastn);
      }
      else{
        header("Location: ../loginAdmin.php");
        die();
      }
    }
    else{
      header("Location: ../loginAdmin.php");
      die();
    }
  }
  else{
    header("Location: ../loginAdmin.php");
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


  if (isset($_POST)) {
    if (isset($_POST['submit'])) {
      $newfn = addslashes($_POST['newfn']);
      $newln = addslashes($_POST['newln']);
      $newgl = addslashes($_POST['newgl']);
      $newdob = addslashes($_POST['newdob']);
      $newea = addslashes($_POST['newea']);
      $newsch = addslashes($_POST['newsch']);
      $stuuid = addslashes($_POST['stuid']);

      $db = new Database;
      $conn = $db->connect();

      $sql = "SELECT * FROM Schools WHERE SchoolName = '$newsch';";
      $resl = $db->read($sql);
      if ($resl) {
        $queryDataI = mysqli_num_rows($resl);
        if ($queryDataI > 0){
          while ($row = mysqli_fetch_assoc($resl)) {
            $x = htmlspecialchars($row['Uid']);
          }
        }
        else{
          $x = createid();
          $today = date("m-d-y");
          $newsql = "INSERT INTO Schools (Uid, SchoolName, Joined, Status) VALUES ('$x', '$newsch', '$today', 'Active');";
          $db->save($newsql);
        }
      }

      $sqltt = "UPDATE Students SET SchoolUid = '$x', FirstName = '$newfn', LastName = '$newln',  GradeLevel = '$newgl', DOB = '$newdob', EmailAddress = '$newea' WHERE Uid = '$stuuid';";
      $db->save($sqltt);

      header("location: https://www.richinc.org/RICH/SuperA/roster.php");
      die();
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="https://kit.fontawesome.com/5ebe76510e.js" crossorigin="anonymous"></script>
<style type="text/css">
  *{
    text-decoration: none;
    list-style: none;
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }

  ul{
    display: inline-block;
    width: 100%;
  }

  .action{
    padding: 5px;
    border-radius: 5px;
  }

  /* Tables */
  table{
    border-collapse: collapse;
    display: table;
    width: 100%;
    color: black;
  }

  #dataRow{
    border: 1px solid #dddddd;
    width: 100%;
  }

  #cnum{
    width: 5%;
  }

  td, th {
    border: 1px solid #dddddd;
    padding: 0px;
  }

  th{
    color: #23527c;
    font-size: 18px;
  }

  tr:nth-child(even) {
    background-color: #dddddd;
  }

  .paginationC{
    overflow: hidden;
    color: white;
    padding-top: 10px;
    background-color: #23527c;
  }

  .paginationC a{
    color: white;
  }
  .paginationC a:hover, .paginationC a:focus{
    color: lightblue;
    list-style: none;
    text-decoration: none;
  }
  .paginationC #left{
    float: left;
    padding-left: 10px;
  }
  .paginationC #right{
    float: right;
    padding-right: 10px;
  }

  /*Modal Style*/
  .modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    top: 0;
    left: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto;
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
  }

  /* Modal Content */
  .modal-content {
    background-color: #fefefe;
    display: block;
    margin: -20px auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    text-align: center;
  }

  /* The Close Button */
  .close {
    color: #aaaaaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
  }

  .close:hover,
  .close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
  }

  .modalForm{
    margin: 50px 0px;
  }

  .modalForm h2{
    text-align: center;
  }
</style>

<head>
  <title>RICH &mdash; Reach Into Cultural Heights</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico" />

  <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

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

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

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

    <div id = "myLogo" class="site-navbar-wrap js-site-navbar bg-white">

      <div class="container-fluid">
        
        <div class="text-center">
          <a href = "roster.php"><img class = "img-fluid" src="../images/LOGO-Larger.png"  href="roster.php" alt="..." style="height: 150px;"></a>
        </div>

        <div class="site-navbar bg-light">
          <div class="py-1">
            <div class="row align-items-left">

              <div class="col-12">
                <nav class="site-navigation text-right" role="navigation">
                  <div class="container-fluid">
                    <div class="d-inline-block d-lg-none ml-md-0 mr-auto py-3"><a href="#" class="site-menu-toggle js-menu-toggle text-black"><span class="icon-menu h3"></span></a></div>

                    <ul class="site-menu js-clone-nav d-none d-lg-block" style = "padding: 0px;">
                      <li style="float: left;">
                        <div style="font-size: 27px;">
                          <?php echo "Hello, " . $firstn . " " . $lastn[0] . "."; ?>
                        </div>
                      </li>

                      <li><a style = "font-size: 16px; background-color: #66f5ea33;" href="roster.php" class="<?php if($page=='roster'){echo 'active';}?>">Roster</a></li>
                      <li><a style = "font-size: 16px; background-color: #66f5ea33;" href="logout.php">Logout</a></li>

                    </ul>
                  </div>
                </nav>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>


    <!--<div id "logoHeight" style="height: 250px;"></div>-->

    <div style="padding-bottom: 350px;" class="text-center">
      <div class = "col-lg-12 mx-auto no-sidebar" >
        <div id = "assignmentContainer" class="shapely-content">

          <?php

            if (isset($_GET['a'])) {

              if (htmlspecialchars(($_GET['a']) == 'e')) {
                $db = new Database;
                $conn = $db->connect();

                $studentID = htmlspecialchars($_GET['id']);
      ?>
                <input type="text" id="showModal" hidden>
                <div id="myModal" class="modal">
                  <!-- Modal content -->
                  <div class="modal-content">
                    <span class="close">&times;</span>
                    <div>
                      <form method="POST" class="modalForm">
                        <h2>Edit Student</h2><br>
        <?php
                        $sql = "SELECT * FROM Students WHERE Uid = '$studentID';";
                        $result = $db->read($sql);

                        if ($result) {
                          $qD = mysqli_num_rows($result);
                          if ($qD > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                              $schoolid = htmlspecialchars($row['SchoolUid']);
                              $sqlf = "SELECT * FROM Schools WHERE Uid = '$schoolid';";
                              $resultf = $db->read($sqlf);

                              if ($resultf) {
                                $qDf = mysqli_num_rows($resultf);
                                if ($qDf > 0) {
                                  while ($rowf = mysqli_fetch_assoc($resultf)) {
                                    $schoolName = htmlspecialchars($rowf['SchoolName']);
                                  }
                                }
                              }
        ?>
                              <input type="text" name="stuid" value="<?php echo $studentID?>" hidden>
                              First Name: <input type="text" name="newfn" value="<?php echo htmlspecialchars($row['FirstName'])?>"><br>
                              Last Name: <input type="text" name="newln" value="<?php echo htmlspecialchars($row['LastName'])?>"><br>
                              Grade: <input type="text" name="newgl" value="<?php echo htmlspecialchars($row['GradeLevel'])?>"><br>
                              Email Address: <input type="text" name="newea" value="<?php echo htmlspecialchars($row['EmailAddress'])?>"><br>
                              School: <input type="text" name="newsch" value="<?php echo $schoolName?>" disabled><br>
        <?php
                            }
                          }
                        }
        ?>
                        <button type="submit" class="form-button" name="submit">Confirm Changes</button>
                      </form>

                  
        <?php 
                      if (isset($_GET["error"])) {
                        if ($_GET["error"] == "emptyinput") {
                          echo "<p class = 'form-text'>Please fill in all fields.</p>";
                        }
                        else if ($_GET["error"] == "stmtfailed") {
                          echo "<p class = 'form-text'>Oops, something went wrong. Try again.</p>";
                        }
                      }
        ?>
                    </div>
                  </div>
                </div>
        <?php

              }

              if (htmlspecialchars(($_GET['a']) == 'del')) {
                $db = new Database;
                $conn = $db->connect();

                $studentID = htmlspecialchars($_GET['id']);

                $sqlcom = "DELETE FROM Students WHERE Uid = '$studentID';";
                $db->save($sqlcom);
            ?>
                <script type="text/javascript">
                  window.location.href = "roster.php";
                </script>
            <?php
              }
            }
            else{
            }
          ?>
          <div class="paginationC">
    <?php
              $db = new Database;
              $conn = $db->connect();

              if (!isset($_GET['page'])) {
                $page = 1;
              }
              else{
                $page = htmlspecialchars($_GET['page']);
              }
              
              $sqlthree = "SELECT * FROM Students WHERE SchoolUid = '$Adminschool';";

              $resulthree = $db->read($sqlthree);
              $resultsperpage = 10;

              if ($resulthree) {
                $qDthree = mysqli_num_rows($resulthree);

                if ($qDthree > 0){
                  $number_of_pages = ceil($qDthree/$resultsperpage);
                  $first_result = ($page-1)*$resultsperpage;

                  $sqlfor = "SELECT * FROM Students WHERE SchoolUid = '$Adminschool' LIMIT " . $first_result . "," . $resultsperpage;
                  
                  $resultfor = $db->read($sqlfor);

                  if ($resulthree) {
                    $qDfor = mysqli_num_rows($resultfor);

                    if ($qDfor > 0){
                      $first_result_number = $first_result+1;

                      if ($qDthree < $resultsperpage) {
                        $last_result_number = $qDthree;
                      }
                      else{
                        $last_result_number = $first_result+$resultsperpage;

                        if ($last_result_number > $qDthree) {
                          $last_result_number = $qDthree;
                        }
                      }
                      echo "<p id = 'left'>Showing results " . $first_result_number . "-" . $last_result_number . " out of " . $qDthree . "</p>";

                      for($page=$number_of_pages; $page>0; $page--){
                        echo "<a id='right' href='roster.php?page=" . $page . "'>" . $page . "</a> ";
                      }
    ?>
          </div>
    <?php
                      $count = 1;
    ?>
                      <table id="catTable">
                        <tr id="dN">
                          <th class="text-center">Number</th>
                          <th class="text-center">Uid</th>
                          <th class="text-center">First Name</th>
                          <th class="text-center">Last Name</th>
                          <th class="text-center">School</th>
                          <th class="text-center">Status</th>
                          <th class="text-center">Actions</th>
                        </tr>

    <?php
                        while ($rowC = mysqli_fetch_assoc($resultfor)) {
    ?>
                          <tr id = 'dataRow'>
                            <td name = 'cnum' id="cnum"><?php echo $count; ?></td>
                            <td name = 'cu'><?php echo htmlspecialchars($rowC['Uid']); ?></td>
                            <td name = 'cfn'><?php echo htmlspecialchars($rowC['FirstName']); ?></td>
                            <td name = 'cln'><?php echo htmlspecialchars($rowC['LastName']); ?></td>
                            <td name = 'cschool'>
    <?php                 
                              $getSchoolUid = htmlspecialchars($rowC['SchoolUid']); 
                              $sqltwo = "SELECT * FROM Schools WHERE Uid = '$getSchoolUid';";
                              $restwo = $db->read($sqltwo);

                              if ($restwo) {
                                $qDtwo = mysqli_num_rows($restwo);

                                if ($qDtwo > 0) {
                                  while ($rowtwo = mysqli_fetch_assoc($restwo)) {
                                    echo htmlspecialchars($rowtwo['SchoolName']);
                                  }
                                }
                                else{
                                  echo "Invalid School";
                                }
                              }
                              else{
                                echo "Invalid School";
                              }
        ?> 
                            </td>
                            <td name = 'cs'><?php echo htmlspecialchars($rowC['Status']); ?></td>
                            <td name = 'ca'>
                              <a href="fullview.php?id=<?php echo htmlspecialchars($rowC['Uid']); ?>"><button class="action"><i class="fas fa-eye"></i></button></a>

                              <a href="roster.php?a=e&id=<?php echo htmlspecialchars($rowC['Uid']); ?>"><button class="action"><i class="fas fa-edit"></i></button></a>

                              <a href="roster.php?a=del&id=<?php echo htmlspecialchars($rowC['Uid']); ?>"><button class="action"><i class="fas fa-trash"></i></button></a>
                            </td>
                          </tr>
        <?php
                          $count++;
                        }
        ?>
                      </table>
        <?php
                    }
                    else{
                      echo "No Results Found";  
                    }
                  }
                  else{
                    echo "No Results Found";
                  }
                }
              }

        ?>
            
            <!--<h1> Roster </h1><br>

            <div style = "padding-left: 0px; padding-right: 0px;" class = "container-fluid">
              <div style = "border: 1px solid; padding: 5px;" class = "row">
                <div style = "font-size: 18px;" class = "col-lg-2 col-md-2 col-sm-6"> Name </div>
                <div style = "font-size: 18px;" class = "col-lg-2 col-md-2 col-sm-6"> Date of Birth </div>
                <div style = "font-size: 18px;" class = "col-lg-1 col-md-1 col-sm-6"> Grade </div>
                <div style = "font-size: 18px;" class = "col-lg-3 col-md-3 col-sm-6"> Email </div>
                <div style = "font-size: 18px;" class = "col-lg-2 col-md-2 col-sm-6"> Password </div>
                <div style = "font-size: 18px;" class = "col-lg-2 col-md-2 col-sm-6"> Options </div>
              </div>
              <div style = "padding-left: 0px; padding-right: 0px;" class = "container-fluid" id = "roster"></div>
            </div>
            <br><br>
            <h3 class="text-left" id="usersTotal"></h3>
            <h3 class="text-left" id="gameCounter"></h3>
            <h3 class="text-left" id="matterCounter"></h3>
            <h3 class="text-left" id="respCounter"></h3>
            <h3 class="text-left" id="stratCounter"></h3>
            <h3 class="text-left" id="consCounter"></h3>
          </div>-->

        </div>
      </div>
    </div>


    <footer class="site-footer">
      <div class="container">

        <div class="row">
          <div class="col">
            <p class="text-center">
              <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
              Copyright &copy; <script data-cfasync="false" src=""></script><script>document.write(new Date().getFullYear());</script> All Rights Reserved </a>
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

  window.onload = function(){

    if ( document.getElementById('showModal') ){
      var modal = document.getElementById("myModal");
      var span = document.getElementsByClassName("close")[0];

      modal.style.display = "block";

      span.onclick = function() {
        modal.style.display = "none";
      }

      window.onclick = function(event) {
        if (event.target == modal) {
          modal.style.display = "none";
        }
      }
    }
  }

  window.onscroll = function() {

    if (window.pageYOffset > 20) {
      document.getElementById("myLogo").style.top = "-260px";
      document.getElementById("logoHeight").style.height = "220px";
    } else {
      document.getElementById("myLogo").style.top = "0px";
      document.getElementById("logoHeight").style.height = "400px";
    }
  }



  function getProfileData(studentEmail){

  }

  function showBadges(){

  }

  function getBadges(studentEmail){
   
  }

  function showProjects(){
    
  }

  function getRoster(){
    
  }

  function displayRoster(){

  }

  function deleteStudent(email){
   
  }

  function viewStudent(email){
   
  }

  function updateStudent(FullName, dob, grade, email, pass){
   
  }

  </script>

</body>
</html>
