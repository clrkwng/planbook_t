<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 8/25/2017
 * Time: 7:09 PM
 */

require_once "vendor/autoload.php";

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

$paths = array("src/AppBundle/Entity/");
$isDevMode = false;

// the connection configuration
$dbParams = array(
    'driver'   => 'pdo_mysql',
    'user'     => 'root',
    'password' => 'sysadm',
    'dbname'   => 'planbook_db',
);

$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
$entityManager = EntityManager::create($dbParams, $config);
