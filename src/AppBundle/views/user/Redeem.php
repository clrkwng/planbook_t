<!DOCTYPE html>

<?php
require_once "../db/dbcomm.php";
require_once "../db/Crypto.php";

if(!isset($_GET['id'])){
    die("Error: The id was not set.");
}

$usernameEncrypted = $_GET['id'];
$username = Crypto::decrypt($usernameEncrypted);

$dbcomm = new dbcomm();

if (isset($_GET['rewardName'])) {
    $rewardName = Crypto::decrypt($_GET['rewardName']);
    if (!$dbcomm->redeemRewardByUsername($username, $rewardName)) {
        $alert =
            "<div class='alert alert-danger alert-dismissible' role='alert'>"
                ."<button type='button' class='close' data-dismiss='alert' aria-label='Close'>"
                    ."<span aria-hidden='true'>"
                        ."&times;"
                    ."</span>"
                ."</button>"
                ."<strong>"
                    ."Error: "
                ."</strong>"
                ."<span>"
                    ."Insufficient Points to redeem."
                ."</span>"
            ."</div>";
    }
}

?>

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Redeem</title>

    <!-- Bootstrap Core CSS -->
    <link href="../../libs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">f

    <!-- Theme CSS -->
    <link href="../../css/start-bootstrap-template.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="//fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href="//fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="../../libs/w3-css/w3.css">

</head>
<body id="page-top" class="index">
<div id="skipnav"><a href="#maincontent">Skip to main content</a></div>

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
                    <a href="../user/Homepage.php?userToken=<?php echo Crypto::encrypt($username, true) ?>#task-daily">Tasks</a>
                </li>
                <li class="page-scroll">
                    <a href="../user/Homepage.php?userToken=<?php echo Crypto::encrypt($username, true) ?>#award-view">Awards</a>
                </li>
                <li role="separator" class="divider"></li>
                <li>
                    <a href ="../user/UserProfile.php?userToken=<?php echo Crypto::encrypt($username, true) ?>">Profile Settings</a>
                </li>
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
                    <h1 class="name">Redeem</h1>
                    <hr class="star-light">
                    <span class="skills">
                        Get your prizes!
                    </span>
                </div>
            </div>
        </div>
    </div>
</header>

<!--Redeem Prizes View -->
<section id="main-section">
    <div class="container">
        <div class="row">
            <div class="content">
                <table width="100%" style="height: 100%; text-align: center;">
                    <tr>
                        <td width="15%" height="71%">
                            <div style="height:30px;"></div>

                            <button onclick="window.location='Homepage.php?userToken=<?php echo Crypto::encrypt($username, true) ?>#3rdPage'" class="w3-button w3-circle w3-teal" style="transform: translateX(-50%) rotate(180deg); width: 190px; height: 180px; font-size: 75px;">➜&nbsp;&nbsp;&nbsp;</button>
                        </td>
                        <td rowspan="2" valign="top" style="overflow-y: auto;">
                            <br><br>

                            <?php
                            $rewardList = $dbcomm->getAllRewardsByUsername($username);
                            if(count($rewardList) > 0) {
                                echo "<table id='rewardsTable' border='1px solid black'>" .
                                    "<tr id='tableHeader'>" .
                                    "<td width='50%'>" .
                                    "<p>Reward</p>" .
                                    "</td>" .
                                    "<td width='20%'>" .
                                    "<p>Points</p>" .
                                    "</td>" .
                                    "<td width='15%'>" .
                                    "<p>Status</p>" .
                                    "</td>" .
                                    "<td width='15%'>" .
                                    "<p>Date</p>" .
                                    "</td>" .
                                    "</tr>";

                                $userCounter = 0;
                                foreach ($rewardList as $curRewardId => $curRewardVals) {
                                    $curRewardName = $curRewardVals['name'];
                                    $curRewardPoints = $curRewardVals['points'];
                                    $curRewardCompleted = $curRewardVals['completed'];
                                    $curRewardRedeemDate = $curRewardVals['redeem_date'];

                                    if ($curRewardRedeemDate == "0/0/0") {
                                        $curRewardRedeemDate = "---";
                                    }

                                    echo "<tr style='height: 40px;'>
                                <td>$curRewardName</td>
                                <td>$curRewardPoints</td>";

                                    if ($curRewardCompleted == 1) {
                                        echo "<td>
                                <span class='glyphicon glyphicon-ok' style='font-size: 25px; color: green;'></span>
                              </td>";
                                    } else {
                                        $curRewardNameEncrypted = Crypto::encrypt($curRewardName, true);
                                        echo "<td>
                                    <a href='Redeem.php?id=$usernameEncrypted&rewardName=$curRewardNameEncrypted'>
                                        <button type='button' id='doneButton' class='confirmRedeem' title='Redeem'>Redeem?</button>
                                    </a>
                              </td>";
                                    }
                                    echo "      <td>$curRewardRedeemDate</td>
                          </tr>";
                                }

                                echo "</table>";
                            }
                            else {
                                echo "<br><br><br>";
                                echo "<h2>Your admin has not set any awards for you yet.</h2>";
                            }

                            ?>

                        </td>
                        <td width="15%" style="text-align: right" valign="center" id="awardsSideBar">
                            <br>
                            <p style="display: inline-block; height: 45px;"><?php echo $dbcomm->getUserTotalPointsByUsername($username); ?>&nbsp;</p><div style="font-size: 18px; display:inline-block; max-width: 60px; text-align: left;"> Total Points&nbsp;</div>
                            <p><?php echo $dbcomm->getNumBronzeStarsByUsername($username); ?> <img src="<?php echo $dbcomm->getBronzeStarImageSource(); ?>" width="50" height="50">&nbsp;</p>
                            <p><?php echo $dbcomm->getNumSilverStarsByUsername($username); ?> <img src="<?php echo $dbcomm->getSilverStarImageSource(); ?>" width="50" height="50">&nbsp;</p>
                            <p><?php echo $dbcomm->getNumGoldStarsByUsername($username); ?> <img src="<?php echo $dbcomm->getGoldStarImageSource(); ?>" width="50" height="50">&nbsp;</p>
                            <p><?php echo $dbcomm->getNumBronzeTrophiesByUsername($username); ?> <img src="<?php echo $dbcomm->getBronzeTrophyImageSource(); ?>" width="50" height="50">&nbsp;</p>
                            <p><?php echo $dbcomm->getNumSilverTrophiesByUsername($username); ?> <img src="<?php echo $dbcomm->getSilverTrophyImageSource(); ?>" width="50" height="50">&nbsp;</p>
                            <p><?php echo $dbcomm->getNumGoldTrophiesByUsername($username); ?> <img src="<?php echo $dbcomm->getGoldTrophyImageSource(); ?>" width="50" height="50">&nbsp;</p>
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
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

<script>
    var elems = document.getElementsByClassName('confirmRedeem');
    var confirmIt = function (e) {
        if (!confirm('Are you sure you want to redeem this task?')) e.preventDefault();
    };
    for (var i = 0, l = elems.length; i < l; i++) {
        elems[i].addEventListener('click', confirmIt, false);
    }
</script>

</body>
</html>