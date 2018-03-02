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
    public function AddHourPriceData( $coinId,  $hourtimestamp,  $usdvalue);
    public function AddDailyPriceData( $coinId,  $dayTimestamp,  $usdvalue);
    public function GetDailyPriceData( $startTimeStamp,  $endTimestamp, $holdings);

}