<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 8/25/2017
 * Time: 7:09 PM
 */

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

require_once "vendor/autoload.php";

$isDevMode = true;
$config = Setup::createXMLMetadataConfiguration(array(__DIR__."/application/config/xml"), $isDevMode);

$conn = array(
    'dbname' => 'planbook_db1',
    'user' => 'root',
    'password' => 'sysadm',
    'host' => 'localhost',
    'driver' => 'pdo_mysql',
);

// obtaining the entity manager
$entityManager = EntityManager::create($conn, $config);