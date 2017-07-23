<?php
    require_once "../db/dbcomm.php";
    //create db connection
    $dbcomm = new dbcomm();

    $errorCount = 0;

    if(isset($_POST['signup-password'])) {
        $password = filter_var($_POST['signup-password'], FILTER_SANITIZE_STRING);
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
    if(isset($_POST['signup-repassword']) and $_POST['signup-password']) {
        $repassword = filter_var($_POST['signup-repassword'], FILTER_SANITIZE_STRING);
        if($repassword != $_POST['signup-password']) {
            $errorCount++;
            $alert .= '<div class="alert alert-danger alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Error!</strong>  The passwords do not match.</div>';
        }
    }
    if (isset($_POST['signup-phonenumber'])){
        if(!preg_match("/^\(\d{3}\) \d{3}-\d{4}$/", $_POST['signup-phonenumber'])){
            $errorCount++;
            $alert .= '<div class="alert alert-danger alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong>Error!</strong>  Invalid phone number.</div>';
        }
    }
    if(isset($_POST["signup-email"])){
        if (!filter_var($_POST["signup-email"], FILTER_VALIDATE_EMAIL)) {
            $errorCount++;
            $alert .= '<div class="alert alert-danger alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Error!</strong>  Invalid email.</div>';
        }
    }

    if ($errorCount == 0 && isset($_POST['signup-password'])) {
        $accountName = $_POST['signup-accountName'];
        $username = $_POST['signup-username'];
        $password = sha1($_POST['signup-password']);
        $email = $_POST['signup-email'];
        $phonenumber = preg_replace('/\D+/', '', $_POST['signup-phonenumber']);

        if($dbcomm->checkIfAccountNameExists($accountName)) {
            $errorCount += 1;
            $alert .= '<div class="alert alert-warning alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Sorry!</strong> That accountName is already in use.</div>';
        }
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
            $dbcomm->createNewAdmin($accountName, $username, $password, $email, $phonenumber);
            $encryptedUsername = openssl_encrypt("$username", 'RC4', 'sendVerificationEmailPassword');
            #die($encryptedUsername . " ; 9xOTHT9ndaPbHaGq/ygu%20g== ::: " . openssl_decrypt("$encryptedUsername", 'BF-ECB', 'sendVerificationEmailPassword') . " ; " . openssl_decrypt('9xOTHT9ndaPbHaGq/ygu%20g==', 'BF-ECB', 'sendVerificationEmailPassword'));
            echo "<script>window.location ='../testApplication/AccountVerificationSender.html?id=$encryptedUsername';</script>";
        }
    }
    else {
        echo "<script>document.getElementById(\"signup-password\").innerHTML = \"\";</script>";
        echo "<script>document.getElementById(\"signup-repassword\").innerHTML = \"\";</script>";
    }

?>
<?php
require_once "dbcomm.php";
//create db connection
$dbcomm = new dbcomm();

$errorCount = 0;

if(isset($_POST['signup-password'])) {
    $password = filter_var($_POST['signup-password'], FILTER_SANITIZE_STRING);
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
if(isset($_POST['signup-repassword']) and $_POST['signup-password']) {
    $repassword = filter_var($_POST['signup-repassword'], FILTER_SANITIZE_STRING);
    if($repassword != $_POST['signup-password']) {
        $errorCount++;
        $alert .= '<div class="alert alert-danger alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Error!</strong>  The passwords do not match.</div>';
    }
}
if (isset($_POST['signup-phonenumber'])){
    if(!preg_match("/^\(\d{3}\) \d{3}-\d{4}$/", $_POST['signup-phonenumber'])){
        $errorCount++;
        $alert .= '<div class="alert alert-danger alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong>Error!</strong>  Invalid phone number.</div>';
    }
}
if(isset($_POST["signup-email"])){
    if (!filter_var($_POST["signup-email"], FILTER_VALIDATE_EMAIL)) {
        $errorCount++;
        $alert .= '<div class="alert alert-danger alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Error!</strong>  Invalid email.</div>';
    }
}

if ($errorCount == 0 && isset($_POST['signup-password'])) {
    $accountName = $_POST['signup-accountName'];
    $username = $_POST['signup-username'];
    $password = sha1($_POST['signup-password']);
    $email = $_POST['signup-email'];
    $phonenumber = preg_replace('/\D+/', '', $_POST['signup-phonenumber']);

    if($dbcomm->checkIfAccountNameExists($accountName)) {
        $errorCount += 1;
        $alert .= '<div class="alert alert-warning alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Sorry!</strong> That accountName is already in use.</div>';
    }
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
        $dbcomm->createNewAdmin($accountName, $username, $password, $email, $phonenumber);
        $encryptedUsername = openssl_encrypt("$username", 'RC4', 'sendVerificationEmailPassword');
        #die($encryptedUsername . " ; 9xOTHT9ndaPbHaGq/ygu%20g== ::: " . openssl_decrypt("$encryptedUsername", 'BF-ECB', 'sendVerificationEmailPassword') . " ; " . openssl_decrypt('9xOTHT9ndaPbHaGq/ygu%20g==', 'BF-ECB', 'sendVerificationEmailPassword'));
        echo "<script>window.location = '../testApplication/AccountVerificationSender.html?id=$encryptedUsername';</script>";
    }
}
else {
    echo "<script>document.getElementById(\"signup-password\").innerHTML = \"\";</script>";
    echo "<script>document.getElementById(\"signup-repassword\").innerHTML = \"\";</script>";
}

?>
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 7/23/2017
 * Time: 12:17 AM
 */