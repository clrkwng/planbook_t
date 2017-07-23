<?php
require_once "../db/dbcomm.php";
//create db connection
$dbcomm = new dbcomm();

if(!isset($_GET['id'])) {
    die("Error: The id was not set.");
}
$username = openssl_decrypt($_GET['id'], 'CAST5-CBC', 'resetPasswordPassword');

if(isset($_POST['Submit'])) {
    $errorCount = 0;

    if (isset($_POST['reset-newPassword']) and isset($_POST['reset-rePassword'])) {
        $password = filter_var($_POST['reset-newPassword'], FILTER_SANITIZE_STRING);
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number = preg_match('@[0-9]@', $password);
        if (!$uppercase || !$lowercase || !$number || strlen($password) < 8) {
            $errorCount++;
            $alert .= '<div class="alert alert-danger alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Error!</strong>  Your password does not meet the requirements.</div>';
        }

        $repassword = filter_var($_POST['reset-rePassword'], FILTER_SANITIZE_STRING);
        if ($repassword != $_POST['reset-newPassword']) {
            $errorCount++;
            $alert .= '<div class="alert alert-danger alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Error!</strong>  The passwords do not match.</div>';
        }
    }


    if ($errorCount == 0 && isset($_POST['reset-newPassword'])) {
        $password = sha1($_POST['reset-newPassword']);
        $dbcomm->resetPasswordByUsername($username, $password);
        echo "<script>window.location = '/src/AppBundle/views/auth/Login.html'</script>";
    }
}
?>