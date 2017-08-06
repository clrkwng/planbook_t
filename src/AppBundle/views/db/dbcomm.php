<?php
class dbcomm
{
    //connection that others can't modify
    protected $sqlconn;

    //connect on startup
    function __construct() {
        $this->connect();
        $this->checkDBHealth();

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
        $this->sqlconn = mysqli_connect('{db.host}','{db.user}','{db.password}','{db.name}');
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
        $accountID = $this->getAccountIDByUsername($username);

        $query = "SELECT `username`,`image_id` FROM `User` WHERE `account_id`='$accountID'";
        $result = $this->doQuery($query);
        while($row = mysqli_fetch_array($result)) {
            $userUsername = $row['username'];
            $this->deleteUserByUsername($userUsername);
        }
        $query = "DELETE FROM `Account` WHERE `id` = '$accountID'";
        $this->doQuery($query);
    }

    /*
    * DB Setup Functions
    */


    /*
     * @param $doFix: boolean: if this is true, then the function will attempt
     *                  to create the missing records
     */
    function checkDBHealth(){
        //Provides the default init for database records
        //Allows for quick setup and checking of DB health

        $this->checkImageTable();
        $this->checkAwardsTable();
        $this->checkTypeTable();
        $this->checkPriorityTable();
    }

    function checkPriorityTable(){
        $priorityNames =
            array(
                "High",
                "Medium",
                "Low",
            );

        foreach ($priorityNames as $curPriorityName){
            $this->checkPriorityTableHelper(true, $curPriorityName);
        }
        return true;
    }

    function checkPriorityTableHelper($doFix, $priorityName){
        if($this->checkIfPriorityExistsByName($priorityName)){
            return true;
        }else{
            if($doFix){
                $this->insertNewPriority($priorityName);
                $this->checkPriorityTableHelper(false, $priorityName);
            }else{
                return false;
            }
        }
        return false;
    }

    function checkIfPriorityExistsByName($priorityName)
    {
        $query = "SELECT `id` FROM `Priority` WHERE `name`='$priorityName';";
        $result = $this->doQuery($query);

        $SQLdataarray = mysqli_fetch_array($result);
        if(count($SQLdataarray) < 1) {
            return FALSE;
        }
        else {
            return TRUE;
        }
    }

    function insertNewPriority($priorityName)
    {
        $query =
            "INSERT INTO `Priority` "
            ."(`name`) "
            ."VALUES "
            ."('$priorityName')";
        $this->doQuery($query);
        return true;
    }

    function checkAwardsTable(){
        $awardNames =
            array(
                "bronzeStar",
                "silverStar",
                "goldStar",
                "bronzeTrophy",
                "silverTrophy",
                "goldTrophy"
            );

        $awardsAmount =
            array(
                "50",
                "10",
                "10",
                "10",
                "10",
                "10"
            );

        $i = 0;
        foreach ($awardNames as $awardName){
            //NOTE: Assumes that $awardName == $imageName
            $this->checkAwardsTableHelper(true, $awardName, $awardName, $awardsAmount[$i]);
            $i++;
        }
        return true;
    }

    function checkAwardsTableHelper($doFix, $awardName, $imageName, $awardAmount){
        if($this->checkIfAwardExistsByName($awardName)){
            return true;
        }else{
            if($doFix){
                $imageId = $this->getImageIdByName($imageName);
                $this->insertNewAward($awardName, $imageId, $awardAmount);
                $this->checkAwardsTableHelper(false, $awardName, $imageName, $awardAmount);
            }else{
                return false;
            }
        }
        return false;
    }

    function checkIfAwardExistsByName($awardName)
    {
        $query = "SELECT `id` FROM `Awards` WHERE `name`='$awardName';";
        $result = $this->doQuery($query);

        $SQLdataarray = mysqli_fetch_array($result);
        if(count($SQLdataarray) < 1) {
            return FALSE;
        }
        else {
            return TRUE;
        }
    }

    function insertNewAward($awardName, $imageId, $awardAmount)
    {
        $query =
            "INSERT INTO `Awards` "
            ."(`name`,`image_id`,`amount`) "
            ."VALUES "
            ."('$awardName', '$imageId', '$awardAmount')";
        $this->doQuery($query);
        return true;
    }

