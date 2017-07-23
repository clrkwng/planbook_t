<?php
require_once "../db/dbcomm.php";
//create db connection
$dbcomm = new dbcomm();

if (isset($_POST['Submit'])){
    if(isset($_POST['recovery-email'])){
        $email = $_POST['recovery-email'];
        if ($dbcomm->checkIfEmailExists($email)){
            $username = $dbcomm->getUsernameByEmail($email);
            $encryptedUsername = openssl_encrypt("$username", 'CAST5-CBC', 'resetPasswordPassword');
            $message = "<html><body><div>Hello,<br><br>
Your username is <b>$username</b>.<br><br>
Click on the following link to reset your Planbook password.<br><br>
<a href='/planbook/modules/auth/PasswordReset.html?id=$encryptedUsername'>Reset Password</a><br><br>
Please ignore this email if you did not request a password change.<br><br>
As always, thanks for using Planbook!<br><br>
Planbook Services<br>
<a href='/planbook/modules/index.html'>www.planbook.com</a>
</div></body></html>";
            $headers = "From: noreply@planbook.xyz"."\r\n";
            $headers .= "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            mail( $email, "Planbook Recovery Email", $message, $headers);

            $alert .='<div class="alert alert-success alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> Email has been sent. </div>';
        }

        else{
            $alert .= '<div class="alert alert-warning alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> This email is currently not registered. </div>';
        }
    }
}
?>