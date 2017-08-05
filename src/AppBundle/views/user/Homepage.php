<!DOCTYPE html>
<?php
ini_set('display_errors', 0);
require_once "../../scripts/dbcomm.php";
//create db connection
$dbcomm = new dbcomm();

if (!isset($_GET['id'])) {
    die("Error: The id was not set.");
}
$encryptedUsername = $_GET['id'];
$encryptedUsername = str_replace("!!!", "+", $encryptedUsername);
$encryptedUsername = str_replace("$$$", "%", $encryptedUsername);
$username = openssl_decrypt($encryptedUsername, 'RC4-40', 'regularUserPassword');
$encryptedUsername = str_replace("+", "!!!", $encryptedUsername);
$encryptedUsername = str_replace("%", "$$$", $encryptedUsername);

if (isset($_POST['createTask'])) {
    if (isset($_POST['taskName']) and isset($_POST['categoryName']) and isset($_POST['importance']) and isset($_POST['start_hour']) and isset($_POST['start_minute']) and isset($_POST['end_hour']) and isset($_POST['end_minute']) and isset($_POST['date'])) {

        $errorCount = 0;
        $taskName = $_POST['taskName'];
        $categoryName = $_POST['categoryName'];
        $importance = $_POST['importance'];
        $start_hour = $_POST['start_hour'];
        $start_minute = $_POST['start_minute'];
        $start_period = $_POST['startAmPm'];
        $end_hour = $_POST['end_hour'];
        $end_minute = $_POST['end_minute'];
        $end_period = $_POST['endAmPm'];
        $taskDate = $_POST['date'];

        /*if ($end_hour < $start_hour OR !($end_hour != $start_hour AND $end_minute >= $start_minute)){
            $errorCount++;
            $alertMessage =
                '<div class="alert alert-danger alert-dismissible" role="alert">'
                .'<button type="button" class="close" data-dismiss="alert" aria-label="Close">'
                .'<span aria-hidden="true">&times;</span>'
                .'</button>'
                .'<strong>'
                .'Error:'
                .'</strong>'
                .'<span>'
                .'The times set are not correct.'
                .'</div>';

        }*/

        $year = substr($taskDate, 6, 4);
        $month = substr($taskDate, 0, 2);
        $day = substr($taskDate, 3, 2);
        $date = $year . "-" . $month . '-' . $day;

        $startTime = $start_hour . ':' . $start_minute . ' ' . $start_period;

        $endTime = $end_hour . ':' . $end_minute . ' ' . $end_period;

        $dbcomm->createTaskByUsername($username, $taskName, $categoryName, $importance, $startTime, $endTime, $date);

        if ($_POST['createTemplate'] == 'yes') {
            $dbcomm->addTemplateByUsername($username, $taskName, $categoryName, $importance, $startTime, $endTime);
        }
    }
}

if (isset($_POST['saveTask'])) {
    if (isset($_POST['editTaskID']) and isset($_POST['editTaskName']) and isset($_POST['editTaskCategoryName']) and isset($_POST['editTaskImportance']) and isset($_POST['editTask_start_hour']) and isset($_POST['editTask_start_minute']) and isset($_POST['editTask_end_hour']) and isset($_POST['editTask_end_minute']) and isset($_POST['editTask_date'])) {

        $errorCount = 0;
        $taskName = $_POST['editTaskName'];
        $categoryName = $_POST['editTaskCategoryName'];
        $importance = $_POST['editTaskImportance'];
        $start_hour = $_POST['editTask_start_hour'];
        $start_minute = $_POST['editTask_start_minute'];
        $start_period = $_POST['editTask_startAmPm'];
        $end_hour = $_POST['editTask_end_hour'];
        $end_minute = $_POST['editTask_end_minute'];
        $end_period = $_POST['editTask_endAmPm'];
        $taskDate = $_POST['editTask_date'];
        $taskIdToUpdate = $_POST['editTaskID'];

        /*if ($end_hour < $start_hour OR !($end_hour != $start_hour AND $end_minute >= $start_minute)){
            $errorCount++;
            $alertMessage =
                '<div class="alert alert-danger alert-dismissible" role="alert">'
                .'<button type="button" class="close" data-dismiss="alert" aria-label="Close">'
                .'<span aria-hidden="true">&times;</span>'
                .'</button>'
                .'<strong>'
                .'Error:'
                .'</strong>'
                .'<span>'
                .'The times set are not correct.'
                .'</div>';

        }*/

        $year = substr($taskDate, 6, 4);
        $month = substr($taskDate, 0, 2);
        $day = substr($taskDate, 3, 2);
        $date = $year . "-" . $month . '-' . $day;

        $startTime = $start_hour . ':' . $start_minute . ' ' . $start_period;

        $endTime = $end_hour . ':' . $end_minute . ' ' . $end_period;

        $dbcomm->updateTaskByTaskID($taskIdToUpdate, $taskName, $categoryName, $importance, $startTime, $endTime, $date);
    }
}

if (isset($_GET['deleteTask'])) {
    $dbcomm->deleteTaskByTaskID($_GET['deleteTask']);
    $alertMessage = '<div class="alert alert-success alert-dismissible col-md-10 col-md-offset-1" role="alert" align="center">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Success!</strong>  The task has been deleted.</div>';
}

if (isset($_GET['weekToDay'])) {
    $weekDay = explode('**', $_GET['weekToDay'])[2];
    $weekMonth = explode('**', $_GET['weekToDay'])[1];
    $weekYear = explode('**', $_GET['weekToDay'])[0];
    if (intval($weekDay) < 10) $weekDay = "0" . $weekDay;
    if (intval($weekMonth) < 10) $weekMonth = "0" . $weekMonth;
    $dbcomm->setDateByDate($username, $weekYear . "-" . $weekMonth . "-" . $weekDay);
}

if (isset($_GET['monthToDay'])) {
    $dbcomm->setDayOfMonthByUsername($username, $_GET['monthToDay']);
}

if (isset($_POST['decrementDate'])) {
    $dbcomm->decrementDateByUsername($username);
}

if (isset($_POST['incrementDate'])) {
    $dbcomm->incrementDateByUsername($username);
}

if (isset($_POST['decrementWeek'])) {
    $dbcomm->decrementWeekByUsername($username);
}

if (isset($_POST['incrementWeek'])) {
    $dbcomm->incrementWeekByUsername($username);
}

if (isset($_POST['decrementMonth'])) {
    $dbcomm->decrementMonthByUsername($username);
}

if (isset($_POST['incrementMonth'])) {
    $dbcomm->incrementMonthByUsername($username);
}

