<?php

if(!isset($_GET['id'])){
    die("Error: The id was not set.");
}
$username = openssl_decrypt($_GET['id]'],'CAST5-ECB','toMarketPassword');

?>