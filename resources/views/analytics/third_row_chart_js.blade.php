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
var lineChartDatalabelColors = getChartColorsArray("third_line_chart_datalabel");
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
            data: {!! json_encode(array_column($third_processedData, 'time_in_count')) !!}
        },
        {
            name: "Time Out",
            data: {!! json_encode(array_column($third_processedData, 'time_out_count')) !!}
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
                @foreach($third_processedData as $hour => $counts)
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
        document.querySelector("#third_line_chart_datalabel"),
        options
    );

    chart.render();
}

// Initialize arrays to hold chart data
var categories = [];
var maxTimeInData = [];
var maxTimeOutData = [];

@foreach($third_weeklyProcessedData as $data)
    categories.push("{{ \Carbon\Carbon::parse($data['date'])->format('M d') }}");
    maxTimeInData.push({{ $data['max_time_in_hour'] ?? 0 }});
    maxTimeOutData.push({{ $data['max_time_out_hour'] ?? 0 }});
@endforeach

// Create the chart options
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
    colors: ['#3a87ad', '#e25e4d'],
    series: [{
        name: "Time (Hour)",
        data: maxTimeInData
    }],
    xaxis: {
        categories: categories
    },
    yaxis: {
    labels: {
        formatter: function (val) {
            if (val === 0) {
                return "12 AM";
            } else if (val < 12) {
                return val.toFixed(0) + " AM";
            } else if (val === 12) {
                return "12 PM";
            } else {
                return (val - 12).toFixed(0) + " PM";
            }
        }
    },
    max: 23, // Limit maximum to 11 PM
    tickAmount: 12 // Set the number of ticks to display
},
    title: {
        text: 'Hour with the most Time In and Time Out Count',
        align: 'left',
        style: {
            fontWeight: '500'
        }
    },
    markers: {
        size: 0,
        hover: {
            sizeOffset: 6
        }
    },
    grid: {
        borderColor: '#f1f1f1'
    }
};

// Create the chart
var chart = new ApexCharts(document.querySelector("#third_line_chart_dashed"), options);
chart.render();

</script>