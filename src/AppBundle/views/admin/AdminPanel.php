<!DOCTYPE html>
<?php
ini_set('display_errors',0);

require_once "../db/dbcomm.php";
require_once "../db/Crypto.php";

$dbcomm = new dbcomm();

if(!isset($_GET['adminToken'])) {
    die("Error: The admin token was not set.");
}

$adminUsernameEncrypted = $_GET['adminToken'];
$adminUsername = Crypto::decrypt($adminUsernameEncrypted, true);
$accountId = $dbcomm->getAccountIDByUsername($adminUsername);

if(isset($_GET['delete'])) //delete the user
{
    $deleteUsername = $_GET['delete'];
    $dbcomm->deleteUserByUsername($deleteUsername);
    $alertMessage =
                '<div class="alert alert-info alert-dismissible" role="alert">'
                    . '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'
                        .'<span aria-hidden="true">&times;</span>'
                    .'</button>'
                    . '<strong>'
                        . 'Success: '
                    . '</strong>'
                    . '<span>'
                        . 'The user has been deleted'
                    . '</span>'
                . '</div>';
}
?>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!--meta tags, from bootstrap template-->

    <title>Admin Panel</title>
    <link rel="stylesheet" href="../../libs/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/admin/admin.css">
    <!-- Theme CSS -->
    <link href="../../css/start-bootstrap-template.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../../css/admin-panel.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]-->
    <script src="../../libs/html5shiv/dist/html5shiv.min.js"></script>
    <script src="../../libs/vendor/respond.min.js"></script>
    <!--[endif]-->
    <!-- Theme JavaScript -->
    <script src="../../libs/freelancer/dist/freelancer.js"></script>
    <style>
        a:hover {
            text-decoration: none;
        }
        td#addNewUserButton{
            cursor: pointer;
        }
    </style>
</head>

<body style="background-color: #e6f7ff;" id="page-top" >

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
                <li>
                    <a href ="../user/UserProfile.php">Profile</a>
                </li>
                <li class="page-scroll">
                    <a href="#manage-users">Group Settings</a>
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

<!-- Header -->
<header>
    <div class="container" id="maincontent" tabindex="-1">
        <div class="row">
            <div class="col-lg-12">
                <div class="intro-text">
                    <h1 class="name">Admin Panel</h1>
                    <hr class="star-light">
                    <span class="skills">
                        Manage
                            <?php if (isset($adminUsername))
                                echo $dbcomm->getAccountNameByUsername($adminUsername);
                            ?>
                         Users
                    </span>
                </div>
            </div>
        </div>
    </div>
</header>

<section id="manage-users">
    <div class="container">

        <?php if (isset($alertMessage)) echo $alertMessage;?>

        <table class="table table-hover" width="100%">
            <tr>
                <th width="40%">
                    User:
                </th>
                <th width="20%">
                    Points:
                </th>
                <th width="20%">
                    Actions:
                </th>
            </tr>
            <?php
            $userIdList = $dbcomm->getAllUsersByAdminUsername($adminUsername);
            $userCounter = 0;
            foreach($userIdList as $curUserId=> $curUserVals)
            {
                $curUserName = $curUserVals['username'];
                $curUserPoints = $curUserVals['total_points'];
                $curUserNameEncrypted = Crypto::encrypt($curUserName, true);
                $curUserEmail = $dbcomm->getEmailByUsername($curUserName);

                $curAdminUsernameEncrypted = Crypto::encrypt($adminUsername, true);

                echo "<tr style='height:80px;'>
                          <td style='vertical-align: middle; cursor: pointer;' class='clickUser' id='clickUser$userCounter'>$curUserName</td>
                          <td style='vertical-align: middle;'>$curUserPoints</td>
                          <td style='vertical-align: middle;'>
                              <a href=\"../user/Homepage.php?adminToken=$curAdminUsernameEncrypted&userToken=$curUserNameEncrypted\" title='Tasks' style='color: black;'>
                                  <span class='glyphicon glyphicon-calendar' style='font-size: 20px;'></span>
                              </a>
                              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                              <a href=\"AddReward.php?adminToken=$curAdminUsernameEncrypted&userToken=$curUserNameEncrypted\" style='color: pink;' title='Rewards'>
                                  <span class='glyphicon glyphicon-piggy-bank' style='font-size: 20px; text-shadow: -1px 0 dimgrey, 0 1px dimgrey, 1px 0 dimgrey, 0 -1px dimgrey;'></span>
                              </a>
                              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                              <a href=\"mailto:$curUserEmail?subject=Planbook%20Email\" style='color: dimgrey;' title='Email'>
                                  <span class='glyphicon glyphicon-envelope' style='font-size: 20px;'></span>
                              </a>
                              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                              <a href=\"AdminPanel.php?adminToken=$curAdminUsernameEncrypted&delete=$curUserName\" style='color: dimgrey;' class=\"confirmation\" title='Delete'>
                                  <span class='glyphicon glyphicon-trash' style='font-size: 20px;'></span>
                              </a>
                          </td>
                      </tr>";
                $userCounter++;
            }
            ?>
            <tr id='addNewUser'>
                <td colspan="3" id="addNewUserButton">
                    <a class="glyphicon glyphicon-plus link_button"
                         href="../auth/CreateUser.php?adminToken=<?php echo Crypto::encrypt($adminUsername);?>"
                    > New User</a>
                </td>
            </tr>
        </table>
    </div><!-- /.container -->

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

</body>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="//use.fontawesome.com/7d70b9fab6.js"></script>
<script src="../../libs/jquery/dist/jquery.min.js"></script>
<script src="../../libs/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="../../libs/jquery-backstretch/jquery.backstretch.min.js"></script>
<script src="../../scripts/jquery/scripts.js"></script>
<script src="../../scripts/jquery/admin/admin-panel-bundle.js"></script>

<script type="text/javascript">
    var elems = document.getElementsByClassName('confirmation');
    var confirmIt = function (e) {
        if (!confirm('Are you sure you want to delete this user?')) e.preventDefault();
    };
    for (var i = 0, l = elems.length; i < l; i++) {
        elems[i].addEventListener('click', confirmIt, false);
    }

    var addUserButton = document.getElementById("addNewUserButton");
    addUserButton.addEventListener('click', function() {
        window.location = '../auth/CreateUser.php?adminToken=<?php echo Crypto::encrypt($adminUsername); ?>';
    }, false);

    var clickUsers = document.getElementsByClassName("clickUser");
    var accountUsernames = <?php echo json_encode($dbcomm->getEncodedUsernamesByAccountID($accountId)); ?>;
    for (var i = 0; i < clickUsers.length; i++) {
        clickUsers[i].addEventListener('click', function() {
            var userNum = Number((this.id).substring(9));
            window.location = '../user/ProfileOverview.php?id=' + accountUsernames[userNum];
        }, false);
    }
</script>
</html>