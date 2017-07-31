<!DOCTYPE html>
<?php
require_once "../db/dbcomm.php";
require_once "../db/Crypto.php";

//create db connection
$dbcomm = new dbcomm();

if (!isset($_GET['id'])) {
    die("Error: The id was not set.");
}
$encryptedUsername = $_GET['id'];
$encryptedUsername = str_replace("!!!", "+", $encryptedUsername);
$encryptedUsername = str_replace("$$$", "%", $encryptedUsername);
$username = Crypto::decrypt($encryptedUsername, true);


if(isset($_POST['createTask'])) {
    if (isset($_POST['taskName']) and isset($_POST['categoryName']) and isset($_POST['importance']) and isset($_POST['start_hour']) and isset($_POST['start_minute']) and isset($_POST['end_hour']) and isset($_POST['end_minute'])) {
        $taskName = $_POST['taskName'];
        $categoryName = $_POST['categoryName'];
        $importance = $_POST['importance'];
        $start_hour = $_POST['start_hour'];
        $start_minute = $_POST['start_minute'];
        $end_hour = $_POST['end_hour'];
        $end_minute = $_POST['end_minute'];
        $date = $_POST['date'];

        $year = substr($date, 6, 4);
        $month = substr($date,0,2);
        $day = substr($date, 3,2);
        $startDateTime = $year.'-'.$month.'-'.$day.' '.$start_hour.':'.$start_minute.':00';
        $endDateTime = $year.'-'.$month.'-'.$day.' '.$end_hour.':'.$end_minute.':00';

        $dbcomm->createTaskByUsername($username, $taskName, $categoryName, $importance, $startDateTime, $endDateTime);
    }
}

