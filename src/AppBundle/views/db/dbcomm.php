<?php

/*
 * Stuff to do when setting up db
 * 1. run script
 * 2. Add award images in `Image` table
 *      a. name -> bronzeStar
 *      b. description -> awards
 *      c. link -> ../resources/img/bronzeStar.png
 * 3. Add awards to `Awards` table
 *      a. name -> bronzeStar
 *      b. image_id -> reference `Image` table
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

    function deleteAccountByUsername($username) {
        $query = "SELECT `account_id` FROM `User` WHERE `username`='$username'";
        $accountID = mysqli_fetch_array($this->doQuery($query))['account_id'];

        $query = "SELECT `id`,`image_id` FROM `User` WHERE `account_id`='$accountID'";
        $result = $this->doQuery($query);
        while($row = mysqli_fetch_array($result)) {
            $userID = $row['id'];
            $userImageID = $row['image_id'];
            echo "Deleting userID:" . $userID . " and userImageID:" . $userImageID;
            $query = "DELETE FROM `User_Awards` WHERE `user_id` = '$userID'";
            $this->doQuery($query);
            $query = "DELETE FROM `Image` WHERE `id` = '$userImageID'";
            $this->doQuery($query);
            $query = "DELETE FROM `Task` WHERE `user_id` = '$userID'";
            $this->doQuery($query);
            $query = "DELETE FROM `Category` WHERE `user_id` = '$userID'";
            $this->doQuery($query);
            $query = "DELETE FROM `Redeem` WHERE `user_id` = '$userID'";
            $this->doQuery($query);
            $query = "DELETE FROM `User` WHERE `id` = '$userID'";
            $this->doQuery($query);
        }
        $query = "DELETE FROM `Account` WHERE `id` = '$accountID'";
        $this->doQuery($query);
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
        $accountID = mysqli_fetch_array($this->doQuery($query))['id'];

        $query = "INSERT INTO `Image` (`name`,`description`,`link`) VALUES ('$username','profile picture','../../resources/img/profile.png')";
        $this->doQuery($query);

        $query = "SELECT `id` FROM `Image` WHERE `name`='$username'";
        $imageID = mysqli_fetch_array($this->doQuery($query))['id'];


        $query = "INSERT INTO `User` (`account_id`, `username`, `password`, `image_id`, `email`, `phone_number`) VALUES ('$accountID', '$username', '$password', '$imageID', '$email', '$phonenumber');";
        $this->doQuery($query);

        $query = "UPDATE `User` SET `type_id`='1' WHERE `username`='$username'";
        $this->doQuery($query);


        $query = "SELECT `id` FROM `User` WHERE `username`='$username'";
        $userID = mysqli_fetch_array($this->doQuery($query))['id'];

        $query = "SELECT `id` FROM `Awards` WHERE `name`='bronzeStar'";
        $bronzeStarID = mysqli_fetch_array($this->doQuery($query))['id'];
        $query = "SELECT `id` FROM `Awards` WHERE `name`='silverStar'";
        $silverStarID = mysqli_fetch_array($this->doQuery($query))['id'];
        $query = "SELECT `id` FROM `Awards` WHERE `name`='goldStar'";
        $goldStarID = mysqli_fetch_array($this->doQuery($query))['id'];
        $query = "SELECT `id` FROM `Awards` WHERE `name`='bronzeTrophy'";
        $bronzeTrophyID = mysqli_fetch_array($this->doQuery($query))['id'];
        $query = "SELECT `id` FROM `Awards` WHERE `name`='silverTrophy'";
        $silverTrophyID = mysqli_fetch_array($this->doQuery($query))['id'];
        $query = "SELECT `id` FROM `Awards` WHERE `name`='goldTrophy'";
        $goldTrophyID = mysqli_fetch_array($this->doQuery($query))['id'];

        $query = "INSERT INTO `User_Awards` (`award_id`, `user_id`, `quantity`) VALUES ($bronzeStarID, $userID, '0');";
        $this->doQuery($query);
        $query = "INSERT INTO `User_Awards` (`award_id`, `user_id`, `quantity`) VALUES ($silverStarID, $userID, '0');";
        $this->doQuery($query);
        $query = "INSERT INTO `User_Awards` (`award_id`, `user_id`, `quantity`) VALUES ($goldStarID, $userID, '0');";
        $this->doQuery($query);
        $query = "INSERT INTO `User_Awards` (`award_id`, `user_id`, `quantity`) VALUES ($bronzeTrophyID, $userID, '0');";
        $this->doQuery($query);
        $query = "INSERT INTO `User_Awards` (`award_id`, `user_id`, `quantity`) VALUES ($silverTrophyID, $userID, '0');";
        $this->doQuery($query);
        $query = "INSERT INTO `User_Awards` (`award_id`, `user_id`, `quantity`) VALUES ($goldTrophyID, $userID, '0');";
        $this->doQuery($query);

        $query = "INSERT INTO `Category` (`name`,`user_id`) VALUES ('Homework','$userID')";
        $this->doQuery($query);
        $query = "INSERT INTO `Category` (`name`,`user_id`) VALUES ('Sports','$userID')";
        $this->doQuery($query);
        $query = "INSERT INTO `Category` (`name`,`user_id`) VALUES ('Health','$userID')";
        $this->doQuery($query);
        $query = "INSERT INTO `Category` (`name`,`user_id`) VALUES ('Exercise','$userID')";
        $this->doQuery($query);
        $query = "INSERT INTO `Category` (`name`,`user_id`) VALUES ('Other','$userID')";
        $this->doQuery($query);
        $query = "INSERT INTO `Category` (`name`,`user_id`) VALUES ('Special Tasks','$userID')";
        $this->doQuery($query);
    }

    function getAccountIDByUsername($username)
    {
        $query = "SELECT `account_id` FROM `User` WHERE `username`='$username'";
        return mysqli_fetch_array($this->doQuery($query))['account_id'];
    }

    function createNewUser($accountID, $username, $password, $email, $phonenumber)
    {
        $query = "INSERT INTO `Image` (`name`,`description`,`link`) VALUES ('$username','profile picture','../../resources/img/profile.png')";
        $this->doQuery($query);

        $query = "SELECT `id` FROM `Image` WHERE `name`='$username'";
        $imageID = mysqli_fetch_array($this->doQuery($query))['id'];

        $query = "INSERT INTO `User` (`account_id`, `username`, `password`, `image_id`, `email`, `phone_number`) VALUES ('$accountID', '$username', '$password', '$imageID', '$email', '$phonenumber');";
        $this->doQuery($query);

        $query = "SELECT `id` FROM `User` WHERE `username`='$username'";
        $userID = mysqli_fetch_array($this->doQuery($query))['id'];

        $query = "SELECT `id` FROM `Awards` WHERE `name`='bronzeStar'";
        $bronzeStarID = mysqli_fetch_array($this->doQuery($query))['id'];
        $query = "SELECT `id` FROM `Awards` WHERE `name`='silverStar'";
        $silverStarID = mysqli_fetch_array($this->doQuery($query))['id'];
        $query = "SELECT `id` FROM `Awards` WHERE `name`='goldStar'";
        $goldStarID = mysqli_fetch_array($this->doQuery($query))['id'];
        $query = "SELECT `id` FROM `Awards` WHERE `name`='bronzeTrophy'";
        $bronzeTrophyID = mysqli_fetch_array($this->doQuery($query))['id'];
        $query = "SELECT `id` FROM `Awards` WHERE `name`='silverTrophy'";
        $silverTrophyID = mysqli_fetch_array($this->doQuery($query))['id'];
        $query = "SELECT `id` FROM `Awards` WHERE `name`='goldTrophy'";
        $goldTrophyID = mysqli_fetch_array($this->doQuery($query))['id'];

        $query = "INSERT INTO `User_Awards` (`award_id`, `user_id`, `quantity`) VALUES ($bronzeStarID, $userID, '0');";
        $this->doQuery($query);
        $query = "INSERT INTO `User_Awards` (`award_id`, `user_id`, `quantity`) VALUES ($silverStarID, $userID, '0');";
        $this->doQuery($query);
        $query = "INSERT INTO `User_Awards` (`award_id`, `user_id`, `quantity`) VALUES ($goldStarID, $userID, '0');";
        $this->doQuery($query);
        $query = "INSERT INTO `User_Awards` (`award_id`, `user_id`, `quantity`) VALUES ($bronzeTrophyID, $userID, '0');";
        $this->doQuery($query);
        $query = "INSERT INTO `User_Awards` (`award_id`, `user_id`, `quantity`) VALUES ($silverTrophyID, $userID, '0');";
        $this->doQuery($query);
        $query = "INSERT INTO `User_Awards` (`award_id`, `user_id`, `quantity`) VALUES ($goldTrophyID, $userID, '0');";
        $this->doQuery($query);

        $query = "INSERT INTO `Category` (`name`,`user_id`) VALUES ('Homework','$userID')";
        $this->doQuery($query);
        $query = "INSERT INTO `Category` (`name`,`user_id`) VALUES ('Sports','$userID')";
        $this->doQuery($query);
        $query = "INSERT INTO `Category` (`name`,`user_id`) VALUES ('Health','$userID')";
        $this->doQuery($query);
        $query = "INSERT INTO `Category` (`name`,`user_id`) VALUES ('Exercise','$userID')";
        $this->doQuery($query);
        $query = "INSERT INTO `Category` (`name`,`user_id`) VALUES ('Other','$userID')";
        $this->doQuery($query);
        $query = "INSERT INTO `Category` (`name`,`user_id`) VALUES ('Special Tasks','$userID')";
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

    function getPhoneNumberByUsername($username) {
        $query = "SELECT `phone_number` FROM `User` WHERE `username`='$username'";
        $phonenumber = mysqli_fetch_array($this->doQuery($query))['phone_number'];
        $phonenumber = "(" . substr($phonenumber,0,3) . ") " . substr($phonenumber,3,3) . "-" . substr($phonenumber,6,4);
        return $phonenumber;
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

        $query = "SELECT * FROM `User` WHERE `account_id`='$accountID' AND `type_id`='2'";
        $result = $this->doQuery($query);

        $users = Array();
        while($row = mysqli_fetch_array($result)) {
            $users[$row['id']] = Array("username"=>$row['username'], "total_points"=>$row['total_points']);
        }
        ksort($users);
        return $users;
    }

    function deleteUserByUsername($username) {
        $query = "SELECT `id` FROM `User` WHERE `username`='$username'";
        $userID = mysqli_fetch_array($this->doQuery($query))['id'];

        $query = "DELETE FROM `User_Awards` WHERE `user_id`='$userID'";
        $this->doQuery($query);

        $query = "SELECT `image_id` FROM `User` WHERE `username`='$username'";
        $imageID = mysqli_fetch_array($this->doQuery($query))['image_id'];

        $query = "DELETE FROM `Image` WHERE `id`='$imageID'";
        $this->doQuery($query);

        $query = "DELETE FROM `User` WHERE `username`='$username'";
        $this->doQuery($query);
    }

    function getAdminUsernameByAccountID($accountID) {
        $query = "SELECT `username` FROM `User` WHERE `account_id`='$accountID' AND `type_id`='1'";
        return mysqli_fetch_array($this->doQuery($query))['username'];
    }

    function getEncodedUsernamesByAccountID($accountID) {
        $query = "SELECT `username` FROM `User` WHERE `account_id`='$accountID'";
        $result = $this->doQuery($query);

        $users = Array();
        while($row = mysqli_fetch_array($result)) {
            $encryptedUsername = openssl_encrypt($row['username'], 'DES-EDE3', 'viewUserProfilePassword');
            $encryptedUsername = str_replace("+", "!!!", $encryptedUsername);
            $encryptedUsername = str_replace("%", "$$$", $encryptedUsername);
            array_push($users, $encryptedUsername);
        }
        return $users;
    }

    /*
     * Awards FUNCTIONS ------------------------------------------------------------
     * */

    function getNumCurrentPointsByUsername($username) {
        $query = "SELECT `current_points` FROM `User` WHERE `username`='$username'";
        return mysqli_fetch_array($this->doQuery($query))['current_points'];
    }

    function getNumTotalPointsByUsername($username) {
        $query = "SELECT `total_points` FROM `User` WHERE `username`='$username'";
        return mysqli_fetch_array($this->doQuery($query))['total_points'];
    }

    function getNumBronzeStarsByUsername($username) {
        $query = "SELECT `id` FROM `User` WHERE `username`='$username'";
        $userID = mysqli_fetch_array($this->doQuery($query))['id'];
        $query = "SELECT `id` FROM `Awards` WHERE `name`='bronzeStar'";
        $awardID = mysqli_fetch_array($this->doQuery($query))['id'];

        $query = "SELECT `quantity` FROM `User_Awards` WHERE `user_id`='$userID' AND `award_id`='$awardID'";
        return mysqli_fetch_array($this->doQuery($query))['quantity'];
    }

    function getNumSilverStarsByUsername($username) {
        $query = "SELECT `id` FROM `User` WHERE `username`='$username'";
        $userID = mysqli_fetch_array($this->doQuery($query))['id'];
        $query = "SELECT `id` FROM `Awards` WHERE `name`='silverStar'";
        $awardID = mysqli_fetch_array($this->doQuery($query))['id'];

        $query = "SELECT `quantity` FROM `User_Awards` WHERE `user_id`='$userID' AND `award_id`='$awardID'";
        return mysqli_fetch_array($this->doQuery($query))['quantity'];
    }

    function getNumGoldStarsByUsername($username) {
        $query = "SELECT `id` FROM `User` WHERE `username`='$username'";
        $userID = mysqli_fetch_array($this->doQuery($query))['id'];
        $query = "SELECT `id` FROM `Awards` WHERE `name`='goldStar'";
        $awardID = mysqli_fetch_array($this->doQuery($query))['id'];

        $query = "SELECT `quantity` FROM `User_Awards` WHERE `user_id`='$userID' AND `award_id`='$awardID'";
        return mysqli_fetch_array($this->doQuery($query))['quantity'];
    }

    function getNumBronzeTrophiesByUsername($username) {
        $query = "SELECT `id` FROM `User` WHERE `username`='$username'";
        $userID = mysqli_fetch_array($this->doQuery($query))['id'];
        $query = "SELECT `id` FROM `Awards` WHERE `name`='bronzeTrophy'";
        $awardID = mysqli_fetch_array($this->doQuery($query))['id'];

        $query = "SELECT `quantity` FROM `User_Awards` WHERE `user_id`='$userID' AND `award_id`='$awardID'";
        return mysqli_fetch_array($this->doQuery($query))['quantity'];
    }

    function getNumSilverTrophiesByUsername($username) {
        $query = "SELECT `id` FROM `User` WHERE `username`='$username'";
        $userID = mysqli_fetch_array($this->doQuery($query))['id'];
        $query = "SELECT `id` FROM `Awards` WHERE `name`='silverTrophy'";
        $awardID = mysqli_fetch_array($this->doQuery($query))['id'];

        $query = "SELECT `quantity` FROM `User_Awards` WHERE `user_id`='$userID' AND `award_id`='$awardID'";
        return mysqli_fetch_array($this->doQuery($query))['quantity'];
    }

    function getNumGoldTrophiesByUsername($username) {
        $query = "SELECT `id` FROM `User` WHERE `username`='$username'";
        $userID = mysqli_fetch_array($this->doQuery($query))['id'];
        $query = "SELECT `id` FROM `Awards` WHERE `name`='goldTrophy'";
        $awardID = mysqli_fetch_array($this->doQuery($query))['id'];

        $query = "SELECT `quantity` FROM `User_Awards` WHERE `user_id`='$userID' AND `award_id`='$awardID'";
        return mysqli_fetch_array($this->doQuery($query))['quantity'];
    }

    function getBronzeStarImageSource() {
        $query = "SELECT `image_id` FROM `Awards` WHERE `name`='bronzeStar'";
        $imageID = mysqli_fetch_array($this->doQuery($query))['image_id'];
        $query = "SELECT `link` FROM `Image` WHERE `id`='$imageID'";
        return mysqli_fetch_array($this->doQuery($query))['link'];
    }

    function getSilverStarImageSource() {
        $query = "SELECT `image_id` FROM `Awards` WHERE `name`='silverStar'";
        $imageID = mysqli_fetch_array($this->doQuery($query))['image_id'];
        $query = "SELECT `link` FROM `Image` WHERE `id`='$imageID'";
        return mysqli_fetch_array($this->doQuery($query))['link'];
    }

    function getGoldStarImageSource() {
        $query = "SELECT `image_id` FROM `Awards` WHERE `name`='goldStar'";
        $imageID = mysqli_fetch_array($this->doQuery($query))['image_id'];
        $query = "SELECT `link` FROM `Image` WHERE `id`='$imageID'";
        return mysqli_fetch_array($this->doQuery($query))['link'];
    }

    function getBronzeTrophyImageSource() {
        $query = "SELECT `image_id` FROM `Awards` WHERE `name`='bronzeTrophy'";
        $imageID = mysqli_fetch_array($this->doQuery($query))['image_id'];
        $query = "SELECT `link` FROM `Image` WHERE `id`='$imageID'";
        return mysqli_fetch_array($this->doQuery($query))['link'];
    }

    function getSilverTrophyImageSource() {
        $query = "SELECT `image_id` FROM `Awards` WHERE `name`='silverTrophy'";
        $imageID = mysqli_fetch_array($this->doQuery($query))['image_id'];
        $query = "SELECT `link` FROM `Image` WHERE `id`='$imageID'";
        return mysqli_fetch_array($this->doQuery($query))['link'];
    }

    function getGoldTrophyImageSource() {
        $query = "SELECT `image_id` FROM `Awards` WHERE `name`='goldTrophy'";
        $imageID = mysqli_fetch_array($this->doQuery($query))['image_id'];
        $query = "SELECT `link` FROM `Image` WHERE `id`='$imageID'";
        return mysqli_fetch_array($this->doQuery($query))['link'];
    }

    /*
     * Profile FUNCTIONS ------------------------------------------------------------
     * */

    function updateEmailByUsername($username, $email) {
        $query = "UPDATE `User` SET `email`='$email' WHERE `username`='$username'";
        $this->doQuery($query);
    }

    function updatePhoneNumberByUsername($username, $phonenumber) {
        $query = "UPDATE `User` SET `phone_number`='$phonenumber' WHERE `username`='$username'";
        $this->doQuery($query);
    }

    function getProfileImageByUsername($username) {
        $query = "SELECT `image_id` FROM `User` WHERE `username`='$username'";
        $imageID = mysqli_fetch_array($this->doQuery($query))['image_id'];

        $query = "SELECT `link` FROM `Image` WHERE `id`='$imageID'";
        return mysqli_fetch_array($this->doQuery($query))['link'];
    }

    function updateProfileImageByUsername($username, $imageSource) {
        $query = "SELECT `image_id` FROM `User` WHERE `username`='$username'";
        $imageID = mysqli_fetch_array($this->doQuery($query))['image_id'];

        $query = "UPDATE `Image` SET `link`='$imageSource' WHERE `id`='$imageID'";
        $this->doQuery($query);
    }

    /*
     * Rewards FUNCTIONS ------------------------------------------------------------
     * */

    function getAllRewardsByUsername($username) {
        $query = "SELECT `id` FROM `User` WHERE `username`='$username'";
        $userID = mysqli_fetch_array($this->doQuery($query))['id'];

        $query = "SELECT `reward`,`points`,`completed`,`redeem_date` FROM `Redeem` WHERE `user_id`='$userID'";
        $result = $this->doQuery($query);

        $users = Array();
        $counter = 0;
        while($row = mysqli_fetch_array($result)) {
            $row['redeem_date'] = substr($row['redeem_date'],5,2) . '/' . substr($row['redeem_date'],8,2) . '/' . substr($row['redeem_date'],0,4);
            $users[$counter] = Array("name"=>$row['reward'], "points"=>$row['points'], "completed"=>$row['completed'], "redeem_date"=>$row['redeem_date']);
            $counter += 1;
        }
        return $users;
    }

    function redeemRewardByUsername($username, $rewardName) {
        $query = "SELECT `id`,`total_points` FROM `User` WHERE `username`='$username'";
        $userID = mysqli_fetch_array($this->doQuery($query))['id'];
        $totalPoints = mysqli_fetch_array($this->doQuery($query))['total_points'];

        $query = "SELECT `points` FROM `Redeem` WHERE `user_id`='$userID' AND `reward`='$rewardName'";
        $pointsRequired = mysqli_fetch_array($this->doQuery($query))['points'];

        if ($totalPoints >= $pointsRequired) {
            date_default_timezone_set("America/New_York");
            $datetime = date('Y-m-d H:i:s');
            $query = "UPDATE `Redeem` SET `completed`='1', `redeem_date`='$datetime' WHERE `user_id`='$userID' AND `reward`='$rewardName'";
            $this->doQuery($query);

            $pointsAfterRedemption = $totalPoints - $pointsRequired;
            $query = "UPDATE `User` SET `total_points`='$pointsAfterRedemption' WHERE `id`='$userID'";
            $this->doQuery($query);
            return true;
        }
        else {
            return false;
        }
    }

    function addRewardByUsername($username, $rewardName, $points) {
        $query = "SELECT `id` FROM `User` WHERE `username`='$username'";
        $userID = mysqli_fetch_array($this->doQuery($query))['id'];

        $query = "INSERT INTO `Redeem` (`user_id`,`reward`,`points`) VALUES ('$userID','$rewardName','$points')";
        $this->doQuery($query);
    }

    /*
     * Create Task FUNCTIONS ----------------------------------------------------------
     */

    function createTaskByUsername($username, $taskName, $categoryName, $importance, $startDateTime, $endDateTime) {
        $query = "SELECT `id` FROM `User` WHERE `username`='$username'";
        $userID = mysqli_fetch_array($this->doQuery($query))['id'];

        $query = "SELECT `id` FROM `Category` WHERE `name`='$categoryName' AND `user_id`='$userID'";
        $categoryID = mysqli_fetch_array($this->doQuery($query))['id'];

        $query = "SELECT `id` FROM `Priority` WHERE `name`='$importance'";
        $priorityID = mysqli_fetch_array($this->doQuery($query))['id'];

        $query = "INSERT INTO `Task` (`user_id`, `task_name`, `category_id`, `priority_id`, `start_time`, `end_time`) VALUES ('$userID', '$taskName', '$categoryID', '$priorityID', '$startDateTime', '$endDateTime')";
        $this->doQuery($query);
    }

    function getCategoriesByUsername($username) {
        $query = "SELECT `id` FROM `User` WHERE `username`='$username'";
        $userID = mysqli_fetch_array($this->doQuery($query))['id'];

        $query = "SELECT `name` FROM `Category` WHERE `user_id`='$userID'";
        $result = $this->doQuery($query);

        $categories = Array();
        $counter = 0;
        while($row = mysqli_fetch_array($result)) {
            $categories[$counter] = $row['name'];
            $counter++;
        }
        sort($categories);
        return $categories;
    }

    function getTasksByCategory($username, $category){
        $query = "SELECT `id` FROM `User` WHERE `username`='$username'";
        $userID = mysqli_fetch_array($this->doQuery($query))['id'];

        $query = "SELECT `id` FROM `Category` WHERE `name` ='$category' AND `user_id` = '$userID'";
        $categoryID = mysqli_fetch_array($this->doQuery($query))['id'];

        $query = "SELECT `task_name` FROM `Task` WHERE `category_id` = '$categoryID' AND `user_id` = '$userID'";
        $result = $this->doQuery($query);

        $tasks = Array();
        $counter = 0;
        while($row = mysqli_fetch_array($result)){
            $tasks[$counter]=$row['task_name'];
            $counter++;
        }
        sort($tasks);
        return $tasks;
    }

    function getPriorities() {
        $query = "SELECT `name` FROM `Priority`";
        $result = $this->doQuery($query);

        $priorities = Array();
        $counter = 0;
        while($row = mysqli_fetch_array($result)) {
            $priorities[$counter] = $row['name'];
            $counter++;
        }
        return $priorities;
    }

    function createNewCategoryByUsername($username, $categoryName) {
        $query = "SELECT `id` FROM `User` WHERE `username`='$username'";
        $userID = mysqli_fetch_array($this->doQuery($query))['id'];

        $query = "INSERT INTO `Category` (`user_id`, `name`) VALUES ('$userID', '$categoryName')";
        $this->doQuery($query);
    }

    function deleteCategoryByUsername($username, $categoryName) {
        $query = "SELECT `id` FROM `User` WHERE `username`='$username'";
        $userID = mysqli_fetch_array($this->doQuery($query))['id'];

        $query = "DELETE FROM `Category` WHERE `user_id`='$userID' AND `name`='$categoryName'";
        $this->doQuery($query);
    }

}