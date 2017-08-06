<?php
ini_set('display_errors',0);
require_once "../db/dbcomm.php";
//create db connection
$dbcomm = new dbcomm();

if(!isset($_GET['id']))
{
    die("Error: The id was not set.");
}

$encryptedUsername = $_GET['id'];
$username = Crypto::decrypt($encryptedUsername, true);

if (isset($_POST['Submit1']) and isset($_FILES['image'])) {
    if ($_FILES['image']['size'] == 0 and $_FILES['image']['error'] == 0)
    {
        $alertMessage =
                    '<div class="alert alert-danger alert-dismissible" role="alert">'
                        . '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'
                            .'<span aria-hidden="true">&times;</span>'
                        .'</button>'
                        . '<strong>'
                            . 'Error: '
                        . '</strong>'
                        . '<span>'
                            . 'No file was selected'
                        . '</span>'
                    . '</div>';
    }
    else {
        chdir("../../resources/img/profilePictures/");
        $cwd = getcwd();
        $path = $cwd . '/'.$username;
        //echo "<script>console.log('$path');</script>";
        if (mkdir("$path")){
            //echo "<script>console.log('Huzzah!');</script>";
        }
        else {
            //echo "<script>console.log('...');</script>";
        }

        $allowed_ext= array('jpg','jpeg','png','gif');
        $file_name =$_FILES['image']['name'];
        //   $file_name =$_FILES['image']['tmp_name'];
        $file_ext = strtolower(end(explode('.',$file_name)));

        $file_size=$_FILES['image']['size'];
        $file_tmp= $_FILES['image']['tmp_name'];
        //echo $file_tmp;echo "<br>";

        $type = pathinfo($file_tmp, PATHINFO_EXTENSION);
        $data = file_get_contents($file_tmp);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        //echo "<script>console.log('$base64');</script>";
        //echo "Base64 is ".$base64;

        if(in_array($file_ext,$allowed_ext) === false) {
            $alertMessage =
                    '<div class="alert alert-danger alert-dismissible" role="alert">'
                        . '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'
                            .'<span aria-hidden="true">&times;</span>'
                        .'</button>'
                        . '<strong>'
                            . 'Error: '
                        . '</strong>'
                        . '<span>'
                            . 'Invalid file extension.'
                        . '</span>'
                    . '</div>';
        }

        if($file_size > 2097152) {
            $alertMessage =
                    '<div class="alert alert-danger alert-dismissible" role="alert">'
                        . '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'
                            .'<span aria-hidden="true">&times;</span>'
                        .'</button>'
                        . '<strong>'
                            . 'Error: '
                        . '</strong>'
                        . '<span>'
                            . 'File is too large. Must be less than two megabytes.'
                        . '</span>'
                    . '</div>';

        }
        if(!isset($alertMessage)) {
            move_uploaded_file($file_tmp, "$path".'/'.$file_name);
            //echo "<script>console.log('The file was uploaded');</script>";
            $dbcomm->updateProfileImageByUsername($username,"../../resources/img/profilePictures/".$username."/".$file_name);
        }
    }
}

if (isset($_POST['Submit2']) and isset($_POST['email'])) {
    $errorCount = 0;
    $email = $_POST["email"];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorCount++;
        $alertMessage =
                    '<div class="alert alert-danger alert-dismissible" role="alert">'
                        . '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'
                            .'<span aria-hidden="true">&times;</span>'
                        .'</button>'
                        . '<strong>'
                            . 'Error: '
                        . '</strong>'
                        . '<span>'
                            . 'Invalid email.'
                        . '</span>'
                    . '</div>';
    }
    if ($dbcomm->checkIfEmailExists($email)) {
        $errorCount += 1;
        $alertMessage =
                    '<div class="alert alert-danger alert-dismissible" role="alert">'
                        . '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'
                            .'<span aria-hidden="true">&times;</span>'
                        .'</button>'
                        . '<strong>'
                            . 'Error: '
                        . '</strong>'
                        . '<span>'
                            . 'Email is already associated with an account.'
                        . '</span>'
                    . '</div>';
    }
    if ($errorCount == 0) {
        $dbcomm->updateEmailByUsername($username, $email);
    }
}

