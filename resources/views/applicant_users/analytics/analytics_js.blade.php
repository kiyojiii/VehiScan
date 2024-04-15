<script>
    $(document).ready(function() {
        // Fetch all violation ajax request
        fetchAllApplicantTimes();

        function fetchAllApplicantTimes() {
            $.ajax({
                url: '{{ route('fetchAllApplicantTime') }}',
                method: 'get',
                success: function(response) {
                    $("#show_all_applicant_time").html(response);
                    $("table").DataTable({
                        order: [0, 'desc']
                    });
                }
            });
        }
    });
</script>

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


// Define arrays to store categories and series data
var categories = [];
var hours = [];

// Iterate over the time data
@foreach($timeData as $vehicleId => $entries)
    @foreach($entries as $entry)
        categories.push("{{ $entry['date'] }}");
        // Use the hour directly without modification
        var hour = "{{ $entry['hour'] }}";
        hours.push(hour);
    @endforeach
@endforeach

 //  line chart datalabel
 var lineChartdashedColors = getChartColorsArray("time_in_chart");
if (lineChartdashedColors) {
    var options = {
        chart: {
            height: 350,
            type: 'line',
            zoom: {
                enabled: false
            },
            toolbar: {
                show: false,
            }
        },
        colors: lineChartdashedColors,
        dataLabels: {
            enabled: false
        },
        stroke: {
            width: [3, 4, 3],
            curve: 'straight',
            dashArray: [0, 8, 5]
        },
        series: [{
            name: "Time In",
            data: hours
        }],
        markers: {
            size: 0,

            hover: {
                sizeOffset: 6
            }
        },
        xaxis: {
            categories: categories
        },
        tooltip: {
            y: [{
                title: {
                    formatter: function (val) {
                        return val + " (Hr)"
                    }
                }
            }]
        },
        grid: {
            borderColor: '#f1f1f1',
        }
    }

    var chart = new ApexCharts(
        document.querySelector("#time_in_chart"),
        options
    );

    chart.render();
}

// column chart
var columnChartColors = getChartColorsArray("monthly_column");
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
                columnWidth: '50%',
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
            data: {!! json_encode($time_in_data) !!}
        }, {
            name: 'Time Out',
            data: {!! json_encode($time_out_data) !!}
        }],
        title: {
            text: 'Vehicle Count Per Month',
            align: 'left',
            style: {
                fontWeight: '500',
            },
        },
        colors: columnChartColors,
        xaxis: {
            categories: {!! json_encode($categories) !!}
        },
        grid: {
            borderColor: '#f1f1f1',
        },
        fill: {
            opacity: 1

        }
    }

    var chart = new ApexCharts(
        document.querySelector("#monthly_column"),
        options
    );

    chart.render();
}

</script>
