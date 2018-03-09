/**
 * Created by matti on 2018-03-07.
 */
var Chart = {
    responsive : {
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
    labelOptions : {
    shape: 'callout',
        align: 'right',
    padding: 5,
    justify: true,
    crop: true,
    style: {
    fontSize: '0.9em',
        textOutline: '1px black',
}
    },
    basic : function(datapoints,categories,labels)
    {
        Highcharts.chart('container', {

            chart: {
                type: 'area',
                zoomType: 'x',
                panning: true,
                panKey: 'shift'
            },

            title: {
                text: 'Quantstamp PoC Portfolio'
            },

            subtitle: {
                text: 'Value of airdropped tokens over time'
            },
            responsive: Chart.responsive,
            annotations: [{
                labelOptions: Chart.labelOptions,
                labels: labels,
                zIndex:10000
            }],

        xAxis: {
            categories:  categories,
            labels: {
                format: '{value}',
                autoRotation: [-45]
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
            data: datapoints,
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
    },
    stacked  : function(coinvalues,categories)
    {
        Highcharts.chart('container', {
            chart: {
                type: 'area',
                zoomType: 'x',
                panning: true,
                panKey: 'shift'
            },
            title: {
                text: 'Quantstamp PoC Portfolio'
            },
            subtitle: {
                text: 'Value of airdropped tokens over time'
            },
            responsive: Chart.responsive,
            annotations: [{
                labelOptions: Chart.labelOptions,
                labels: labels,
                zIndex:10000
            }],
            xAxis: {
                categories: categories,
                title: {
                    enabled: false
                },
                minRange:5
            },
            yAxis: {
                startOnTick: true,
                endOnTick: false,
                maxPadding: 0.35,
                title: {
                    text: 'USD'
                },
                labels: {
                    format: '{value} USD'
                }
            },
            tooltip: {
                split: true,
                valueSuffix: ' USD'
            },
            plotOptions: {
                area: {
                    stacking: 'normal',
                    lineColor: '#666666',
                    lineWidth: 1,
                    marker: {
                        lineWidth: 0,
                        lineColor: '#666666'
                    }
                }
            },
            series: coinvalues
        });
    }
}
