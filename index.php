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
$chartData = $portfolio->GetDailyPriceData(1519689600,time());
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
<div class="footer">
    <span>Created by mnording</span><br>
    <span><a href="https://twitter.com/mnording?ref_src=twsrc%5Etfw" class="twitter-follow-button" data-show-count="false">Follow @mnording</a><script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
    </span></br>
   <span>
       <a href="https://github.com/mnording/QSPPortfolio/"><img src="images/GitHub-Mark-32px.png"></a>
   </span> </br>
    <span>Price-data from CoinMarketCap</span>
</div>
</div>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/annotations.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script>
    // Data generated from http://www.bikeforums.net/professional-cycling-fans/1113087-2017-tour-de-france-gpx-tcx-files.html
    var elevationData = [
        <?php foreach($chartData as $datapoint) { echo "[".$datapoint["value"]."],";} ?>
    ] ;

    // Now create the chart
    Highcharts.chart('container', {

        chart: {
            type: 'area',
            zoomType: 'x',
            panning: true,
            panKey: 'shift'
        },

        title: {
            text: 'QSP Portfolio Value'
        },

        subtitle: {
            text: 'Holder Value over time'
        },
        responsive: {
            rules: [{
                condition: {
                    maxWidth: 500
                },
                chartOptions: {
                    legend: {
                        align: 'center',
                        verticalAlign: 'bottom',
                        layout: 'horizontal'
                    },
                    yAxis: {
                        labels: {
                            align: 'left',
                            x: 0,
                            y: -5
                        },
                        title: {
                            text: null
                        }
                    },
                    subtitle: {
                        text: null
                    },
                    credits: {
                        enabled: false
                    }
                }
            }]
        },
        annotations: [{
            labelOptions: {
                shape: 'connector',
                align: 'right',
                justify: false,
                crop: true,
                style: {
                    fontSize: '0.8em',
                    textOutline: '1px white'
                }
            },
            labels: [{
                point: {
                    xAxis: 0,
                    yAxis: 0,
                    x: 0,
                    y: 1155000
                },
                text: 'INSTAR Distrobution'
            }, {
                point: {
                    xAxis: 0,
                    yAxis: 0,
                    x: 0,
                    y: 1155000
                },
                text: 'XNK Distrobution'
            }]
        }],
<?php $startDate = $portfolio->getEarliestDate();
$addingDate = $startDate;

$dateArray= array();
while ($addingDate <= date("Y-m-d")) {
    $dateArray[] = $addingDate;
    $addingDate = strtotime("+1 day", strtotime($addingDate));
    $addingDate = date("Y-m-d",$addingDate);
}?>
        xAxis: {
            categories:  <?php echo json_encode($dateArray); ?>,
            labels: {
                format: '{value}'
            },
            minRange: 5,
            title: {
                text: 'Date'
            }
        },

        yAxis: {
            startOnTick: true,
            endOnTick: false,
            maxPadding: 0.35,
            title: {
                text: null
            },
            labels: {
                format: '{value} USD'
            }
        },

        tooltip: {
            headerFormat: 'Date: {point.x}<br>',
            pointFormat: '{point.y} USD',
            shared: true
        },

        legend: {
            enabled: false
        },

        series: [{
            data: elevationData,
            lineColor: Highcharts.getOptions().colors[1],
            color: Highcharts.getOptions().colors[2],
            fillOpacity: 0.5,
            name: 'Elevation',
            marker: {
                enabled: false
            },
            threshold: null
        }]

    });
</script>
</body>
</html>