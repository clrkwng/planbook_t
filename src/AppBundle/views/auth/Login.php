<?php
session_start();
$username = $password = '';

if (isset($_COOKIE['username']) and isset($_COOKIE['password'])){
    $cookieUsername = $_COOKIE['username'];
    $cookiePassword = $_COOKIE['password'];
}


require_once "../../scripts/dbcomm.php";
require_once "../../scripts/Crypto.php";

//create db connection
$dbcomm = new dbcomm();

if (isset($_POST['submitCredentials'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if($dbcomm->verifyCredentials($username, sha1($password))) {

        if($dbcomm->isAccountVerified($username)) {
           if(isset($_POST['remember'])){
               if($_POST['remember']=='yes'){
                   $cookie_name_username = 'username';
                   $cookie_value_username = $username;
                   setcookie($cookie_name_username, $cookie_value_username, time() + 60*60*24*7);
                   $cookie_name_password = 'password';
                   $cookie_value_password = $password;
                   setcookie($cookie_name_password, $cookie_value_password, time() + 60*60*24*7);
               }
           }
            $type = $dbcomm->getTypeByUsername($_POST['username']);
            if($type == "Admin") {
                $encryptedUsername = Crypto::encrypt($username, true);
                echo "<script>window.location = '../admin/AdminPanel.php?id=$encryptedUsername'</script>";
            }
            elseif($type == "User") {
                $encryptedUsername = Crypto::encrypt($username, true);
                echo "<script>window.location = '../user/Homepage.php?id=$encryptedUsername'</script>";
            }
        }
        else {
            $encryptedUsername = Crypto::encrypt($username, true);

            $alertMessage =
                '<div class="alert alert-danger alert-dismissible" role="alert">'
                    .'<button type="button" class="close" data-dismiss="alert" aria-label="Close">'
                        .'<span aria-hidden="true">&times;</span>'
                    .'</button>'
                    .'<strong>'
                        .'Error: '
                    .'</strong>'
                    .'<span>'
                        .'Please verify your account.\n'
                    .'</span>'
                    .'<a href="../email-sender/AccountVerificationSender.php?id=$encryptedUsername">'
                        .'Click here'
                    .'</a>'
                    .'<span>'
                        .' to resend the verification email.'
                    .'</span>'
                .'</div>';
        }
    }
    else {
        $alertMessage =
                '<div class="alert alert-danger alert-dismissible" role="alert">'
                    . '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'
                        .'<span aria-hidden="true">&times;</span>'
                    .'</button>'
                    . '<strong>'
                        . 'Error: '
                    . '</strong>'
                    . '<span>'
                        . 'Incorrect Username/Password'
                    . '</span>'
                . '</div>';
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
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:400,100,300,500">
    <link rel="stylesheet" href="../../libs/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../libs/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../../css/form-elements.css">
    <link rel="stylesheet" href="../../css/main-style.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]-->
    <script src="../../libs/html5shiv/dist/html5shiv.min.js"></script>
    <script src="../../libs/vendor/respond.min.js"></script>
    <!--[endif]-->

    <!-- Favicon and touch icons -->
    <link rel="shortcut icon" href="../../resources/img/ico/favicon.png">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../../resources/img/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../../resources/img/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../../resources/img/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="../../resources/img/ico/apple-touch-icon-57-precomposed.png">
    <link rel="stylesheet" href="../../css/auth/login.css"/>

</head>

<body>
<nav id="mainNav" class="navbar navbar-default navbar-fixed-top navbar-custom">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header page-scroll">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span> Menu <i class="fa fa-bars"></i>
            </button>
            <a class="navbar-brand" href="../index.html">Planbook</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href ="Login.php">Login/Sign up</a>
                </li>
                <li class="page-scroll">
                    <a href="../index.html#portfolio">Activities</a>
                </li>
                <li class="page-scroll">
                    <a href="../index.html#about">About</a>
                </li>
                <li class="page-scroll">
                    <a href="../index.html#contact">Contact</a>
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
                        <font color="White"><strong>Planbook</strong> Login Page</font>
                    </h1>
                    <div class="description">
                        <p>
                            <font color="White" >"To achieve <strong>big</strong> things, start small!"</font>
                        </p>
                    </div>
                    <?php if (isset($alertMessage)) echo "echo $alertMessage";?>
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
                    <form role="form" action="Login.php" method="post" class="login-form">
                        <div class="form-group">
                            <label class="sr-only" for="username">Username</label>
                            <input type="text" name="username" placeholder="Username..."
                                   class="form-control" id="username"
                                   value="<?php echo $username;?>"/>
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="password">Password</label>
                            <input type="password" name="password" placeholder="Password..."
                                   class="form-control" id="password"
                                   value="<?php echo $password;?>"/>
                        </div>
                        <table cellpadding="0" cellspacing="0" border="0" style="width:100%;">
                            <tr>
                                <td align = "left">
                                    <div class="form-group">
                                        <input type="checkbox" name="remember" value="yes" title="Remember Me"/>
                                    </div>
                                </td>
                                <td align = "right">
                                    <div class = "form-group">
                                        <a href="../email-sender/RecoveryEmail.php">
                                            Forgot login?
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <button class="btn" type="submit" value="postBackCredentials" name="submitCredentials">Login</button>
                    </form>
                    <div>

                    </div>
                </div>
            </div>
        </div>
        <div class = "row">
            Don't have an account yet? <a href="CreateAccount.php">Click Here</a>
        </div>
    </div>
</div>

</div>


<!-- Javascript -->
<script src="../../libs/jquery/dist/jquery.min.js"></script>
<script src="../../libs/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="../../libs/jquery-backstretch/jquery.backstretch.min.js"></script>
<script src="../../scripts/jquery/scripts.js"></script>

<!--[if lt IE 10]-->
<script src="../../scripts/jquery/placeholder.js"></script>
<!--[endif]-->

</body>

</html>