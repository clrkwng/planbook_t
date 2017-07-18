<?php
require_once "dbcomm.php";
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
<a href='http://dev1.planbook.xyz/testApplication/resetPassword.php?id=$encryptedUsername'>Reset Password</a><br><br>
Please ignore this email if you did not request a password change.<br><br>
As always, thanks for using Planbook!<br><br>
Planbook Services<br>
<a href='http://dev1.planbook.xyz/testApplication/index.html'>www.planbook.com</a>
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
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Planbook Login</title>

    <!-- CSS -->
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/form-elements.css">
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Favicon and touch icons -->
    <link rel="shortcut icon" href="assets/ico/favicon.png">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">

</head>

<body>
<nav id="mainNav" class="navbar navbar-default navbar-fixed-top navbar-custom">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header page-scroll">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span> Menu <i class="fa fa-bars"></i>
            </button>
            <a class="navbar-brand" href="index.html">Planbook</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href ="signin.php">Sign In/Sign up</a>
                </li>
                <li class="page-scroll">
                    <a href="index.html#portfolio">Activities</a>
                </li>
                <li class="page-scroll">
                    <a href="index.html#about">About</a>
                </li>
                <li class="page-scroll">
                    <a href="index.html#contact">Contact</a>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
</nav>
<!-- Top content -->
<div class="top-content">

    <div class="inner-bg">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3 text">
                    <h1 align="left">
                        <font color="#696969"><strong>Login Recovery Page</strong></font>
                    </h1>
                    <div class="">
                        <p align = "left">
                            <font color="696969">Enter your email and follow the instructions on resetting your password.</font>
                        </p>
                    </div>

                    <? if (isset($alert)) //if the alert for creating list is set, then echo the alert
                    {
                        echo '<div>';
                        echo $alert;
                        echo '</div>';
                    }
                    ?>
                </div>

                <div class="col-sm-6 col-sm-offset-3 form-box">
                    <div class="form-bottom">
                        <form role="form" action="" method="post" class="login-form">
                            <div class="form-group">
                                <label class="sr-only" for="recovery-email">Email</label>
                                <input type="email" name="recovery-email" placeholder="Email..."
                                       class="form-email form-control" id="recovery-email"
                                       value="">
                            </div>
                            <button class = "btn" type = "submit" name="Submit">Send email</button>
                        </form>
                        <div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


<!-- Javascript -->
<script src="assets/js/jquery-1.11.1.min.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/jquery.backstretch.min.js"></script>
<script src="assets/js/scripts.js"></script>

<!--[if lt IE 10]-->
<script src="assets/js/placeholder.js"></script>
<!--[endif]-->

</body>

</html>