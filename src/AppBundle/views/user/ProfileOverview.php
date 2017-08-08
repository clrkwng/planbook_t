<?php
ini_set('display_errors',0);
require_once "../db/dbcomm.php";
//create db connection
$dbcomm = new dbcomm();

if(!isset($_GET['adminToken']))
{
    die("Error: The admin token was not set.");
}

$adminUsernameEncrypted = $_GET['adminToken'];
$adminUsername = Crypto::decrypt($adminUsernameEncrypted, true);

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
        $path = $cwd . '/'.$adminUsername;
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
            $dbcomm->updateProfileImageByUsername($adminUsername,"../../resources/img/profilePictures/".$adminUsername."/".$file_name);
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
        $dbcomm->updateEmailByUsername($adminUsername, $email);
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
        $dbcomm->updatePhoneNumberByUsername($adminUsername, $phonenumber);
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

    <!-- Bootstrap Core CSS -->
    <link href="../../libs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">f

    <!-- Theme CSS -->
    <link href="../../css/start-bootstrap-template.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="//fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href="//fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="../../libs/w3-css/w3.css">
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

<body id="page-top" class="index">
<!-- Navigation -->
<nav id="mainNav" class="navbar navbar-default navbar-fixed-top navbar-custom">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header page-scroll">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span> Menu <i class="fa fa-bars"></i>
            </button>
            <a class="navbar-brand" href="#page-top">Planbook</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li class="hidden">
                    <a href="#page-top"></a>
                </li>
                <li class="page-scroll">
                    <a href="../admin/AdminPanel.php?adminToken=<?php echo Crypto::encrypt($adminUsername, true) ?>">Admin Panel</a>
                </li>
                <li role="separator" class="divider"></li>
                <li>
                    <a href="../auth/Login.php">Log out</a>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
</nav>
<!-- Top content -->
<section id="manage-profile">
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
                                <img src="<?php echo $dbcomm->getProfileImageByUsername($adminUsername); ?>" id="profileImage">
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
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Username: <?php echo $adminUsername; ?><br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Account Name: <?php echo $dbcomm->getAccountNameByUsername($adminUsername); ?><br>
                                <div class="glyphicon glyphicon-wrench" style="color: #5e5e5e; display: inline-block;" id="changeEmailButton" data-toggle="modal" data-target="#changeEmailModal"></div>
                                Email: <?php echo $dbcomm->getEmailByUsername($adminUsername); ?><br>
                                <div class="glyphicon glyphicon-wrench" style="color: #5e5e5e; display: inline-block;" id="changePhoneNumberButton" data-toggle="modal" data-target="#changePhoneNumberModal"></div>
                                Phone: <?php echo $dbcomm->getPhoneNumberByUsername($adminUsername); ?><br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total Points: <?php echo $dbcomm->getUserTotalPointsByUsername($adminUsername); ?><br>
                            </td>
                            <td colspan="2">
                                <table width="100%" align="center">
                                    <tr>
                                        <td colspan="3">
                                            Current Points: <?php echo $dbcomm->getUserCurrentPointsByUsername($adminUsername); ?>
                                        </td>
                                    </tr>
                                    <tr><td height="10px"></td></tr>
                                    <tr>
                                        <td height="50%">
                                            <?php echo $dbcomm->getNumBronzeStarsByUsername($adminUsername); ?>&nbsp;&nbsp;<img src="<?php echo $dbcomm->getBronzeStarImageSource(); ?>" width="50px" height="50px">
                                        </td>
                                        <td>
                                            <?php echo $dbcomm->getNumSilverStarsByUsername($adminUsername); ?>&nbsp;&nbsp;<img src="<?php echo $dbcomm->getSilverStarImageSource(); ?>" width="50px" height="50px">
                                        </td>
                                        <td>
                                            <?php echo $dbcomm->getNumGoldStarsByUsername($adminUsername); ?>&nbsp;&nbsp;<img src="<?php echo $dbcomm->getGoldStarImageSource(); ?>" width="50px" height="50px">
                                        </td>
                                    </tr>
                                    <tr><td height="20px"></td></tr>
                                    <tr>
                                        <td height="50%">
                                            <?php echo $dbcomm->getNumBronzeTrophiesByUsername($adminUsername); ?>&nbsp;&nbsp;<img src="<?php echo $dbcomm->getBronzeTrophyImageSource(); ?>" width="50px" height="50px">
                                        </td>
                                        <td>
                                            <?php echo $dbcomm->getNumSilverTrophiesByUsername($adminUsername); ?>&nbsp;&nbsp;<img src="<?php echo $dbcomm->getSilverTrophyImageSource(); ?>" width="50px" height="50px">
                                        </td>
                                        <td>
                                            <?php echo $dbcomm->getNumGoldTrophiesByUsername($adminUsername); ?>&nbsp;&nbsp;<img src="<?php echo $dbcomm->getGoldTrophyImageSource(); ?>" width="50px" height="50px">
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
</section>

