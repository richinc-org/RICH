<?php 
  require("classes/connect.php");
   session_start();
?>
<?php
    if (isset($_POST)) {
      if (isset($_POST['submit'])) {
        $uName = htmlspecialchars($_POST['uEmail']);
        $uPass = htmlspecialchars($_POST['uPass']);
        $db = new Database;
        $conn = $db->connect();
        $sql = "SELECT EmailAddress, Pass, Uid, FirstName, LastName, Status FROM Students WHERE EmailAddress = '" . $uName . "';";
        $result = $db->read($sql);
        if ($result) {
          $queryData = mysqli_num_rows($result);
          if ($queryData > 0){
            while ($row = mysqli_fetch_assoc($result)) {
              $pwdHashed = $row['Pass'];
              if ($uName == $row['EmailAddress']){
                if(password_verify($uPass, $pwdHashed)){
                  if (htmlspecialchars($row['Status']) == "active") {
                    session_destroy();
                    session_start();
                    $_SESSION['userName'] = $uName;
                    $_SESSION['uid'] = $row['Uid'];
                    $_SESSION['firstname'] = $row['FirstName'];
                    $_SESSION['lastname'] = $row['LastName'];

                    header("Location: Account/portal-home.php");
                  }
                  else{
                    // Login Failed A
                  }
                }
                else{
                  // Login Failed B
                }
              }
              else{
                // Login Failed C
              }
            }
          }
        }
      }
      else{
        
      }
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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">



  <link rel="stylesheet" href="fonts/flaticon/font/flaticon.css">

  <link rel="stylesheet" href="css/aos.css">

  <link rel="stylesheet" href="css/style.css">

  <style>
    h4,
    ul {
      text-align: left;
    }

    .buttoncontainer {
      position: absolute;
      bottom: 0;
      width: 100%;
      left: 0;
    }

    .buttoncontainer button {
      border-bottom-right-radius: 18px;
      border-bottom-left-radius: 18px;
      border: none;
      width: 100%;
      padding: 12px 0px;
      background: transparent;
      color: white;
      font-size: 15pt;
      transition: all 250ms linear;
    }

    .buttoncontainer button:hover {
      background: rgba(47, 66, 121, 1);
      transition: all 250ms linear;
    }

    .formlink {
      color: rgba(255, 255, 255, 0.555);
    }

    .formlink:hover {
      color: white;
    }

    .centerit {
      display: grid;
      align-items: center;
      justify-items: center;
    }

    .feature {
      font-weight: 500;
      color: black;
    }

    /* #footerSpacing {
      padding-bottom: 200px;
    } */
	
	.icon-links{
		text-align: center;
		font-size: 24px;
		width: 100%;
	}
		
	@media only screen and (min-width: 1400px) {
		.icon-links {
			padding-right: 55px;
		}
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

    <div style="top: 0px;" id="myLogo" class="site-navbar-wrap js-site-navbar bg-white">



    <div class="container-fluid">

<div class="text-center pics_in_a_row">
  <a href="https://www.instagram.com/p/CqocMt_PwZ3/?utm_source=ig_web_button_share_sheet">
    <img class="img-fluid top" src="3decade.png"
      href="https://www.instagram.com/p/CqocMt_PwZ3/?utm_source=ig_web_button_share_sheet" alt="..." width="200"
      height="200"></a>


  <a href="index.html"><img class="img-fluid top" src="images/LOGO.png" href="index.html" alt="..."></a>

  <a href="https://www.richinc.org/RICH/rich_new_vision/rich_new_vision.html">
    <img class="img-fluid top" src="nvl.png" alt="..." width="200" height="187">
  </a>
</div>

		<div class="icon-links">
			<a href="https://www.instagram.com/richincstudents/" target = "_blank"><i class="fa fa-instagram"></i></a>
			<a href="https://www.facebook.com/richincstudents/?modal=admin_todo_tour" target = "_blank"><i class="fa fa-facebook-square"></i></a>
			<a href="https://www.linkedin.com/company/reach-into-cultural-heights/" target = "_blank"><i class="fa fa-linkedin-square"></i></a>
			<a href="https://twitter.com/richincstudents" target = "_blank"><i class="fa fa-twitter-square"></i></a>
			<a href="https://www.youtube.com/channel/UCqAvWoYXzpvOtIstzJ8LBBg?view_as=subscriber" target = "_blank"><i class="fa fa-youtube-square"></i></a>
		</div>

    <div class="site-navbar bg-light">
          <div class="py-1">
            <div class="row align-items-left">

              <div class="col-12">
                <nav class="site-navigation text-center" role="navigation">
                  <div class="container-fluid">
                    <div class="d-inline-block d-lg-none ml-md-0 mr-auto py-3" style="float:right;"><a href="#"
                        class="site-menu-toggle js-menu-toggle text-black"><span class="icon-menu h3"></span></a></div>

                    <ul class="site-menu js-clone-nav d-none d-lg-block">
                  
                      <li><a class="activelink" href="index.html">Home</a></li>

                      <li class="has-children">
                        <a href="mission.html" style = "color:#c51f1f;">About Us</a>
                        <!-- <ul class="dropdown arrow-top">-->
                        <ul class="dropdown menu1">
                          <li><a href="mission.html">About Reach Into Cultural Heights</a></li>
                          <li><a href="board-directors.html">Board of Directors</a></li>
                          <li><a href="interns.html">CUNY Interns</a></li>
                          <li><a href="privacy-policy.html">Privacy Policy</a></li>
                        </ul> 
                      </li>



                      <li class="has-children">
                        <a href="overview.html" style = "color:#c5721f;">Our Work</a>
                        <!-- <ul class="dropdown arrow-top"> -->
                          <ul class="dropdown menu2">
                          <li><a href="overview.html">Program Overview</a></li>
                          <li><a href="rich-learning-system.html">RICH Learning System</a></li>
                          <li><a href="sdlp.html">Self-Directed Learning Projects</a></li>
                          <li><a href="nvlpessay1.html">RICH Student Essays to NVLP Elders</a></li>
                          <li><a href="projectsnack.html">RICH Snacking for Smartness</a></li>
                          <li><a href="reach-for-success.html">RICH Towards The Future</a></li>
                        </ul>
                      </li>

                      <li class="has-children">
                        <a href="graduate-testimonials.html" style="color:#2f7939;">Success Stories</a>
                        <!-- <ul class="dropdown arrow-top"> -->
                          <ul class="dropdown menu3">
                          <li><a href="graduate-testimonials.html">Graduate Testimonials</a></li>
                          <li><a href="first-graduates.html">First Graduates</a></li>
                          <li><a href="campaign1.html">Then & Now</a></li>
                        </ul>
                      </li>

                      <li><a href="parents-investment-alliance.html">Parents Investment Alliance</a></li>
                      <!--
                      <li><a href="gsuite-classroom.html">G Suite Classroom</a></li>-->

                      <li class="has-children">
                        <a href="podcasts.html" style = "color:#c51f1f;">Podcasts</a>
                        <!-- <ul class="dropdown arrow-top"> -->
                          <ul class="dropdown menu4">
                          <li><a href="podcasts.html">Reach For Success Program</a></li>
                        </ul>
                      </li>

                      <li class="has-children">
                        <a href="annual-reports.html"style = "color:#c5721f;">Contact Us</a>
                        <!-- <ul class="dropdown arrow-top"> -->
                          <ul class="dropdown menu5">
                          <li><a href="annual-reports.html">Annual Reports</a></li>
                          <li><a href="partnership-opportunities.html">Partnership Opportunities</a></li>
                          <li><a href="contact-us.html">Contact Us</a></li>
                        </ul>
                      </li>

                      <li class="has-children">
                        <a onclick="checkLogin()">RICH PORTAL</a>
                        <!-- <ul class="dropdown arrow-top"> -->
                          <ul class="dropdown menu6">
                          <li><a onclick="checkLogin()">Portal Login</a></li>
                          <li><a href="gsuite-classroom.html">G Suite Classroom</a></li>
                        </ul>
                      </li>
                      <!--
                      <li>
                        <button class="portalbutton" onclick="checkLogin()"> RICH PORTAL </button>
                      </li>
                    -->


                    </ul>

                  </div>
                </nav>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div id="logoHeight" style="height: 350px;"></div>
    <div id="footerSpacing" class="text-center">
      <div id="piaContainer" class="container">

        <div class="col-md-8 mx-auto no-sidebar">
          <div class="shapely-content">

            <h4 class = "feature">
              The RICH portal is an online belonging community that features:
            </h4>
            <ul>
              <li class = "feature one">RICH 4 guiding principles</li>
              <li class = "feature two">Essential Academic Tutorials</li>
              <li class = "feature three">Engaging Group Discussions</li>
              <li class = "feature four">Impactful Google Classroom Discussion</li>
              <li class = "feature five">Fun Activities Supporting RICH Program Principles</li>
            </ul>

            <br/>
            <div class="container" id="LoginForm">
              <form action="" method="POST">
                <h2 style="text-align: center; color: white;"> SIGN IN </h2>
                <h3 style="text-align: center; color: white;">RICH STUDENTS</h3>
                <div class="form-group">
                  <label style="float:left;" for="uName">Username</label>
                  <input type="email" name="uEmail" class="form-control" id="uEmail" required></input>
                </div>
                <div class="form-group">
                  <label style="float:left;" for="uPass">Password</label>
                  <input type="password" name="uPass" class="form-control" id="uPass" required></input>
                </div>
                <div id="falseCredentials" class="container" style="display: none;">
                  <div class="alert alert-danger" role="alert">
                    Hi there! Looks like one of your credentials is incorrect.
                  </div>
                </div>
                <div id="disabledAccount" class="container" style="display: none;">
                  <div class="alert alert-danger" role="alert">
                    This account no longer exist.
                  </div>
                </div>

                <!-- <div class="form-group">
                  <a class="formlink" href="loginAdmin.php"> Go To Adminstrator Account </a>
                </div> -->
                <br />
                <div class="buttoncontainer">
                  <button type="submit" name="submit"> SIGN IN </button>
                </div>
                
              </form>

          </div>
        </div>
      </div>
    </div>
    <br><br><br><br><br>

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
    //-----------------------------------------------------------------------------
    window.onscroll = function () {

      if (window.pageYOffset > 20) {
        document.getElementById("myLogo").style.top = "-250px";
        document.getElementById("logoHeight").style.height = "200px";
      } else {
        document.getElementById("myLogo").style.top = "0px";
        document.getElementById("logoHeight").style.height = "375px";
      }
    }

    var userInfo;
    getUserInfo();

    function getUserInfo() {
      mode = "getInfo";

      var xhttp = new XMLHttpRequest();
      var url = "php/UsersRICH.php";
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

    function checkLogin() {

      if (userInfo == "" || userInfo == "undefined") {
        window.location.href = "login.php";
      }
      else {
        window.location.href = "Account/portal-home.php";
      }
      //window.location.href = "login.php";
    }
    //---------------------------------------------------------------------------------

    var isUser;
    var username;
    var password;

    function Login() {

      var userEmail = document.getElementById("uEmail").value;
      var userPass = document.getElementById("uPass").value;
      
    }

    function Check() {
      return isUser;
    }

    function checkLogin(email, pass) {
      mode = "Login";

      var xhttp = new XMLHttpRequest();
      var url = "php/UsersRICH.php";
      var params = "mode=" + mode + "&email=" + email + "&pass=" + pass;

      xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          var String1 = "User Exists";
          var result = String1.localeCompare(this.responseText);
          if (result == 0) {
            isUser = true;
          }
          else isUser = false;
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

