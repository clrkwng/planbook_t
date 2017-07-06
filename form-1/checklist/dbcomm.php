<?php

/**
 * Created by PhpStorm.
 * User: clwang
 * Date: 6/26/17
 * Time: 4:18 PM
 */
class dbcomm
{
    //the connection to database
    protected $sqlconn;

        function __construct()
        {
            $this->connect();
        }

        function __destruct()
        {
            $this->disconnect();
        }

    /*
     *
     *
     * GENERAL FUNCTIONS
     *
     *
     * */

    function connect() //connect to database
    {
        $this->sqlconn = mysqli_connect('mysql.planbook.xyz','pb_dev2','4FEF!j1w3KUSz0M','checklist2');
        if (mysqli_connect_errno()){
            die("Failed to connect to MYSQL: " . mysqli_connect_error());
        }
    }

    function disconnect() //disconnect from database
    {
        mysqli_close($this->sqlconn);
    }

    function doQuery($query) //how to run a query in SQL
    {
        $result = mysqli_query($this->sqlconn,$query) or die(mysqli_error($this->sqlconn));
            return $result;
    }

    function getHumanTimeFromTimestamp($timestamp) //format time stamp in local time, human time
    {
        date_default_timezone_set("America/New_York");
        $humantime = date("M j, Y (H:i:s)", $timestamp);

        return $humantime;
    }

    function newTimestamp() // new timestamp
    {
        return time();
    }

    function newID() //create new ID, with random string appended
    {
        $ID = (string)$this->newTimestamp().(string)rand(1000, 9999);
        return $ID;
    }
    /*
     *
     *
     * LIST FUNCTIONS
     *
     *
     * */

    function createNewList($listName) //run query for creating new checklist
    {
        $listID = $this->newID();
        $timestamp = $this->newTimestamp();
        $query = "INSERT INTO `checklists` (`checklistID`, `name`, `timestamp`,`password`) VALUES ('$listID', '$listName', '$timestamp', '');";

        return $this->doQuery($query);
    }

    function deletelistByID($listID) //run query for deleting list by id
    {
        $query = "DELETE FROM `checklists` WHERE `checklistID` IN ('$listID');";
        return $this->doQuery($query);
    }

    function getAllLists() //run query for getting lists
    {
        $query = "SELECT * FROM `checklists`;";

        $result = $this->doQuery($query);
        $lists = Array();
        while ($row = mysqli_fetch_array($result))
        {
            $lists[$row['name']] = Array("checklistID"=>$row['checklistID'], "timestamp"=>$row['timestamp']); //return list with assigned key values
        }
        ksort($lists); //sory list
        return $lists;
    }

    function getListNameByID($listID) //get list name by id
    {
        $query = "SELECT `name` FROM `checklists` WHERE `checklistID` = '$listID';";

        return mysqli_fetch_array($this->doQuery($query))['name'];
    }

    function checkIfListNameExists($listName) //check if the thing exists
    {
        $query = "SELECT `checklistID` FROM `checklists` WHERE `name` = '$listName';";

        $result =  $this->doQuery($query);

        $SQLdataarray = mysqli_fetch_array($result);
        if (count($SQLdataarray)<1)
        {
            return FALSE; //if the count of the array is <1, then doesnt exist
        }
        else
        {
            return TRUE;
        }
    }

    function getListTimestampByListID($listID) //get the timestamp by the list id
    {
       $query = "SELECT `timestamp` FROM `checklists` WHERE `checklistID` = '$listID';";
        return mysqli_fetch_array($this->doQuery($query))['timestamp'];
    }

    /*
     *
     *
     * ITEM FUNCTIONS
     *
     *
     * */

    function getAllItemsByListID($listID) //returns all items
    {
        $query = "SELECT * FROM `items` WHERE `checklistID` = '$listID';";
        $result = $this->doQuery($query);
        $items = Array();
        while ($row = mysqli_fetch_array($result))
        {
            $items[$row['description']] = $row['itemID'];
        }
        ksort($items);
        return $items;
    }

    function addNewListItem($listID, $description) //adds a new item into the list by listid
    {
        $itemID = $this->newID();
        $timestamp = $this->newTimestamp();
        $query = "INSERT INTO `items` (`itemID`, `checklistID`, `description`,`timestamp`) VALUES ('$itemID', '$listID', '$description', '$timestamp');";
        return $this->doQuery($query);
    }

    function deletelistItemByID($itemID) //deletes the list item by the id
    {
        $query = "DELETE FROM `items` WHERE `itemID` IN ('$itemID');";
        return $this->doQuery($query);
    }

    function getItemTimeStampByItemID($itemID) //gets the timestamp associated in the array
    {
        $query = "SELECT `timestamp` FROM `items` WHERE `itemID` = '$itemID';";
        return mysqli_fetch_array($this->doQuery($query))['timestamp'];
    }

    function getItemDescriptionByID($itemID) //gets the description in the array
    {
        $query = "SELECT `description` FROM `items` WHERE `itemID` = '$itemID';";
        return mysqli_fetch_array($this->doQuery($query))['description'];
    }

}