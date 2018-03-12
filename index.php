<?php
/**
 * Created by PhpStorm.
 * User: matti
 * Date: 2018-02-22
 * Time: 09:53
 */
error_reporting(-1);
setlocale(LC_MONETARY, 'en_US');
require 'portfolio.php';
$portfolio = new portfolio();
?>
<!doctype html>
<html class="no-js" lang="">
<head>
<?php require 'tracking.php'; ?>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Quantstamp Proof of Care Portfolio Tracker</title>
    <meta name="description" content="Follow the value of the proof of care program by Quantstamp!">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
<div class="wrapper">
<div id="container" style="height: 400px;"></div>
    <div class="charttypecontrols">
        <button onclick="BasicChart()"><img src="https://caring.quantstamp.com/assets/quantstamp-logo-blue-abe1f18b6db596d0b2a44cc9a89c39214a6bd3915c0ab77e23adaff70266a59e.svg"> Basic chart</button>
        <button onclick="CoinChart()" style="float:right;">Chart per coin <img src="https://caring.quantstamp.com/assets/quantstamp-logo-blue-abe1f18b6db596d0b2a44cc9a89c39214a6bd3915c0ab77e23adaff70266a59e.svg"></button>
    </div>
<table class="cointable">
    <thead>
    <th></th>
    <th>Coin</th>
    <th>Amount of Coins</th>
    <th>Current Value</th>
    </thead>
    <tbody>
    <?php
    $totalvalue = 0;
    foreach($portfolio->getAllCoins() as $coin)
    {
        $amount = $portfolio->GetAmountOfCoin($coin->GetId());
        $currentValue = $portfolio->GetLatestValue($coin->GetId());
        echo "<tr>";
        echo "<td><img src='".$coin->GetImageUrl()."'></td>";
        echo "<td>".$coin->GetName()."</td>";
        echo "<td>".number_format($amount)."</td>";
        echo "<td>".money_format('%i', $currentValue)."</td>";
        echo "</tr>";
        $totalvalue += $currentValue;
    }
    ?>
    <tr class="summaryrow">
        <td></td>
        <td>Total</td>
        <td></td>
        <td><?php echo money_format('%i', $totalvalue) ?></td>
    </tr>
    </tbody>
</table>
<div class="content">
    <p>The above data is a visualization of the value of tokens that are shared with participants of the Quantstamp Proof-of-Care program.
        Tokens of audited companies are airdropped to participants and the above graph shows the value of the tokens that have been airdropped to this date.</p>
</div>

</div>
<div class="footer">
    <span>Created by mnording</span><br>
    <span><a href="https://twitter.com/mnording?ref_src=twsrc%5Etfw" class="twitter-follow-button" data-show-count="false">Follow @mnording</a><script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
    </span></br>
   <span>
       <a href="https://github.com/mnording/QSPPortfolio/"><img src="images/GitHub-Mark-32px.png"></a>
   </span> </br>
    <span>Price-data from CoinMarketCap</span>
</div>
<script
    src="https://code.jquery.com/jquery-1.12.4.min.js"
    integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ="
    crossorigin="anonymous"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/annotations.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="js/charts.js"></script>
<script> 
    var dates;
    var totals;
    var labels;
    var percoin;
    $.ajax("api/getData.php",{
        success: function(data)
        {

            dates = data.dates;
            totals = data.totals;
            labels = data.labels;
            percoin = data.percoin;
            BasicChart();
        },
        dataType: "json"
    })

    function BasicChart(){
        Chart.basic(totals,dates,labels);
    }
    function CoinChart()
    {
        Chart.stacked(percoin,dates,labels);
    }

</script>
</body>
</html>