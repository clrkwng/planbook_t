<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 8/25/2017
 * Time: 7:09 PM
 */

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

$loader = require_once "vendor/autoload.php";

$isDevMode = true;
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/src/AppBundle"), $isDevMode);

$conn = array(
    'dbname' => 'planbook_db',
    'user' => 'root',
    'password' => 'sysadm',
    'host' => 'localhost',
    'driver' => 'pdo_mysql',
);

// obtaining the entity manager
$entityManager = EntityManager::create($conn, $config);

Doctrine\Common\Annotations\AnnotationRegistry::registerLoader(array($loader, 'loadClass'));
