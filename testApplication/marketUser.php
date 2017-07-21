<!DOCTYPE html>

<?php

if(!isset($_GET['id'])){
    die("Error: The id was not set.");
}
$username = openssl_decrypt($_GET['id]'],'CAST5-ECB','toMarketPassword');

?>

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Market</title>

    <link rel="stylesheet" type="text/css" href="assets/fullPage.js-master/jquery.fullPage.css" />
    <link rel="stylesheet" type="text/css" href="assets/fullPage.js-master/examples/examples.css" />
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

    <style>
        body {
            background-color: #7BAABE;
        }

        h1 {
            font-size: 6em;
        }

        .toAwards {
            font: 26px Monaco, MonoSpace;
            height: 120px;
            position: absolute;
            width: 20px;
            left: 1%;
            transform-origin: bottom center;
        }

        #toAwards1 { transform: rotate(18deg); }
        #toAwards2 { transform: rotate(30deg); }
        #toAwards3 { transform: rotate(54deg); }
        #toAwards4 { transform: rotate(66deg); }
        #toAwards5 { transform: rotate(78deg); }
        #toAwards6 { transform: rotate(102deg); }
        #toAwards7 { transform: rotate(114deg); }
        #toAwards8 { transform: rotate(126deg); }
        #toAwards9 { transform: rotate(138deg); }
        #toAwards10 { transform: rotate(150deg); }
        #toAwards11 { transform: rotate(162deg); }
    </style>

</head>
<body>

<table width="100%" style="height: 100%; text-align: center;" border="1px solid black">
    <tr>
        <td width="15%"></td>
        <td height="25%">
            <h1>Market</h1>
            <p style="font-size: 25px;">Redeem your prize now!</p>
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
            <? $encryptedUsername = openssl_encrypt($username,'RC4-40','regularUserPassword'); ?>
            <button onclick="window.location='homepage.php?id=<? echo $encryptedUsername ?>#3rdPage'" class="w3-button w3-circle w3-teal" style="transform: translateX(-50%) rotate(180deg); width: 190px; height: 180px; font-size: 75px;">➜&nbsp;&nbsp;&nbsp;</button>
        </td>
        <td rowspan="2">
            <!--This is where the rewards go-->
        </td>
        <td width="15%" style="text-align: right" valign="center">
            <br>
            <p style="display: inline-block">108&nbsp;</p><div style="font-size: 18px; display:inline-block;">Points&nbsp;</div>
            <p>1 <img src="assets/img/bronzeStar.png" width="50" height="50">&nbsp;</p>
            <p>5 <img src="assets/img/silverStar.png" width="50" height="50">&nbsp;</p>
            <p>8 <img src="assets/img/goldStar.png" width="50" height="50">&nbsp;</p>
            <p>1 <img src="assets/img/bronzeTrophy.png" width="50" height="50">&nbsp;</p>
            <p>5 <img src="assets/img/silverTrophy.png" width="50" height="50">&nbsp;</p>
            <p>8 <img src="assets/img/goldTrophy.png" width="50" height="50">&nbsp;</p>
            <br>
        </td>
    </tr>
    <tr><td></td><td></td></tr>
</table>

</body>
</html>