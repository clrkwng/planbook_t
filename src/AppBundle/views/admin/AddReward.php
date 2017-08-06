<!DOCTYPE html>

<?php
require_once "../db/dbcomm.php";
require_once "../db/Crypto.php";

ini_set('display_errors', 0);

if (!isset($_GET['id']) or !isset($_GET['reward'])) {
    die("Error: The id or reward id was not set.");
}
$encryptedAdminUsername = $_GET['id'];
$adminUsername = Crypto::decrypt($encryptedAdminUsername);

$encryptedUserUsername = $_GET['reward'];
$userUsername = Crypto::decrypt($encryptedUserUsername);

//create db connection
$dbcomm = new dbcomm();

if (isset($_POST['doneButton'])) {
    $unencryptedRewardName = str_replace("XyzYx", " ", $_POST['rewardName']);
    if (!$dbcomm->redeemRewardByUsername($userUsername, $unencryptedRewardName)) {
        $alert = '<div class="alert alert-danger alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Error!</strong>  Insufficient points to redeem.</div>';
    }
}

if (isset($_POST['SubmitReward'])) {
    foreach($_POST['users'] as $userChecked){
        $encodedUsername = $userChecked;

        $unencodedUsername = Crypto::decrypt($encodedUsername);
        $dbcomm->addRewardByUsername($unencodedUsername,$_POST['rewardName'],$_POST['numOfPoints']);
    }
}

if(isset($_GET['delete'])) {
    $deleteRewardID = $_GET['delete'];
    $dbcomm->deleteRewardByRewardID($deleteRewardID);
    $alert = '<div class="alert alert-success alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Success!</strong>  The reward has been deleted.</div>'; //successful deletion alert

}

?>


<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Rewards</title>

    <link rel="stylesheet" href="../../libs/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../../libs/fullpage-js/dist/jquery.fullpage.min.js"/>
    <link rel="stylesheet" type="text/css" href="../../css/fullpage-style.css"/>
    <link rel="stylesheet" href="../../libs/w3-css/w3.css">
    <link rel="stylesheet" type="text/css" href="../../css/admin/addreward.css"/>

</head>
<body>

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
            <?php
                $encryptedUsername = Crypto::encrypt($adminUsername, true);
            ?>
            <button onclick="window.location='AdminPanel.php?id=<?php echo $encryptedUsername ?>'"
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
                $rewards = $dbcomm->getAllRewardsByUsername($userUsername);
                $userCounter = 0;
                foreach ($rewards as $rewardId => $rewardValues) {
                    $rewardID = $rewardValues['rewardID'];
                    $rewardName = $rewardValues['name'];
                    $rewardPoints = $rewardValues['points'];
                    $rewardCompleted = $rewardValues['completed'];
                    $rewardRedeemDate = $rewardValues['redeem_date'];

                    if ($rewardRedeemDate == "//") {
                        $rewardRedeemDate = "---";
                    }

                    echo "<tr style='height: 40px;'>
                                <td>$rewardName</td>
                                <td>$rewardPoints</td>";

                    if ($rewardCompleted == 1) {
                        echo "<td><span class='glyphicon glyphicon-ok' style='font-size: 25px; color: green;'></span></td>";
                    } else {
                        $encyptedRewardName = str_replace(" ", "XyzYx", $rewardName);
                        echo "<td>
                                    <form role='form' action=\"AddReward.php?id=$encryptedAdminUsername&reward=$encryptedUserUsername\" method='post'>
                                        <input type='text' name='rewardName' value='$encyptedRewardName' style='display: none;'>
                                        <button type='submit' name='doneButton' id='doneButton' class='confirmRedeem' title='Redeem'>Redeem?</button>
                                    </form>
                              </td>";
                    }
                    echo "    <td>$rewardRedeemDate</td>
                              <td>
                                  <a href=\"AddReward.php?id=$encryptedAdminUsername&reward=$encryptedUserUsername&delete=$rewardID\" style='color: dimgrey;' class=\"confirmation\" title='Delete'>
                                    <span class='glyphicon glyphicon-trash' style='font-size: 20px;'></span>
                                  </a>
                              </td>
                          </tr>";
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

<script src="../../libs/jquery/dist/jquery.min.js"></script>
<script src="../../libs/bootstrap/dist/js/bootstrap.min.js"></script>
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
                            <form enctype="multipart/form-data" action="AddReward.php?id=<?php echo $encryptedAdminUsername; ?>&reward=<?php echo $encryptedUserUsername; ?>" method="post">
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

</html>