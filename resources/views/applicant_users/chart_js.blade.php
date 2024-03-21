<script>
    function getChartColorsArray(e) {
  if (null !== document.getElementById(e)) {
    var t = document.getElementById(e).getAttribute("data-colors");
    if (t)
      return (t = JSON.parse(t)).map(function (e) {
        var t = e.replace(" ", "");
        if (-1 === t.indexOf(",")) {
          var r = getComputedStyle(document.documentElement).getPropertyValue(
            t
          );
          return r || t;
        }
        var o = e.split(",");
        return 2 != o.length
          ? t
          : "rgba(" +
              getComputedStyle(document.documentElement).getPropertyValue(
                o[0]
              ) +
              "," +
              o[1] +
              ")";
      });
    console.warn("data-colors Attribute not found on:", e);
  }
}

function getChartColorsArray(e) {
        if (null !== document.getElementById(e)) {
            var t = document.getElementById(e).getAttribute("data-colors");
            if (t)
                return (t = JSON.parse(t)).map(function(e) {
                    var t = e.replace(" ", "");
                    if (-1 === t.indexOf(",")) {
                        var r = getComputedStyle(document.documentElement).getPropertyValue(
                            t
                        );
                        return r || t;
                    }
                    var o = e.split(",");
                    return 2 != o.length ?
                        t :
                        "rgba(" +
                        getComputedStyle(document.documentElement).getPropertyValue(
                            o[0]
                        ) +
                        "," +
                        o[1] +
                        ")";
                });
            console.warn("data-colors Attribute not found on:", e);
        }
    }

    // column chart
    var columnChartColors = getChartColorsArray("user_column_chart");
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
                data: {!! json_encode($timeInData) !!},
            }, {
                name: 'Time Out',
                data: {!! json_encode($timeOutData) !!},
            }],
            colors: columnChartColors,
            xaxis: {
              title: {
                    text: 'Days',
                    style: {
                        fontWeight: '500',
                    },
                },
                categories: {!! json_encode($dates) !!},
            },
            yaxis: {
                title: {
                    text: 'Time Frequency',
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
            }
        }

        var chart = new ApexCharts(
            document.querySelector("#user_column_chart"),
            options
        );

        chart.render();
    }
</script>