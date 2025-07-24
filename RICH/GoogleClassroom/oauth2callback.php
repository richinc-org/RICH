<?php
header("Access-Control-Allow-Origin: *");

require_once __DIR__.'/vendor/autoload.php';

session_start();

$client = new Google_Client();
$client->setAuthConfigFile('client_id.json');
$client->setRedirectUri('https://www.richinc.org/RICH/GoogleClassroom/oauth2callback.php');
$client->setScopes(array('https://www.googleapis.com/auth/classroom.courses.readonly', 'https://www.googleapis.com/auth/classroom.announcements.readonly', 'https://www.googleapis.com/auth/classroom.coursework.me.readonly', 'https://www.googleapis.com/auth/userinfo.email', 'https://www.googleapis.com/auth/classroom.coursework.students.readonly'));
#$client->setAccessType('offline');

if (! isset($_GET['code'])) {
  $auth_url = $client->createAuthUrl();
  //header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
  echo $auth_url;
  //open_window($auth_url);
} else {
    $client->authenticate($_GET['code']);
    $_SESSION['access_token'] = $client->getAccessToken();

    $google_oauth = new Google_Service_Oauth2($client);
    $google_account_user = $google_oauth->userinfo->get();

    $email = $google_account_user->email;
    echo $email;
    echo $_SESSION['userName'];
    //echo json_encode($google_account_email);
    //echo json_encode($emailArray->email);

    if ($_SESSION['userName'] != $email){
      //echo "https://venus.cs.qc.cuny.edu/~yoes9965/RICH/falseAddress.html";
      //unset($_SESSION['access_token']);
      //unset($_GET['code']);
      unset($_SESSION['userName']);

      //$client->delete();
      $client = new Google_Client();

      $redirect_uri = 'https://www.richinc.org/RICH/falseAddress.html';
      header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
    }

    else {
      $redirect_uri = "https://www.richinc.org/RICH/GoogleClassroom/classAPI.php";
      header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
    }
}

?>
