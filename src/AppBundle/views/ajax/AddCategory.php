<?php
require_once "../db/dbcomm.php";
require_once "../db/Crypto.php";

//create db connection
$dbcomm = new dbcomm();

if (isset($_POST['newCategoryName']) and isset($_POST['newCategoryUsername'])) {
    $username = $_POST['newCategoryUsername'];
    $categoryName = $_POST['newCategoryName'];

    $dbcomm->createNewCategoryByUsername($username, $categoryName);
}