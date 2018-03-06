<?php

/**
 * Created by PhpStorm.
 * User: matti
 * Date: 2018-02-22
 * Time: 09:45
 */
require_once 'database.php';
require 'dbconfig.php';
/***
 * Class portfolio
 */
class portfolio
{
    private $holdings;
    private $dataStorage;
    function __construct()
    {
        global $dbconfig;
        $this->dataStorage = new database($dbconfig);

    }
    function getHoldings()
    {
        return $this->dataStorage->GetHoldings();
    }
    function getEarliestDate()
    {
        $date = "2018-05-01";

        foreach($this->getHoldings() as $holding)
        {

            if($holding->GetDate() <= $date)
            {
                $date = $holding->GetDate();
            }
        }
        return $date;
    }
    function GetDailyPriceData($start,$end)
    {
        return $this->dataStorage->GetDailyPriceData($start,$end, $this->getHoldings());
    }
    function getAllCoins()
    {
        $coins = $this->dataStorage->GetCoins();
        return $coins;
    }
    function GetAmountOfCoin($coinid)
    {
        return $this->dataStorage->GetAmountsOfCertainCoin($coinid);
    }
    function GetLatestValue($coinid)
    {
        return $this->dataStorage->GetLatestValueOfCoin($coinid);
    }

}