if (isset($_GET['today']) and $_GET['today'] = 'xtxrxuxex') {
    $dbcomm->setCurrentDateByUsername($username);
}

$wordDaysOfTheWeek = Array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");
$months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
$numDaysInMonth = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
if ($dbcomm->isCurrentYearALeapYear($username) == 1) {
    $numDaysInMonth[1] = 29;
}


$theDate = $dbcomm->getDateByUsername($username);
$currentDate = substr($theDate, 5, 2) . '/' . substr($theDate, 8, 2);
$currentDay = intval($dbcomm->getDayByUsername($username));
$currentMonth = $dbcomm->getMonthByUsername($username);
$currentMonthName = $months[$currentMonth - 1];
$currentYear = $dbcomm->getYearByUsername($username);


if (isset($_GET['completeTaskID'])) {
    $todayDate = date('Y-m-d');

    if ($todayDate <= $theDate) {
        $encryptedTaskID = $_GET['completeTaskID'];
        $encryptedTaskID = str_replace("!!!", "+", $encryptedTaskID);
        $encryptedTaskID = str_replace("$$$", "%", $encryptedTaskID);
        $taskID = openssl_decrypt($encryptedTaskID, 'RC2-64-CBC', 'completeTaskPassword');
        $completeTaskID = intval($taskID);
        $dbcomm->completeTaskByTaskID($username, $completeTaskID);
        $alertMessage .= '<div class="alert alert-success alert-dismissible col-md-10 col-md-offset-1" role="alert" align="center">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Success!</strong>  Your task has been completed.</div>';
    } else {
        $alertMessage .= '<div class="alert alert-danger alert-dismissible col-md-10 col-md-offset-1" role="alert" align="center">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Error!</strong>  Previous tasks can no longer be completed.</div>';
    }
}

$dbcomm->convertPointsStarsTrophies($username);
?>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../../libs/bootstrap/dist/css/bootstrap.min.css">
    <script src="../../libs/jquery/dist/jquery.min.js"></script>
    <script src="../../libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Planbook</title>


    <link rel="stylesheet" type="text/css" href="../../libs/fullpage-js/dist/jquery.fullpage.min.css"/>
    <link rel="stylesheet" type="text/css" href="../../css/fullpage-style.css"/>
    <link rel="stylesheet" href="../../libs/w3-css/w3.css">

    <script type="text/javascript" src="../../libs/fullpage-js/dist/jquery.fullpage.min.js"></script>
    <script type="text/javascript" src="../../scripts/jquery/fullpage-config.js"></script>
    <script type="text/javascript" src="../../scripts/jquery/user/tasklist-config.js"></script>
    <link rel="stylesheet" type="text/css" href="../../css/user/homepage.css"/>
    <script src="../../scripts/jquery/user/createTask.js"></script>
    <script type="text/javascript"
            src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
    <link rel="stylesheet"
          href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#fullpage').fullpage({
                sectionsColor: ['#ADD8E6', /*'#ADD8E6',*/ '#ADD8E6'],
                anchors: ['firstPage', /*'secondPage',*/ '3rdPage'],
                menu: '#menu'
            });
        });
    </script>

</head>
<body>

<ol id="menu">
    <li data-menuanchor="firstPage"><a href="#firstPage">Tasks</a></li>
    <!--<li data-menuanchor="secondPage"><a href="#secondPage">Stats</a></li>-->
    <li data-menuanchor="3rdPage"><a href="#3rdPage">Awards</a></li>
</ol>