if (isset($_POST['Submit3']) and isset($_POST['phonenumber'])) {
    $errorCount = 0;
    $phonenumber = $_POST["phonenumber"];
    $phonenumber = preg_replace('/\D+/', '', $phonenumber);
    if (isset($_POST['signup-phonenumber'])){
        if(!preg_match("/^\(\d{3}\) \d{3}-\d{4}$/", $_POST['signup-phonenumber'])){
            $errorCount++;
            $alertMessage =
                    '<div class="alert alert-danger alert-dismissible" role="alert">'
                        . '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'
                            .'<span aria-hidden="true">&times;</span>'
                        .'</button>'
                        . '<strong>'
                            . 'Error: '
                        . '</strong>'
                        . '<span>'
                            . 'Invalid phone number.'
                        . '</span>'
                    . '</div>';
        }
    }
    if($dbcomm->checkIfPhonenumberExists($phonenumber)) {
        $errorCount += 1;
        $alertMessage =
                    '<div class="alert alert-danger alert-dismissible" role="alert">'
                        . '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'
                            .'<span aria-hidden="true">&times;</span>'
                        .'</button>'
                        . '<strong>'
                            . 'Error: '
                        . '</strong>'
                        . '<span>'
                            . 'Phone number is already associated with an account.'
                        . '</span>'
                    . '</div>';

    }
    if ($errorCount == 0) {
        $dbcomm->updatePhoneNumberByUsername($username, $phonenumber);
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profile</title>

    <!-- CSS -->
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
    <link rel="stylesheet" href="../../libs/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../libs/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../../css/form-elements.css">
    <link rel="stylesheet" href="../../css/main-style.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]-->
    <script src="//oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="//oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <!--[endif]-->

    <!-- Favicon and touch icons -->
    <link rel="shortcut icon" href="../../resources/img/ico/favicon.png">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../../resources/img/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../../resources/img/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../../resources/img/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="../../resources/img/ico/apple-touch-icon-57-precomposed.png">

    <style>
        #profileImage {
            border-radius: 50%;
            background-color: #fff;
            border: 1px solid black;
            width: 150px;
            height: 150px;
        }
        p, td {
            font-size: 20px;
            color: #5e5e5e;
        }
        #profileImageButton, #changeEmailButton, #changePhoneNumberButton {
            cursor: pointer;
        }
    </style>

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
                    <a href ="../auth/Login.php">Login/Sign up</a>
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
                <h1 align="left">
                    <font color="#696969"><strong>Profile Overview</strong></font>
                </h1>
            </div>
            <div class="row">
                <?php if (isset($alertMessage)) echo "$alertMessage";?>
            </div>
            <div class="row">
                <div class="col-sm-10 col-sm-offset-1 text">
                    <table id="profileTable" width="100%" style="line-height: 2;">
                        <tr>
                            <td></td>
                            <td>
                                <img src="<? echo $dbcomm->getProfileImageByUsername($username); ?>" id="profileImage">
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td width="40%"></td>
                            <td width="20%" id="profileImageButton" data-toggle="modal" data-target="#profileImageModal">
                                <div class="glyphicon glyphicon-wrench" style="color: #5e5e5e; display: inline-block;"></div>
                                <p style="display: inline-block;">&nbsp;Profile Image&nbsp;&nbsp;&nbsp;</p>
                            </td>
                            <td width="40%"></td>
                        </tr>
                        <tr>
                            <td align="left">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Username: <? echo $username; ?><br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Account Name: <? echo $dbcomm->getAccountNameByUsername($username); ?><br>
                                <div class="glyphicon glyphicon-wrench" style="color: #5e5e5e; display: inline-block;" id="changeEmailButton" data-toggle="modal" data-target="#changeEmailModal"></div>
                                Email: <? echo $dbcomm->getEmailByUsername($username); ?><br>
                                <div class="glyphicon glyphicon-wrench" style="color: #5e5e5e; display: inline-block;" id="changePhoneNumberButton" data-toggle="modal" data-target="#changePhoneNumberModal"></div>
                                Phone: <? echo $dbcomm->getPhoneNumberByUsername($username); ?><br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total Points: <? echo $dbcomm->getNumTotalPointsByUsername($username); ?><br>
                            </td>
                            <td colspan="2">
                                <table width="100%" align="center">
                                    <tr>
                                        <td colspan="3">
                                            Current Points: <? echo $dbcomm->getNumCurrentPointsByUsername($username); ?>
                                        </td>
                                    </tr>
                                    <tr><td height="10px"></td></tr>
                                    <tr>
                                        <td height="50%">
                                            <? echo $dbcomm->getNumBronzeStarsByUsername($username); ?>&nbsp;&nbsp;<img src="<? echo $dbcomm->getBronzeStarImageSource(); ?>" width="50px" height="50px">
                                        </td>
                                        <td>
                                            <? echo $dbcomm->getNumSilverStarsByUsername($username); ?>&nbsp;&nbsp;<img src="<? echo $dbcomm->getSilverStarImageSource(); ?>" width="50px" height="50px">
                                        </td>
                                        <td>
                                            <? echo $dbcomm->getNumGoldStarsByUsername($username); ?>&nbsp;&nbsp;<img src="<? echo $dbcomm->getGoldStarImageSource(); ?>" width="50px" height="50px">
                                        </td>
                                    </tr>
                                    <tr><td height="20px"></td></tr>
                                    <tr>
                                        <td height="50%">
                                            <? echo $dbcomm->getNumBronzeTrophiesByUsername($username); ?>&nbsp;&nbsp;<img src="<? echo $dbcomm->getBronzeTrophyImageSource(); ?>" width="50px" height="50px">
                                        </td>
                                        <td>
                                            <? echo $dbcomm->getNumSilverTrophiesByUsername($username); ?>&nbsp;&nbsp;<img src="<? echo $dbcomm->getSilverTrophyImageSource(); ?>" width="50px" height="50px">
                                        </td>
                                        <td>
                                            <? echo $dbcomm->getNumGoldTrophiesByUsername($username); ?>&nbsp;&nbsp;<img src="<? echo $dbcomm->getGoldTrophyImageSource(); ?>" width="50px" height="50px">
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
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

