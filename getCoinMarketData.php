<?php

// https://api.coinmarketcap.com/v1/ticker/quantstamp/
include "portfolio.php";
$portfolio = new portfolio();

$earliestDate = $portfolio->getEarliestDate();


