<!DOCTYPE html>
<?php

if(!isset($_GET['id']))
{

}
$username = 'Kev';

?>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Planbook</title>


    <link rel="stylesheet" type="text/css" href="assets/fullPage.js-master/jquery.fullPage.css" />
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/fullPage.js-master/examples/examples.css" />
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

    <!--[if IE]>
    <script type="text/javascript">
        var console = { log: function() {} };
    </script>
    <![endif]-->

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/jquery-ui.min.js"></script>

    <script type="text/javascript" src="assets/fullPage.js-master/jquery.fullPage.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="assets/fullPage.js-master/examples/examples.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#fullpage').fullpage({
                sectionsColor: ['#7FB3D5', '#FCFBE3', '#7FB3D5'],
                anchors: ['firstPage', 'secondPage', '3rdPage'],
                menu: '#menu',
            });
        });
    </script>

    <style>
        table tr#starSymbols td {
            vertical-align: bottom;
            height: 27%;
        }
        table tr#trophySymbols td {
            vertical-align: bottom;
            height: 32%;
        }
        table tr#starCount td {
            vertical-align: top;
            height: 6%;
        }
        table tr#trophyCount td {
            vertical-align: top;
            height: 6%;
        }
        h1 {
            font-size: 58px;
        }

        .toMarket {
            font: 26px Monaco, MonoSpace;
            height: 120px;
            position: absolute;
            width: 20px;
            right: 1%;
            transform-origin: bottom center;
        }

        #toMarket1 { transform: rotate(-162deg); }
        #toMarket2 { transform: rotate(-150deg); }
        #toMarket3 { transform: rotate(-126deg); }
        #toMarket4 { transform: rotate(-114deg); }
        #toMarket5 { transform: rotate(-102deg); }
        #toMarket6 { transform: rotate(-78deg); }
        #toMarket7 { transform: rotate(-66deg); }
        #toMarket8 { transform: rotate(-54deg); }
        #toMarket9 { transform: rotate(-42deg); }
        #toMarket10 { transform: rotate(-30deg); }
        #toMarket11 { transform: rotate(-18deg); }

        #exchangeSystem p {
            font-size: 20px;
        }
        body {
            margin: 0;
            min-width: 250px;
        }

        /* Include the padding and border in an element's total width and height */
        * {
            box-sizing: border-box;
        }

        /* Remove margins and padding from the list */
        ul {
            margin: 0;
            padding: 0;
        }

        /* Style the list items */
        ul li {
            cursor: pointer;
            position: relative;
            padding: 12px 8px 12px 40px;
            background: #eee;
            font-size: 18px;
            transition: 0.2s;

            /* make the list items unselectable */
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        /* Set all odd list items to a different color (zebra-stripes) */
        ul li:nth-child(odd) {
            background: #f9f9f9;
        }

        /* Darker background-color on hover */
        ul li:hover {
            background: #ddd;
        }

        /* When clicked on, add a background color and strike out text */
        ul li.checked {
            background: #888;
            color: #fff;
            text-decoration: line-through;
        }


        /* Style the close button */
        .close {
            position: absolute;
            right: 0;
            top: 0;
            padding: 12px 16px 12px 16px;
        }

        .close:hover {
            background-color: #f44336;
            color: white;
        }

        .list-group {
            margin-top: 0 !important;;
        }


    </style>

</head>
<body>

<ol id="menu">
    <li data-menuanchor="firstPage"><a href="#firstPage">Stats</a></li>
    <li data-menuanchor="secondPage"><a href="#secondPage">Tasks</a></li>
    <li data-menuanchor="3rdPage"><a href="#3rdPage">Awards</a></li>
</ol>

<div id="fullpage">
    <div class="section " id="section0">
        <div class="content">
            <h1>Stats</h1>
        </div>
    </div>
    <div class="section" id="section1">
        <div class="slide" id="slide1">
            <div class="content">
                <h1>Daily View (6/21)</h1>
                <table align="center" width="80%">
                    <tr>
                        <td colspan="3" align="left">
                            <div class="panel-group">
                                <div class="panel panel-default">
                                    <div class="panel-heading"  style="background-color:#BA7FD5;">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" href="#collapse1">Homework</a>
                                        </h4>
                                    </div>
                                    <div id="collapse1" class="panel-collapse collapse">
                                        <ul class="list-group">
                                            <li class="list-group-item">One</li>
                                            <li class="list-group-item">Two</li>
                                            <li class="list-group-item">Three</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" align="left">
                            <div class="panel-group">
                                <div class="panel panel-default">
                                    <div class="panel-heading"  style="background-color:#B37FCA;">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" href="#collapse2">Sports</a>
                                        </h4>
                                    </div>
                                    <div id="collapse2" class="panel-collapse collapse">
                                        <ul class="list-group">
                                            <li class="list-group-item">One</li>
                                            <li class="list-group-item">Two</li>
                                            <li class="list-group-item">Three</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" align="left">
                            <div class="panel-group">
                                <div class="panel panel-default">
                                    <div class="panel-heading"  style="background-color:#AB7FC0;">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" href="#collapse3">Health</a>
                                        </h4>
                                    </div>
                                    <div id="collapse3" class="panel-collapse collapse">
                                        <ul class="list-group">
                                            <li class="list-group-item">One</li>
                                            <li class="list-group-item">Two</li>
                                            <li class="list-group-item">Three</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" align="left">
                            <div class="panel-group">
                                <div class="panel panel-default">
                                    <div class="panel-heading"  style="background-color:#A47FB5;">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" href="#collapse4">Exercise</a>
                                        </h4>
                                    </div>
                                    <div id="collapse4" class="panel-collapse collapse">
                                        <ul class="list-group">
                                            <li class="list-group-item">One</li>
                                            <li class="list-group-item">Two</li>
                                            <li class="list-group-item">Three</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" align="left">
                            <div class="panel-group">
                                <div class="panel panel-default">
                                    <div class="panel-heading"  style="background-color:#9D7FAA;">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" href="#collapse5">Other</a>
                                        </h4>
                                    </div>
                                    <div id="collapse5" class="panel-collapse collapse">
                                        <ul class="list-group">
                                            <li class="list-group-item">One</li>
                                            <li class="list-group-item">Two</li>
                                            <li class="list-group-item">Three</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" align="left">
                            <div class="panel-group">
                                <div class="panel panel-default">
                                    <div class="panel-heading"  style="background-color:#957FA0;">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" href="#collapse6">Special tasks</a>
                                        </h4>
                                    </div>
                                    <div id="collapse6" class="panel-collapse collapse">
                                        <ul class="list-group">
                                            <li class="list-group-item">One</li>
                                            <li class="list-group-item">Two</li>
                                            <li class="list-group-item">Three</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="slide" id="slide2">
            <div class="content">
                <h1>Weekly View</h1>
            </div>
        </div>
        <div class="slide" id="slide2">
            <div class="content">
                <h1>Monthly View</h1>

            </div>
        </div>
    </div>
    <div class="section" id="section2">
        <table align="center" width="100%" style="height: 100%;">
            <tr style="height:25%">
                <td rowspan="6" valign="center" width="20%" id="exchangeSystem" style="border-right: 1px solid black;">
                    <h3><u>Exchange System</u></h3>
                    <p style="font-size: 18px;">10 point conversion scale</p>
                    <br><br>
                    <p>Points</p>
                    <p style="transform: rotate(90deg); font-size: 25px;">➜</p>
                    <p>Bronze Stars</p>
                    <p style="transform: rotate(90deg); font-size: 25px;">➜</p>
                    <p>Silver Stars</p>
                    <p style="transform: rotate(90deg); font-size: 25px;">➜</p>
                    <p>Gold Stars</p>
                    <p style="transform: rotate(90deg); font-size: 25px;">➜</p>
                    <p>Bronze Trophies</p>
                    <p style="transform: rotate(90deg); font-size: 25px;">➜</p>
                    <p>Silver Trophies</p>
                    <p style="transform: rotate(90deg); font-size: 25px;">➜</p>
                    <p>Gold Trophies</p>
                </td>
                <td rowspan="5" width="5%"></td>
                <td colspan="3" valign="bottom">
                    <h1>Awards</h1>
                </td>
                <td>
                    <h3 style="color: dimgrey; font-size: 30px; text-align: left;">Points: 108</h3>
                </td>
            </tr>
            <tr id="starSymbols">
                <td valign="bottom">
                    <img src="assets/img/bronzeStar.png" width="150" height="150">
                </td>
                <td>
                    <img src="assets/img/silverStar.png" width="150" height="150">
                </td>
                <td>
                    <img src="assets/img/goldStar.png" width="150" height="150">
                </td>
                <td width="15%" rowspan="3" align="right" style="vertical-align: middle">
                    <div class="toMarket" id="toMarket1">T</div>
                    <div class="toMarket" id="toMarket2">O</div>
                    <div class="toMarket" id="toMarket3">T</div>
                    <div class="toMarket" id="toMarket4">H</div>
                    <div class="toMarket" id="toMarket5">E</div>
                    <div class="toMarket" id="toMarket6">M</div>
                    <div class="toMarket" id="toMarket7">A</div>
                    <div class="toMarket" id="toMarket8">R</div>
                    <div class="toMarket" id="toMarket9">K</div>
                    <div class="toMarket" id="toMarket10">E</div>
                    <div class="toMarket" id="toMarket11">T</div>
                    <div style="height: 30px;"></div>
                    <? $encryptedMarketUsername = openssl_encrypt($username,'CAST5-ECB','toMarketPassword');?>
                    <button onclick="window.location='marketUser.php?id=<? echo $encryptedMarketUsername ?>';" class="w3-button w3-circle w3-teal" style="transform: translateX(50%); width: 190px; height: 180px; font-size: 75px;">➜&nbsp;&nbsp;&nbsp;</button>
                </td>
            </tr>
            <tr id="starCount">
                <td>
                    <p>1</p>
                </td>
                <td>
                    <p>5</p>
                </td>
                <td>
                    <p>8</p>
                </td>
            </tr>
            <tr id="trophySymbols">
                <td>
                    <img src="assets/img/bronzeTrophy.png" width="150" height="150">
                </td>
                <td>
                    <img src="assets/img/silverTrophy.png" width="150" height="150">
                </td>
                <td>
                    <img src="assets/img/goldTrophy.png" width="150" height="150">
                </td>
            </tr>
            <tr id="trophyCount">
                <td>
                    <p>1</p>
                </td>
                <td>
                    <p>5</p>
                </td>
                <td>
                    <p>8</p>
                </td>
                <td width="15%"></td>
            </tr>
            <tr style="height:5%;"></tr>
        </table>
    </div>
</div>
<script>
    // Create a "close" button and append it to each list item
    var myNodelist = document.getElementsByClassName("list-group-item");
    var i;
    for (i = 0; i < myNodelist.length; i++) {
        var span = document.createElement("SPAN");
        var txt = document.createTextNode("\u00D7");
        span.className = "close";
        span.appendChild(txt);
        myNodelist[i].appendChild(span);
    }

    // Click on a close button to hide the current list item
    var close = document.getElementsByClassName("close");
    var i;
    for (i = 0; i < close.length; i++) {
        close[i].onclick = function() {
            var div = this.parentElement;
            div.style.display = "none";
        }
    }

    // Add a "checked" symbol when clicking on a list item
    var list = document.getElementsByClassName("list-group");
    for(i = 0; i < list.length; i++) {
        console.log(list[i]);
        list[i].addEventListener('click', function(ev) {
            if (ev.target.tagName === 'li') {
                ev.target.classList.toggle('checked');
            }
        }, false);
    }

</script>
</body>
</html>