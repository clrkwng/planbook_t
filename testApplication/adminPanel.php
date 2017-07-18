<!DOCTYPE html>
<?php
require_once "dbcomm.php";
$dbcomm = new dbcomm();

if(!isset($_GET['id'])) {
    die("Error: The id was not set.");
}
$username = openssl_decrypt($_GET['id'], 'bf-cfb', 'adminPanelPassword');
$accountID = $dbcomm->getAccountIDByUsername($username);
$encryptedAccountID = openssl_encrypt($accountID, 'bf-ecb', 'makeNewUserPassword');

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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Custom styles for this template -->
    <link href="assets/css/adminPanel.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="../https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="../https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body style="background-color: #e6f7ff;">

<?php require_once "assets/template_items/navbar.php";?>

<div class="container">

    <div class="starter-template">
        <h1 align="left">Admin Panel</h1>
    </div>

    <? if (isset($alert))  echo $alert; ?>

    <h2 align="center">Manage <b><? echo $dbcomm->getAccountNameByUsername($username); ?></b> Users</h2>
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
        $users = $dbcomm->getAllUsersByAdminUsername($username); //formatting and echoing all the items in the checklists out
        foreach($users as $userId=>$userValues)
        {
            $userName = $userValues['username'];
            $userPoints = $userValues['total_points'];
            echo "<tr style='height:80px;'><td style='vertical-align: middle;'>$userName</td><td style='vertical-align: middle;'>$userPoints</td><td><a href='adminPanel.php' class='confirmation'>[X]</a></td></tr>";
        }
        ?>
        <tr style="height: 80px;">
            <td colspan="3" style="vertical-align: middle;">
                <a href = "createUser.php?id=<? echo $encryptedAccountID; ?>"><div class = "glyphicon glyphicon-plus"></div> New User</a>
            </td>
        </tr>
    </table>

</div><!-- /.container -->


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="../https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
<script src="../https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<script type="text/javascript">
    var elems = document.getElementsByClassName('confirmation');
    var confirmIt = function (e) {
        if (!confirm('Are you sure you want to delete this user?')) e.preventDefault();
    };
    for (var i = 0, l = elems.length; i < l; i++) {
        elems[i].addEventListener('click', confirmIt, false);
    }
</script>
</body>
</html>