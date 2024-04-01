<script>
    // get colors array from the string
    function getChartColorsArray(chartId) {
        if (document.getElementById(chartId) !== null) {
            var colors = document.getElementById(chartId).getAttribute("data-colors");
            if (colors) {
                colors = JSON.parse(colors);
                return colors.map(function(value) {
                    var newValue = value.replace(" ", "");
                    if (newValue.indexOf(",") === -1) {
                        var color = getComputedStyle(document.documentElement).getPropertyValue(
                            newValue
                        );
                        if (color) return color;
                        else return newValue;
                    } else {
                        var val = value.split(",");
                        if (val.length == 2) {
                            var rgbaColor = getComputedStyle(
                                document.documentElement
                            ).getPropertyValue(val[0]);
                            rgbaColor = "rgba(" + rgbaColor + "," + val[1] + ")";
                            return rgbaColor;
                        } else {
                            return newValue;
                        }
                    }
                });
            } else {
                console.warn('data-colors Attribute not found on:', chartId);
            }
        }
    }

    var columnChartColors = getChartColorsArray("BarTimeCount");
if (columnChartColors) {
    var options = {
        chart: {
            height: 350,
            type: 'bar',
            toolbar: {
                show: false,
            }
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '45%',
                endingShape: 'rounded'
            },
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            show: true,
            width: 2,
            colors: ['transparent']
        },
        series: [{
            name: 'Time In',
            data: {!! json_encode($timeInCounts) !!}
        }, {
            name: 'Time Out',
            data: {!! json_encode($timeOutCounts) !!}
        }],
        colors: columnChartColors,
        xaxis: {
            categories: {!! json_encode($daysOfWeek) !!}
        },
        yaxis: {
            title: {
                text: 'Count',
                style: {
                    fontWeight: '500',
                },
            }
        },
        grid: {
            borderColor: '#f1f1f1',
        },
        fill: {
            opacity: 1
        },
        tooltip: {
            y: {
                formatter: function (val) {
                    return val + " times";
                }
            }
        }
    };

    var chart = new ApexCharts(
        document.querySelector("#BarTimeCount"),
        options
    );

    chart.render();
}

    var columnChartColors = getChartColorsArray("MonthlyBarTimeCount");
    if (columnChartColors) {
        var options = {
            chart: {
                height: 350,
                type: 'bar',
                toolbar: {
                    show: false,
                }
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '45%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            series: [{
                name: 'Time In',
                data: {!! json_encode($monthlyTimeInCounts) !!}
            }, {
                name: 'Time Out',
                data: {!! json_encode($monthlyTimeOutCounts) !!}
            }],
            colors: columnChartColors,
            xaxis: {
                categories: {!! json_encode($months) !!}
            },
            yaxis: {
                title: {
                    text: 'Count',
                    style: {
                        fontWeight: '500',
                    },
                }
            },
            grid: {
                borderColor: '#f1f1f1',
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return val + " times";
                    }
                }
            }
        };

        var chart = new ApexCharts(
            document.querySelector("#MonthlyBarTimeCount"),
            options
        );

        chart.render();
}
</script>