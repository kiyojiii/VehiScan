<!DOCTYPE html>
<html>

<head>
    <title>Scratch Blade</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!-- App favicon -->
    <link rel="shortcut icon" href="<?php echo url('theme') ?>/dist/assets/images/favicon.ico">

    <!-- Bootstrap Css -->
    <link href="<?php echo url('theme') ?>/dist/assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="<?php echo url('theme') ?>/dist/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="<?php echo url('theme') ?>/dist/assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    <!-- App js -->
    <script src="<?php echo url('theme') ?>/dist/assets/js/plugin.js"></script>

</head>

<body>

MARCH {{$totalTimeCurrentMonth}}
FEBRUARY {{$totalTimePreviousMonth}}
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Date</th>
                <th>Total Time In</th>
                <th>Total Time Out</th>
                <th>Total Time</th>
            </tr>
        </thead>
        <tbody>
            @foreach($totalTimePerDay as $record)
            <tr>
                <td>{{ $record->date }}</td>
                <td>{{ $record->total_time_in }}</td>
                <td>{{ $record->total_time_out }}</td>
                <td>{{ $record->total_time_in + $record->total_time_out }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="col-xl-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Column Chart</h4>

                <div id="column_chart" data-colors='["--bs-success", "--bs-danger", "--bs-info"]' class="apex-charts" dir="ltr"></div>
            </div>
        </div>
    </div>
    
<div class="col-xl-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Line Chart</h4>

                <div id="line_chart_dashed" data-colors='["--bs-success", "--bs-danger", "--bs-info"]' class="apex-charts" dir="ltr"></div>
            </div>
        </div>
    </div>

    <div class="col-xl-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Pie Chart</h4>

                <div id="pie_chart" data-colors='["--bs-success", "--bs-primary", "--bs-danger", "--bs-info", "--bs-warning", "--bs-secondary", "--bs-dark"]' class="apex-charts" dir="ltr"></div>
            </div>
        </div>
    </div>


</body>

<!-- JAVASCRIPT -->
<script src="<?php echo url('theme') ?>/dist/assets/libs/jquery/jquery.min.js"></script>
<!-- apexcharts -->
<script src="<?php echo url('theme') ?>/dist/assets/libs/apexcharts/apexcharts.min.js"></script>

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

    var columnChartColors = getChartColorsArray("column_chart");
columnChartColors &&
  ((options = {
    chart: { height: 350, type: "bar", toolbar: { show: !1 } },
    plotOptions: {
      bar: { horizontal: !1, columnWidth: "45%", endingShape: "rounded" },
    },
    dataLabels: { enabled: !1 },
    stroke: { show: !0, width: 2, colors: ["transparent"] },
    series: [
      { name: "Net Profit", data: [46, 57, 59, 54, 62, 58, 64, 60, 66] },
      { name: "Revenue", data: [74, 83, 102, 97, 86, 106, 93, 114, 94] },
      { name: "Free Cash Flow", data: [37, 42, 38, 26, 47, 50, 54, 55, 43] },
    ],
    colors: columnChartColors,
    xaxis: {
      categories: [
        "Feb",
        "Mar",
        "Apr",
        "May",
        "Jun",
        "Jul",
        "Aug",
        "Sep",
        "Oct",
      ],
    },
    yaxis: { title: { text: "$ (thousands)", style: { fontWeight: "500" } } },
    grid: { borderColor: "#f1f1f1" },
    fill: { opacity: 1 },
    tooltip: {
      y: {
        formatter: function (e) {
          return "$ " + e + " thousands";
        },
      },
    },
  }),
  (chart = new ApexCharts(
    document.querySelector("#column_chart"),
    options
  )).render());

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
    title: {
      text: "Vehicle Record Per Day",
      align: "left",
      style: { fontWeight: "500" },
    },
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

    var labels = @json($appointments->pluck('appointment')->toArray());
    var series = @json($appointments->pluck('applicants_count')->toArray());

var options,
    chart,
    pieChartColors = getChartColorsArray("pie_chart");

    pieChartColors && ((options = {
    chart: { height: 320, type: "pie" },
    labels: labels,
    series: series,
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


</html>