<div class="modal fade" id="profileImageModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Change Profile Image</h2>
            </div>
            <div class="modal-body">
                <table width="80%" align="center">
                    <tr>
                        <td>
                            <form enctype="multipart/form-data" action="ProfileOverview.php?id=<? echo $encryptedUsername; ?>" method="post">
                                <input style="line-height: 1em;" type="file" name="image" accept="image/*">
                                <br>
                                <input type="submit" name="Submit1" class="btn btn-default">
                            </form>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="changeEmailModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Change Email</h2>
            </div>
            <div class="modal-body">
                <table width="80%" align="center">
                    <tr>
                        <td>
                            <form enctype="multipart/form-data" action="ProfileOverview.php?id=<? echo $encryptedUsername; ?>" method="post">
                                <input style="line-height: 1em;" type="email" name="email" value="" placeholder="New Email...">
                                &nbsp;&nbsp;&nbsp;
                                <input style="line-height: 1.5em;" type="submit" name="Submit2" class="btn btn-default">
                            </form>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="changePhoneNumberModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Change Profile Image</h2>
            </div>
            <div class="modal-body">
                <table width="80%" align="center">
                    <tr>
                        <td>
                            <form enctype="multipart/form-data" action="ProfileOverview.php?id=<? echo $encryptedUsername; ?>" method="post">
                                <input style="line-height: 1em;" type="text" name="phonenumber" value="" placeholder="New Phone Number..."
                                       onblur="$(this).val($(this).val().replace(/[^0-9.]/g, '')); if($(this).val().length >= 10){$(this).val('(' + $(this).val().substring(0,3) + ') ' + $(this).val().substring(3,6) + '-' + $(this).val().substring(6,10));}">
                                &nbsp;&nbsp;&nbsp;
                                <input style="line-height: 1.5em;" type="submit" name="Submit3" class="btn btn-default">
                            </form>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

</html>