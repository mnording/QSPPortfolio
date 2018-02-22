<?php

// https://api.coinmarketcap.com/v1/ticker/quantstamp/
include "portfolio.php";
$portfolio = new portfolio();

$earliestDate = $portfolio->getEarliestDate();

$today = new time();


//$numDays = abs($earliestDate - $today)/60/60/24;


$checkingDate = $earliestDate;
while($checkingDate < $today)
{
    $datestring = date("YY-MM-DD",$checkingDate);
    foreach($portfolio->getHoldings() as $holding)
    {
        $usdValue = 0;
        if($holding["dateAdded"] < $checkingDate) //Was this holding added to the portfolio at the date we are checking?
        {
            //get history from db

            $query = "SELECT * FROM holdinghistory WHERE dateadded = '$datestring'"; // TODO: Run that query for all coins in holdings
            // $usdValue += $value fromdb
        }
    }
    $holdingDataForChart[] = array(
        "date" => $datestring,
        "value" => $usdValue);

    $checkingDate = $checkingDate + (60*60*24); //adding a full day to the timestamp
}
echo json_encode($holdingDataForChart);

