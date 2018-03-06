<?php
/**
 * Created by PhpStorm.
 * User: matti
 * Date: 2018-03-03
 * Time: 16:25
 *  This is being run daily by a schedueler in order to transform hour data into daily averages.
 */

require_once 'portfolio.php';
require_once 'database.php';
require_once 'dbconfig.php';
global $dbconfig;
$datastorage = new database($dbconfig);
$portfolio = new portfolio();

$coins = $portfolio->getAllCoins();
$datastorage->UpdateDaily($coins);

