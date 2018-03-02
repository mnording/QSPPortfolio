<?php

/**
 * Created by PhpStorm.
 * User: matti
 * Date: 2018-02-22
 * Time: 09:45
 */
require 'database.php';

/***
 * Class portfolio
 */
class portfolio
{
    private $holdings;
    private $dataStorage;
    function __construct()
    {
        $this->dataStorage = new database();
        $this->holdings = array(
            array(
                "id" => "INSTAR",
                "name" =>"Insights Network",
                "quantity" => 1500000,
                "dateAdded" => 1519862400, // 1st March 2018
                "UsdIcoCost" => 0.17
            ),
            array(
                "id"=>"XNK",
                "name"=>"Ink Protocol",
                "quantity"=> 200,
                "dateAdded"=> 1519776000, // 28 Feb 2018
                "UsdIcoCost"=> 0.13
            )
        );
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

            if($holding["dateAdded"] <= $date)
            {
                $date = $holding["dateAdded"];
            }
        }
        return $date;
    }
    function GetDailyPriceData($start,$end)
    {
        return $this->dataStorage->GetDailyPriceData($start,$end, $this->getHoldings());
    }
}