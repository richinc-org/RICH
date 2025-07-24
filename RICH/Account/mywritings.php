<?php 
  session_start();
  ob_start();
  require("../classes/connect.php");

?>
<!DOCTYPE html>
<html lang="en">


<script>
var userInfo;
getUserInfo();
//alert(userInfo);
if (userInfo == ""){
  //window.location.href = "../notLogin.html";
}

function getUserInfo(){
  mode = "getInfo";

  var xhttp = new XMLHttpRequest();
  var url = "../php/UsersRICH.php";
  var params = "mode=" + mode;

  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200){
      userInfo = this.responseText;
    }
  };

  xhttp.open("POST", url, false);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send(params);
}

</script>

<head>
  <title>RICH &mdash; Reach Into Cultural Heights</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link rel="shortcut icon" type="image/x-icon" href="../images/favicon.ico" />

  <!--<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">-->

  <link href="https://fonts.googleapis.com/css?family=Amatic+SC:400,700|Work+Sans:300,400,700" rel="stylesheet">
  <link rel="stylesheet" href="../fonts/icomoon/style.css">

  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/magnific-popup.css">
  <link rel="stylesheet" href="../css/jquery-ui.css">
  <link rel="stylesheet" href="../css/owl.carousel.min.css">
  <link rel="stylesheet" href="../css/owl.theme.default.min.css">
  <link rel="stylesheet" href="../css/bootstrap-datepicker.css">
  <link rel="stylesheet" href="../css/animate.css">

  <!--<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/mediaelement@4.2.7/build/mediaelementplayer.min.css">-->

  <link rel="stylesheet" href="../fonts/flaticon/font/flaticon.css">

  <link rel="stylesheet" href="../css/aos.css">

  <link rel="stylesheet" href="../css/style.css">
  
  <style>
    .readEssay{
      text-align: left;
    }

    .readEssay p{
      margin: 0;
      font-size: 16px;
    }

    #title{
      color: #2f4279;
      font-size: 2rem;
    }

    #listtitle{
      color: #2f4279;
      font-size: 1.6rem;
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

    <div id = "myLogo" style = "padding: 0;" class="site-navbar-wrap js-site-navbar bg-white">

      <div class="container-fluid">

        <div class="text-center">
          <a href = "../index.html"><img class = "img-fluid" src="../images/LOGO-Larger.png"  href="../index.html" alt="..."></a>
        </div>

        <div class="site-navbar bg-light">
          <div class="py-1">
            <div class="row align-items-left">
              <li> <a href="logout.php"><button style="font-size: 16px; position: absolute; top:50px; right:50px ;" class="portalbutton"> LOGOUT </button></a></li>
              <div class="col-12">
                <nav class="site-navigation text-right" role="navigation">
                  <div class="container-fluid">
                    <div class="d-inline-block d-lg-none ml-md-0 mr-auto py-3"><a href="#"
                        class="site-menu-toggle js-menu-toggle text-black"><span class="icon-menu h3"></span></a></div>

                    <ul class="site-menu js-clone-nav d-none d-lg-block">

                      <li style="float:left;">
                        <div style="font-size: 27px;" id="userInfo">
                        </div>
                        
                      </li>
                      <li><a style="font-size: 16px;" class="activelink"
                          href="https://www.richinc.org/RICH/Account/portal-home.html">Home</a></li>
                      <li class="has-children">
                        <a style="font-size: 16px;color:#c51f1f;" href="https://www.richinc.org/RICH/Account/weekly-writings.php" >RICH
                          Reflective Writing</a>
                        <ul class="dropdown arrow-top">
                          <li><a href="https://www.richinc.org/RICH/Account/weekly-writings.php">Weekly-Writings</a></li>
                          <li><a href="https://www.richinc.org/RICH/Account/mywritings.php">My Writings</a></li>
                          <li><a href="https://www.richinc.org/RICH/Account/group-discussion.html">Group Discussion</a>
                          </li>
                        </ul>
                      </li>
                      <li><a style="font-size: 16px; color:#c5721f;" href="https://www.richinc.org/RICH/Account/redirect.html">Google
                          Classroom</a></li>
                      <li><a style="font-size: 16px;color:#2f7939;"
                          href="https://www.richinc.org/RICH/Account/profile.html">Personal-Profile</a></li>
                      <li><a style="font-size: 16px;"
                          href="https://www.richinc.org/RICH/Account/projects.html">Projects</a></li>
                      <li><a style="font-size: 16px; color:#c51f1f;"
                          href="https://www.richinc.org/RICH/Account/SafeSpace.html" >Safe-Space</a></li>
                      <!-- <li> <a href="logout.php"><button style="font-size: 16px; position:absolute; top:0; right:0 ;" class="portalbutton"> LOGOUT </button></a></li> -->


                    </ul>

                  </div>
                </nav>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div id = "logoHeight" style="height: 400px;"></div>


    <!--<div id "logoHeight" style="height: 250px;"></div>-->

    <div style="padding-bottom: 100px;" class="text-center">
      <div id = "piaContainer" class="container">
        <div class = "col-md-12 mx-auto no-sidebar" >
          <div id = "assignmentContainer" class="shapely-content">
            <section>
              <div class="readEssay">
