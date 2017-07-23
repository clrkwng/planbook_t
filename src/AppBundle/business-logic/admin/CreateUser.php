<?php
require_once "../db/dbcomm.php";
//create db connection
$dbcomm = new dbcomm();

if(!isset($_GET['id'])){
    die("Error: The ID was not set.");
}

$accountID = openssl_decrypt($_GET['id'], 'bf-ecb', 'makeNewUserPassword');

$errorCount = 0;

if(isset($_POST['user-password'])) {
    $password = filter_var($_POST['user-password'], FILTER_SANITIZE_STRING);
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number = preg_match('@[0-9]@', $password);
    if (!$uppercase || !$lowercase || !$number || strlen($password) < 8) {
        $errorCount++;
        $alert .= '<div class="alert alert-danger alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Error!</strong>  Your password does not meet the requirements.</div>';
    }
}
if(isset($_POST['user-repassword']) and $_POST['user-password']) {
    $repassword = filter_var($_POST['user-repassword'], FILTER_SANITIZE_STRING);
    if($repassword != $_POST['user-password']) {
        $errorCount++;
        $alert .= '<div class="alert alert-danger alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Error!</strong>  The passwords do not match.</div>';
    }
}
if (isset($_POST['user-phonenumber'])){
    if(!preg_match("/^\(\d{3}\) \d{3}-\d{4}$/", $_POST['user-phonenumber'])){
        $errorCount++;
        $alert .= '<div class="alert alert-danger alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong>Error!</strong>  Invalid phone number.</div>';
    }
}
if(isset($_POST["user-email"])){
    if (!filter_var($_POST["user-email"], FILTER_VALIDATE_EMAIL)) {
        $errorCount++;
        $alert .= '<div class="alert alert-danger alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Error!</strong>  Invalid email.</div>';
    }
}

if ($errorCount == 0 && isset($_POST['user-password'])) {
    $username = $_POST['user-username'];
    $password = sha1($_POST['user-password']);
    $email = $_POST['user-email'];
    $phonenumber = preg_replace('/\D+/', '', $_POST['user-phonenumber']);

    if($dbcomm->checkIfUsernameExists($username)) {
        $errorCount += 1;
        $alert .= '<div class="alert alert-warning alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Sorry!</strong> That username is already in use.</div>';
    }
    if($dbcomm->checkIfPhonenumberExists($phonenumber)) {
        $errorCount += 1;
        $alert .= '<div class="alert alert-warning alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Sorry!</strong> That phone number is already associated with an account.</div>';
    }
    if($dbcomm->checkIfEmailExists($email)) {
        $errorCount += 1;
        $alert .= '<div class="alert alert-warning alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Sorry!</strong> That email is already associated with an account.</div>';
    }
    if ($errorCount == 0) {
        $dbcomm->createNewUser($accountID, $username, $password, $email, $phonenumber);
        $adminUsername = $dbcomm->getAdminUsernameByAccountID($accountID);
        $encryptedUsername = openssl_encrypt($adminUsername, 'bf-cfb', 'adminPanelPassword');
        echo "<script>window.location = '../testApplication/AdminPanel.html?id=$encryptedUsername';</script>";
    }
}
else {
    echo "<script>document.getElementById(\"user-password\").innerHTML = \"\";</script>";
    echo "<script>document.getElementById(\"user-repassword\").innerHTML = \"\";</script>";
}

?>