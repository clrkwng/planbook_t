<?php
session_start();
if (isset($_COOKIE['username']) and isset($_COOKIE['password'])){
    $cookieUsername = $_COOKIE['username'];
    $cookiePassword = $_COOKIE['password'];
}


require_once "../db/dbcomm.php";
//create db connection
$dbcomm = new dbcomm();

if (isset($_POST['Submit'])) {
    if(isset($_POST['signin-username']) and isset($_POST['signin-password'])) {
        if($dbcomm->verifyCredentials($_POST['signin-username'], sha1($_POST['signin-password']))) {

            $username = $_POST['signin-username'];

            if($dbcomm->isAccountVerified($_POST['signin-username'])) {
                if($_POST['remember']=='yes'){
                    $cookie_name_username = 'username';
                    $cookie_value_username = $_POST['signin-username'];
                    setcookie($cookie_name_username, $cookie_value_username, time() + 60*60*24*7);
                    $cookie_name_password = 'password';
                    $cookie_value_password = $_POST['signin-password'];
                    setcookie($cookie_name_password, $cookie_value_password, time() + 60*60*24*7);
                }
                $type = $dbcomm->getTypeByUsername($_POST['signin-username']);
                if($type == "Admin") {
                    $encryptedUsername = openssl_encrypt($username,'bf-cfb','adminPanelPassword');
                    echo "<script>window.location = '../AdminPanel.html?id=$encryptedUsername'</script>";
                }
                elseif($type == "Regular") {
                    $encryptedUsername = openssl_encrypt($username,'RC4-40','regularUserPassword');
                    echo "<script>window.location = '../Homepage.html?id=$encryptedUsername'</script>";
                }
            }
            else {
                $encryptedUsername = openssl_encrypt("$username", 'RC4', 'sendVerificationEmailPassword');
                $alert .= "<div class='alert alert-warning alert-dismissible' role='alert'>
          <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
          <strong>Sorry!</strong> Please verify your account. <a href='VerifyAccount.php?id=$encryptedUsername'>Click here</a> to resend the verification email.</div>";
            }
        }
        else {
            $alert .= '<div class="alert alert-danger alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Error!</strong> Incorrect Username/Password</div>';
        }
    }
}
?>