<?php
                $DB = new Database;
                $conn = $DB->connect();
                if (isset($_GET)) {
                  if (isset($_GET['view'])) {
                    $aid = htmlspecialchars($_GET['id']);
                    $author = htmlspecialchars($_GET['u']);
                    $sqlfind = "SELECT * FROM Writings WHERE ArticleID = '$aid' AND Student = '$author';";
                    $result = $DB->read($sqlfind);
                    if ($result) {
                      $queryData = mysqli_num_rows($result);
                      if ($queryData > 0){
                        while ($row = mysqli_fetch_assoc($result)) {
                          echo "<p id = 'title'>" . htmlspecialchars($row['Title']) . "</p><p>" . htmlspecialchars($row['Student']) . "</p><p>Date: " . htmlspecialchars($row['DateAdded']) . "</p><p>Principles Used: " . htmlspecialchars($row['Principles']) . "</p><br><br><p>" . htmlspecialchars($row['Essay']) . "</p><br><br>";
?>
                          <a href="weekly-writings.php"><button>Back to Weekly Writings</button></a>
                          <a href="mywritings.php?action=d&id=<?php echo htmlspecialchars($row['ArticleID']);?>&u=<?php echo htmlspecialchars($row['Student']);?>"><button>Delete</button></a>
<?php
                        }
                      }
                    }
                  }

                  else if (isset($_GET['action'])){
                    $aid = htmlspecialchars($_GET['id']);
                    $author = htmlspecialchars($_GET['u']);
                    $sqlfind = "DELETE FROM Writings WHERE ArticleID = '$aid' AND Student = '$author';";
                    $result = $DB->save($sqlfind);
                    header("location: weekly-writings.php");
                    exit();
                  }

                  else{
?>
                    <h3><u>My Essays</u></h3>
<?php
                    $useruid = $_SESSION['uid'];
                    $sqlfind = "SELECT * FROM Writings WHERE StudentID = '$useruid' AND Status = 'Submitted';";
                    $result = $DB->read($sqlfind);
                    if ($result) {
                      $queryData = mysqli_num_rows($result);
                      if ($queryData > 0){
                        while ($row = mysqli_fetch_assoc($result)) {
?>
                          <a href = 'mywritings.php?view=v&id=<?php echo htmlspecialchars($row['ArticleID']);?>&u=<?php echo htmlspecialchars($row['Student']);?>'>
                            <p id = 'listtitle'> <?php echo htmlspecialchars($row['Title'])?> </p>
                          </a>
<?php
                        }
                      }
                    }
                  }
                }

?>
              </div>

            </section>
          </div>
        </div>
      </div>
    </div>
  </div>

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
  <footer class="site-footer">
    <div class="container">

      <div class="row">
        <div class="col">
          <p class="text-center">
            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
            Copyright &copy; <script data-cfasync="false" src=""></script><script>document.write(new Date().getFullYear());</script> All Rights Reserved | This template is made by <a href="https://colorlib.com" target="_blank" >Colorlib</a>
            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
          </p>
        </div>

      </div>
    </div>
  </footer>
</div>

<script src="../js/jquery-3.3.1.min.js"></script>
<script src="../js/jquery-migrate-3.0.1.min.js"></script>
<script src="../js/jquery-ui.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/owl.carousel.min.js"></script>
<script src="../js/jquery.stellar.min.js"></script>
<script src="../js/jquery.countdown.min.js"></script>
<script src="../js/jquery.magnific-popup.min.js"></script>
<script src="../js/bootstrap-datepicker.min.js"></script>
<script src="../js/aos.js"></script>

<script>

window.onscroll = function() {

  if (window.pageYOffset > 20) {
    document.getElementById("myLogo").style.top = "-260px";
    document.getElementById("logoHeight").style.height = "220px";
  } else {
    document.getElementById("myLogo").style.top = "0px";
    document.getElementById("logoHeight").style.height = "400px";
  }
}

var statusCheck;
/*
var date = new Date();
if (date.getDay() == 3){
document.getElementById("WeeklyWriting").style.display = "block";
}
else {
document.getElementById("notDay").style.display = "block";
}
*/
var profileData = [];
getProfileData();
if (profileData[0].FirstName == ""){
  window.location.href = "../notLogin.html";
}
var lastName = profileData[0].LastName;
document.getElementById("userInfo").innerHTML = "Hi " + profileData[0].FirstName + " " + lastName.substring(0,1) + ".";

function getUserInfo(){
  mode = "getInfo";

  var xhttp = new XMLHttpRequest();
  var url = "../php/UsersRICH.php";
  var params = "mode=" + mode;

  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200){
      userInfo = this.responseText;
    }
  };

  xhttp.open("POST", url, false);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send(params);
}

function Logout(){
  mode = "Logout";

  var xhttp = new XMLHttpRequest();
  var url = "../php/UsersRICH.php";
  var params = "mode=" + mode;

  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200){

    }
  };

  xhttp.open("POST", url, false);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send(params);

  window.location.href = "../index.html";
}

function getProfileData(){
  mode = "getProfileData";

  var xhttp = new XMLHttpRequest();
  var url = "../php/UsersRICH.php";
  var params = "mode=" + mode;

  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200){
      profileData = JSON.parse(this.responseText);
    }
  };

  xhttp.open("POST", url, false);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send(params);
}

</script>

<script>

function getStatus(date, day){
  mode = "getWritingStatus";

  var xhttp = new XMLHttpRequest();
  var url = "../php/RICHProjects.php";
  var params = "mode=" + mode + "&date=" + date + "&day=" + day;

  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200){
      if (this.responseText != null){
        statusCheck = this.responseText;
      }
    }
  };

  xhttp.open("POST", url, false);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send(params);
}
</script>

</body>
</html>