    function checkImageTable(){
        $imageFileNames =
            array(
                "SYSTEM_DEFAULT",
                "bronzeStar",
                "silverStar",
                "goldStar",
                "bronzeTrophy",
                "silverTrophy",
                "goldTrophy"
            );
        $rootImgDir = '../../resources/img/';
        $imageFileLinks =
            array(
                $rootImgDir . 'profile.png',
                $rootImgDir . 'awards/bronzeStar.png',
                $rootImgDir . 'awards/silverStar.png',
                $rootImgDir . 'awards/goldStar.png',
                $rootImgDir . 'awards/bronzeTrophy.png',
                $rootImgDir . 'awards/silverTrophy.png',
                $rootImgDir . 'awards/goldTrophy.png'
            );
        $imageFileDescriptions =
            array(
                "System provided default image.",
                "System provided default image.",
                "System provided default image.",
                "System provided default image.",
                "System provided default image.",
                "System provided default image.",
                "System provided default image."
            );
        $i = 0;
        foreach ($imageFileNames as $imageName){
            $this->checkImageTableHelper(true, $imageName, $imageFileDescriptions[$i], $imageFileLinks[$i]);
            $i++;
        }
    }

    function checkImageTableHelper($doFix, $imageName, $imageDescription, $imageLink){
        if($this->checkIfImageExistsByName($imageName)){
            return true;
        }else{
            if($doFix){
                $this->insertNewImage($imageName, $imageDescription, $imageLink);
                $this->checkImageTableHelper(false, $imageName, $imageDescription, $imageLink);
            }else{
                return false;
            }
        }
        return false;
    }

    function checkIfImageExistsByName($imageName)
    {
        $query = "SELECT `id` FROM `Image` WHERE `name`='$imageName';";
        $result = $this->doQuery($query);

        $SQLdataarray = mysqli_fetch_array($result);
        if(count($SQLdataarray) < 1) {
            return FALSE;
        }
        else {
            return TRUE;
        }
    }

    function getImageIdByName($imageName){
        $query = "SELECT `id` FROM `Image` WHERE `name`='$imageName'";
        return mysqli_fetch_array($this->doQuery($query))['id'];
    }

    function insertNewImage($imageName, $imageDescription, $imageLink)
    {
        $query =
            "INSERT INTO `Image` "
            ."(`name`,`description`,`link`) "
            ."VALUES "
            ."('$imageName', '$imageDescription', '$imageLink')";
        $this->doQuery($query);
        return true;
    }


    function checkTypeTable(){
        return $this->checkTypeTableAdmin(true) && $this->checkTypeTableUser(true);
    }

    function checkTypeTableAdmin($doFix){
        if($this->checkIfTypeExistsInDB('Admin')){
            return true;
        }else{
            if($doFix){
                $this->insertNewType('Admin');
                return $this->checkTypeTableAdmin(false);
            }else{
                return false;
            }
        }
    }
    function checkTypeTableUser($doFix){
        if($this->checkIfTypeExistsInDB('User')){
            return true;
        }else{
            if($doFix){
                $this->insertNewType('User');
                return $this->checkTypeTableUser(false);
            }else{
                return false;
            }
        }
    }

    function checkIfTypeExistsInDB($typeName)
    {
        $query = "SELECT `id` FROM `Type` WHERE `name`='$typeName';";
        $result = $this->doQuery($query);

        $SQLdataarray = mysqli_fetch_array($result);
        if(count($SQLdataarray) < 1) {
            return FALSE;
        }
        else {
            return TRUE;
        }
    }
    function insertNewType($typeName)
    {
        $query =
            "INSERT INTO `Type` "
            ."(`name`) "
            ."VALUES "
            ."('$typeName')";
        $this->doQuery($query);
    }

    function getTypeIdByName($typeName) {
        $query = "SELECT `id` FROM `Type` WHERE `name`='$typeName'";
        return mysqli_fetch_array($this->doQuery($query))['id'];
    }

    function getBronzeStarAwardID() {
        $query = "SELECT `id` FROM `Awards` WHERE `name`='bronzeStar'";
        return mysqli_fetch_array($this->doQuery($query))['id'];
    }

    function getSilverStarAwardID() {
        $query = "SELECT `id` FROM `Awards` WHERE `name`='silverStar'";
        return mysqli_fetch_array($this->doQuery($query))['id'];
    }

    function getGoldStarAwardID() {
        $query = "SELECT `id` FROM `Awards` WHERE `name`='goldStar'";
        return mysqli_fetch_array($this->doQuery($query))['id'];
    }

    function getBronzeTrophyAwardID() {
        $query = "SELECT `id` FROM `Awards` WHERE `name`='bronzeTrophy'";
        return mysqli_fetch_array($this->doQuery($query))['id'];
    }

    function getSilverTrophyAwardID() {
        $query = "SELECT `id` FROM `Awards` WHERE `name`='silverTrophy'";
        return mysqli_fetch_array($this->doQuery($query))['id'];
    }

    function getGoldTrophyAwardID() {
        $query = "SELECT `id` FROM `Awards` WHERE `name`='goldTrophy'";
        return mysqli_fetch_array($this->doQuery($query))['id'];
    }

