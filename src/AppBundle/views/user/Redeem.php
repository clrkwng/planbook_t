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

    <link rel="stylesheet" href="../../libs/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../../libs/fullpage-js/dist/jquery.fullpage.min.js" />
    <link rel="stylesheet" type="text/css" href="../../css/fullpage-style.css" />
    <link rel="stylesheet" href="../../libs/w3-css/w3.css">
    <link rel="stylesheet" type="text/css" href="../../css/user/redeem.css"/>

</head>
<body>

<table width="100%" style="height: 100%; text-align: center;">
    <tr>
        <td width="15%"></td>
        <td height="25%">
            <h1>Redeem</h1>
            <p style="font-size: 25px;">Get your prize now!</p>
            <?php if (isset($alert))  echo $alert; ?>
        </td>
        <td width="15%"></td>
    </tr>
    <tr>
        <td width="15%" height="71%">
            <div class="toAwards" id="toAwards1">T</div>
            <div class="toAwards" id="toAwards2">O</div>
            <div class="toAwards" id="toAwards3">T</div>
            <div class="toAwards" id="toAwards4">H</div>
            <div class="toAwards" id="toAwards5">E</div>
            <div class="toAwards" id="toAwards6">A</div>
            <div class="toAwards" id="toAwards7">W</div>
            <div class="toAwards" id="toAwards8">A</div>
            <div class="toAwards" id="toAwards9">R</div>
            <div class="toAwards" id="toAwards10">D</div>
            <div class="toAwards" id="toAwards11">S</div>
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

<script src="../../libs/jquery/dist/jquery.min.js"></script>
<script src="../../libs/bootstrap/dist/js/bootstrap.min.js"></script>

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