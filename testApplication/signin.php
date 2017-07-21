<?php
session_start();
if (isset($_COOKIE['username']) and isset($_COOKIE['password'])){
    $cookieUsername = $_COOKIE['username'];
    $cookiePassword = $_COOKIE['password'];
}


require_once "dbcomm.php";
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
                    echo "<script>window.location = 'adminPanel.php?id=$encryptedUsername'</script>";
                }
                elseif($type == "Regular") {
                    $encryptedUsername = openssl_encrypt($username,'RC4-40','regularUserPassword');
                    echo "<script>window.location = 'homepage.php?id=$encryptedUsername'</script>";
                }
            }
            else {
                $encryptedUsername = openssl_encrypt("$username", 'RC4', 'sendVerificationEmailPassword');
                $alert .= "<div class='alert alert-warning alert-dismissible' role='alert'>
          <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
          <strong>Sorry!</strong> Please verify your account. <a href='http://dev1.planbook.xyz/testApplication/accountVerificationEmail.php?id=$encryptedUsername'>Click here</a> to resend the verification email.</div>";
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
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>

    <!-- CSS -->
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
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
                    <a href ="signin.php">Login/Sign up</a>
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
                <div class="col-sm-8 col-sm-offset-2 text">
                    <h1>
                        <font color="White" style="font-size: 1.5em;"><strong>Planbook</strong> Login Page</font>
                    </h1>
                    <div class="description">
                        <p>
                            <font color="White" style="font-size:1.5em;" >"To achieve <strong>big</strong> things, start small!"</font>
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
                    <div class="form-top">
                        <div class="form-top-left">
                            <h3>Login to our site</h3>
                            <p>Enter your credentials to log on:</p>
                        </div>
                        <div class="form-top-right">
                            <i class="fa fa-key"></i>
                        </div>
                    </div>
                    <div class="form-bottom">
                        <form role="form" action="signin.php" method="post" class="login-form">
                            <div class="form-group">
                                <label class="sr-only" for="signin-username">Username</label>
                                <input type="text" name="signin-username" placeholder="Username..."
                                       class="form-control" id="signin-username"
                                       value="<? echo (isset($cookieUsername))?$cookieUsername:''; ?>">
                            </div>
                            <div class="form-group">
                                <label class="sr-only" for="signin-password">Password</label>
                                <input type="password" name="signin-password" placeholder="Password..."
                                       class="form-control" id="signin-password"
                                       value="<? echo (isset($cookiePassword))?$cookiePassword:''; ?>">
                            </div>
                            <table cellpadding="0" cellspacing="0" border="0" style="width:100%">
                                <tr>
                                    <td align = "left"><div class="form-group"><input type="checkbox" name="remember" value="yes">&nbsp;&nbsp;Remember me</div></td>
                                    <td align = "right"><div class = "form-group"><a href="sendRecoveryEmail.php">Forgot login?</a></div></td>
                                </tr>
                            </table>
                            <button class = "btn" type = "submit" name="Submit">Login</button>
                        </form>
                        <div>

                        </div>
                    </div>
                </div>
            </div>
            <div class = "row">
                Don't have an account yet? <a href="signup.php">Click Here</a>
            </div>
        </div>
    </div>

</div>


<!-- Javascript -->
<script src="assets/js/jquery-1.11.1.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/jquery.backstretch.min.js"></script>
<script src="assets/js/scripts.js"></script>

<!--[if lt IE 10]-->
<script src="assets/js/placeholder.js"></script>
<!--[endif]-->

</body>

</html>