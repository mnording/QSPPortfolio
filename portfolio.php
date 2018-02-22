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
                "date" => 1519862400 // 1st March 2018
            )
        );
    }
}