<div id="fullpage">
    <div class="section" id="section0">
        <div class="slide" id="slide1">
            <div class="content">
                <!--https://bootsnipp.com/snippets/D2kkX-->
                <? if (isset($alertMessage)) {
                    echo "<div>";
                    echo $alertMessage;
                    echo "</div>";
                } ?>
                <table align="center" width="80%">
                    <tr>
                        <td width="10%" align="left">
                            <form role="form" action="Homepage.php?id=<? echo $encryptedUsername; ?>&today=xtxrxuxex"
                                  method="post">
                                <button type="submit" class="btn btn-primary">Today</button>
                            </form>
                        </td>
                        <td align="center">
                            <form role="form" action="Homepage.php?id=<? echo $encryptedUsername ?>#firstPage"
                                  method="post" class="login-form" style="display: inline-block">
                                <button class="glyphicon glyphicon-chevron-left"
                                        style="font-size: 3em; cursor: pointer; appearance: none; -webkit-appearance: none; -moz-appearance: none; outline: none;border: 0; background: transparent;"
                                        name="decrementDate" type="submit"></button>
                            </form>
                            <h1 style="display: inline-block;" id="dailyViewDate">
                                &nbsp;<? echo $currentMonthName . " " . $currentDay . ", " . $currentYear; ?>&nbsp;</h1>
                            <form role="form" action="Homepage.php?id=<? echo $encryptedUsername ?>#firstPage"
                                  method="post" class="login-form" style="display: inline-block">
                                <button class="glyphicon glyphicon-chevron-right"
                                        style="font-size: 3em; display: inline-block; cursor: pointer; appearance: none; -webkit-appearance: none; -moz-appearance: none; outline: none;border: 0; background: transparent;"
                                        name="incrementDate" type="submit"></button>
                            </form>
                        </td>
                        <td align="right" width="10%">
                            <div class="content">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#mymodal"
                                        id="newTaskButton">
                                    New Task
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <?php
                        $categories = $dbcomm->getCategoryNamesByUsername($username);
                        $colors = $dbcomm->getThemeByUsername($username);
                        $allTasksForDay = Array();
                        $ultimateTaskCount = 0;
                        for ($i = 0; $i < sizeOf($categories); $i++) {
                            $category = $categories[$i];
                            $color = $colors[$i];
                            $j = $i + 1;

                            $tasks = $dbcomm->getTaskInfoByCategory($username, $category);
                            $taskCount = count($tasks);

                            for ($l = 0; $l < $taskCount; $l++) {
                                $tasks[$l]['category'] = $category;
                                array_push($allTasksForDay, $tasks[$l]);
                            }

                            echo '<tr>';
                            echo '<td colspan="3" align="left">';
                            echo '<div class="panel-group">';
                            echo '<div class="panel panel-default">';
                            echo "<div class='panel-heading' style='background-color:$color;'>";
                            echo '<h4 class="panel-title">';
                            echo "<a data-toggle='collapse' data-target='#collapse$j'>";
                            echo $category . "</a>";
                            echo "&nbsp;&nbsp;<span class='badge' style='color: $color'>$taskCount</span>";
                            echo '</h4>';
                            echo '</div>';
                            echo "<div id='collapse$j' class='panel-collapse collapse'>";
                            echo '<form>';
                            echo '<table class="list-group" width="100%">';
                            $priorityColor = "gray";
                            foreach ($tasks as $taskID => $tasksValues) {
                                $task = $tasksValues['taskName'];
                                $priority = $tasksValues['priority'];
                                $startTime = $tasksValues['startTime'];
                                $endTime = $tasksValues['endTime'];
                                $date = $tasksValues['date'];
                                $taskID = $tasksValues['id'];
                                if ($priority == "Low") {
                                    $priorityStyle = 'style = "color:green"';
                                } else if ($priority == "Medium") {
                                    $priorityStyle = 'style="color: yellow;text-shadow: -1px 0 dimgrey, 0 1px dimgrey, 1px 0 dimgrey, 0 -1px dimgrey;"';
                                } else {
                                    $priorityStyle = 'style = "color: red"';
                                }

                                $encryptedTaskID = openssl_encrypt($taskID, 'RC2-64-CBC', 'completeTaskPassword');
                                $encryptedTaskID = str_replace("+", "!!!", $encryptedTaskID);
                                $encryptedTaskID = str_replace("%", "$$$", $encryptedTaskID);
                                $completedTRClass = "";
                                $strikethroughTDClass="";
                                if ($dbcomm->isCompletedByTaskID($taskID)) {
                                    $completedTRClass = "background-image: url('strikethrough.png');";
                                    $strikethroughTDClass = "text-decoration: line-through;";
                                }
                                echo "<tr id='closeItem'  style='border: 1px solid black;>";
                                echo "<td style='padding: 8px; $strikethroughTDClass' width='40%'>$task</td>";
                                echo "<td align ='center' style='$strikethroughTDClass'><div class='glyphicon glyphicon-alert'$priorityStyle></div></td>";
                                echo "<td align = 'left' width='20%' style='$strikethroughTDClass'>$priority Priority </td>";
                                echo "<td align ='center' style='$strikethroughTDClass'><div class='glyphicon glyphicon-time'></div></td>";
                                echo "<td align='right' width='7.5%'style='$strikethroughTDClass'>$startTime</td>";
                                echo "<td align = 'center'style='$strikethroughTDClass'> to </td>";
                                echo "<td align='left'style='$strikethroughTDClass'>$endTime</td>";
                                if (!($dbcomm->isCompletedByTaskID($taskID))) {
                                    echo "<td align='center' width='2%' id='tdConfirmComplete'>
                                        <a href='Homepage.php?id=$encryptedUsername&completeTaskID=$encryptedTaskID' class='confirmCompleteTask' title='Complete' id='confirmComplete'>
                                            <div class='glyphicon glyphicon-ok-sign'></div>
                                        </a>
                                      </td>";
                                    echo "<td align='center' width='2%'>
                                        <button style='appearance: none; -webkit-appearance: none; -moz-appearance: none; outline: none; border: 0; background: transparent;' type='button' class='glyphicon glyphicon-pencil' id = 'ultimateTaskCount$ultimateTaskCount' title='Edit' data-toggle='modal' data-target='#editTaskModal' onclick='loadEditTask(this.id)'></button>
                                      </td>";
                                    echo "<td align='center' width='2%'>
                                        <a href='Homepage.php?id=$encryptedUsername&deleteTask=$taskID' class='confirmation' title='Delete'>
                                            <div class='glyphicon glyphicon-remove-sign'></div>
                                        </a>
                                      </td>";
                                }
                                echo '</tr>';
                                $ultimateTaskCount++;
                            }
                            if ($taskCount == 0) {
                                echo '<tr>';
                                echo '<td style="padding: 8px">No Tasks here</td>';
                                echo '</tr>';
                            }
                            echo '</table>';
                            echo '</form>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                            echo '</td>';
                            echo '</tr>';
                        }
                        ?>
                    </tr>
                </table>
            </div>
        </div>
        <div class="slide" id="slide2">
            <div class="content">
                <table align="center" width="80%">
                    <tr>
                        <?php
                        $datesOfTheWeek = $dbcomm->getDatesofCurrentWeekByUsername($username);
                        $daysOfTheWeek = $datesOfTheWeek[0];
                        $monthsOfTheWeek = $datesOfTheWeek[1];
                        $yearsOfTheWeek = $datesOfTheWeek[2];
                        $colors = $dbcomm->getThemeByUsername($username);
                        ?>
                        <td colspan="7" align="center">
                            <form role="form" action="Homepage.php?id=<? echo $encryptedUsername ?>#firstPage/1"
                                  method="post" class="login-form" style="display: inline-block">
                                <button class="glyphicon glyphicon-chevron-left"
                                        style="font-size: 3em; cursor: pointer; appearance: none; -webkit-appearance: none; -moz-appearance: none; outline: none;border: 0; background: transparent;"
                                        name="decrementWeek" type="submit"></button>
                            </form>
                            <h2 style="display: inline-block; font-size: 3em;" id="dailyViewDate">
                                &nbsp;
                                <? echo $months[intval($monthsOfTheWeek[0]) - 1] . " " . $daysOfTheWeek[0] . ", " . $yearsOfTheWeek[0]; ?>
                                &nbsp;-&nbsp;
                                <? echo $months[intval($monthsOfTheWeek[6]) - 1] . " " . $daysOfTheWeek[6] . ", " . $yearsOfTheWeek[6]; ?>
                                &nbsp;
                            </h2>
                            <form role="form" action="Homepage.php?id=<? echo $encryptedUsername ?>#firstPage/1"
                                  method="post" class="login-form" style="display: inline-block">
                                <button class="glyphicon glyphicon-chevron-right"
                                        style="font-size: 3em; display: inline-block; cursor: pointer; appearance: none; -webkit-appearance: none; -moz-appearance: none; outline: none;border: 0; background: transparent;"
                                        name="incrementWeek" type="submit"></button>
                            </form>
                        </td>
                    </tr>
                    <tr style="border: 1px solid black" align="center">
                        <?php
                        for ($i = 0; $i < 7; $i++) {
                            $styleTagForWeek = "";
                            $daySubstr = substr($wordDaysOfTheWeek[$i], 0, 3);
                            $dayNumberTag = $daysOfTheWeek[$i];
                            if (intval(date('j')) == intval($daysOfTheWeek[$i]) and intval(date('n')) == intval($monthsOfTheWeek[$i]) and intval(date('Y')) == intval($yearsOfTheWeek[$i])) {
                                if ($daysOfTheWeek[$i] < 10) {
                                    $dayNumberTag = "<span style='background-color: red; border-radius: 50%; color: white;'>&nbsp;$daysOfTheWeek[$i]&nbsp;</span>";
                                } else {
                                    $dayNumberTag = "<span style='background-color: red; border-radius: 50%; color: white;'>$daysOfTheWeek[$i]</span>";
                                }
                            }
                            echo "<td class='weekToDay$i' width='100/7%' style='border: 1px solid black; background-color: $colors[$i]; cursor: pointer;'>
                                      <h4>$daySubstr $dayNumberTag</h4>
                                  </td>";
                        }
                        ?>
                    </tr>
                    <?php
                    $categories = $dbcomm->getCategoryNamesByUsername($username);
                    $colors = $dbcomm->getThemeByUsername($username);
                    for ($i = 0; $i < sizeOf($categories); $i++) {
                        $dbcomm->setDateByDate($username, $yearsOfTheWeek[0] . "-" . $monthsOfTheWeek[0] . "-" . $daysOfTheWeek[0]);
                        $categoryName = $categories[$i];
                        echo "<tr>";

                        for ($j = 0; $j < 7; $j++) {
                            $tasks = $dbcomm->getTaskInfoByCategory($username, $categoryName);
                            $taskCount = count($tasks);

                            $color = $colors[($i % 8)];
                            $styleTag = "";
                            if ($i == sizeOf($categories) - 1) {
                                $styleTag = "border-bottom: 1px solid black;";
                            }
                            //$ = $dbcomm->getNumberOfTasksInCategoryByDate($username, $category, $currentDate);
                            if ($taskCount > 0) {
                                echo "<td class='weekToDay$j' style='border-left: 1px solid black; border-right: 1px solid black; $styleTag height: 55px; padding: 2px 10px 2px 10px; cursor: pointer;'>
                                    <div class='badge' style='display: block; background-color: $color; color: black;'>
                                        $categoryName&nbsp;&nbsp;
                                        <span class='badge' style='display: inline-block; background-color: black; color: $color;'>$taskCount</span>
                                    </div>
                                  </td>";
                            } else {
                                echo "<td class='weekToDay$j' style='border-left: 1px solid black; border-right: 1px solid black; $styleTag height: 55px; cursor: pointer;'></td>";
                            }

                            $dbcomm->incrementDateByUsername($username);
                        }
                        echo "</tr>";
                    }

                    $dbcomm->setDateByDate($username, $theDate);
                    ?>
                </table>
            </div>
        </div>
        <div class="slide" id="slide3">
            <div class="content">
                <table align="center" width="80%" id="monthlyViewTable" border="1px solid black">
                    <tr>
                        <td colspan="7" align="center">
                            <form role="form" action="Homepage.php?id=<? echo $encryptedUsername ?>#firstPage/2"
                                  method="post" class="login-form" style="display: inline-block">
                                <button class="glyphicon glyphicon-chevron-left"
                                        style="font-size: 3em; display: inline-block; cursor: pointer; appearance: none; -webkit-appearance: none; -moz-appearance: none; outline: none;border: 0; background: transparent;"
                                        name="decrementMonth" type="submit"></button>
                            </form>
                            <h1 style="display: inline-block;" id="dailyViewDate">
                                &nbsp;<? echo $currentMonthName . " " . $currentYear; ?>&nbsp;</h1>
                            <form role="form" action="Homepage.php?id=<? echo $encryptedUsername ?>#firstPage/2"
                                  method="post" class="login-form" style="display: inline-block">
                                <button class="glyphicon glyphicon-chevron-right"
                                        style="font-size: 3em; display: inline-block; cursor: pointer; appearance: none; -webkit-appearance: none; -moz-appearance: none; outline: none;border: 0; background: transparent;"
                                        name="incrementMonth" type="submit"></button>
                            </form>
                        </td>
                    </tr>
                    <tr align="right">
                        <td width="100/7%"
                            style="padding-right: 10px; background-color: <? echo $colors[0]; ?>; height: 40px;"><h4>
                                Sun</h4></td>
                        <td width="100/7%" style="padding-right: 10px; background-color: <? echo $colors[1]; ?>"><h4>
                                Mon</h4></td>
                        <td width="100/7%" style="padding-right: 10px; background-color: <? echo $colors[2]; ?>"><h4>
                                Tue</h4></td>
                        <td width="100/7%" style="padding-right: 10px; background-color: <? echo $colors[3]; ?>"><h4>
                                Wed</h4></td>
                        <td width="100/7%" style="padding-right: 10px; background-color: <? echo $colors[4]; ?>"><h4>
                                Thu</h4></td>
                        <td width="100/7%" style="padding-right: 10px; background-color: <? echo $colors[5]; ?>"><h4>
                                Fri</h4></td>
                        <td width="100/7%" style="padding-right: 10px; background-color: <? echo $colors[6]; ?>"><h4>
                                Sun</h4></td>
                    </tr>
                    <?php
                    $firstDOTW = $dbcomm->getDOTWofFirstDayofCurrentMonth($username);
                    $tasksperDay = $dbcomm->getNumTasksPerDayOfCurrentMonthByUsername($username);

                    echo "<tr>";

                    for ($i = 0; $i < $firstDOTW; $i++) {
                        echo "<td></td>";
                    }

                    for ($i = 1; $i <= $numDaysInMonth[intval($currentMonth) - 1]; $i++) {
                        $numTasks = $tasksperDay[$i - 1];
                        $taskColorIndex = ($i + $firstDOTW - 1) % 7;

                        $taskColor = $colors[$taskColorIndex];

                        echo "<td id='monthlyView$i' class='monthlyView' style='height: 70px; vertical-align: top; text-align: right; padding: 7px 7px 7px 7px; cursor: pointer;'>";

                        if (intval(date('j')) == $i and intval(date('n')) == $currentMonth and intval(date('Y')) == $currentYear) {
                            $numberStyleTag = $i;
                            if ($i < 10) $numberStyleTag = "&nbsp;$i&nbsp;";
                            echo "<span style='background-color: red; border-radius: 50%; color: white;'>$numberStyleTag</span>";
                        } else {
                            if ($i < 10) echo "&nbsp;$i&nbsp;";
                            else         echo "$i";
                        }

                        if ($numTasks > 0) {
                            $numberStyleTag = "Tasks";
                            if ($numTasks == 1) $numberStyleTag = "Task";
                            echo "<span class='badge' style='display: block; background-color: $taskColor; color: black;'>$numTasks&nbsp;$numberStyleTag</span>";
                        }

                        echo "</td>";

                        if (($i + $firstDOTW - 1) % 7 == 6) {
                            echo "</tr><tr>";
                        }
                    }

                    echo "</tr>";
                    ?>
                </table>
            </div>
        </div>
    </div>
    <!--<div class="section " id="section1">
        <div class="content">
            <h1>Stats</h1>
        </div>
    </div>-->
    <div class="section" id="section2">
        <table align="center" width="100%" style="height: 100%;">
            <tr style="height:25%">
                <td rowspan="6" valign="center" width="20%" id="exchangeSystem" style="border-right: 1px solid black;">
                    <h3><u>Exchange System</u></h3>
                    <br>
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
                    <div style="left: 40%; position: relative; top: 55px">
                        <button type="button" class="glyphicon glyphicon-question-sign" data-toggle="modal"
                                data-target="#infoAwardsModal"
                                style="font-size:32px; appearance: none; -webkit-appearance: none; -moz-appearance: none; outline: none;border: 0; background: transparent">
                        </button>
                    </div>
                </td>
                <td rowspan="5" width="5%"></td>
                <td colspan="3" valign="bottom">
                    <h1>Awards</h1>
                </td>
                <td>
                    <h3 style="color: dimgrey; font-size: 30px; text-align: left;">
                        Total points: <? echo $dbcomm->getNumTotalPointsByUsername($username); ?></h3>
                </td>
            </tr>
            <tr id="starSymbols">
                <td valign="bottom">
                    <img src="<? echo $dbcomm->getBronzeStarImageSource(); ?>" width="150" height="150">
                </td>
                <td>
                    <img src="<? echo $dbcomm->getSilverStarImageSource(); ?>" width="150" height="150">
                </td>
                <td>
                    <img src="<? echo $dbcomm->getGoldStarImageSource(); ?>" width="150" height="150">
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
                    $encryptedMarketUsername = openssl_encrypt($username, 'CAST5-ECB', 'toMarketPassword');
                    $encryptedMarketUsername = str_replace("+", "!!!", $encryptedMarketUsername);
                    $encryptedMarketUsername = str_replace("%", "$$$", $encryptedMarketUsername);
                    ?>
                    <button onclick="window.location='Market.php?id=<? echo $encryptedMarketUsername ?>';"
                            class="w3-button w3-circle w3-teal"
                            style="transform: translateX(50%); width: 190px; height: 180px; font-size: 75px;">➜&nbsp;&nbsp;&nbsp;
                    </button>
                </td>
            </tr>
            <tr id="starCount">
                <td>
                    <p><? echo $dbcomm->getNumBronzeStarsByUsername($username); ?></p>
                </td>
                <td>
                    <p><? echo $dbcomm->getNumSilverStarsByUsername($username); ?></p>
                </td>
                <td>
                    <p><? echo $dbcomm->getNumGoldStarsByUsername($username); ?></p>
                </td>
            </tr>
            <tr id="trophySymbols">
                <td>
                    <img src="<? echo $dbcomm->getBronzeTrophyImageSource(); ?>" width="150" height="150">
                </td>
                <td>
                    <img src="<? echo $dbcomm->getSilverTrophyImageSource(); ?>" width="150" height="150">
                </td>
                <td>
                    <img src="<? echo $dbcomm->getGoldTrophyImageSource(); ?>" width="150" height="150">
                </td>
            </tr>
            <tr id="trophyCount">
                <td>
                    <p><? echo $dbcomm->getNumBronzeTrophiesByUsername($username); ?></p>
                </td>
                <td>
                    <p><? echo $dbcomm->getNumSilverTrophiesByUsername($username); ?></p>
                </td>
                <td>
                    <p><? echo $dbcomm->getNumGoldTrophiesByUsername($username); ?></p>
                </td>
                <td width="15%"></td>
            </tr>
            <tr style="height:5%;"></tr>
        </table>
    </div>
