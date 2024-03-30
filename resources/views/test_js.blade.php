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

// Line chart datalabel
var lineChartDatalabelColors = getChartColorsArray("line_chart_datalabel");
if (lineChartDatalabelColors) {
    var options = {
        chart: {
            height: 380,
            type: 'line',
            zoom: {
                enabled: false
            },
            toolbar: {
                show: false
            }
        },
        colors: lineChartDatalabelColors,
        dataLabels: {
            enabled: false,
        },
        stroke: {
            width: [3, 3],
            curve: 'straight'
        },
        series: [{
            name: "Time In",
            data: {!! json_encode(array_column($processedData, 'time_in_count')) !!}
        },
        {
            name: "Time Out",
            data: {!! json_encode(array_column($processedData, 'time_out_count')) !!}
        }
        ],
        title: {
            text: 'Time In and Time Out Counts Per Hour',
            align: 'left',
            style: {
                fontWeight: '500',
            },
        },
        grid: {
            row: {
                colors: ['transparent', 'transparent'],
                opacity: 0.2
            },
            borderColor: '#f1f1f1'
        },
        markers: {
            style: 'inverted',
            size: 6
        },
        xaxis: {
            categories: [
                @foreach($processedData as $hour => $counts)
                    '{{ $hour % 12 == 0 ? 12 : $hour % 12 }} {{ $hour < 12 ? "AM" : "PM" }}',
                @endforeach
            ],
            title: {
                text: 'Hour'
            }
        },
        yaxis: {
            title: {
                text: 'Count'
            },
            min: 0
        },
        legend: {
            position: 'top',
            horizontalAlign: 'right',
            floating: true,
            offsetY: -25,
            offsetX: -5
        },
        responsive: [{
            breakpoint: 600,
            options: {
                chart: {
                    toolbar: {
                        show: false
                    }
                },
                legend: {
                    show: false
                },
            }
        }]
    };

    var chart = new ApexCharts(
        document.querySelector("#line_chart_datalabel"),
        options
    );

    chart.render();
}


</script>