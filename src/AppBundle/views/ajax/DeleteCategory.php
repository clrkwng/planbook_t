<?php
require_once "../db/dbcomm.php";
require_once "../db/Crypto.php";

//create db connection
$dbcomm = new dbcomm();

if (isset($_POST['deleteCategoryID'])) {
    $categoryID = $_POST['deleteCategoryID'];
    $dbcomm->deleteCategoryByCategoryID($categoryID);
}