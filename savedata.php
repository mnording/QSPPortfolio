<?php
/**
 * Created by PhpStorm.
 * User: matti
 * Date: 2018-03-02
 * Time: 15:16
 */
require 'portfolio.php';
require 'pricehandler.php';


$portfolio = new portfolio();
$prices = new pricehandler();

$coins = $portfolio->getAllCoins();
foreach($coins as $coin)
{
    $url = "https://api.coinmarketcap.com/v1/ticker/".$coin->GetTicker()."/";
    // Get cURL resource
    $curl = curl_init();
// Set some options - we are passing in a useragent too here
    curl_setopt_array($curl, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => $url,
        CURLOPT_USERAGENT => 'quantstampnews pricebot'
    ));
// Send the request & save response to $resp
    $resp = curl_exec($curl);
// Close request to clear up some resources
    curl_close($curl);
    $resp = json_decode($resp)[0];

    print_r($resp);
    $currentAmountOfCoin = $portfolio->GetAmountOfCoin($coin->GetId());
    $totalUsdValue = $currentAmountOfCoin * $resp->price_usd;
    echo "we have ".$currentAmountOfCoin." of ".$coin->GetName();
    echo "new price is ".$resp->price_usd;
    $prices->AddHourlyPrice($coin->GetId(),$totalUsdValue);
}