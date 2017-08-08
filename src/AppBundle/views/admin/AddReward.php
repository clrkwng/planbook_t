<!DOCTYPE html>

<?php
require_once "../db/dbcomm.php";
require_once "../db/Crypto.php";

ini_set('display_errors', 0);

if (!isset($_GET['adminToken']) or !isset($_GET['userToken'])) {
    die("Error: The admin or user token was not set.");
}
$adminUsernameEncrypted = $_GET['adminToken'];
$adminUsername = Crypto::decrypt($adminUsernameEncrypted);

$userUsernameEncrypted = $_GET['userToken'];
$userUsername = Crypto::decrypt($userUsernameEncrypted);

//create db connection
$dbcomm = new dbcomm();

if (isset($_POST['doneButton'])) {
    $unencryptedRewardName = Crypto::decrypt($_POST['rewardName']);
    if (!$dbcomm->redeemRewardByUsername($userUsername, $unencryptedRewardName)) {
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
            ."</div>'";
    }
}

if (isset($_POST['SubmitReward'])) {
    foreach($_POST['users'] as $userChecked){
        $dbcomm->addRewardByUsername($userUsername, $_POST['rewardName'], $_POST['numOfPoints']);
    }
}

if(isset($_GET['delete'])) {
    $deleteRewardID = $_GET['delete'];
    $dbcomm->deleteRewardByRewardID($deleteRewardID);
    $alert =
            "<div class='alert alert-success alert-dismissible' role='alert'>"
                ."<button type='button' class='close' data-dismiss='alert' aria-label='Close'>"
                    ."<span aria-hidden='true'>"
                        ."&times;"
                    ."</span>"
                ."</button>"
                ."<strong>"
                    ."Success: "
                ."</strong>"
                ."<span>"
                    ."Reward deleted."
                ."</span>"
            ."</div>'";

}

?>


