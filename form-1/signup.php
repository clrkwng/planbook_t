<!DOCTYPE html>

<?php
if (isset($_POST['Submit'])) {
    $errorCount = 0;

    if(isset($_POST['form-accountID'])) {
        if(1==2) {
            $errorCount++;
        }
    }
    if(isset($_POST["form-email"])){
        if (!filter_var($_POST["form-email"], FILTER_VALIDATE_EMAIL)) {
            $errorCount++;
        }
    }
    if ($_POST['form-phonenumber']){
        if(!preg_match("/^\(\d{3}\) \d{3}-\d{4}$/", $_POST['form-phonenumber'])){
            $errorCount++;
        }
    }
    if(isset($_POST['form-password'])) {
        $password = filter_var($_POST['form-password'], FILTER_SANITIZE_STRING);
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number = preg_match('@[0-9]@', $password);
        if (!$uppercase || !$lowercase || !$number || strlen($password) < 8) {
            $errorCount++;
        }
    }
    if(isset($_POST['form-repassword'])) {
        $repassword = filter_var($_POST['form-repassword'], FILTER_SANITIZE_STRING);
        if($repassword != $password) {
            $errorCount++;
        }
    }

    if ($errorCount == 0) {
        echo "<script>window.location = 'http://dev2.planbook.xyz/planbook/form-1/homepage.php'</script>";
    }
    else {
        echo "<script>document.getElementById(\"form-password\").innerHTML = \"\";</script>";
        echo "<script>document.getElementById(\"form-repassword\").innerHTML = \"\";</script>";
    }
}
?>

<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Planbook Login</title>

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

<!-- Top content -->
<div class="top-content">

    <div class="inner-bg">
        <div class="container">
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2 text">
                    <h1><strong>
                            <font color
                                  ="#959962">Planbook</strong> Signup Page</font>
                    </h1>
                    <div class="description">
                        <p>
                            <font color="#959962">"To achieve <strong>big</strong> things, start small"</font>
                        </p>
                    </div>
                </div>

                <div class="col-sm-6 col-sm-offset-3 form-box">
                    <div class="form-bottom">
                        <form role="form" action="" method="post" class="login-form">
                            <div class="form-group">
                                <label class="sr-only" for="form-accountID">Account ID</label>
                                <input type="text" name="form-accountID" placeholder="Account ID..."
                                       class="form-accountID form-control" id="form-accountID">
                            </div>
                            <div class="form-group">
                                <label class="sr-only" for="form-email">Email</label>
                                <input type="text" name="form-email" placeholder="Email..."
                                       class="form-email form-control" id="form-email">
                            </div>
                            <div class="form-group">
                                <label class="sr-only" for="form-phonenumber">Phone Number</label>
                                <input type="text" name="form-phonenumber" placeholder="Phone number..."
                                       class="form-phonenumber form-control" id="form-phonenumber">
                            </div>
                            <div class="form-group">
                                <label class="sr-only" for="form-password">Password</label>
                                <input type="password" name="form-password" placeholder="Password..."
                                       class="form-password form-control" id="form-password">
                            </div>
                            <div class="form-group">
                                <label class="sr-only" for="form-repassword">Re-enter Password</label>
                                <input type="password" name="form-repassword" placeholder="Re-enter password..."
                                       class="form-repassword form-control" id="form-repassword">
                            </div>
                            <button type="submit" class="btn" formaction="index.php">Register!</button>
                        </form>
                        <div>

                        </div>
                    </div>
                </div>
            </div>
            <div class = "row">
                Back to <a href="signin.php">login</a>
            </div>
        </div>
    </div>

</div>


<!-- Javascript -->
<script src="assets/js/jquery-1.11.1.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/jquery.backstretch.min.js"></script>
<script src="assets/js/scripts.js"></script>
<script src="assets/js/formatPhoneInput.js"></script>

<!--[if lt IE 10]>
<script src="assets/js/placeholder.js"></script>
<![endif]-->

</body>

</html>