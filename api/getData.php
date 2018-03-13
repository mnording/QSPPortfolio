<?php
/**
 * Created by PhpStorm.
 * User: matti
 * Date: 2018-03-12
 * Time: 13:21
 */
setlocale(LC_MONETARY, 'en_US');
$datatype = $_GET["type"];
    require '../portfolio.php';
    $portfolio = new portfolio();

$valuesArray = array();

    $chartData = $portfolio->GetDailyPriceData(1519689600,time());
$valuesOnly = array();
foreach($chartData as $point)
{
    $valuesOnly[] = $point["value"];
}
$valuesArray["totals"] = $valuesOnly;


    $startDate = $portfolio->getEarliestDate();
    $addingDate = $startDate;

    $dateArray= array();
    while ($addingDate < date("Y-m-d")) {
        $dateArray[] = $addingDate;
        $addingDate = strtotime("+1 day", strtotime($addingDate));
        $addingDate = date("Y-m-d", $addingDate);
    }
    $valuesArray["dates"] = $dateArray;


    $valuesArray["labels"] = $portfolio->GetDropLabels(1519689600,time());


    $valuesArray["percoin"] = $portfolio->GetDailyPriceDataByCoin(1519689600,time());

    $totalvalue = 0;
$coins = array();
    foreach($portfolio->getAllCoins() as $coin)
    {
        $amount = $portfolio->GetAmountOfCoin($coin->GetId());
        $currentValue = $portfolio->GetLatestValue($coin->GetId());
        $totalvalue += $currentValue;
        $coins[] = array(
            "name" => $coin->GetName(),
            "amount" => number_format($amount),
            "value" => money_format('%i', $currentValue),
            "coinimage" => $coin->GetImageUrl()
        );

    }
$valuesArray["coins"] = $coins;
$valuesArray["currentTotal"] = money_format('%i', $totalvalue);


echo json_encode($valuesArray);



