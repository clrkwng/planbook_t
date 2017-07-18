<?php

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
        $this->sqlconn = mysqli_connect('mysql.planbook.xyz','pb_dev1','4FEF!j1w3KUSz0M','planbook_db1');
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

    /*
     * SIGN-UP FUNCTIONS ------------------------------------------------------------
     * */

    function checkIfAccountNameExists($accountName)
    {
        $query = "SELECT `id` FROM `Account` WHERE `account_name`='$accountName';";
        $result = $this->doQuery($query);

        $SQLdataarray = mysqli_fetch_array($result);
        if(count($SQLdataarray) < 1) {
            return FALSE;
        }
        else {
            return TRUE;
        }
    }

    function checkIfUsernameExists($username)
    {
        $query = "SELECT `id` FROM `User` WHERE `username`='$username';";
        $result = $this->doQuery($query);

        $SQLdataarray = mysqli_fetch_array($result);
        if(count($SQLdataarray) < 1) {
            return FALSE;
        }
        else {
            return TRUE;
        }
    }

    function checkIfPhonenumberExists($phonenumber)
    {
        $query = "SELECT `id` FROM `User` WHERE `phone_number`='$phonenumber';";
        $result = $this->doQuery($query);

        $SQLdataarray = mysqli_fetch_array($result);
        if(count($SQLdataarray) < 1) {
            return FALSE;
        }
        else {
            return TRUE;
        }
    }

    function checkIfEmailExists($email)
    {
        $query = "SELECT `id` FROM `User` WHERE `email`='$email';";
        $result = $this->doQuery($query);

        $SQLdataarray = mysqli_fetch_array($result);
        if(count($SQLdataarray) < 1) {
            return FALSE;
        }
        else {
            return TRUE;
        }
    }

    function createNewAdmin($accountName, $username, $password, $email, $phonenumber)
    {
        $query = "INSERT INTO  `Account` (`account_name`) VALUES ('$accountName');";
        $this->doQuery($query);

        $query = "SELECT `id` FROM `Account` WHERE `account_name`='$accountName'";
        $result = $this->doQuery($query);
        $SQLdataarray = mysqli_fetch_array($result);
        $accountID = $SQLdataarray['id'];

        $query = "INSERT INTO `User` (`account_id`, `username`, `password`, `email`, `phone_number`) VALUES ('$accountID', '$username', '$password', '$email', '$phonenumber');";
        $this->doQuery($query);

        $query = "UPDATE `User` SET `type_id`='1' WHERE `username`='$username'";
        $this->doQuery($query);
    }

    function getAccountIDByUsername($username)
    {
        $query = "SELECT `account_id` FROM `User` WHERE `username`='$username'";
        return mysqli_fetch_array($this->doQuery($query))['account_id'];
    }

    function createNewUser($accountID, $username, $password, $email, $phonenumber)
    {
        $query = "INSERT INTO `User` (`account_id`, `username`, `password`, `email`, `phone_number`) VALUES ('$accountID', '$username', '$password', '$email', '$phonenumber');";
        $this->doQuery($query);
    }

    function verifyAccountByAccountID($accountID)
    {
        $query = "UPDATE `Account` SET `verified`='1' WHERE `id`='$accountID'";
        return $this->doQuery($query);
    }

    /*
     * SIGN-IN FUNCTIONS ------------------------------------------------------------
     * */

    function verifyCredentials($username, $password)
    {
        $query = "SELECT `id` FROM `User` WHERE `username`='$username' AND `password`='$password';";
        $result = $this->doQuery($query);

        $SQLdataarray = mysqli_fetch_array($result);
        if(count($SQLdataarray) < 1) {
            return FALSE;
        }
        else {
            return TRUE;
        }
    }

    function isAccountVerified($username)
    {
        $query = "SELECT `account_id` FROM `User` WHERE `username`='$username'";
        $accountID =  mysqli_fetch_array($this->doQuery($query))['account_id'];
        $query = "SELECT `verified` FROM `Account` WHERE `id`='$accountID'";
        $verified  = mysqli_fetch_array($this->doQuery($query))['verified'];
        if ($verified > 0){
            return True;
        }
        else{
            return False;
        }
    }

    function getUserIDFromUsername($username)
    {
        $query = "SELECT `id` FROM `User` WHERE `username`='$username';";
        return mysqli_fetch_array($this->doQuery($query))['id'];
    }

    function getTypeByUsername($username)
    {
        $query = "SELECT `type_id` FROM `User` WHERE `username`='$username'";
        $type = mysqli_fetch_array($this->doQuery($query))['type_id'];
        $query = "SELECT `name` FROM `Type` WHERE `id`='$type'";
        return mysqli_fetch_array($this->doQuery($query))['name'];
    }

    /*
     * Verify FUNCTIONS ------------------------------------------------------------
     * */

    function getEmailByUsername($username) {
        $query = "SELECT `email` FROM `User` WHERE `username`='$username'";
        return mysqli_fetch_array($this->doQuery($query))['email'];
    }

    function verifyAccountByUsername($username) {
        $query = "SELECT `account_id` FROM `User` WHERE `username`='$username'";
        $accountID =  mysqli_fetch_array($this->doQuery($query))['account_id'];
        $this->verifyAccountByAccountID($accountID);
    }

    /*
     * Recovery FUNCTIONS ------------------------------------------------------------
     * */

    // check if email exists uses the function in the sign-up section

    function getUsernameByEmail($email) {
        $query = "SELECT `username` FROM `User` WHERE `email`='$email'";
        return mysqli_fetch_array($this->doQuery($query))['username'];
    }

    function resetPasswordByUsername($username, $password) {
        $query = "UPDATE `User` SET `password`='$password' WHERE `username`='$username'";
        return $this->doQuery($query);
    }

    /*
     * Admin Panel FUNCTIONS ------------------------------------------------------------
     * */

    function getAccountNameByUsername($username) {
        $query = "SELECT `account_id` FROM `User` WHERE `username`='$username'";
        $accountID = mysqli_fetch_array($this->doQuery($query))['account_id'];
        $query = "SELECT `account_name` FROM `Account` WHERE `id`='$accountID'";
        return mysqli_fetch_array($this->doQuery($query))['account_name'];
    }

    function getAllUsersByAdminUsername($username) {
        $query = "SELECT `account_id` FROM `User` WHERE `username`='$username'";
        $accountID = mysqli_fetch_array($this->doQuery($query))['account_id'];

        $query = "SELECT * FROM `User` WHERE `account_id`='$accountID'";
        $result = $this->doQuery($query);

        $users = Array();
        while($row = mysqli_fetch_array($result)) {
            $users[$row['id']] = Array("username"=>$row['username'], "total_points"=>$row['total_points']);
        }
        ksort($users);
        return $users;
    }

}