<?php
session_destroy();
session_start();
$_SESSION['userName'] = "userName";
$_SESSION['uid'] = "uid";
$_SESSION['firstname'] = "firstname";
$_SESSION['lastname'] = "lastname";
?>

<?php
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

?>