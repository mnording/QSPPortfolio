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

    public function GetHoldings();
    public function AddHourPriceData( $coinId,   $usdvalue);
    public function AddDailyPriceData( $coinId,   $usdvalue,$day);
    public function GetDailyPriceData( $startTimeStamp,  $endTimestamp);
    public function GetCoins();
    public function GetAmountsOfCertainCoin($coinid);



}