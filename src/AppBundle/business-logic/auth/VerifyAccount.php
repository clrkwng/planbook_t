<?php
require_once "../db/dbcomm.php";
//create db connection
$dbcomm = new dbcomm();

if(!isset($_GET['id'])) {
    die("Error: The id was not set.");
}
$encryptedUsername = $_GET['id'];
$username = openssl_decrypt($encryptedUsername, 'RC4', 'sendVerificationEmailPassword');

if($dbcomm->checkIfUsernameExists($username)){
    $dbcomm->verifyAccountByUsername($username);
}


?>