<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Rewards</title>

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
<section id="add-rewards">
    <div class="container">
            <div class="row">
                <table>
                    <tr>
                        <td width="15%"></td>
                        <td height="25%">
                            <h1>Rewards</h1>
                            <p style="font-size: 25px;">Manage Rewards for <b><?php echo $userUsername; ?></b></p>
                            <?php if (isset($alert))  echo $alert; ?>
                        </td>
                        <td width="15%" valign="bottom">
                            <p style="max-width: 100%;">
                                <?php echo $userUsername; ?>'s
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td width="15%" height="71%">
                            <div class="toAdminPanel" id="toAdminPanel1">A</div>
                            <div class="toAdminPanel" id="toAdminPanel2">D</div>
                            <div class="toAdminPanel" id="toAdminPanel3">M</div>
                            <div class="toAdminPanel" id="toAdminPanel4">I</div>
                            <div class="toAdminPanel" id="toAdminPanel5">N</div>
                            <div class="toAdminPanel" id="toAdminPanel6">P</div>
                            <div class="toAdminPanel" id="toAdminPanel7">A</div>
                            <div class="toAdminPanel" id="toAdminPanel8">N</div>
                            <div class="toAdminPanel" id="toAdminPanel9">E</div>
                            <div class="toAdminPanel" id="toAdminPanel10">L</div>
                            <div style="height:30px;"></div>

                            <button onclick="window.location='AdminPanel.php?adminToken=<?php echo Crypto::encrypt($adminUsername, true) ?>'"
                                    class="w3-button w3-circle w3-teal"
                                    style="transform: translateX(-50%) rotate(180deg); width: 190px; height: 180px; font-size: 75px;">➜&nbsp;&nbsp;&nbsp;
                            </button>
                        </td>
                        <td rowspan="2" valign="top" style="overflow-y: auto;">
                            <br><br>
                            <table id="rewardsTable" border="1px solid black">
                                <tr id="tableHeader">
                                    <td width="40%">
                                        <p>Reward</p>
                                    </td>
                                    <td width="20%">
                                        <p>Points</p>
                                    </td>
                                    <td width="15%">
                                        <p>Status</p>
                                    </td>
                                    <td width="15%">
                                        <p>Date</p>
                                    </td>
                                    <td width="10%">
                                        <p>Delete</p>
                                    </td>
                                </tr>

                                <?php
                                $rewardList = $dbcomm->getAllRewardsByUsername($userUsername);
                                $userCounter = 0;
                                foreach ($rewardList as $rewardId => $curRewardVals) {
                                    $curRewardId = $curRewardVals['rewardID'];
                                    $curRewardName = $curRewardVals['name'];
                                    $curRewardPoints = $curRewardVals['points'];
                                    $curRewardCompleted = $curRewardVals['completed'];
                                    $curRewardRedeemDate = $curRewardVals['redeem_date'];

                                    if ($curRewardRedeemDate == "//") {
                                        $curRewardRedeemDate = "---";
                                    }

                                    echo
                                        "<tr style='height: 40px;'>"
                                        ."<td>"
                                        .$curRewardName
                                        ."</td>"
                                        ."<td>"
                                        .$curRewardPoints
                                        ."</td>";

                                    if ($curRewardCompleted == 1) {
                                        echo
                                            "<td>"
                                            ."<span class='glyphicon glyphicon-ok' style='font-size: 25px; color: green;'>"
                                            ."</span>"
                                            ."</td>";
                                    } else {
                                        $curRewardNameEncrypted = Crypto::encrypt($curRewardName, true);
                                        echo
                                            "<td>"
                                            ."<form role='form' action=\"AddReward.php?adminToken=". Crypto::encrypt($adminUsername, true)."&userToken=". Crypto::encrypt($userUsername, true)."\" method='post'>"
                                            ."<input type='text' name='rewardName' value='$curRewardNameEncrypted' style='display: none;'>"
                                            ."<button type='submit' name='doneButton' id='doneButton' class='confirmRedeem' title='Redeem'>"
                                            ."Redeem?"
                                            ."</button>"
                                            ."</form>"
                                            ."</td>";
                                    }
                                    echo
                                        "<td>"
                                        .$curRewardRedeemDate
                                        ."</td>"
                                        ."<td>"
                                        ."<a href=\"AddReward.php?adminToken=". Crypto::encrypt($adminUsername, true)."&userToken=". Crypto::encrypt($userUsername, true)."&delete=$curRewardId\" style='color: dimgrey;' class=\"confirmation\" title='Delete'>"
                                        ."<span class='glyphicon glyphicon-trash' style='font-size: 20px;'>"
                                        ."</span>"
                                        ."</a>"
                                        ."</td>"
                                        ."</tr>";
                                }
                                ?>
                                <tr style="height: 40px; cursor: pointer;" data-toggle="modal" data-target="#addRewardModal">
                                    <td style="border-right-style:hidden;" valign="middle">
                                        &nbsp;&nbsp;&nbsp;<div class = "glyphicon glyphicon-plus" style="font-size: 16px; color: green;"></div> Add Award
                                    </td>
                                    <td colspan="4"></td>
                                </tr>
                            </table>
                        </td>
                        <td width="15%" style="text-align: right" valign="center" id="awardsSideBar">
                            <p align="center" style="vertical-align: top;"><u>Awards</u></p>

                            <p style="display: inline-block; height: 45px;"><?php echo $dbcomm->getUserTotalPointsByUsername($userUsername); ?>&nbsp;</p><div style="font-size: 18px; display:inline-block; max-width: 60px; text-align: left;"> Total Points&nbsp;</div>
                            <p><?php echo $dbcomm->getNumBronzeStarsByUsername($userUsername); ?> <img src="<?php echo $dbcomm->getBronzeStarImageSource(); ?>" width="50" height="50">&nbsp;</p>
                            <p><?php echo $dbcomm->getNumSilverStarsByUsername($userUsername); ?> <img src="<?php echo $dbcomm->getSilverStarImageSource(); ?>" width="50" height="50">&nbsp;</p>
                            <p><?php echo $dbcomm->getNumGoldStarsByUsername($userUsername); ?> <img src="<?php echo $dbcomm->getGoldStarImageSource(); ?>" width="50" height="50">&nbsp;</p>
                            <p><?php echo $dbcomm->getNumBronzeTrophiesByUsername($userUsername); ?> <img src="<?php echo $dbcomm->getBronzeTrophyImageSource(); ?>" width="50" height="50">&nbsp;</p>
                            <p><?php echo $dbcomm->getNumSilverTrophiesByUsername($userUsername); ?> <img src="<?php echo $dbcomm->getSilverTrophyImageSource(); ?>" width="50" height="50">&nbsp;</p>
                            <p><?php echo $dbcomm->getNumGoldTrophiesByUsername($userUsername); ?> <img src="<?php echo $dbcomm->getGoldTrophyImageSource(); ?>" width="50" height="50">&nbsp;</p>
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
<div class="modal fade" id="addRewardModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="text-align: center;">
                <h2>Add Reward</h2>
            </div>
            <div class="modal-body">
                <table width="80%" align="center">
                    <tr>
                        <td align="left">
                            <form enctype="multipart/form-data" action="AddReward.php?adminToken=<?php echo Crypto::encrypt($adminUsername, true); ?>&userToken=<?php echo Crypto::encrypt($userUsername, true); ?>" method="post">
                                <input type="text" name="rewardName" placeholder="Reward Name...">
                                <br><br>
                                <input type="number" name="numOfPoints" placeholder="Points Required...">
                                <br><br><br>
                                <p style="font-size: 20px;">Select Users</p>
                                <br>
                                <?php
                                $users = $dbcomm->getEncodedUsernamesByAccountID($dbcomm->getAccountIDByUsername($adminUsername));
                                $adminCounter = true;
                                foreach ($users as $encodedUsername) {
                                    if(!$adminCounter){
                                        $unencodedUsername = Crypto::decrypt($encodedUsername, true);
                                        echo "<input type=\"checkbox\" name=\"users[]\" value=\"$encodedUsername\"> $unencodedUsername<br>";
                                    }
                                    else {
                                        $adminCounter = false;
                                    }
                                }
                                ?>
                                <br><br>
                                <div style="width: 100%; text-align: center;"><input type="submit" name="SubmitReward" class="btn btn-default"></div>
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
<script>
    var elems = document.getElementsByClassName('confirmRedeem');
    var confirmIt = function (e) {
        if (!confirm('Are you sure you want to redeem this reward?')) e.preventDefault();
    };
    for (var i = 0, l = elems.length; i < l; i++) {
        elems[i].addEventListener('click', confirmIt, false);
    }

    var deletes = document.getElementsByClassName('confirmDelete');
    var confirmDelete = function (e) {
        if (!confirm('Are you sure you want to delete this reward?')) e.preventDefault();
    };
    for (var m = 0; m < deletes.length; m++) {
        deletes[m].addEventListener('click', confirmDelete, false);
    }
</script>

</body>


</html>