</div>
<script>


    var elems = document.getElementsByClassName('confirmation');
    var confirmIt = function (e) {
        if (!confirm('Are you sure you want to delete this task?')) e.preventDefault();
    };
    for (var i = 0, l = elems.length; i < l; i++) {
        elems[i].addEventListener('click', confirmIt, false);
    }

    var completeTasks = document.getElementsByClassName('confirmCompleteTask');
    var confirmCompleteTask = function (e) {
        if (!confirm('Complete this task?')) e.preventDefault();
        else {
            var tempElement = this.parentElement;
            var trID = (tempElement.parentElement).id;
            $('#trID').toggleClass("highlight");
        }
    };
    for (var n = 0; n < completeTasks.length; n++) {
        completeTasks[n].addEventListener('click', confirmCompleteTask, false);
    }


    var monthlyViews = document.getElementsByClassName('monthlyView');
    for (var e = 0; e < monthlyViews.length; e++) {
        monthlyViews[e].addEventListener('click', function (ev) {
            if (ev.target.tagName === 'TD') {
                var tdID = ev.target.id;
                tdID = parseInt(tdID.substr(11));
                window.location = 'Homepage.php?id=<? echo $encryptedUsername; ?>&monthToDay=' + tdID;
            }
            else if (ev.target.tagName === 'SPAN') {
                var tdElement = ev.target.parentElement;
                if (tdElement.tagName === 'TD') {
                    var tdElementID = tdElement.id;
                    tdElementID = parseInt(tdElementID.substr(11));
                    window.location = 'Homepage.php?id=<? echo $encryptedUsername; ?>&monthToDay=' + tdElementID;
                }
                else {
                    //alert('tag error inside');
                }
            }
            else {
                //alert('tag error outside');
            }
        }, false);
    }

    var daysOfWeek = <?php echo json_encode($daysOfTheWeek); ?>;
    var monthsOfWeek = <?php echo json_encode($monthsOfTheWeek); ?>;
    var yearsOfWeek = <?php echo json_encode($yearsOfTheWeek); ?>;
    for (var m = 0; m < 7; m++) {
        daysOfWeek[m] = parseInt(daysOfWeek[m])
    }
    for (var j = 0; j < 7; j++) {
        var weeklyViews = document.getElementsByClassName('weekToDay' + j);
        for (var k = 0; k < weeklyViews.length; k++) {
            weeklyViews[k].addEventListener('click', function (ev) {
                var id, day, month, year;
                if (ev.target.tagName === 'TD') {
                    id = Number((ev.target.className).substring(9));
                    day = daysOfWeek[id];
                    month = monthsOfWeek[id];
                    year = yearsOfWeek[id];
                    window.location = 'Homepage.php?id=<? echo $encryptedUsername; ?>&weekToDay=' + year + "**" + month + "**" + day;
                }
                else if (ev.target.tagName === 'H4') {
                    var tdElement3 = ev.target.parentElement;
                    if (tdElement3.tagName === 'TD') {
                        id = Number((tdElement3.className).substring(9));
                        day = daysOfWeek[id];
                        month = monthsOfWeek[id];
                        year = yearsOfWeek[id];
                        window.location = 'Homepage.php?id=<? echo $encryptedUsername; ?>&weekToDay=' + year + "**" + month + "**" + day;
                    }
                    else {
                        //alert('tag error inside3');
                    }
                }
                else if (ev.target.tagName === 'DIV') {
                    var tdElement = ev.target.parentElement;
                    if (tdElement.tagName === 'TD') {
                        id = Number((tdElement.className).substring(9));
                        day = daysOfWeek[id];
                        month = monthsOfWeek[id];
                        year = yearsOfWeek[id];
                        window.location = 'Homepage.php?id=<? echo $encryptedUsername; ?>&weekToDay=' + year + "**" + month + "**" + day;
                    }
                    else {
                        //alert('tag error inside1');
                    }
                }
                else if (ev.target.tagName === 'SPAN') {
                    var tdElement2 = (ev.target.parentElement).parentElement;
                    if (tdElement2.tagName === 'TD') {
                        id = Number((tdElement2.className).substring(9));
                        day = daysOfWeek[id];
                        month = monthsOfWeek[id];
                        year = yearsOfWeek[id];
                        window.location = 'Homepage.php?id=<? echo $encryptedUsername; ?>&weekToDay=' + year + "**" + month + "**" + day;
                    }
                    else {
                        //alert('tag error inside2');
                    }
                }
                else {
                    //alert('tag error outside');
                }
            }, false);
        }
    }

    function onManageCategories(selectElement) {
        if (selectElement.value === "manageCategories") {
            $('#manageCategoriesModal').modal('show');
        }
    }

    function closeManageCategoryModal() {
        $("#categoryName").val('defaultSelected');
    }

    function loadTemplate() {
        var templates = <?php echo json_encode($dbcomm->getAllTemplatesByUsername($username)); ?>;
        var radioValue = $('input[name="templateRadio"]:checked').val();
        for (var i = 0; i < templates.length; i++) {
            if (templates[i]['templateID'] === radioValue) {
                var templateName = templates[i]['templateName'];
                var startHour = templates[i]['startHour'];
                var startMin = templates[i]['startMin'];
                var startAMPM = templates[i]['startAMPM'];
                var endHour = templates[i]['endHour'];
                var endMin = templates[i]['endMin'];
                var endAMPM = templates[i]['endAMPM'];
                var templatePriority = templates[i]['priority'];
                var templateCategory = templates[i]['category'];

                $("#taskName").val(templateName);
                $("#categoryName").val(templateCategory);
                $("#importance").val(templatePriority);
                $("#start_hour").val(startHour);
                $("#start_minute").val(startMin);
                $("#startAmPm").val(startAMPM);
                $("#end_hour").val(endHour);
                $("#end_minute").val(endMin);
                $("#endAmPm").val(endAMPM);

                $('#templateModal').modal('hide');
                break;
            }
        }
    }

    function loadEditTask(id) {
        var dayTasks = <?php echo json_encode($allTasksForDay); ?>;
        var dayTasksIndex = Number(id.substring(17));

        var taskName = dayTasks[dayTasksIndex]['taskName'];
        var startHour = dayTasks[dayTasksIndex]['startTime'].substring(0, 2);
        var startMin = dayTasks[dayTasksIndex]['startTime'].substring(3, 5);
        var startAMPM = dayTasks[dayTasksIndex]['startTime'].substring(6, 8);
        var endHour = dayTasks[dayTasksIndex]['endTime'].substring(0, 2);
        var endMin = dayTasks[dayTasksIndex]['endTime'].substring(3, 5);
        var endAMPM = dayTasks[dayTasksIndex]['endTime'].substring(6, 8);
        var day = dayTasks[dayTasksIndex]['date'].substring(8, 10);
        var month = dayTasks[dayTasksIndex]['date'].substring(5, 7);
        var year = dayTasks[dayTasksIndex]['date'].substring(0, 4);
        var templatePriority = dayTasks[dayTasksIndex]['priority'];
        var templateCategory = dayTasks[dayTasksIndex]['category'];
        var taskID = dayTasks[dayTasksIndex]['id'];

        $("#editTaskName").val(taskName);
        $("#editTaskCategoryName").val(templateCategory);
        $("#editTaskImportance").val(templatePriority);
        $("#editTask_start_hour").val(startHour);
        $("#editTask_start_minute").val(startMin);
        $("#editTask_startAmPm").val(startAMPM);
        $("#editTask_end_hour").val(endHour);
        $("#editTask_end_minute").val(endMin);
        $("#editTask_endAmPm").val(endAMPM);
        $("#editTask_date").val(month + "/" + day + "/" + year);
        $("#editTaskID").val(taskID);
    }


    $(function () {

        $('#categoryForm').on('submit', function (e) {

            e.preventDefault();

            $.ajax({
                type: 'post',
                url: '../ajax/AddCategory.php',
                data: $('#categoryForm').serialize(),
                success: function () {
                    //alert('form was submitted');
                }
            });

            var table = document.getElementById("tableOfCategories");
            var row = table.insertRow();
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);
            var newCategoryName = document.getElementById("newCategoryName").value;
            $('#newCategoryName').val("");
            cell1.innerHTML = "- " + newCategoryName;
            cell2.innerHTML = "";
            cell3.innerHTML = "<div class='glyphicon glyphicon-trash' style='font-size: 20px; color: dimgrey; cursor: pointer;' title='Delete''></div>";
            cell3.style.borderRight = "1px solid black";

        });

    });


    $(document).ready(function () {
        $('#mymodal').click(function () {
            $('html').css('overflow', 'hidden');
            $('body').bind('touchmove', function (e) {
                e.preventDefault()
            });
        });
        $('.mymodal-close').click(function () {
            $('html').css('overflow', 'scroll');
            $('body').unbind('touchmove');
        });

        var date_input = $('input[name="date"]'); //our date input has the name "date"
        var container = $('.bootstrap-iso form').length > 0 ? $('.bootstrap-iso form').parent() : "body";
        date_input.datepicker({
            format: 'mm/dd/yyyy',
            container: container,
            todayHighlight: true,
            autoclose: true
        })
    });
