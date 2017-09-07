<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 8/25/2017
 * Time: 7:14 PM
 */
use Doctrine\ORM\Tools\Console\ConsoleRunner;

// replace with file to your own project bootstrap
require_once 'bootstrap.php';

return ConsoleRunner::createHelperSet($entityManager); //$entityManager inherited from bootstrap.php