<!-- Footer -->
<footer class="text-center">
    <div class="footer-above">
        <div class="container">
            <div class="row">
                <div class="footer-col col-md-4">
                    <h3>Location</h3>
                    <p>400 Cedar Ave
                        <br>West Long Branch, NJ 07764</p>
                </div>
                <div class="footer-col col-md-4">
                    <h3>Around the Web</h3>
                    <ul class="list-inline">
                        <li>
                            <a href="#" class="btn-social btn-outline"><span class="sr-only">Facebook</span><i class="fa fa-fw fa-facebook"></i></a>
                        </li>
                        <li>
                            <a href="#" class="btn-social btn-outline"><span class="sr-only">Google Plus</span><i class="fa fa-fw fa-google-plus"></i></a>
                        </li>
                        <li>
                            <a href="#" class="btn-social btn-outline"><span class="sr-only">Twitter</span><i class="fa fa-fw fa-twitter"></i></a>
                        </li>
                        <li>
                            <a href="#" class="btn-social btn-outline"><span class="sr-only">Linked In</span><i class="fa fa-fw fa-linkedin"></i></a>
                        </li>
                        <li>
                            <a href="#" class="btn-social btn-outline"><span class="sr-only">Dribble</span><i class="fa fa-fw fa-dribbble"></i></a>
                        </li>
                    </ul>
                </div>
                <div class="footer-col col-md-4">
                    <h3>About Planbook</h3>
                    <p>Planbook is a free to use tool to help keep lives organized.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-below">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    Copyright &copy; Planbook 2017
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Scroll to Top Button (Only visible on small and extra-small screen sizes) -->
<div class="scroll-top page-scroll hidden-sm hidden-xs hidden-lg hidden-md">
    <a class="btn btn-primary" href="#page-top">
        <i class="fa fa-chevron-up"></i>
    </a>
</div>

<!--------------------- Modals --------------------->
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
                            <form enctype="multipart/form-data" action="ProfileOverview.php?adminToken=<?php echo Crypto::encrypt($adminUsername, true); ?>" method="post">
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
                            <form enctype="multipart/form-data" action="ProfileOverview.php?adminToken=<?php echo Crypto::encrypt($adminUsername, true); ?>" method="post">
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
                            <form enctype="multipart/form-data" action="ProfileOverview.php?adminToken=<?php echo Crypto::encrypt($adminUsername, true); ?>" method="post">
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

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="//use.fontawesome.com/7d70b9fab6.js"></script>
<script src="../../libs/jquery/dist/jquery.min.js"></script>
<script src="../../libs/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="../../libs/jquery-backstretch/jquery.backstretch.min.js"></script>

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]-->
<script src="../../libs/html5shiv/dist/html5shiv.min.js"></script>
<script src="../../libs/vendor/respond.min.js"></script>
<!--[endif]-->
<!-- Theme JavaScript -->
<script src="../../libs/freelancer/dist/freelancer.js"></script>

</body>



</html>