</script>


<!--------------------- Modals --------------------->


<div class="modal fade" id="infoAwardsModal">
    <form role="form" action="Homepage.php?id=<? echo $encryptedUsername; ?>#firstPage" method="post">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="padding-left: 10%;">
                    <h2>Awards Info</h2>

                </div>
                <div class="modal-body">
                    <table width="80%" align="center">
                        <tr>
                            <td valign="bottom" width="40%">
                                <h3>
                                    Earning Points&nbsp;&nbsp;&nbsp;&nbsp;
                                    <span class="glyphicon glyphicon-piggy-bank"></span>
                                </h3>
                                <h6>Points will be added to your total points whenever you create
                                    and complete new tasks. 'Low priority' tasks are worth 5 points,
                                    'Medium priority' tasks are worth 8 points, and 'High priority'
                                    tasks are worth 10 points.</h6>
                                <h3>
                                    Stars and Trophies&nbsp;&nbsp;&nbsp;&nbsp;
                                    <span class="glyphicon glyphicon-star"></span>
                                </h3>
                                <h6>Whenever you reach 50 points, a bronze star will automatically be
                                    added to your account as a personal achievement. From here, 10 bronze
                                    stars become a silver star and 10 silver stars become a gold star.
                                    Once you reach 10 gold stars, they turn into a bronze trophy. Then,
                                    10 bronze trophies become a silver trophy and 10 silver trophies become
                                    a gold trophy.</h6>
                                <h3>
                                    Redeeming Rewards&nbsp;&nbsp;&nbsp;&nbsp;
                                    <span class="glyphicon glyphicon-gift"></span>
                                </h3>
                                <h6>Stars and trophies, however, aren't taken away from how many total
                                    points you have. You can use these points that you have to redeem
                                    rewards in the market once you reach enough points.</h6>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <table align="center" width="80%">
                        <tr>
                            <td align="right">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="modal fade" id="mymodal">
    <form role="form" action="Homepage.php?id=<? echo $encryptedUsername; ?>#firstPage" method="post"
          class="task_create">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="padding-left: 10%;">
                    <h2>Create New Task</h2>

                    <? if (isset($alertMessageForTask)) //if the alert for creating list is set, then echo the alert
                    {
                        echo '<div>';
                        echo $alertMessageForTask;
                        echo '</div>';
                    }
                    ?>

                </div>
                <div class="modal-body">
                    <table width="80%" align="center">
                        <tr>
                            <td valign="bottom" width="40%">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="taskName" id="taskName" maxlength="45"
                                           placeholder="Enter Task Name...">
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
                        <tr>
                            <td height="10px"></td>
                        </tr>
                        <tr>
                            <td>
                                <select class="form-control" title="Category Name" name="categoryName" id="categoryName"
                                        onchange="onManageCategories(this)">
                                    <option value="defaultSelected" disabled selected>Choose Category</option>
                                    <?php
                                    $categories = $dbcomm->getCategoriesByUsername($username);
                                    for ($i = 0; $i < count($categories); $i++) {
                                        $categoryName = $categories[$i]['name'];
                                        echo "<option value='$categoryName'>$categoryName</option>";
                                    }
                                    ?>
                                    <option disabled>-----------------</option>
                                    <option value="manageCategories">Manage Categories</option>
                                </select>
                            </td>
                            <td></td>
                            <td width="40%">
                                <select class="form-control" title="Importance" name="importance" id="importance">
                                    <option value="" disabled selected>Choose Importance</option>
                                    <?php
                                    $priorities = $dbcomm->getPriorities();
                                    for ($i = 0; $i < count($priorities); $i++) {
                                        echo "<option value='$priorities[$i]'>$priorities[$i]</option>";
                                    }
                                    ?>
                                </select>

                            </td>
                        </tr>
                        <tr>
                            <td height="10px"></td>
                        </tr>
                        <tr>
                            <td>Start Time</td>
                            <td></td>
                            <td>End Time</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="input-group registration-date-time ">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-time"
                                                                          aria-hidden="true"></span></span>
                                    <select type="text" class="form-control" id="start_hour" name="start_hour">
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
                                    </select>
                                    <span class="input-group-addon">:</span>
                                    <select type="text" class="form-control" id="start_minute" name="start_minute">
                                        <option value="00">00</option>
                                        <option value="15">15</option>
                                        <option value="30">30</option>
                                        <option value="45">45</option>
                                    </select>
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-minus"
                                                                          aria-hidden="true"></span></span>
                                    <select type="text" class="form-control" id="startAmPm" name="startAmPm">
                                        <option value="AM">AM</option>
                                        <option value="PM">PM</option>
                                    </select>
                                </div>
                            </td>
                            <td></td>
                            <td>
                                <div class="input-group registration-date-time ">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-time"
                                                                          aria-hidden="true"></span></span>
                                    <select type="text" class="form-control" id="end_hour" name="end_hour">
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
                                    </select>
                                    <span class="input-group-addon">:</span>
                                    <select type="text" class="form-control" id="end_minute" name="end_minute">
                                        <option value="00">00</option>
                                        <option value="15">15</option>
                                        <option value="30">30</option>
                                        <option value="45">45</option>
                                    </select>
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-minus"
                                                                          aria-hidden="true"> </span></span>
                                    <select type="text" class="form-control" id="endAmPm" name="endAmPm">
                                        <option value="AM">AM</option>
                                        <option value="PM">PM</option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td height="10px"></td>
                        </tr>
                        <tr>
                            <td>Date</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-group ">
                                    <div class="input-group">
                                        <input class="form-control" id="date" name="date" placeholder="MM/DD/YYYY"
                                               type="text"/>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <table align="center" width="80%">
                        <tr>
                            <td align="left">
                                <input type="checkbox" name="createTemplate" value="yes" align="left"> Save as Template
                            </td>
                            <td align="right">
                                <button type="submit" name="createTask" class="btn btn-primary">Create</button>
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
    <!--<form id="templateForm">-->
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="text-align: center">
                <h2>Templates</h2>
            </div>
            <div class="modal-body">
                <table width="100%">
                    <tr>
                        <td colspan="2">
                            Templates:
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td height="20px" colspan="2"></td>
                    </tr>
                    <?php
                    $templates = $dbcomm->getAllTemplatesByUsername($username);
                    foreach ($templates as $templateCount => $templateValues) {
                        $templateID = $templateValues['templateID'];
                        $templateName = $templateValues['templateName'];
                        echo "<tr>",
                        "<td width='40%'>",
                        "<div class=\"radio\">",
                        "<label><input type=\"radio\" name=\"templateRadio\" value=\"$templateID\">$templateName</label>",
                        "</div>",
                        "</td>",
                        "<td width='60%' class='deleteTemplate'>",
                        "<span class='glyphicon glyphicon-trash' style='font-size: 20px; color: dimgrey; cursor: pointer;' title='Delete'></span>",
                        "</td>",
                        "</tr>";
                    }
                    ?>
                </table>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" name="templateSubmit" onclick="loadTemplate()">Use Template</button>
                <button type="button" class="btn btn-default" id="closeTemplateModal" data-dismiss="modal">Close
                </button>
            </div>
        </div>
    </div>
    <!--</form>-->
