<?php

/**
 * Created by PhpStorm.
 * User: matti
 * Date: 2018-03-02
 * Time: 15:30
 */
require_once 'database.php';
require_once 'dbconfig.php';
class pricehandler
{
    private $dblink;
    public function __construct()
    {
        global $dbconfig;
        $this->dblink = new database($dbconfig);

    }
    public function AddHourlyPrice($coin,$usdvalue)
    {
        //multiply current holdings with USD value
        echo "adding value ".$usdvalue. " to coin ".$coin->GetId();
        $this->dblink->AddHourPriceData($coin,$usdvalue);
    }

}