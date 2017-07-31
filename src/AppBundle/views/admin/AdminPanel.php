<!DOCTYPE html>
<?php
ini_set('display_errors',0);

require_once "../db/dbcomm.php";
require_once "../db/Crypto.php";

$dbcomm = new dbcomm();

if(!isset($_GET['id'])) {
    die("Error: The id was not set.");
}

$encryptedUsername = $_GET['id'];
$adminUsername = Crypto::decrypt($encryptedUsername, true);
$accountID = $dbcomm->getAccountIDByUsername($adminUsername);
$encryptedAccountID = Crypto::encrypt($accountID, true);


if(isset($_GET['delete'])) //delete the user
{
    $deleteUsername = $_GET['delete'];
    $dbcomm->deleteUserByUsername($deleteUsername);
    $alertMessage =
                '<div class="alert alert-danger alert-dismissible" role="alert">'
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

    <!--<link rel="icon" href="../../favicon.ico">-->

    <!--meta tags, from bootstrap template-->

    <title>Admin Panel</title>
    <link rel="stylesheet" href="../../libs/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/admin/admin.css">

    <!-- Custom styles for this template -->
    <link href="../../css/admin-panel.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]-->
    <script src="../../libs/html5shiv/dist/html5shiv.min.js"></script>
    <script src="../../libs/vendor/respond.min.js"></script>
    <!--[endif]-->

</head>

<body>

<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="active"><a href="../index.html">Planbook</a></li>
            </ul>
            <div class="btn-group">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="glyphicon glyphicon-user"></span>
                </button>
                <ul class="dropdown-menu">
                    <li><a href="../user/UserProfile.php">Profile</a></li>
                    <li><a href="#">Group Settings</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="../auth/Login.php">Log out</a></li>
                </ul>
            </div>
        </div><!--/.nav-collapse -->
    </div>
</nav>

<div class="container">

    <div class="starter-template">
        <h1 align="left">Admin Panel</h1>
    </div>

    <?php if (isset($alertMessage)) echo "echo $alertMessage";?>

    <h2 align="center">Manage <b>
            <?php if (isset($adminUsername)) echo $dbcomm->getAccountNameByUsername($adminUsername);?>
    </b> Users</h2>
    <br>
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
        $users = $dbcomm->getAllUsersByAdminUsername($adminUsername); //formatting and echoing all the items in the checklists out
        $userCounter = 0;
        foreach($users as $userId=>$userValues)
        {
            $userName = $userValues['username'];
            $userPoints = $userValues['total_points'];
            if($userCounter == 0){

                echo "<tr id='user-row'>"
                        ."<td class='clickUser' id='clickUser$userCounter'>"
                            .$userName
                        ."</td>"
                        ."<td>"
                            ."$userPoints"
                        ."</td>"
                    ."<td></td>"
                      ."</tr>";
                $userCounter++;
            }
            else{
                $encryptedRewardAdminUsername = Crypto::encrypt($adminUsername, true);
                $encryptedRewardUserUsername = Crypto::encrypt($userName, true);

                echo "<tr id='user-row'>"
                        ."<td class='clickUser' id='clickUser$userCounter'>"
                            ."$userName"
                        ."</td>"
                        ."<td >"
                            ."$userPoints"
                        ."</td>"
                        ."<td>"
                            ."<a id='rewardLink' href='AddReward.php?id=$encryptedRewardAdminUsername&reward=$encryptedRewardUserUsername\' title='Rewards'>"
                                ."<span class='glyphicon glyphicon-piggy-bank'></span>"
                            ."</a>"
                            ."&nbsp;&nbsp;&nbsp;&nbsp;&n"
                            ."<a id='adminPanelLink' href=\"AdminPanel.php?id=$encryptedUsername&delete=$userName\" class=\"confirmation\" title='Delete'>"
                                ."<span class='glyphicon glyphicon-trash'></span>"
                            ."</a>"
                        ."</td>"
                  ."</tr>";
                $userCounter += 1;
            }
        }
        ?>
        <tr id='addNewUser'>
            <td colspan="3" id="addNewUserButton">
                <a class="glyphicon glyphicon-plus link_button"
                     href="../auth/CreateUser.php?id=<?php echo $encryptedAccountID;?>"
                > New User</a>
            </td>
        </tr>
    </table>

</div><!-- /.container -->


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
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

    var clickUsers = document.getElementsByClassName("clickUser");
    var accountUsernames = <?php echo json_encode($dbcomm->getEncodedUsernamesByAccountID($accountID)); ?>;
    for (var i = 0; i < clickUsers.length; i++) {
        clickUsers[i].addEventListener('click', function() {
            var userNum = Number((this.id).substring((this.id).length-1));
            window.location = '../user/ProfileOverview.php?id=' + accountUsernames[userNum];
        }, false);
    }
</script>
</body>
</html>