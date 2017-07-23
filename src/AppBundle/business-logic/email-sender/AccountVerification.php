<?php
require_once "../db/dbcomm.php";
//create db connection
$dbcomm = new dbcomm();

if(!isset($_GET['id'])) {
    die("Error: The id was not set.");
}
$encryptedUsername = $_GET['id'];
$username = openssl_decrypt($encryptedUsername, 'RC4', 'sendVerificationEmailPassword');

$email = $dbcomm->getEmailByUsername($username);

if ($dbcomm->checkIfEmailExists($email)) {
    $headers = "From: noreply@planbook.xyz" . "\r\n";
    $headers .= "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $message = "<html><body><div>Hello,<br><br>
        Click on the following link to verify your Planbook account.<br><br>
        <a href='/planbook/modules/auth/AccountVerification.html?id=$encryptedUsername'>Verify Account</a><br><br>
        Please ignore this email if you did not create a Planbook account.<br><br>
        As always, thanks for using Planbook!<br><br>
        Planbook Services<br>
        <a href='/planbook/modules/index.html'>www.planbook.com</a>
        </div></body></html>";
    mail($email, "Planbook Verification Email", $message, $headers);
}


?>