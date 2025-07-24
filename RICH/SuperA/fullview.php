<?php
  session_start();
  ob_start();
  require("../classes/connect.php");
  require("../classes/login.php");
  require("../classes/user.php");

  $page = "roster";
  $db = new Database;
  $conn = $db->connect();

  if (isset($_SESSION["Superuid"])) {
    $Superuid = $_SESSION["Superuid"];
    $login = new Login;
    $resultsIn = $login->checkUserId($Superuid);

    if ($resultsIn) {
      $user = new User;
      $user_data = $user->getUserInfo($Superuid);

      if ($user_data) {
        $firstn = stripslashes($user_data["FirstName"]);
        $lastn = stripslashes($user_data["LastName"]);
        $firstn = htmlspecialchars($firstn);
        $lastn = htmlspecialchars($lastn);
      }
      else{
        header("Location: login.php");
        die();
      }
    }
    else{
      header("Location: login.php");
      die();
    }
  }
  else{
    header("Location: login.php");
    die();
  }
?>
<!DOCTYPE html>
<html lang="en">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="https://kit.fontawesome.com/728379f5a6.js" crossorigin="anonymous"></script>
<style type="text/css">
  *{
    text-decoration: none;
    list-style: none;
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }

  .tabs {
      overflow: hidden;
      border: 1px solid #ccc;
      background-color: #23527c;
      text-align: center;
      font-size: 0px;
    }

    /* Style the buttons inside the tab */
    .tabs button {
      background-color: inherit;
      border: none;
      margin: 0px;
      outline: none;
      cursor: pointer;
      padding: 14px 16px;
      transition: 0.3s;
      font-size: 18.5px;
      color: white;
    }

    /* Change background color of buttons on hover */
    .tabs button:hover{
      background-color: powderblue;
      color: #555;
    }

    .tabs button:focus{
      background-color: powderblue;
    }

    /* Create an active/current tablink class */
    .tabs button.active {
      background-color: black;
    }

    /* Style the tab content */
    .tabcontent {
      display: none;
      padding: 6px 12px;
      border: 1px solid black;
      border-top: none;
    }

    .tabcontent h2{
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
                      <li><a style = "font-size: 16px; background-color: #66f5ea33;" href="admins.php" class="<?php if($page=='admin'){echo 'active';}?>">School Admins</a></li>
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
            if (isset($_GET)) {
              if (htmlspecialchars($_GET['action']) == 'd') {
                $aid = htmlspecialchars($_GET['aid']);
                $author = htmlspecialchars($_GET['u']);
                $sqlfind = "DELETE FROM Writings WHERE ArticleID = '$aid' AND StudentID = '$author';";
                $result = $db->save($sqlfind);
                header("location: fullview.php?id=$author");
                exit();
              }

              else if (htmlspecialchars($_GET['said'])) {
                $stuid = htmlspecialchars($_GET['said']);
          ?>
                <div class="tabs">
                  <button class="tablinks" onclick="openTab(event, 'info')" id="defaultOpen">INFORMATION </button>
                </div>

                <div id="info" class="tabcontent">
                  <h2>Information</h2><br><br>
                  <h4>Name - Uid:</h4>
                  <h4>
                    <?php 
                      $sqlsql = "SELECT FirstName, LastName, Uid FROM SchoolAdmins WHERE Uid = '$stuid';";
                      $results = $db->read($sqlsql);

                      if ($results) {
                        $query = mysqli_num_rows($results);

                        if ($query > 0){
                          while ($row = mysqli_fetch_assoc($results)) {
                            $firstname = htmlspecialchars($row['FirstName']);
                            $lastname = htmlspecialchars($row['LastName']);
                            $realUid = htmlspecialchars($row['Uid']);
                            $fullname = $firstname . " " . $lastname;
                            echo $fullname . " - " . $realUid;
                          }
                        }
                      }
                    ?>
                  </h4><br>

                  <h4>School:</h4>
                  <h4>
                    <?php 
                      $sqlsql = "SELECT SchoolUid FROM SchoolAdmins WHERE Uid = '$stuid';";
                      $results = $db->read($sqlsql);

                      if ($results) {
                        $query = mysqli_num_rows($results);

                        if ($query > 0){
                          while ($row = mysqli_fetch_assoc($results)) {
                            $schoolN = htmlspecialchars($row['SchoolUid']);

                            $sql = "SELECT SchoolName FROM Schools WHERE Uid = '$schoolN';";
                            $result = $db->read($sql);

                            if ($result) {
                              $queryD = mysqli_num_rows($result);

                              if ($queryD > 0){
                                while ($rows = mysqli_fetch_assoc($result)) {
                                  echo $rows['SchoolName'];
                                }
                              }
                            }
                            else{
                              echo "Invalid School";
                            }
                          }
                        }
                        else{
                          echo "Invalid School";
                        }
                      }
                    ?>
                  </h4><br>

                  <h4>Email:</h4>
                  <h4>
                    <?php 
                      $sql = "SELECT EmailAddress FROM SchoolAdmins WHERE Uid = '$stuid';";
                      $results = $db->read($sql);

                      if ($results) {
                        $query = mysqli_num_rows($results);

                        if ($query > 0){
                          while ($row = mysqli_fetch_assoc($results)) {
                            echo htmlspecialchars($row['EmailAddress']);
                          }
                        }
                      }
                    ?>
                  </h4><br>
                </div>
          <?php
              }
              else if (htmlspecialchars($_GET['id'])) {
                $stuid = htmlspecialchars($_GET['id']);
          ?>
                <div class="tabs">
                  <button class="tablinks" onclick="openTab(event, 'info')" id="<?php if(!isset($_GET['aid'])){echo 'defaultOpen';}?>">INFORMATION </button>
                  <button class="tablinks" onclick="openTab(event, 'badges')">BADGES</button>
                  <button class="tablinks" onclick="openTab(event, 'projects')">PROJECTS</button>
                  <button class="tablinks" onclick="openTab(event, 'writings')" id="<?php if(isset($_GET['aid'])){echo 'defaultOpen';}?>">WRITINGS</button>
                </div>

                <div id="info" class="tabcontent">
                  <h2>Information</h2><br><br>
                  <h4>Name - Uid:</h4>
                  <h4>
                    <?php 
                      $sqlsql = "SELECT FirstName, LastName, Uid FROM Students WHERE Uid = '$stuid';";
                      $results = $db->read($sqlsql);

                      if ($results) {
                        $query = mysqli_num_rows($results);

                        if ($query > 0){
                          while ($row = mysqli_fetch_assoc($results)) {
                            $firstname = htmlspecialchars($row['FirstName']);
                            $lastname = htmlspecialchars($row['LastName']);
                            $realUid = htmlspecialchars($row['Uid']);
                            $fullname = $firstname . " " . $lastname;
                            echo $fullname . " - " . $realUid;
                          }
                        }
                      }
                    ?>
                  </h4><br>

                  <h4>School:</h4>
                  <h4>
                    <?php 
                      $sqlsql = "SELECT SchoolUid FROM Students WHERE Uid = '$stuid';";
                      $results = $db->read($sqlsql);

                      if ($results) {
                        $query = mysqli_num_rows($results);

                        if ($query > 0){
                          while ($row = mysqli_fetch_assoc($results)) {
                            $schoolN = htmlspecialchars($row['SchoolUid']);

                            $sql = "SELECT SchoolName FROM Schools WHERE Uid = '$schoolN';";
                            $result = $db->read($sql);

                            if ($result) {
                              $queryD = mysqli_num_rows($result);

                              if ($queryD > 0){
                                while ($rows = mysqli_fetch_assoc($result)) {
                                  echo $rows['SchoolName'];
                                }
                              }
                            }
                            else{
                              echo "Invalid School";
                            }
                          }
                        }
                        else{
                          echo "Invalid School";
                        }
                      }
                    ?>
                  </h4><br>

                  <h4>Gender:</h4>
                  <h4>
                    <?php 
                      $sql = "SELECT Gender FROM Students WHERE Uid = '$stuid';";
                      $results = $db->read($sql);

                      if ($results) {
                        $query = mysqli_num_rows($results);

                        if ($query > 0){
                          while ($row = mysqli_fetch_assoc($results)) {
                            echo htmlspecialchars($row['Gender']);
                          }
                        }
                      }
                    ?>
                  </h4><br>

                  <h4>Email:</h4>
                  <h4>
                    <?php 
                      $sql = "SELECT EmailAddress FROM Students WHERE Uid = '$stuid';";
                      $results = $db->read($sql);

                      if ($results) {
                        $query = mysqli_num_rows($results);

                        if ($query > 0){
                          while ($row = mysqli_fetch_assoc($results)) {
                            echo htmlspecialchars($row['EmailAddress']);
                          }
                        }
                      }
                    ?>
                  </h4><br>

                  <h4>Grade:</h4>
                  <h4>
                    <?php 
                      $sql = "SELECT GradeLevel FROM Students WHERE Uid = '$stuid';";
                      $results = $db->read($sql);

                      if ($results) {
                        $query = mysqli_num_rows($results);

                        if ($query > 0){
                          while ($row = mysqli_fetch_assoc($results)) {
                            echo htmlspecialchars($row['GradeLevel']);
                          }
                        }
                      }
                    ?>
                  </h4><br>
                </div>

                <div id="badges" class="tabcontent">
                  <h2>Badges</h2><br><br>
                  <?php

                    if (isset($_GET['id'])) {
                      $author = htmlspecialchars($_GET['id']);
                      $sqlfind = "SELECT * FROM Projects WHERE StudentID = '$author';";
                      $result = $db->read($sqlfind);
                      if ($result) {
                        $queryData = mysqli_num_rows($result);
                        if ($queryData > 0){
                          while ($row = mysqli_fetch_assoc($result)) {

                          }
                        }
                        else{
                          echo "<h4>This student has no badges.</h4>";
                        }
                      }
                    }  
                  ?>
                </div>

                <div id="projects" class="tabcontent">
                  <h2>Projects</h2><br><br>
                  <?php

                    if (isset($_GET['id'])) {
                      $author = htmlspecialchars($_GET['id']);
                      $sqlfind = "SELECT * FROM Projects WHERE StudentID = '$author';";
                      $result = $db->read($sqlfind);
                      if ($result) {
                        $queryData = mysqli_num_rows($result);
                        if ($queryData > 0){
                          while ($row = mysqli_fetch_assoc($result)) {

                          }
                        }
                        else{
                          echo "<h4>This student has no projects.</h4>";
                        }
                      }
                    }  
                  ?>
                </div>

                <div id="writings" class="tabcontent">
                  <h2>Writings</h2><br><br>
                  <?php

                    if (isset($_GET['aid'])) {
                      $aid = htmlspecialchars($_GET['aid']);
                      $author = htmlspecialchars($_GET['id']);
                      $sqlfind = "SELECT * FROM Writings WHERE ArticleID = '$aid' AND StudentID = '$author';";
                      $result = $db->read($sqlfind);
                      if ($result) {
                        $queryData = mysqli_num_rows($result);
                        if ($queryData > 0){
                          while ($row = mysqli_fetch_assoc($result)) {
                            echo "<p id = 'title'>" . htmlspecialchars($row['Title']) . "</p><p>" . htmlspecialchars($row['Student']) . "</p><p>Date: " . htmlspecialchars($row['DateAdded']) . "</p><p>Principles Used: " . htmlspecialchars($row['Principles']) . "</p><br><br><p>" . htmlspecialchars($row['Essay']) . "</p><br><br>";
  ?>
                            <a href="fullview.php?id=<?php echo htmlspecialchars($row['StudentID']);?>"><button>Back to User Information</button></a>
                            <a href="fullview.php?action=d&aid=<?php echo htmlspecialchars($row['ArticleID']);?>&u=<?php echo htmlspecialchars($row['StudentID']);?>"><button>Delete</button></a>
  <?php
                          }
                        }
                      }
                    }
                    else{
                      $sql = "SELECT * FROM Writings WHERE StudentID = '$stuid';";
                      $results = $db->read($sql);

                      if ($results) {
                        $query = mysqli_num_rows($results);

                        if ($query > 0){
                          while ($row = mysqli_fetch_assoc($results)) {
                    ?>
                            <h3><a href = 'fullview.php?id=<?php echo htmlspecialchars($row['StudentID']);?>&aid=<?php echo htmlspecialchars($row['ArticleID']);?>'>
                              <?php echo htmlspecialchars($row['Title'])?>
                            </a></h3>

                            <h4>Date Added: <?php echo htmlspecialchars($row['DateAdded'])?></h4>

                            <h4>Date Updated: <?php echo htmlspecialchars($row['DateUpdated'])?></h4>

                            <h4>Status: <?php echo htmlspecialchars($row['Status'])?></h4>
                            <br>
                  <?php
                          }
                        }
                        else{
                          echo "<h4>This student has no writings.</h4>";
                        }
                      }
                    }
                  ?>
                </div>
          <?php
              }
            }
            else{
          ?>
              <script type="text/javascript">
                window.location.href = "roster.php";
              </script>
          <?php
            }
          ?>

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
  <script src="js/aos.js"></script>

  <script src="js/mediaelement-and-player.min.js"></script>

  <script src="js/main.js"></script>

  <script type="text/javascript">
    document.getElementById("defaultOpen").click();

    function openTab(evt, tabName){
      var i, tabcontent, tablinks;
      tabcontent = document.getElementsByClassName("tabcontent");
      for (i = 0; i < tabcontent.length; i++) {
          tabcontent[i].style.display = "none";
      }
      tablinks = document.getElementsByClassName("tablinks");
      for (i = 0; i < tablinks.length; i++) {
          tablinks[i].className = tablinks[i].className.replace(" active", "");
      }
      document.getElementById(tabName).style.display = "block";
      evt.currentTarget.className += " active";
    }
  </script>

  <script>

  window.onscroll = function() {
  }

  </script>

</body>
</html>