?>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../../libs/bootstrap/dist/css/bootstrap.min.css">
    <script src="../../libs/jquery/dist/jquery.min.js"></script>
    <script src="../../libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Planbook</title>


    <link rel="stylesheet" type="text/css" href="../../libs/fullpage-js/dist/jquery.fullpage.min.css"/>
    <link rel="stylesheet" href="../../libs/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../../css/fullpage-style.css" />
    <link rel="stylesheet" href="../../libs/w3-css/w3.css">

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/jquery-ui.min.js"></script>

    <script type="text/javascript" src="../../libs/fullpage-js/dist/jquery.fullpage.min.js"></script>
    <script src="../../libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../../scripts/jquery/fullpage-config.js"></script>
    <script type="text/javascript" src="../../scripts/jquery/user/fullpage-homepage-config.js"></script>
    <script type="text/javascript" src="../../scripts/jquery/user/tasklist-config.js"></script>
    <link rel="stylesheet" type="text/css" href="../../css/user/homepage.css"/>
    <script src="../../scripts/jquery/user/createTask.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>


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
                <table align="center" width="80%">
                    <tr>
                        <td colspan="2" align="right" width=67.6666666%>
                            <h1>Daily View (<?php echo date("n/j"); ?>)</h1>
                        </td>
                        <td align="right">
                            <div class="content">
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#mymodal">
                                    New Task
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <?php
                        $categories = $dbcomm->getCategoriesByUsername($username);
                        for ($i = 0; $i < sizeOf($categories); $i++){
                            $category = $categories[$i];
                            echo
                                '<tr>'
                                    .'<td colspan="3" align="left">'
                                        .'<div class="panel-group">'
                                            .'<div class="panel panel-default">'
                                                .'<div class="panel-heading" style="background-color:#BA7FD5;">'
                                                    .'<h4 class="panel-title">'
                                                        .'<a data-toggle="collapse" href="#collapse'.($i+1).'">'.$category.'</a>'
                                                    .'</h4>'
                                                .'</div>'
                                                .'<div id="collapse'.($i+1).'" class="panel-collapse collapse">'
                                                    .'<ul class="list-group">';
                                                        $tasks = $dbcomm->getTasksByCategory($username, $category);
                                                        for ($j = 0; $j < sizeOf($tasks); $j++) {
                                                        echo
                                                            '<li class="list-group-item">'
                                                                .$tasks[$j]
                                                            .'</li>';
                                                        }
                                                echo '</ul>'
                                                .'</div>'
                                            .'</div>'
                                        .'</div>'
                                    .'</td>'
                                .'</tr>';
                        }
                        ?>
                    </tr>
                </table>
            </div>
        </div>
        <div class="slide" id="slide2">
            <div class="content">
                <table align="center" width="80%" border="1px solid black">
                    <tr>
                        <td align="center" colspan="7"> <h1>Weekly View</h1>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" width="100/7%" style="background-color: #BA7FD5"><h4>Sun 30</h4></td>
                        <td align="center" width="100/7%" style="background-color: #B37FCA"><h4>Mon 31</h4></td>
                        <td align="center" width="100/7%" style="background-color: #AB7FC0"><h4>Tue 1</h4></td>
                        <td align="center" width="100/7%" style="background-color: #A47FB5"><h4>Wed 2</h4></td>
                        <td align="center" width="100/7%" style="background-color: #9D7FAA"><h4>Thu 3</h4></td>
                        <td align="center" width="100/7%" style="background-color: #957FA0"><h4>Fri 4</h4></td>
                        <td align="center" width="100/7%" style="background-color: #8E7F95"><h4>Sat 5</h4></td>
                    </tr>
                    <tr>
                        <td width="100/7%" style="height: 55px;"><div style="display: block; width:120px; height: 40px;background-color: #BA7FD5; line-height: 3em; font-size: 15px;" align="left"><div style="display: inline-block;">Sports</div> <div class="badge" style="vertical-align: middle; display: inline-block;" align="right">4</div></div></td>

                    </tr>

                </table>
            </div>
        </div>
        <div class="slide" id="slide3">
            <div class="content">
                <h1>Monthly View</h1>
                <div class="container">

                </div>
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
                    <h3 style="color: dimgrey; font-size: 30px; text-align: left;">
                        Points: <?php echo $dbcomm->getNumCurrentPointsByUsername($username); ?></h3>
                </td>
            </tr>
            <tr id="starSymbols">
                <td valign="bottom">
                    <img src="<?php echo $dbcomm->getBronzeStarImageSource(); ?>" width="150" height="150">
                </td>
                <td>
                    <img src="<?php echo $dbcomm->getSilverStarImageSource(); ?>" width="150" height="150">
                </td>
                <td>
                    <img src="<?php echo $dbcomm->getGoldStarImageSource(); ?>" width="150" height="150">
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
                    <?php
                        $encryptedMarketUsername = Crypto::encrypt($username, true);
                    ?>
                    <button onclick="window.location='Market.php?id=<?php echo $encryptedMarketUsername ?>';"
                            class="w3-button w3-circle w3-teal"
                            style="transform: translateX(50%); width: 190px; height: 180px; font-size: 75px;">➜&nbsp;&nbsp;&nbsp;
                    </button>
                </td>
            </tr>
            <tr id="starCount">
                <td>
                    <p><?php echo $dbcomm->getNumBronzeStarsByUsername($username); ?></p>
                </td>
                <td>
                    <p><?php echo $dbcomm->getNumSilverStarsByUsername($username); ?></p>
                </td>
                <td>
                    <p><?php echo $dbcomm->getNumGoldStarsByUsername($username); ?></p>
                </td>
            </tr>
            <tr id="trophySymbols">
                <td>
                    <img src="<?php echo $dbcomm->getBronzeTrophyImageSource(); ?>" width="150" height="150">
                </td>
                <td>
                    <img src="<?php echo $dbcomm->getSilverTrophyImageSource(); ?>" width="150" height="150">
                </td>
                <td>
                    <img src="<?php echo $dbcomm->getGoldTrophyImageSource(); ?>" width="150" height="150">
                </td>
            </tr>
            <tr id="trophyCount">
                <td>
                    <p><?php echo $dbcomm->getNumBronzeTrophiesByUsername($username); ?></p>
                </td>
                <td>
                    <p><?php echo $dbcomm->getNumSilverTrophiesByUsername($username); ?></p>
                </td>
                <td>
                    <p><?php echo $dbcomm->getNumGoldTrophiesByUsername($username); ?></p>
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
    for (var i = 0; i < myNodelist.length; i++) {
        var span = document.createElement("SPAN");
        var txt = document.createTextNode("\u00D7");
        span.className = "close";
        span.appendChild(txt);
        myNodelist[i].appendChild(span);
    }

    // Click on a close button to hide the current list item
    var close = document.getElementsByClassName("close");
    for (var i = 0; i < close.length; i++) {
        close[i].onclick = function () {
            var div = this.parentElement;
            div.style.display = "none";
        }
    }

    // Add a "checked" symbol when clicking on a list item
    var list = document.getElementsByClassName("list-group");
    for (var i = 0; i < list.length; i++) {
        list[i].addEventListener('click', function (ev) {
            if (ev.target.tagName === 'LI') {
                ev.target.classList.toggle('checked');
            }
        }, false);
    }

    var elems = document.getElementsByClassName('close');
    var confirmIt = function (e) {
        if (!confirm('Are you sure you want to delete this task?')) e.preventDefault();
    };
    for (var i = 0, l = elems.length; i < l; i++) {
        elems[i].addEventListener('click', confirmIt, false);
    }

    $(document).ready(function() {
        $('#mymodal').click(function() {
            $('html').css('overflow', 'hidden');
            $('body').bind('touchmove', function(e) {
                e.preventDefault()
            });
        });
        $('.mymodal-close').click(function() {
            $('html').css('overflow', 'scroll');
            $('body').unbind('touchmove');
        });
    });
    $(document).ready(function(){
        var date_input=$('input[name="date"]'); //our date input has the name "date"
        var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
        date_input.datepicker({
            format: 'mm/dd/yyyy',
            container: container,
            todayHighlight: true,
            autoclose: true,
        })
    })
