<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>VehiScan | Applicant </title>

    <!-- Include Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- apexcharts -->
    <script src="<?php echo url('theme') ?>/dist/assets/libs/apexcharts/apexcharts.min.js"></script>
</head>

<body>
  
    <!-- Loader -->
    <div id="preloader">
        <div id="status">
            <div class="spinner-chase">
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
            </div>
        </div>
    </div>
    
    @extends('layouts.app2')

    @section('content')
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Analytics</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item active">Analytics</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->

                @forelse($owners as $owners)

                <div class="row">
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Total Hours Per Day</h4>

                                <div id="line_chart_datalabel" data-colors='["--bs-primary", "--bs-success"]' class="apex-charts" dir="ltr"></div>
                            </div>
                        </div><!--end card-->
                    </div>

                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Time Count Per Month</h4>

                                <div id="column_chart" data-colors='["--bs-success", "--bs-danger"]' class="apex-charts" dir="ltr"></div>
                            </div>
                        </div><!--end card-->
                    </div>
                </div>
                <!-- end row -->

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

var lineChartDatalabelColors = getChartColorsArray("line_chart_datalabel");
lineChartDatalabelColors && (
  options = {
    chart: {
      height: 380,
      type: "line",
      zoom: { enabled: false },
      toolbar: { show: false },
    },
    colors: lineChartDatalabelColors,
    dataLabels: { enabled: false },
    stroke: { width: [3, 3], curve: "straight" },
    series: [
      { name: "Total Hours:", data: {!! json_encode($differences) !!} },
    ],
    grid: {
      row: { colors: ["transparent", "transparent"], opacity: 0.2 },
      borderColor: "#f1f1f1",
    },
    markers: { style: "inverted", size: 6 },
    xaxis: {
    categories: {!! json_encode($formattedDates) !!},
    title: { text: "Date" },
    },
    yaxis: { title: { text: "Hours (Hrs)" } },
    legend: {
      position: "top",
      horizontalAlign: "right",
      floating: true,
      offsetY: -25,
      offsetX: -5,
    },
    responsive: [
      {
        breakpoint: 600,
        options: { chart: { toolbar: { show: false } }, legend: { show: false } },
      },
    ],
  },
  chart = new ApexCharts(document.querySelector("#line_chart_datalabel"), options),
  chart.render()
);


var columnChartColors = getChartColorsArray("column_chart");
if (columnChartColors) {
  var options = {
    chart: { height: 350, type: "bar", toolbar: { show: false } },
    plotOptions: {
      bar: { horizontal: false, columnWidth: "45%", endingShape: "rounded" },
    },
    dataLabels: { enabled: false },
    stroke: { show: true, width: 2, colors: ["transparent"] },
    series: [
      { name: "Time In", data: [{{ $timeInData }}] },
      { name: "Time Out", data: [{{ $timeOutData }}] },
    ],
    colors: columnChartColors,
    xaxis: { categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'] },
    yaxis: { title: { text: "Count" }, min: 5, max: 40 },
    grid: { borderColor: "#f1f1f1" },
    fill: { opacity: 1 },
  };
  
  var chart = new ApexCharts(document.querySelector("#column_chart"), options);
  chart.render();
}


</script>

                
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body border-bottom">

                                <div class="card-body" id="show_all_applicant_time">
                                    <h1 class="text-center text-secondary my-5"> Loading... </h1>
                                </div>

                            </div>

                        </div><!--end card-->
                    </div><!--end col-->

                </div><!--end row-->

                @empty
                    <h1 class="text-center text-danger my-5"><i class="bx bx-error"></i> You Have Not Applied Yet </h1>
                    <div class="text-center">
                        <a href="{{ route('applicant_users.applicant_apply') }}" class="btn btn-primary">
                            Apply Now
                        </a>
                    </div>
                @endforelse

            </div> <!-- container-fluid -->
        </div><!-- End Page-content -->

    </div>
    <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    @include('applicant_users.analytics.analytics_js')

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

</body>

</html>
@endsection