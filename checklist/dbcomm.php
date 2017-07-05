<?php

/**
 * Created by PhpStorm.
 * User: apple
 * Date: 6/26/17
 * Time: 4:18 PM
 */
class dbcomm
{
    //connection that others can't modify
    protected $sqlconn;

    //connect on startup
    function __construct() {
        $this->connect();
    }

    //disconnect on close
    function __destruct() {
        $this->disconnect();
    }


    /*
     * GENERAL FUNCTIONS ------------------------------------------------------------
     * */

    //connect to db or die
    function connect() {
        $this->sqlconn = mysqli_connect('mysql.planbook.xyz','pb_dev1','4FEF!j1w3KUSz0M','checklist1');
        if (mysqli_connect_errno()) {
            die("Connection failed: " . mysqli_connect_error());
        }
    }

    //disconnect from db
    function disconnect() {
        mysqli_close($this->sqlconn);
    }

    //send query to mysql or die
    function doQuery($query) {
        $result = mysqli_query($this->sqlconn,$query) or die(mysqli_error($this->sqlconn));
        return $result;
    }

    //convert timestamp to human time
    function getHumanTimeFromTimestamp($timestamp) {
        date_default_timezone_set("America/New_York");
        $humantime = date("M j, Y (H:i:s)", $timestamp);
        return $humantime;
    }

    //make a new timestamp
    function newTimestamp() {
        return time();
    }

    //make new id for list or time
    function newID() {
        $ID = $this->newTimestamp().(string)rand(1000,9999);
        return $ID;
    }

    /*
     * LIST FUNCTIONS ------------------------------------------------------------
     * */

    //make new list  from listname
    function createNewList($listName) {
        $listID = $this->newID();
        $timestamp = $this->newTimestamp();
        $query = "INSERT INTO  `checklists` (`checklistID`, `name`, `timestamp`, `password`) VALUES ('$listID', '$listName', '$timestamp', '');";
        return $this->doQuery($query);
    }

    //delete list by listID
    function deleteListByID($listID) {
        $query = "DELETE FROM `checklists` WHERE `checklistID` IN ('$listID');";
        return $this->doQuery($query);
    }

    //return all lists in key value pair sorted by listname
    function getAllLists() {
        $query = "SELECT * FROM `checklists`;";
        $result = $this->doQuery($query);

        $lists = Array();
        while($row = mysqli_fetch_array($result)) {
            $lists[$row['name']] = Array("checklistID"=>$row['checklistID'], "timestamp"=>$row['timestamp']);
        }
        ksort($lists);
        return $lists;
    }

    //return name by listID
    function getListNameByID($listID) {
        $query = "SELECT `name` FROM `checklists` WHERE `checklistID` = '$listID';";
        return mysqli_fetch_array($this->doQuery($query))['name'];
    }

    //check if listname exists by counting the number of occurrences
    function checkIfListNameExists($listName) {
        $query = "SELECT `checklistID` FROM `checklists` WHERE `name` = '$listName';";
        $result = $this->doQuery($query);
        $SQLdataarray = mysqli_fetch_array($result);
        if(count($SQLdataarray) < 1) {
            return FALSE;
        }
        else {
            return TRUE;
        }
    }

    //get the timestamp by list ID
    function getListTimestampByListID($listID) {
        $query = "SELECT `timestamp` FROM `checklists` WHERE `checklistID` = '$listID';";
        return mysqli_fetch_array($this->doQuery($query))['timestamp'];
    }

    /*
     * ITEM FUNCTIONS ------------------------------------------------------------
     * */

    //get all items of a list by listID in key value pair sorted by description
    function getAllItemsByListID($listID) {
        $query = "SELECT * FROM `items` WHERE `checklistID` = '$listID';";
        $result = $this->doQuery($query);

        $items = Array();
        while($row = mysqli_fetch_array($result)) {
            $items[$row['description']] = $row['itemID'];
        }
        ksort($items);
        return $items;
    }

    //add new item to list with timestamp
    function addNewListItem($listID, $description) {
        $itemID = $this->newID();
        $timestamp = $this->newTimestamp();
        $query = "INSERT INTO  `items` (`itemID`, `checklistID`, `description`, `timestamp`) VALUES ('$itemID', '$listID', '$description', '$timestamp');";
        return $this->doQuery($query);
    }

    //delete item by itemID
    function deleteListItemByID($itemID) {
        $query = "DELETE FROM `items` WHERE `itemID` IN ('$itemID');";
        return $this->doQuery($query);
    }

    //get timestamp of item
    function getItemTimestampByItemID($itemID) {
        $query = "SELECT `timestamp` FROM `items` WHERE `itemID` = '$itemID';";
        return mysqli_fetch_array($this->doQuery($query))['timestamp'];
    }

    //get item description from itemID
    function getItemDescriptionByID($itemID) {
        $query = "SELECT `desciption` FROM `items` WHERE `itemID` = '$itemID';";
        return mysqli_fetch_array($this->doQuery($query))['description'];
    }

}