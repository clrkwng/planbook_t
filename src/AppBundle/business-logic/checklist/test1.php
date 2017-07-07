<?php
/**
 * Created by PhpStorm.
 * User: clwang
 * Date: 6/27/17
 * Time: 12:41 PM
 */

require_once "dbcomm.php";

$dbcomm = new dbcomm();

$dbcomm->createNewList("Test List 1");
$dbcomm->createNewList("Test List 2");
$dbcomm->createNewList("Test List 3");
$dbcomm->createNewList("Test List 4");
$dbcomm->createNewList("Test List 5");


/*$dbcomm->addNewListItem("14985818005033", "Shoes");
$dbcomm->addNewListItem("14985818005033", "Hat");
$dbcomm->addNewListItem("14985818005033", "Coat");*/

//print_r($dbcomm->getAllLists());

//echo $dbcomm->getListNameByID("14985818005033");

//$dbcomm->deletelistByID("14985818005033");