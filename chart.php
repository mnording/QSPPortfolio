<?php
/**
 * Created by PhpStorm.
 * User: matti
 * Date: 2018-02-22
 * Time: 09:53
 */
error_reporting(-1);
require 'portfolio.php';

$portfolio = new portfolio();

$chartData = $portfolio->GetDailyPriceData(1519689600,time());
var_dump($chartData);
?>
<style>
    #container {
        max-width: 800px;
        height: 400px;
        margin: 1em auto;
    }
</style>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/annotations.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>

<div id="container" style="height: 400px; min-width: 380px"></div>

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
                    x: 2,
                    y: 228
                },
                text: 'INSTAR Distrobution'
            }, {
                point: {
                    xAxis: 0,
                    yAxis: 0,
                    x: 4,
                    y: 238
                },
                text: 'XNK Distrobution'
            }]
        }],
<?php $startDate = $portfolio->getEarliestDate();
$addingDate = $startDate;
echo $startdate;
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
            headerFormat: 'Date: {point.x:.1f}<br>',
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