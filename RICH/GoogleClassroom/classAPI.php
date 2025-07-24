<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Origin: 'https://accounts.google.com'");

require __DIR__ . '/vendor/autoload.php';

session_start();

$client = new Google_Client();
$client->setScopes(array('https://www.googleapis.com/auth/classroom.courses.readonly', 'https://www.googleapis.com/auth/classroom.announcements.readonly', 'https://www.googleapis.com/auth/classroom.coursework.me.readonly', 'https://www.googleapis.com/auth/classroom.coursework.students.readonly'));
$client->setAuthConfig('client_id.json');
#$client->setAccessType('offline');

if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
  $client->setAccessToken($_SESSION['access_token']);

  // Get the API client and construct the service object.
  $service = new Google_Service_Classroom($client);

  $myCourses = array();
  $getCourses = array();
  //$getAnnouncements = array();
  $getCourseWork = array();
  $getStudentSubmissions = array();

  if ($_POST['mode'] == "getClasses"){

    if ($_SESSION['courseList'] == ""){
      // Print the first 10 courses the user has access to.
      $optParams = array(
        'pageSize' => 10
      );
      $results = $service->courses->listCourses($optParams);

      if (count($results->getCourses()) == 0) {
        //echo "No courses found\n";
      } else {
        //echo "Courses:\n";
        foreach ($results->getCourses() as $course) {
          //echo $course->getName(). "\n";
          //echo $course->getId(). "\n";
          //if ($course->getGuardiansEnabled() == true){
          array_push($myCourses, $course->getId());
          array_push($getCourses, $course->getName(), $course->getId(), $course->getAlternateLink());
          //}
        }
      }
      $_SESSION['courseList'] = $getCourses;
    }
    echo json_encode($_SESSION['courseList']);
  }

  /*
  for($i = 0; $i < sizeof($myCourses); $i++){
  $results2 = $service->courses_announcements->listCoursesAnnouncements($myCourses[$i]);

  if (count($results2->getAnnouncements()) == 0) {
  //echo "No Announcements found:\n";
} else {
//echo "Announcements:\n";
foreach ($results2->getAnnouncements() as $course) {
//echo $course->getState() . "\n";
//echo $course->getText() . "\n";
array_push($getAnnouncements, $course->getCourseId(), $course->getText(), $course->getCreationTime());
}
}
}
*/

else if ($_POST['mode'] == "getCourseWork"){

  $coursesArray = $_SESSION['courseList'];
  if($_SESSION['courseArray'] == ""){
    $results3 = $service->courses_courseWork->listCoursesCourseWork($_POST['course']);
    if(count($results3->getCourseWork()) == 0){

    }
    else{
      foreach ($results3->getCourseWork() as $course) {
        $tempArray = array();
        //array_push($tempArray, $course->getId(), $course->getTitle(), $course->getAlternateLink());
        $tempArray[] = $course->getId();
        $tempArray[] = $course->getTitle();
        $tempArray[] = $course->getAlternateLink();

        //array_push([$getCourseWork], $tempArray);
        $getCourseWork[] = $tempArray;

      }
    }
    $_SESSION['courseArray'] = $getCourseWork;
  }
  echo json_encode($_SESSION['courseArray']);

}

//echo json_encode($submissionStates);

else if ($_GET['mode'] == "getAssignmentStatus"){
  /*
  $courseWorkArray = array();
  $getStudentSubmissions = array();

  $results3 = $service->courses_courseWork->listCoursesCourseWork($_GET['course']);
  if(count($results3->getCourseWork()) == 0){

}
else{
foreach ($results3->getCourseWork() as $course) {
$tempArray = array();
//array_push($tempArray, $course->getId(), $course->getTitle());
$tempArray[] = $course->getId();
$tempArray[] = $course->getTitle();

//array_push($courseWorkArray, $tempArray);
$courseWorkArray[] = $tempArray;
}
}
*/
$courseWorkArray = $_SESSION['courseArray'];
if ($_SESSION['Submissions'] == ""){
  for ($i = 0; $i < sizeof($courseWorkArray); $i++){
    $results4 = $service->courses_courseWork_studentSubmissions->listCoursesCourseWorkStudentSubmissions($_GET['course'], $courseWorkArray[$i][0]);
    $assignmentArray = array();
    if(count($results4->getStudentSubmissions()) == 0){
      // Do Nothing
    }
    else{
      foreach ($results4->getStudentSubmissions() as $sub) {
        if($sub -> getState() == "TURNED_IN"){
          //array_push($assignmentArray, $courseWorkArray[$i][1], $courseWorkArray[$i][0], $sub -> getState());
          $assignmentArray[] = $courseWorkArray[$i][1];
          $assignmentArray[] = $courseWorkArray[$i][0];
          $assignmentArray[] = $sub -> getState();

          //array_push($getStudentSubmissions, $assignmentArray);
          $getStudentSubmissions[] = $assignmentArray;
        }
        //echo $courseWorkArray[$i][1];
      }
    }
  }
  $_SESSION['Submissions'] = $getStudentSubmissions;
}

echo json_encode($_SESSION['Submissions']);

/*
$results4 = $service->courses_courseWork_studentSubmissions->listCoursesCourseWorkStudentSubmissions($_POST['course'], $_POST['assignmentID']);
$getStudentSubmissions = array();
$assignmentArray = array();
if(count($results4->getStudentSubmissions()) == 0){
// Do Nothing
}
else{
foreach ($results4->getStudentSubmissions() as $sub) {
array_push($assignmentArray, $_POST['title'], $_POST['assignmentID'], $sub -> getState());
array_push($getStudentSubmissions, $assignmentArray);
}
}
echo json_encode($getStudentSubmissions);
*/

//echo $courseWorkArray[0][1];

}


//array_push($courseWork, $course->getId());
/*
$results4 = $service->courses_studentSubmissions>listCoursesCourseWorkStudentSubmissions($_POST['course'], $courseWork->getId());
$submission = $results4->getStudentSubmissions();
array_push($submissionStates, $submission->getState());
*/

/*
for ($i = 0; $i < sizeof($courseWork); $i++){
$results4 = $service->courses_studentSubmissions>listCoursesCourseWorkStudentSubmissions($_POST['course'], $courseWork[$i]);
foreach ($results4->getStudentSubmissions() as $submission) {
array_push($submissionStates, $submission->getState());
}
}
*/


else {
  $redirect_uri = 'https://www.richinc.org/RICH/Account/GoogleClassroom.html';
  header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}

}
else{
  $redirect_uri = "https://www.richinc.org/RICH/GoogleClassroom/oauth2callback.php";
  header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}

?>
