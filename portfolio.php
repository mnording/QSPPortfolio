<?php

/**
 * Created by PhpStorm.
 * User: matti
 * Date: 2018-02-22
 * Time: 09:45
 */
class portfolio
{
    private $holdings;
    function __construct()
    {
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
        return $this->holdings();
    }
    function getEarliestDate()
    {
        $date = 99999999999;
        foreach($this->holdings as $holding)
        {
            if($holding["dateAdded"] < $date)
            {
                $date = $holding["dateAdded"];
            }
        }
        return $date;
    }
}