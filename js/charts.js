/**
 * Created by matti on 2018-03-07.
 */
var Chart = {
    basic : function(datapoints,categories)
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

        xAxis: {
            categories:  categories,
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
                type: 'area'
            },
            title: {
                text: 'Quantstamp PoC Portfolio'
            },
            subtitle: {
                text: 'Value of airdropped tokens over time'
            },
            xAxis: {
                categories: categories,
                tickmarkPlacement: 'off',
                title: {
                    enabled: false
                }
            },
            yAxis: {
                title: {
                    text: 'USD'
                },
                labels: {
                    formatter: function () {
                        return this.value / 1000;
                    }
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
                        lineWidth: 1,
                        lineColor: '#666666'
                    }
                }
            },
            series: coinvalues
        });
    }
}
