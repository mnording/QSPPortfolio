<?php
/**
 * Created by PhpStorm.
 * User: matti
 * Date: 2018-02-22
 * Time: 09:53
 */

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
        [225],
        [226],
        [228],
        [228],
        [238],
        [239]
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

        xAxis: {
            categories: ['2018-03-01', '2018-03-02', '2018-03-03', '2018-03-04'],
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