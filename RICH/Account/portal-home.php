<?php 
require("../classes/connect.php");
$servername = "mysqlcluster9.registeredsite.com";
$username = "rich_main";
$password = "Ey_123123";
$dbname = "rich_users";

session_start();

// Create connection

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$userInfo = $conn->prepare("SELECT FirstName FROM Students WHERE EmailAddress = (?)");
$userInfo->bind_param("s", $_SESSION['userName']);
//$email = "dawsonjacqueline1@gmail.com";
//$userInfo->bind_param("s", $email);
$userInfo->execute();
$row = $userInfo->get_result()->fetch_assoc();

if(!isset($row['FirstName'])) {
  //header('Location: ./../notLogin.html');
}
?>



<!DOCTYPE html>
<html lang="en">

<script>



<?php 
/**
  getUserInfo();
  
  if (userInfo == "") {
    //window.location.href = "../notLogin.html";
  }

  function getUserInfo() {
    mode = "getInfo";

    var xhttp = new XMLHttpRequest();
    var url = "./../php/UsersRICH.php";
    var params = "mode=" + mode;

    xhttp.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        window.alert(this.responseText);
        return this.responseText;
      }
    };

    xhttp.open("POST", url, false);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(params);
  }
  */
?>

</script>

<head>
  <title>RICH &mdash; Reach Into Cultural Heights</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link rel="shortcut icon" type="image/x-icon" href="../images/favicon.ico" />

  <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

  <link href="https://fonts.googleapis.com/css?family=Amatic+SC:400,700|Work+Sans:300,400,700" rel="stylesheet">
  <link rel="stylesheet" href="../fonts/icomoon/style.css">

  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/magnific-popup.css">
  <link rel="stylesheet" href="../css/jquery-ui.css">
  <link rel="stylesheet" href="../css/owl.carousel.min.css">
  <link rel="stylesheet" href="../css/owl.theme.default.min.css">
  <link rel="stylesheet" href="../css/bootstrap-datepicker.css">
  <link rel="stylesheet" href="../css/animate.css">
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/mediaelement@4.2.7/build/mediaelementplayer.min.css">

  <link rel="stylesheet" href="../fonts/flaticon/font/flaticon.css">

  <link rel="stylesheet" href="../css/aos.css">

  <link rel="stylesheet" href="../css/style.css">
  <style>
    .paragraph,
    ul li {
      font-size: 13pt;
      line-height: 1.7;
      color: rgba(0, 0, 0, 0.7);
    }

    #mission {
      position: relative;
    }

    #mission::before {
      content: "OUR MISSION";
      font-size: 13pt;
      line-height: 30px;
      letter-spacing: 4px;
      position: absolute;
      top: -30px;
      left: 0;
      color: #3352af;
      font-weight: bold;
    }
	
	#mission, #audio1{
		display: inline-block;
		margin-right: 10px;
	}
  </style>
  <script>
	function playS(){
		sound = new Audio("../audio/RICH_Welcome.mp3");
		sound.play();
	}
   </script>
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

    <div id="myLogo" style="padding: 0;" class="site-navbar-wrap js-site-navbar bg-white">

      <div class="container-fluid">

        <div class="text-center">
          <a href="../index.html"><img class="img-fluid" src="../images/LOGO-Larger.png" href="../index.html"
              alt="..."></a>
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

    <div id="logoHeight" style="height: 400px;"></div>


    <!--<div id "logoHeight" style="height: 250px;"></div>-->

    <div style="padding-bottom: 50px;" class="text-center">
      <div id="piaContainer" class="container">
        <div class="col-md-12 mx-auto no-sidebar text-left">
          <h1 style="color: #2f4279; margin-left: 1em;" class="text-center"> REACH FOR SUCCESS PROGRAM </h1><br>
          <br />
          <div class="text-center">
            <img class="img-fluid" style="width: 80%; margin-top: -20px; border-radius: 4px;"
              src="../images/rich-image2.jpg" alt="" width="640" height="427"></div>
          <br />
          <div class="text-center" style="display: grid; place-items: center;">
            <h4 class="text-center" style="width: 80%;">Welcome to the new “Reach for Success” Program online sessions.
              These digital sessions are designed to encourage you to use the RICH Principles.<h4>
          </div>
          <br>
          <div style="margin-top: -100px;" class="site-section site-block-feature">
            <div class="container">
              <h2 style="color: #2f4279; margin-left: 1em;" class="text-center"> RICH 4 GUIDING PRINCIPLES </h2><br>
              <div class="d-block d-md-flex border-bottom">
                <div class="text-center p-4 item border-right">
                  <span class="display-3 mb-3 d-block text-primary"><img style="cursor: pointer;"
                      onclick="window.location.href = '../mission.html'" src="../images/matter.png"></span>

                  <p class="text-center" style="font-size: 20px; font-weight: 700;">My goal is to maintain a
                    positive attitude.
                  </p>
                  <!-- <p><a href="#">Read More <span class="icon-arrow-right small"></span></a></p> -->

                </div>
                <div class="text-center p-4 item">
                  <span class="display-3 mb-3 d-block text-primary"><img style="cursor: pointer;"
                      onclick="window.location.href = '../mission.html'" src="../images/responsibility.png"></span>

                  <p class="text-center" style="font-size: 20px; font-weight: 700;">My goal is to put forth more
                    effort to
                    improve my self-management skills.</p>
                  <!-- <p><a href="#">Read More <span class="icon-arrow-right small"></span></a></p> -->

                </div>
              </div>
              <div class="d-block d-md-flex">
                <div class="text-center p-4 item border-right">
                  <span class="display-3 mb-3 d-block text-primary"><img style="cursor: pointer;"
                      onclick="window.location.href = '../overview.html'" src="../images/considerate.png"></span>

                  <p class="text-center" style="font-size: 20px; font-weight: 700;">My goal is to motivate myself in
                    the spirit
                    of teamwork to better my relationship with others.</p>
                  <!-- <p><a href="#">Read More <span class="icon-arrow-right small"></span></a></p> -->

                </div>
                <div class="text-center p-4 item">
                  <span class="display-3 mb-3 d-block text-primary"><img style="cursor: pointer;"
                      onclick="window.location.href = '../overview.html'" src="../images/strategies.png"></span>

                  <p class="text-center" style="font-size: 20px; font-weight: 700;">I am committed to setting
                    well-defined and
                    realistic goals that demonstrate my personal learning style.</p>
                  <!-- <p><a href="#">Read More <span class="icon-arrow-right small"></span></a></p> -->

                </div>
              </div>
            </div>
          </div>
          <br>
          <h4 id="mission" style="margin-top: -70px;">DEVELOPING POSITIVE RELATIONSHIPS</h4><button onclick="playS()" id="audio1" i class="fa fa-play"></button>
          <p class="paragraph">Practicing the 4 RICH Principles will help you develop skills in positively
            using language. You will learn how to think more clearly and write with better confidence and experience
            new learning attitudes to guide you towards school success. It is important for you to understand that
            your first experience in achieving life success starts now, while you’re a
            student in school. What you are most often not told is that success in school, and everyday life, is
            based on your ability
            to build positive relationships. Our online lessons will help you gain insight into fostering stronger
            and more meaningful relationships.</p>
          <ul>
            <li>Talking more freely about feeling positive </li>
            <li>Writing using Standard English with greater confidence</li>
            <li>Reading more “how to” books on topics of interest</li>
            <li>Becoming a good listener</li>
            <li>Learning how to ask questions</li>
            <li>Using “I” messages instead of quickly blaming others</li>
            <li>Developing positive thoughts to succeed in school</li>
            <li>Developing a positive attitude and behavior towards others </li>
            <li>Becoming a positive student peer leader </li>
          </ul>

          <p class="paragraph">The mastery of the RICH Principles will have a positive effect on your relationships
            in school, at
            home and in the community where you live. The RICH Principles will help you give positive feedback, and
            positive support to others, by becoming more concerned for others. Most importantly you will take
            control of your learning by being responsible for your own behavior in school and at home.</p>
          <br>
          <h2 class="text-center">Best wishes on your Reach for Success journey!</h2>
        </div>
      </div>
    </div>
  </div>


  <footer class="site-footer">
    <div class="container">

      <div class="row">
        <div class="col">
          <p class="text-center">
              Email: rich@att.net
              <br>
              Phone: (929) 242-9036
              <br>
              Address: Tech Incubator at Queens College, 65-30 Kissena Blvd, Flushing, NY 11367
              <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
           <br>
            Copyright &copy;
            <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
            <script>document.write(new Date().getFullYear());</script> All Rights Reserved | This template is made by <a
              href="https://colorlib.com" target="_blank">Colorlib</a>
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


  <script src="../js/mediaelement-and-player.min.js"></script>

  <script src="../js/main.js"></script>

  <script>

    window.onscroll = function () {

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
    if (profileData[0].FirstName == "") {
      window.location.href = "../notLogin.html";
    }
    var lastName = profileData[0].LastName;
    document.getElementById("userInfo").innerHTML = "Hi " + profileData[0].FirstName + " " + lastName.substring(0, 1) + ".";

    function getUserInfo() {
      mode = "getInfo";

      var xhttp = new XMLHttpRequest();
      var url = "../php/UsersRICH.php";
      var params = "mode=" + mode;

      xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          userInfo = this.responseText;
        }
      };

      xhttp.open("POST", url, false);
      xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhttp.send(params);
    }

    function Logout() {
      mode = "Logout";

      var xhttp = new XMLHttpRequest();
      var url = "../php/UsersRICH.php";
      var params = "mode=" + mode;

      xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {

        }
      };

      xhttp.open("POST", url, false);
      xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhttp.send(params);

      window.location.href = "../index.html";
    }

    function getProfileData() {
      mode = "getProfileData";

      var xhttp = new XMLHttpRequest();
      var url = "../php/UsersRICH.php";
      var params = "mode=" + mode;

      xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          profileData = JSON.parse(this.responseText);
        }
      };

      xhttp.open("POST", url, false);
      xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhttp.send(params);
    }

  </script>

  <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

  <script>
    var quill = new Quill('#editor', {
      theme: 'snow'
    });


    function Submit() {
      var danger = document.getElementById("danger");
      var text = quill.getText();
      var principlesUsed = document.getElementById("principlesUsed").value;
      var d = new Date();
      var date = d.toLocaleDateString();
      var day = d.getDay();

      if (checkStrings()) {
        document.getElementById("emptyInput").style.display = "block";
        document.getElementById("alreadySubmitted").style.display = "none";
      }

      else {
        getStatus(date, day);

        if (statusCheck == "true") {
          addToDB(date, day, text, principlesUsed);
          document.getElementById("successfulSubmit").style.display = "block";
          document.getElementById("emptyInput").style.display = "none";
          clearAreas();
        }
        else {
          document.getElementById("successfulSubmit").style.display = "none";
          document.getElementById("alreadySubmitted").style.display = "block";
          document.getElementById("emptyInput").style.display = "none";
          clearAreas();
        }
      }
    }

    function checkStrings() {
      if (document.getElementById("principlesUsed").value == " " || quill.getLength() == 1) {
        return true;
      }
      return false;
    }

    function addToDB(date, day, text, principlesUsed) {
      //alert(text);
      //alert(projectName);
      mode = "addWriting";

      var xhttp = new XMLHttpRequest();
      var url = "../php/RICHProjects.php";
      var params = "mode=" + mode + "&date=" + date + "&day=" + day + "&essay=" + text + "&pUsed=" + principlesUsed;

      xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {

        }
      };

      xhttp.open("POST", url, false);
      xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhttp.send(params);

    }

    function clearAreas() {
      quill.setText('');
      $('#principlesUsed').val('');
    }

    function getStatus(date, day) {
      mode = "getWritingStatus";

      var xhttp = new XMLHttpRequest();
      var url = "../php/RICHProjects.php";
      var params = "mode=" + mode + "&date=" + date + "&day=" + day;

      xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          if (this.responseText != null) {
            statusCheck = this.responseText;
          }
        }
      };

      xhttp.open("POST", url, false);
      xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhttp.send(params);
    }
  </script>
<?php
/**
echo 'DEBUG';

echo '<pre>';
var_dump(session_id());
var_dump($_SESSION['userName']);
var_dump($_SESSION['uid']);
var_dump($_SESSION['firstname']);
var_dump($_SESSION['lastname']);
echo '</pre>';

echo '<pre>';
var_dump($_SESSION);
echo '</pre>';
**/
?>

</body>

</html>