</div>

<div class="modal fade" id="manageCategoriesModal">
    <form id="categoryForm">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="text-align: center;">
                    <h2>Manage Categories</h2>
                </div>
                <div class="modal-body">
                    <table width="100%">
                        <tr>
                            <td width="50%">
                                <table width="100%" id="tableOfCategories">
                                    <tr>
                                        <td colspan="3" style="border-right: 1px solid black;">
                                            Categories:
                                            <br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="20px" colspan="3" style="border-right: 1px solid black;"></td>
                                    </tr>
                                    <?php
                                    $categories = $dbcomm->getCategoriesByUsername($username);
                                    for ($i = 0; $i < count($categories); $i++) {
                                        $categoryName = $categories[$i]['name'];
                                        echo "<tr id='categories$i'>
                                            <td>- $categoryName</td>
                                            <td width='40px'></td>
                                            <td style='border-right: 1px solid black;'>
                                                <div class='glyphicon glyphicon-trash' style='font-size: 20px; color: dimgrey; cursor: pointer;' id='delete$i' title='Delete' onclick='deleteCategory(this)'></div>
                                            </td>
                                        </tr>";
                                    }
                                    ?>
                                </table>
                            </td>
                            <td width="50%" style="vertical-align: top;">
                                <div style="width: 100%; padding: 10px 10px 10px 10px;">
                                    Add New Category:
                                    <br><br>
                                    <input type="text" name="newCategoryUsername" id="newCategoryUsername"
                                           value="<? echo $username ?>" style="display: none;">
                                    <input maxlength="15" type="text" class="form-control" name="newCategoryName"
                                           id="newCategoryName" placeholder="Category Name...">
                                    <br>
                                    <button type="submit" name="submitAddCategory" class="btn btn-default"
                                            style="float: right;">Add Category
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"
                            onclick="closeManageCategoryModal()">Close
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="modal fade" id="editTaskModal">
    <form role="form" action="Homepage.php?id=<? echo $encryptedUsername; ?>#firstPage" method="post">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="padding-left: 10%;">
                    <h2>Edit Task</h2>

                    <? if (isset($alertMessageForEditTask)) {
                        echo '<div>';
                        echo $alertMessageForEditTask;
                        echo '</div>';
                    }
                    ?>

                </div>
                <div class="modal-body">
                    <table width="80%" align="center">
                        <tr>
                            <td valign="bottom" width="40%">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="editTaskName" id="editTaskName"
                                           maxlength="45" placeholder="Enter Task Name...">
                                </div>
                            </td>
                            <td align="center" valign="top" width="20%"><!--<h3>-or-</h3>--></td>
                            <td>
                                <!--
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#templateModal">
                                    Use template
                                </button>
                                -->
                            </td>
                        </tr>
                        <tr>
                            <td height="10px"></td>
                        </tr>
                        <tr>
                            <td>
                                <select class="form-control" title="Category Name" name="editTaskCategoryName"
                                        id="editTaskCategoryName">
                                    <option value="defaultSelected" disabled selected>Choose Category</option>
                                    <?php
                                    $categories = $dbcomm->getCategoriesByUsername($username);
                                    for ($i = 0; $i < count($categories); $i++) {
                                        $categoryName = $categories[$i]['name'];
                                        echo "<option value='$categoryName'>$categoryName</option>";
                                    }
                                    ?>
                                </select>
                            </td>
                            <td></td>
                            <td width="40%">
                                <select class="form-control" title="Importance" name="editTaskImportance"
                                        id="editTaskImportance">
                                    <option value="defaultSelected" disabled selected>Choose Importance</option>
                                    <?php
                                    $priorities = $dbcomm->getPriorities();
                                    for ($i = 0; $i < count($priorities); $i++) {
                                        echo "<option value='$priorities[$i]'>$priorities[$i]</option>";
                                    }
                                    ?>
                                </select>

                            </td>
                        </tr>
                        <tr>
                            <td height="10px"></td>
                        </tr>
                        <tr>
                            <td>Start Time</td>
                            <td></td>
                            <td>End Time</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="input-group registration-date-time ">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-time"
                                                                          aria-hidden="true"></span></span>
                                    <select type="text" class="form-control" id="editTask_start_hour"
                                            name="editTask_start_hour">
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
                                    </select>
                                    <span class="input-group-addon">:</span>
                                    <select type="text" class="form-control" id="editTask_start_minute"
                                            name="editTask_start_minute">
                                        <option value="00">00</option>
                                        <option value="15">15</option>
                                        <option value="30">30</option>
                                        <option value="45">45</option>
                                    </select>
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-minus"
                                                                          aria-hidden="true"></span></span>
                                    <select type="text" class="form-control" id="editTask_startAmPm"
                                            name="editTask_startAmPm">
                                        <option value="AM">AM</option>
                                        <option value="PM">PM</option>
                                    </select>
                                </div>
                            </td>
                            <td></td>
                            <td>
                                <div class="input-group registration-date-time ">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-time"
                                                                          aria-hidden="true"></span></span>
                                    <select type="text" class="form-control" id="editTask_end_hour"
                                            name="editTask_end_hour">
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
                                    </select>
                                    <span class="input-group-addon">:</span>
                                    <select type="text" class="form-control" id="editTask_end_minute"
                                            name="editTask_end_minute">
                                        <option value="00">00</option>
                                        <option value="15">15</option>
                                        <option value="30">30</option>
                                        <option value="45">45</option>
                                    </select>
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-minus"
                                                                          aria-hidden="true"> </span></span>
                                    <select type="text" class="form-control" id="editTask_endAmPm"
                                            name="editTask_endAmPm">
                                        <option value="AM">AM</option>
                                        <option value="PM">PM</option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td height="10px"></td>
                        </tr>
                        <tr>
                            <td>Date</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-group">
                                    <div class="input-group">
                                        <input class="form-control" id="editTask_date" name="editTask_date"
                                               placeholder="MM/DD/YYYY" type="text"/>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <table align="center" width="80%">
                        <tr>
                            <td align="right">
                                <input type="text" name="editTaskID" id="editTaskID" style="display: none;">
                                <button type="submit" name="saveTask" class="btn btn-primary">Save</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </form>
</div>

</body>
</html>