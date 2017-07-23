<?php
$users = $dbcomm->getAllUsersByAdminUsername($username); //formatting and echoing all the items in the checklists out
$adminCounter = true;
foreach($users as $userId=>$userValues)
{
    $userName = $userValues['username'];
    $userPoints = $userValues['total_points'];
    if($adminCounter){
        echo "<tr style='height:80px;'><td style='vertical-align: middle;'>$userName</td><td style='vertical-align: middle;'>$userPoints</td><td></td></tr>";
        $adminCounter = false;
    }
    else{
        echo "<tr style='height:80px;'><td style='vertical-align: middle;'>$userName</td><td style='vertical-align: middle;'>$userPoints</td><td style='vertical-align: middle;'><a href=\"adminPanel.php?id=$encryptedUsername&delete=$userName\" style='color: dimgrey;' class=\"confirmation\"><span class='glyphicon glyphicon-trash' style='font-size: 20px;'></span></a></td></tr>";
    }
}
?>