</script>
</body>
<div class="modal fade" id="mymodal">
    <form role="form" action="Homepage.php?id=<?php echo $encryptedUsername; ?>#secondPage" method="post" class="task_create">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Create New Task</h2>
                    <?php if (isset($alertMessage)) echo "echo $alertMessage";?>
                </div>
                <div class="modal-body">
                    <table width="80%" align="center">
                        <tr>
                            <td valign="bottom" width="40%">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="taskName" id="usr" placeholder="Enter Task Name...">
                                </div>
                            </td>
                            <td align="center" valign="top" width="20%"><h3>-or-</h3></td>
                            <td>
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#templateModal">
                                    Use template
                                </button>
                            </td>
                        </tr>
                        <tr><td height="10px"></td></tr>
                        <tr>
                            <td>
                                <select class="form-control" name="categoryName" id="categoryName" title="">
                                    <option value="" disabled selected>Choose Category</option>
                                    <?php
                                        $categories = $dbcomm->getCategoriesByUsername($username);
                                        for($i = 0; $i < count($categories); $i++) {
                                            echo "<option value='$categories[$i]'>$categories[$i]</option>";
                                        }
                                    ?>
                                    <option disabled>-----------------</option>
                                    <option value="AddCategory">Add Category</option>
                                    <option value="DeleteCategory">Delete Category</option>
                                </select>
                            </td>
                            <td></td>
                            <td width="40%">
                                <select class="form-control" name="importance" id="importance" title="">
                                    <option value="" disabled selected>Choose Importance</option>
                                    <?php
                                        $priorities = $dbcomm->getPriorities();
                                        for($i = 0; $i < count($priorities); $i++) {
                                            echo "<option value='$priorities[$i]'>$priorities[$i]</option>";
                                        }
                                    ?>
                                </select>

                            </td>
                        </tr>
                        <tr><td height="10px"></td></tr>
                        <tr><td>Start Time</td><td></td><td>End Time</td></tr>
                        <tr>
                            <td><div class="input-group registration-date-time ">
                                    <span class="input-group-addon" ><span class="glyphicon glyphicon-time" aria-hidden="true"></span></span>
                                    <select type="text" class="form-control" id="start_hour" name="start_hour">
                                        <option value="00">00</option>
                                        <option value="01">01</option>
                                        <option value="02">02</option>
                                        <option value="03">03</option>
                                        <option value="04">04</option>
                                        <option value="05">05</option>
                                        <option value="06">06</option>
                                        <option value="07">07</option>
                                        <option value="08">08</option>
                                        <option value="09">09</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                        <option value="13">13</option>
                                        <option value="14">14</option>
                                        <option value="15">15</option>
                                        <option value="16">16</option>
                                        <option value="17">17</option>
                                        <option value="18">18</option>
                                        <option value="19">19</option>
                                        <option value="20">20</option>
                                        <option value="21">21</option>
                                        <option value="22">22</option>
                                        <option value="23">23</option>
                                    </select>
                                    <span class="input-group-addon" ><span class="glyphicon glyphicon-time" aria-hidden="true"></span></span>
                                    <select type="text" class="form-control" id="start_minute" name="start_minute">
                                        <option value="00">00</option>
                                        <option value="15">15</option>
                                        <option value="30">30</option>
                                        <option value="45">45</option>
                                    </select>
                                </div>
                            </td>
                            <td></td>
                            <td><div class="input-group registration-date-time ">
                                    <span class="input-group-addon" ><span class="glyphicon glyphicon-time" aria-hidden="true"></span></span>
                                    <select type="text" class="form-control" id="end_hour" name="end_hour">
                                        <option value="00">00</option>
                                        <option value="01">01</option>
                                        <option value="02">02</option>
                                        <option value="03">03</option>
                                        <option value="04">04</option>
                                        <option value="05">05</option>
                                        <option value="06">06</option>
                                        <option value="07">07</option>
                                        <option value="08">08</option>
                                        <option value="09">09</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                        <option value="13">13</option>
                                        <option value="14">14</option>
                                        <option value="15">15</option>
                                        <option value="16">16</option>
                                        <option value="17">17</option>
                                        <option value="18">18</option>
                                        <option value="19">19</option>
                                        <option value="20">20</option>
                                        <option value="21">21</option>
                                        <option value="22">22</option>
                                        <option value="23">23</option>
                                    </select>
                                    <span class="input-group-addon" ><span class="glyphicon glyphicon-time" aria-hidden="true"></span></span>
                                    <select type="text" class="form-control" id="end_minute" name="end_minute">
                                        <option value="00">00</option>
                                        <option value="15">15</option>
                                        <option value="30">30</option>
                                        <option value="45">45</option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr><td height="10px"></td></tr>
                        <tr><td>Date</td></tr>
                        <tr><td> <div class="form-group ">
                                    <div class="input-group">
                                        <input class="form-control" id="date" name="date" placeholder="MM/DD/YYYY" type="text"/>
                                    </div>
                                </div></td></tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <table>
                        <tr>
                            <td align="left" colspan="2" width="74%">
                                <input type="checkbox" name="vehicle" value="createTemplate" align="left"> Save as Template
                            </td>
                            <td>
                                <button type="submit" name="createTask" class="btn btn-primary">
                                    Create
                                </button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="modal fade" id="templateModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Use Template</h2>
            </div>
            <div class="modal-body">
                <table>
                    <tr><td>template 1</td></tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">
                    Use Template
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
</html>