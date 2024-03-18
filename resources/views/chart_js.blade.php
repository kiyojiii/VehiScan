<!-- apexcharts init -->
<script>
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

    var lineChartdashedColors = getChartColorsArray("line_chart_dashed");
lineChartdashedColors &&
  ((options = {
    chart: {
      height: 380,
      type: "line",
      zoom: { enabled: !1 },
      toolbar: { show: !1 },
    },
    colors: lineChartdashedColors,
    dataLabels: { enabled: !1 },
    stroke: { width: [3, 3, 3], curve: "straight", dashArray: [0, 0, 5] },
    series: [
      {
        name: "Time In",
        data: @json($totalTimePerDay->pluck('total_time_in')),
      },
      {
        name: "Time Out",
        data: @json($totalTimePerDay->pluck('total_time_out')),
      },
      {
        name: "Total Visits",
        data: @json($totalTimePerDay->map(function($day) {
            return $day['total_time_in'] + $day['total_time_out'];
        })),
        },
    ],
    markers: { size: 0, hover: { sizeOffset: 6 } },
    xaxis: {
        categories: @json($totalTimePerDay->pluck('date')->map(function($date) {
            return \Carbon\Carbon::parse($date)->format('d M');
        })),

    },
    tooltip: {
      y: [
        {
          title: {
            formatter: function (e) {
              return e;
            },
          },
        },
        {
          title: {
            formatter: function (e) {
              return e;
            },
          },
        },
        {
          title: {
            formatter: function (e) {
              return e;
            },
          },
        },
      ],
    },
    grid: { borderColor: "#f1f1f1" },
  }),
  (chart = new ApexCharts(
    document.querySelector("#line_chart_dashed"),
    options
  )).render());

  var series = @json($appointments->pluck('applicants_count')->toArray());

  var options,
    chart,
    pieChartColors = getChartColorsArray("pie_chart");

    pieChartColors && ((options = {
    chart: { height: 320, type: "pie" },
    labels: ["Vehicles", "Owners", "Drivers"],
    series: @json($series),
    colors: pieChartColors,
    legend: {
        show: !0,
        position: "bottom",
        horizontalAlign: "center",
        verticalAlign: "middle",
        floating: !1,
        fontSize: "14px",
        offsetX: 0,
    },
    responsive: [{
        breakpoint: 600,
        options: { chart: { height: 240 }, legend: { show: !1 } },
    }, ],
}), (chart = new ApexCharts(
    document.querySelector("#pie_chart"),
    options
)));

chart.render();
</script>