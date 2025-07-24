<?php 
  require("../classes/connect.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>RICH &mdash; Reach Into Cultural Heights</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link rel="shortcut icon" type="image/x-icon" href="../images/favicon.ico" />

  <link href="https://fonts.googleapis.com/css?family=Amatic+SC:400,700|Work+Sans:300,400,700" rel="stylesheet">
  <link rel="stylesheet" href="../fonts/icomoon/style.css">

  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/magnific-popup.css">
  <link rel="stylesheet" href="../css/jquery-ui.css">
  <link rel="stylesheet" href="../css/owl.carousel.min.css">
  <link rel="stylesheet" href="../css/owl.theme.default.min.css">
  <link rel="stylesheet" href="../css/bootstrap-datepicker.css">
  <link rel="stylesheet" href="../css/animate.css">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/mediaelement@4.2.7/build/mediaelementplayer.min.css">



  <link rel="stylesheet" href="../fonts/flaticon/font/flaticon.css">

  <link rel="stylesheet" href="../css/aos.css">

  <link rel="stylesheet" href="../css/style.css">
  <style>
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
    <a href = "../index.html"><img class = "img-fluid" src="../images/LOGO.png"  href="../index.html" alt="..."></a>


  <div id = "piaContainer" class="container">

    <div class = "col-md-8 mx-auto no-sidebar" >
      <div class="shapely-content">
            <br><br>


            <div class="container" id="LoginForm">
              <form action="" method="POST">
                <h2 style="text-align: center; color: white;"> SIGN IN </h2>
                <h3 style="text-align: center; color: white;">RICH SUPER ADMINS</h3>
                <div class="form-group">
                  <label style="float:left;" for="userName">Username</label>
                  <input type="email" class="form-control" id="userEmail" name="logAemail" required></input>
                </div>
                <div class="form-group">
                  <label style="float:left;" for="userPass"> Password</label>
                  <input type="password" class="form-control" id="userPass" name="logApass" required></input>
                </div>
                <div id="falseCredentials" class="container" style="display: none;">
                  <div class="alert alert-danger" role="alert">
                    Hi there! Looks like one of your credentials is incorrect.
                  </div>
                </div>
                <br><br>
                <div class="buttoncontainer">
                  <button type="submit" name="logAsub"> Sign in </button>
                </div>

                <?php 
                  if (isset($_POST)) {
                    if (isset($_POST['logAsub'])) {
                      $aName = htmlspecialchars($_POST['logAemail']);
                      $aPass = htmlspecialchars($_POST['logApass']);
                      $db = new Database;
                      $conn = $db->connect();

                      $sql = "SELECT EmailAddress, Pass, Uid, FirstName, LastName FROM SuperAdm WHERE EmailAddress = '$aName';";

                      $result = $db->read($sql);
                      if ($result) {
                        $queryData = mysqli_num_rows($result);
                        if ($queryData > 0){
                          while ($row = mysqli_fetch_assoc($result)) {
                            $ApwdHashed = $row['Pass'];
                            if ($aName == $row['EmailAddress']){
                              if(password_verify($aPass, $ApwdHashed)){
                                session_start();
                                $_SESSION['SuperuserName'] = $aName;
                                $_SESSION['Superuid'] = $row['Uid'];
                                $_SESSION['Superfirstname'] = $row['FirstName'];
                                $_SESSION['Superlastname'] = $row['LastName'];
              ?>
                                <script type="text/javascript">
                                  window.location.href = "roster.php";
                                </script>
              <?php
                              }
                              else{
              ?>
                                <script type="text/javascript">
                                  document.getElementById("falseCredentials").style.display = "block";
                                </script>
              <?php
                              }
                            }
                            else{
              ?>
                              <script type="text/javascript">
                                document.getElementById("falseCredentials").style.display = "block";
                              </script>
              <?php
                            }
                          }
                        }
                      }
                    }
                    else{
                      
                    }
                  }
                ?>
              </form>
            </div>


          </div>
        </div>
      </div>
    </div>

    <br><br><br><br>
    <footer class="site-footer">
      <div class="container">

        <div class="row">
          <div class="col">
            <p class="text-center">
              <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
              Copyright &copy;
              <script data-cfasync="false"
                src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
              <script>document.write(new Date().getFullYear());</script> All Rights Reserved | This template is made by
              <a href="https://colorlib.com" target="_blank">Colorlib</a>
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
        window.location.href = "Account/portal-home.html";
      }
      //window.location.href = "login.php";
    }
    //---------------------------------------------------------------------------------

    var isUser;
    var username;
    var password;

    function Login() {

      var userEmail = document.getElementById("userEmail").value;
      var userPass = document.getElementById("userPass").value;

      checkLogin(userEmail, userPass);

      if (isUser == false) {
        document.getElementById("falseCredentials").style.display = "block";
      }
      return isUser;

    }

    function Check() {
      return isUser;
    }

    function checkLogin(email, pass) {
      mode = "Login";

      var xhttp = new XMLHttpRequest();
      var url = "php/AdminsRICH.php";
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

</body>

</html>
