<?php
require_once "../db/dbcomm.php";
$dbcomm = new dbcomm();

if(!isset($_GET['id'])) {
    die("Error: The id was not set.");
}
$username = openssl_decrypt($_GET['id'], 'bf-cfb', 'adminPanelPassword');
$encryptedUsername = $_GET['id'];
$accountID = $dbcomm->getAccountIDByUsername($username);
$encryptedAccountID = openssl_encrypt($accountID, 'bf-ecb', 'makeNewUserPassword');

if(isset($_GET['delete'])) //delete the user
{
    $deleteUsername = $_GET['delete'];
    $dbcomm->deleteUserByUsername($deleteUsername);
    $alert = '<div class="alert alert-success alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Success!</strong>  The user has been deleted.</div>'; //successful deletion alert

}
?>