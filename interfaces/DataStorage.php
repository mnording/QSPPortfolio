<?php
/**
 * Created by PhpStorm.
 * User: matti
 * Date: 2018-03-01
 * Time: 14:26
 */

namespace interfaces;


interface DataStorage
{

    public function GetDailyDataForCoin();
    public function GetHoldings();

}