    function getAccountIDByUsername($username)
    {
        $query = "SELECT `account_id` FROM `User` WHERE `username`='$username'";
        return mysqli_fetch_array($this->doQuery($query))['account_id'];
    }

    function getUserIDFromUsername($username)
    {
        $query = "SELECT `id` FROM `User` WHERE `username`='$username';";
        return mysqli_fetch_array($this->doQuery($query))['id'];
    }

    function getImageIDFromUsername($username) {
        $query = "SELECT `id` FROM `Image` WHERE `name`='$username'";
        return mysqli_fetch_array($this->doQuery($query))['id'];
    }

    /*
     * SIGN-UP FUNCTIONS ------------------------------------------------------------
     * */

    function checkIfAccountNameExists($accountName)
    {
        $query = "SELECT `id` FROM `Account` WHERE `name`='$accountName';";
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

    function checkIfPhonenumberExists($phoneNumber)
    {
        $query = "SELECT `id` FROM `User` WHERE `phone_number`='$phoneNumber';";
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

    function createNewAdmin($accountName, $username, $password, $email, $phoneNumber)
    {
        //Register forest in Account DB
        $query =
            "INSERT INTO  `Account` "
                ."(`name`, `password`, `email`, `phone_number`) "
            ."VALUES "
                ."('$accountName', '$password', '$email', '$phoneNumber');";
        $this->doQuery($query);

        //Fetch the corresponding Id for the newly created record
        $query = "SELECT `id` FROM `Account` WHERE `name`='$accountName'";
        $accountID = mysqli_fetch_array($this->doQuery($query))['id'];

        //Fetch the Type.id corresponding to the "Admin" role
        $adminID = $this->getTypeIdByName('Admin');

        //Fetch the default Image.id for the profile picture
        $query = "SELECT `id` FROM `image` WHERE `name`='SYSTEM_DEFAULT'";
        $profilePic_ID = mysqli_fetch_array($this->doQuery($query))['id'];

        //Register a user with Admin status in the forest
        $query =
            "INSERT INTO `User` "
                ."(`account_id`, `username`, `password`, `image_id`, `email`, `phone_number`, `type_id`) "
            ."VALUES "
                ."('$accountID', '$username', '$password', '$profilePic_ID', '$email', '$phoneNumber', '$adminID');";
        $this->doQuery($query);
    }

    function createNewUser($accountID, $username, $password, $email, $phoneNumber)
    {
        //Fetch Default ImageId
        $query = "SELECT `id` FROM `Image` WHERE `name`='SYSTEM_DEFAULT'";
        $imageID = mysqli_fetch_array($this->doQuery($query))['id'];

        //Fetch User Type Id
        $typeID = $this->getTypeIdByName('User');

        //Create User Record in forest
        $query =
            "INSERT INTO `User` "
                ."(`account_id`, `username`, `password`, `image_id`, `email`, `phone_number`, `type_id`) "
            ."VALUES "
            ."('$accountID', '$username', '$password', '$imageID', '$email', '$phoneNumber', '$typeID');";
        $this->doQuery($query);

        //Get the newly created user's corresponding id
        $query = "SELECT `id` FROM `User` WHERE `username`='$username'";
        $userID = mysqli_fetch_array($this->doQuery($query))['id'];

        //Get the id's corresponding to the default awards
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

        $awardIds =
            array(
                $bronzeStarID,
                $silverStarID,
                $goldStarID,
                $bronzeTrophyID,
                $silverTrophyID,
                $goldTrophyID
            );

        foreach ($awardIds as $curAwardId){
            //Create Records for each of the awards available for the user
            $query =
                "INSERT INTO `User_Awards` "
                ."(`award_id`, `user_id`, `quantity`) "
                ."VALUES ($curAwardId, $userID, '0');";
            $this->doQuery($query);
        }

        $defaultCategories =
            array(
                'Homework',
                'Sports',
                'Health',
                'Exercise',
                'Other',
                'Special Tasks'
            );
        foreach ($defaultCategories as $curCategory){
            //Create Records for each of the categories available for the user
            $query =
                "INSERT INTO `Category` "
                ."(`name`,`user_id`) "
                ."VALUES ('$curCategory', '$userID')";
            $this->doQuery($query);
        }

        $userID = $this->getUserIDFromUsername($username);

        $bronzeStarID = $this->getBronzeStarAwardID();
        $silverStarID = $this->getSilverStarAwardID();
        $goldStarID = $this->getGoldStarAwardID();
        $bronzeTrophyID = $this->getBronzeTrophyAwardID();
        $silverTrophyID = $this->getSilverTrophyAwardID();
        $goldTrophyID = $this->getGoldTrophyAwardID();

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

        $query = "INSERT INTO `Date` (`user_id`) VALUES ('$userID')";
        $this ->doQuery($query);
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
        $accountID = $this->getAccountIDByUsername($username);
        $query = "SELECT `verified` FROM `Account` WHERE `id`='$accountID'";
        $verified  = mysqli_fetch_array($this->doQuery($query))['verified'];
        if ($verified > 0){
            return True;
        }
        else{
            return False;
        }
    }


    function getTypeByUsername($username)
    {
        $query = "SELECT `type_id` FROM `User` WHERE `username`='$username'";
        $typeID = mysqli_fetch_array($this->doQuery($query))['type_id'];
        $query = "SELECT `name` FROM `Type` WHERE `id`='$typeID'";
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
        $accountID = $this->getAccountIDByUsername($username);
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
        $accountID = $this->getAccountIDByUsername($username);
        $query = "SELECT `name` FROM `Account` WHERE `id`='$accountID'";
        return mysqli_fetch_array($this->doQuery($query))['name'];
    }

    function getAllUsersByAdminUsername($username) {
        $accountID = $this->getAccountIDByUsername($username);

        $typeID = $this->getTypeIdByName('User');

        $query = "SELECT * FROM `User` WHERE `account_id`='$accountID' AND `type_id`='$typeID'";
        $result = $this->doQuery($query);

        $users = Array();
        while($row = mysqli_fetch_array($result)) {
            $users[$row['id']] = Array("username"=>$row['username'], "total_points"=>$row['total_points']);
        }
        ksort($users);
        return $users;
    }

    function deleteUserByUsername($username) {
        $userID = $this->getUserIDFromUsername($username);

        $query = "DELETE FROM `User_Awards` WHERE `user_id`='$userID'";
        $this->doQuery($query);

        $imageID = $this->getImageIDFromUsername($username);

        $query = "DELETE FROM `Image` WHERE `id`='$imageID'";
        $this->doQuery($query);

        $query = "DELETE FROM `Redeem` WHERE `user_id`='$userID'";
        $this->doQuery($query);

        $query = "DELETE FROM `Date` WHERE `user_id`='$userID'";
        $this->doQuery($query);

        $query = "DELETE FROM `Category` WHERE `user_id`='$userID'";
        $this->doQuery($query);

        $query = "DELETE FROM `Task` WHERE `user_id`='$userID'";
        $this->doQuery($query);

        $query = "DELETE FROM `Template` WHERE `user_id`='$userID'";
        $this->doQuery($query);

        $query = "DELETE FROM `Theme` WHERE `user_id`='$userID'";
        $this->doQuery($query);

        $query = "DELETE FROM `User` WHERE `username`='$username'";
        $this->doQuery($query);
    }

    function getAdminUsernameByAccountID($accountID) {
        $adminTypeID = $this->getTypeIdByName('Admin');

        $query = "SELECT `username` FROM `User` WHERE `account_id`='$accountID' AND `type_id`='$adminTypeID'";
        return mysqli_fetch_array($this->doQuery($query))['username'];
    }

    function getEncodedUsernamesByAccountID($accountID) {
        $userTypeID = $this->getTypeIdByName('User');

        $query = "SELECT `username` FROM `User` WHERE `account_id`='$accountID' AND `type_id`='$userTypeID'";
        $result = $this->doQuery($query);

        $users = Array();
        while($row = mysqli_fetch_array($result)) {

            $curUsername = $row['username'];
            $encryptedUsername = Crypto::encrypt($curUsername, true);

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
        $userID = $this->getUserIDFromUsername($username);
        $awardID = $this->getBronzeStarAwardID();

        $query = "SELECT `quantity` FROM `User_Awards` WHERE `user_id`='$userID' AND `award_id`='$awardID'";
        return mysqli_fetch_array($this->doQuery($query))['quantity'];
    }

    function getNumSilverStarsByUsername($username) {
        $userID = $this->getUserIDFromUsername($username);
        $awardID = $this->getSilverStarAwardID();

        $query = "SELECT `quantity` FROM `User_Awards` WHERE `user_id`='$userID' AND `award_id`='$awardID'";
        return mysqli_fetch_array($this->doQuery($query))['quantity'];
    }

    function getNumGoldStarsByUsername($username) {
        $userID = $this->getUserIDFromUsername($username);
        $awardID = $this->getGoldStarAwardID();

        $query = "SELECT `quantity` FROM `User_Awards` WHERE `user_id`='$userID' AND `award_id`='$awardID'";
        return mysqli_fetch_array($this->doQuery($query))['quantity'];
    }

    function getNumBronzeTrophiesByUsername($username) {
        $userID = $this->getUserIDFromUsername($username);
        $awardID = $this->getBronzeTrophyAwardID();

        $query = "SELECT `quantity` FROM `User_Awards` WHERE `user_id`='$userID' AND `award_id`='$awardID'";
        return mysqli_fetch_array($this->doQuery($query))['quantity'];
    }

    function getNumSilverTrophiesByUsername($username) {
        $userID = $this->getUserIDFromUsername($username);
        $awardID = $this->getSilverTrophyAwardID();

        $query = "SELECT `quantity` FROM `User_Awards` WHERE `user_id`='$userID' AND `award_id`='$awardID'";
        return mysqli_fetch_array($this->doQuery($query))['quantity'];
    }

    function getNumGoldTrophiesByUsername($username) {
        $userID = $this->getUserIDFromUsername($username);
        $awardID = $this->getGoldTrophyAwardID();

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
        $imageID = $this->getImageIDFromUsername($username);

        $query = "SELECT `link` FROM `Image` WHERE `id`='$imageID'";
        return mysqli_fetch_array($this->doQuery($query))['link'];
    }

    function updateProfileImageByUsername($username, $imageSource) {
        $imageID = $this->getImageIDFromUsername($username);

        $query = "UPDATE `Image` SET `link`='$imageSource' WHERE `id`='$imageID'";
        $this->doQuery($query);
    }

    /*
     * Rewards FUNCTIONS ------------------------------------------------------------
     * */

    function getAllRewardsByUsername($username) {
        $userID = $this->getUserIDFromUsername($username);

        $query = "SELECT `id`, `reward`,`points`,`completed`,`redeem_date` FROM `Redeem` WHERE `user_id`='$userID'";
        $result = $this->doQuery($query);

        $users = Array();
        $counter = 0;
        while($row = mysqli_fetch_array($result)) {
            $row['redeem_date'] = substr($row['redeem_date'],5,2) . '/' . substr($row['redeem_date'],8,2) . '/' . substr($row['redeem_date'],0,4);
            $users[$counter] = Array("rewardID"=>$row['id'], "name"=>$row['reward'], "points"=>$row['points'], "completed"=>$row['completed'], "redeem_date"=>$row['redeem_date']);
            $counter += 1;
        }
        return $users;
    }

    function deleteRewardByRewardID($rewardID) {
        $query = "DELETE FROM `Redeem` WHERE `id`='$rewardID'";
        $this->doQuery($query);
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
        $userID = $this->getUserIDFromUsername($username);

        $query = "INSERT INTO `Redeem` (`user_id`,`reward`,`points`) VALUES ('$userID','$rewardName','$points')";
        $this->doQuery($query);
    }

    /*
     * Create Task FUNCTIONS ----------------------------------------------------------
     */

    function createTaskByUsername($username, $taskName, $categoryName, $importance, $startTime, $endTime, $date) {
        $userID = $this->getUserIDFromUsername($username);

        $query = "SELECT `id` FROM `Category` WHERE `name`='$categoryName' AND `user_id`='$userID'";
        $categoryID = mysqli_fetch_array($this->doQuery($query))['id'];

        $query = "SELECT `id` FROM `Priority` WHERE `name`='$importance'";
        $priorityID = mysqli_fetch_array($this->doQuery($query))['id'];

        $query =
            "INSERT INTO `Task` "
                ."(`user_id`, `name`, `category_id`, `priority_id`, `start_time`, `end_time`, `date`) "
            ."VALUES "
                ."('$userID', '$taskName', '$categoryID', '$priorityID', '$startTime', '$endTime', '$date')";
        $this->doQuery($query);
    }

    function getCategoriesByUsername($username) {
        $userID = $this->getUserIDFromUsername($username);

        $query = "SELECT `name`, `id` FROM `Category` WHERE `user_id`='$userID'";
        $result = $this->doQuery($query);

        $categories = Array();
        $counter = 0;
        while($row = mysqli_fetch_array($result)) {
            $categories[$counter] = Array('name'=>$row['name'], 'id'=>$row['id']);
            $counter++;
        }
        return $categories;
    }

    function getCategoryNamesByUsername($username) {
        $userID = $this->getUserIDFromUsername($username);

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
        $userID = $this->getUserIDFromUsername($username);

        $query = "INSERT INTO `Category` (`user_id`, `name`) VALUES ('$userID', '$categoryName')";
        $this->doQuery($query);
    }

    function deleteCategoryByCategoryID($categoryID) {
        $query = "DELETE FROM `Category` WHERE `id`='$categoryID'";
        $this->doQuery($query);
    }

    function deleteTaskByTaskID($taskID){
        $query = "DELETE FROM `Task` WHERE `id`='$taskID'";
        $this->doQuery($query);
    }

    function getPriorityValue($priority_id){
        $query = "SELECT `name` FROM `Priority` WHERE `id` = '$priority_id'";
        return mysqli_fetch_array($this->doQuery($query))['name'];
    }

    function getTaskInfoByCategory($username, $category){
        $userID = $this->getUserIDFromUsername($username);

        $query = "SELECT `date` FROM `Date` WHERE `user_id`='$userID'";
        $currentDate = mysqli_fetch_array($this->doQuery($query))['date'];

        $query = "SELECT `id` FROM `Category` WHERE `name` ='$category' AND `user_id` = '$userID'";
        $categoryID = mysqli_fetch_array($this->doQuery($query))['id'];

        $query = "SELECT `name`, `priority_id`, `start_time`, `end_time`, `date`, `id` "
                    ."FROM `Task`  "
                ."WHERE `category_id` = '$categoryID' "
                    ."AND `user_id` = '$userID' "
                    ."AND `date`='$currentDate'";
        $result = $this->doQuery($query);
        $tasks = Array();
        $counter = 0;
        while($row = mysqli_fetch_array($result)){
            $tasks[$counter] =
                Array(
                    "taskName"=>$row['name'],
                    "date"=>$row['date'],
                    "priority"=>$this->getPriorityValue($row['priority_id']),
                    "startTime"=>$row['start_time'],
                    "endTime"=>$row['end_time'],
                    "id"=>$row['id']
                );
            $counter++;
        }
        return $tasks;
    }

    /*
     * Date FUNCTIONS ------------------------------------------------------------
     * */

    function checkIfDateIsToday($date, $currentDate){
        if ($date == $currentDate)  return true;
        else                        return false;
    }

    function setCurrentDateByUsername($username) {
        $userID = $this->getUserIDFromUsername($username);

        $currentDate = date('Y-m-d');
        $query = "UPDATE `Date` SET `date`='$currentDate' WHERE `user_id`='$userID'";
        $this->doQuery($query);
    }

    function setDateByDate($username, $newDate) {
        $userID = $this->getUserIDFromUsername($username);

        $query = "UPDATE `Date` SET `date`='$newDate' WHERE `user_id`='$userID'";
        $this->doQuery($query);
    }

    function getDateByUsername($username) {
        $userID = $this->getUserIDFromUsername($username);

        $query = "SELECT `date` FROM `Date` WHERE `user_id`='$userID'";
        return mysqli_fetch_array($this->doQuery($query))['date'];
    }

    function getDayByUsername($username) {
        $userID = $this->getUserIDFromUsername($username);

        $query = "SELECT `date` FROM `Date` WHERE `user_id`='$userID'";
        return substr(mysqli_fetch_array($this->doQuery($query))['date'],8,2);
    }

    function incrementDateByUsername($username) {
        $userID = $this->getUserIDFromUsername($username);
        $currentDate = $this->getDateByUsername($username);

        $newDate = date('Y-m-d', strtotime($currentDate . ' +1 day'));
        $query = "UPDATE `Date` SET `date`='$newDate' WHERE `user_id`='$userID'";
        $this->doQuery($query);
    }

    function decrementDateByUsername($username) {
        $userID = $this->getUserIDFromUsername($username);
        $currentDate = $this->getDateByUsername($username);

        $newDate = date('Y-m-d', strtotime($currentDate . ' -1 day'));
        $query = "UPDATE `Date` SET `date`='$newDate' WHERE `user_id`='$userID'";
        $this->doQuery($query);
    }

    /*
     * Week FUNCTIONS ------------------------------------------------------------
     * */

    function getDatesofCurrentWeekByUsername($username) {
        $numDaysInMonth = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
        if($this->isCurrentYearALeapYear($username)) $numDaysInMonth[1] = 29;

        $userID = $this->getUserIDFromUsername($username);

        $currentDate = $this->getDateByUsername($username);
        $currentDay = $this->getDayByUsername($username);
        $currentMonth = $this->getMonthByUsername($username);
        $currentYear = $this->getYearByUsername($username);

        $firstDOTW = $this->getDOTWofFirstDayofCurrentMonth($username);
        $datesOfTheWeek = Array(Array(),Array(),Array());

        if($currentDay > 7-$firstDOTW || $currentDate == 0) {
            $weekStartDate = 1;
            for($i = 1; $i <= $numDaysInMonth[intval($currentMonth)-1]; $i++) {
                if(($i+$firstDOTW-1)%7 == 0) {
                    $weekStartDate = $i;
                }
                if($i == $currentDay) {
                    break;
                }
            }

            $this->setDayOfMonthByUsername($username, $weekStartDate);

            for($i = 0; $i < 7; $i++) {
                $date = $this->getDayByUsername($username);
                $month = $this->getMonthByUsername($username);
                $year = $this->getYearByUsername($username);

                array_push($datesOfTheWeek[0],intval($date));
                array_push($datesOfTheWeek[1],intval($month));
                array_push($datesOfTheWeek[2],intval($year));

                $this->incrementDateByUsername($username);
            }
            for($i = 0; $i < 7; $i++) {
                $this->decrementDateByUsername($username);
            }
        }
        else {
            $this->setDayOfMonthByUsername($username, 1);

            for($i = 1; $i <= 7-$firstDOTW; $i++) {
                array_push($datesOfTheWeek[0], intval($i));
                array_push($datesOfTheWeek[1], intval($currentMonth));
                array_push($datesOfTheWeek[2], intval($currentYear));
            }

            for ($i = 0; $i < $firstDOTW; $i++) {
                $this->decrementDateByUsername($username);

                $date = $this->getDayByUsername($username);
                $month = $this->getMonthByUsername($username);
                $year = $this->getYearByUsername($username);

                array_unshift($datesOfTheWeek[0], intval($date));
                array_unshift($datesOfTheWeek[1], intval($month));
                array_unshift($datesOfTheWeek[2], intval($year));
            }
            for($i = 0; $i < $firstDOTW; $i++) {
                $this->incrementDateByUsername($username);
            }
        }

        $this->setDateByDate($username, $currentDate);

        return $datesOfTheWeek;
    }

    function incrementWeekByUsername($username) {
        $userID = $this->getUserIDFromUsername($username);
        $currentDate = $this->getDateByUsername($username);

        $newDate = date('Y-m-d', strtotime($currentDate . ' +7 day'));
        $query = "UPDATE `Date` SET `date`='$newDate' WHERE `user_id`='$userID'";
        $this->doQuery($query);
    }

    function decrementWeekByUsername($username) {
        $userID = $this->getUserIDFromUsername($username);
        $currentDate = $this->getDateByUsername($username);

        $newDate = date('Y-m-d', strtotime($currentDate . ' -7 day'));
        $query = "UPDATE `Date` SET `date`='$newDate' WHERE `user_id`='$userID'";
        $this->doQuery($query);
    }

    /*
     * Month FUNCTIONS ------------------------------------------------------------
     * */

    function getMonthByUsername($username) {
        $userID = $this->getUserIDFromUsername($username);

        $query = "SELECT `date` FROM `Date` WHERE `user_id`='$userID'";
        return substr(mysqli_fetch_array($this->doQuery($query))['date'],5,2);
    }

    function getYearByUsername($username) {
        $userID = $this->getUserIDFromUsername($username);

        $query = "SELECT `date` FROM `Date` WHERE `user_id`='$userID'";
        return substr(mysqli_fetch_array($this->doQuery($query))['date'],0,4);
    }

    function incrementMonthByUsername($username) {
        $userID = $this->getUserIDFromUsername($username);
        $currentDate = $this->getDateByUsername($username);

        $newDate = date('Y-m-d', strtotime($currentDate . ' +1 month'));
        $query = "UPDATE `Date` SET `date`='$newDate' WHERE `user_id`='$userID'";
        $this->doQuery($query);
    }

    function decrementMonthByUsername($username) {
        $userID = $this->getUserIDFromUsername($username);
        $currentDate = $this->getDateByUsername($username);

        $newDate = date('Y-m-d', strtotime($currentDate . ' -1 month'));
        $query = "UPDATE `Date` SET `date`='$newDate' WHERE `user_id`='$userID'";
        $this->doQuery($query);
    }

    function getDOTWofFirstDayofCurrentMonth($username) {
        $currentDate = $this->getDayByUsername($username);

        $this->setDayOfMonthByUsername($username, 1);
        $dotw = date('w',strtotime($this->getDateByUsername($username)));
        $this->setDayOfMonthByUsername($username, $currentDate);

        return $dotw;
    }

    function isCurrentYearALeapYear($username) {
        $currentDate = $this->getDateByUsername($username);
        return date('L', $currentDate);
    }

    function getNumTasksPerDayOfCurrentMonthByUsername($username) {
        $numDaysInMonth = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
        if($this->isCurrentYearALeapYear($username)) $numDaysInMonth[1] = 29;

        $userID = $this->getUserIDFromUsername($username);
        $currentDate = $this->getDateByUsername($username);

        $currentYear = intval(substr($currentDate,0,4));
        $currentMonth = intval(substr($currentDate,5,2));

        $tasksperDay = Array();
        for($i = 1; $i <= $numDaysInMonth[$currentMonth-1]; $i++) {
            $checkDate = $currentYear;
            if (strlen($checkDate) < 4) $checkDate = "0" . $checkDate;
            $checkDate .= "-".$currentMonth;
            if (strlen($checkDate) < 7) $checkDate = substr($checkDate,0,5) . "0" . substr($checkDate,5);
            $checkDate .= "-".$i;
            if (strlen($checkDate) < 10) $checkDate = substr($checkDate,0,8) . "0" . substr($checkDate,8);

            $query = "SELECT `id` FROM `Task` WHERE `user_id`='$userID' AND `date`='$checkDate'";
            $result = $this->doQuery($query);

            $taskCount = 0;
            while($row = mysqli_fetch_array($result)){
                $taskCount++;
            }
            array_push($tasksperDay,$taskCount);
        }
        return $tasksperDay;
    }

    function setDayOfMonthByUsername($username, $newDayInt) {
        $userID = $this->getUserIDFromUsername($username);

        $currentDate = $this->getDayByUsername($username);
        $difference = $newDayInt - $currentDate;
        $newDate = date('Y-m-d',strtotime($this->getDateByUsername($username) . ' ' . $difference . ' day'));

        $query = "UPDATE `Date` SET `date`='$newDate' WHERE `user_id`='$userID'";
        $this->doQuery($query);
    }

    /*
     * Template FUNCTIONS ------------------------------------------------------------
     * */

    function getAllTemplatesByUsername($username){
        $userID = $this->getUserIDFromUsername($username);

        $query = "SELECT `id`, `task_name`, `category_id`, `priority_id`, `start_time`, `end_time` "
                    ."FROM `Template`  "
                ."WHERE `user_id` = '$userID'";
        $result = $this->doQuery($query);
        $tasks = Array();
        $counter = 0;
        while($row = mysqli_fetch_array($result)){
            $categoryID = $row['category_id'];
            $query = "SELECT `name` FROM `Category` WHERE `id`='$categoryID'";
            $categoryName = mysqli_fetch_array($this->doQuery($query))['name'];
            $tasks[$counter] =
                Array(
                    "templateID"=>$row['id'],
                    "templateName"=>$row['task_name'],
                    "startHour"=>substr($row['start_time'],0,2),
                    "startMin"=>substr($row['start_time'],3,2),
                    "startAMPM"=>substr($row['start_time'],6,2),
                    "endHour"=>substr($row['end_time'], 0, 2),
                    "endMin"=>substr($row['end_time'],3,2),
                    "endAMPM"=>substr($row['end_time'],6,2),
                    "priority"=>$this->getPriorityValue($row['priority_id']),
                    "category"=>$categoryName
                );
            $counter++;
        }
        return $tasks;
    }

    function addTemplateByUsername($username, $taskName, $categoryName, $importance, $startTime, $endTime) {
        $userID = $this->getUserIDFromUsername($username);

        $query = "SELECT `id` FROM `Category` WHERE `name`='$categoryName' AND `user_id`='$userID'";
        $categoryID = mysqli_fetch_array($this->doQuery($query))['id'];

        $query = "SELECT `id` FROM `Priority` WHERE `name`='$importance'";
        $priorityID = mysqli_fetch_array($this->doQuery($query))['id'];

        $query = "INSERT INTO `Template` "
                    ."(`user_id`, `task_name`, `category_id`, `priority_id`, `start_time`, `end_time`) "
                ."VALUES "
                    ."('$userID', '$taskName', '$categoryID', '$priorityID', '$startTime', '$endTime')";
        $this->doQuery($query);
    }

    function deleteTemplateByUsername($username, $templateID) {
        $userID = $this->getUserIDFromUsername($username);

        $query = "DELETE FROM `Template` "
                    ."WHERE `user_id`='$userID' "
                    ."AND `task_name`='$templateID'";
        $this->doQuery($query);
    }

    /*
     * Theme Functions ------------------------------------------------------------
     */

    function setDefaultThemeByUsername($username){
        $userID = $this->getUserIDFromUsername($username);

        $colors = Array("#F9E79F", "#EADA9B", "#DBCD97", "#CBC093", "#BCB38F", "#ADA68B", "#9E9987", "#8F8C83");
        $query = "INSERT INTO `Theme` (`color1`, `color2`, `color3`, `color4`, `color5`, `color6`, `color7`, `color8`, `user_id`) VALUES ('$colors[0]', '$colors[1]', '$colors[2]', '$colors[3]', '$colors[4]', '$colors[5]', '$colors[6]', '$colors[7]', '$userID')";
        $this->doQuery($query);
    }

    function getThemeByUsername($username){
        $userID = $this->getUserIDFromUsername($username);

        $query = "SELECT `color1`, `color2`, `color3`, `color4`, `color5`, `color6`, `color7`, `color8` FROM `Theme` WHERE $userID = `user_id`";
        $result = $this->doQuery($query);
        $colors = Array();
        while($row = mysqli_fetch_array($result)){
            array_push($colors, $row['color1']);
            array_push($colors, $row['color2']);
            array_push($colors, $row['color3']);
            array_push($colors, $row['color4']);
            array_push($colors, $row['color5']);
            array_push($colors, $row['color6']);
            array_push($colors, $row['color7']);
            array_push($colors, $row['color8']);
        }
        return $colors;
    }

}