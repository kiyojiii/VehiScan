<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MVIS | Analytics</title>

    <link rel="icon" href="{{ asset('images/seal.png') }}" type="image/x-icon">

    <!-- JQUERY -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!-- App favicon -->
    <link rel="icon" href="{{ asset('images/seal.png') }}" type="image/x-icon">

    <!-- Bootstrap Css -->
    <link href="<?php echo url('theme') ?>/dist/assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="<?php echo url('theme') ?>/dist/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="<?php echo url('theme') ?>/dist/assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    <!-- App js -->
    <script src="<?php echo url('theme') ?>/dist/assets/js/plugin.js"></script>
    <!-- apexcharts -->
    <script src="<?php echo url('theme') ?>/dist/assets/libs/apexcharts/apexcharts.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- Include SweetAlert library -->
</head>

<body>

    <!-- Add this style to adjust z-index -->
    <style>
        .select2-container--open {
            z-index: 1600 !important;
            /* Adjust the z-index as needed */
        }
    </style>

    @extends('layouts.app')

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
                            <h4 id="digitalClock" class="clock"></h4>
                            @include('clock_js')
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item active"><a href="javascript: void(0);">All Charts</a></li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->


                <div class="row">
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Weekly Time Count [{{ $formattedStartDate }} - {{ $formattedEndDate }}] </h4>
                                <div class="input-group mb-2">
                                    <input type="text" id="weekPicker" class="form-control" placeholder="Select Week">
                                    <button class="btn btn-primary" id="applyWeekFilter">Filter</button> &nbsp;&nbsp;&nbsp;&nbsp;
                                </div>
                                <div id="BarTimeCount" data-colors='["--bs-success", "--bs-danger"]' class="apex-charts" dir="ltr"></div>
                            </div>
                        </div><!--end card-->
                    </div>

                    <script>
                        $(document).ready(function() {
                            // Initialize date picker
                            $('#weekPicker').datepicker({
                                format: 'yyyy-mm-dd',
                                autoclose: true,
                                orientation: 'bottom',
                                todayHighlight: true, // Highlight today's date
                            });

                            // Today button click event
                            $('#todayButton').click(function() {
                                // Get today's date
                                var today = new Date();
                                var formattedToday = today.getFullYear() + '-' + ('0' + (today.getMonth() + 1)).slice(-2) + '-' + ('0' + today.getDate()).slice(-2);

                                // Set today's date in the date picker
                                $('#weekPicker').datepicker('update', formattedToday);
                            });

                            // Apply filter when 'Apply' button is clicked
                            $('#applyWeekFilter').click(function() {
                                var selectedDate = $('#weekPicker').datepicker('getDate');

                                // Check if a date is selected
                                if (selectedDate === null) {
                                    // If no date is chosen, show SweetAlert message
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'No Date Chosen',
                                        text: 'Please choose a date before filtering.',
                                    });
                                    return;
                                }

                                var startDate = new Date(selectedDate);
                                var endDate = new Date(selectedDate);

                                // Calculate the previous Monday
                                startDate.setDate(startDate.getDate() - (startDate.getDay() + 6) % 7 + 1);
                                // Calculate the following Sunday
                                endDate.setDate(startDate.getDate() + 6);

                                // Redirect to the index route with the adjusted start and end dates as query parameters
                                window.location.href = "{{ route('analytics') }}?start_date=" + startDate.toISOString().slice(0, 10) + "&end_date=" + endDate.toISOString().slice(0, 10);
                            });
                        });
                    </script>

                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Monthly Time Count Year: [<span id="currentYear">{{ $currentYear }}</span>] </h4>
                                <div class="input-group">
                                    <input type="text" id="yearPicker" class="form-control" placeholder="Select Year">
                                    <button class="btn btn-primary" id="applyYearFilter">Filter</button>
                                </div>
                                <div id="MonthlyBarTimeCount" data-colors='["--bs-success", "--bs-danger"]' class="apex-charts" dir="ltr"></div>
                            </div>
                        </div><!--end card-->
                    </div>

                    <script>
                        $(document).ready(function() {
                            // Initialize date picker for the year input field
                            $('#yearPicker').datepicker({
                                format: 'yyyy',
                                viewMode: 'years',
                                minViewMode: 'years',
                                autoclose: true,
                                orientation: 'bottom',
                                todayHighlight: true, // Highlight today's date
                            });

                            // Apply filter when 'Filter' button is clicked
                            $('#applyYearFilter').click(function() {
                                var selectedYear = $('#yearPicker').val();

                                // Check if a year is selected
                                if (selectedYear === '') {
                                    // If no year is chosen, show SweetAlert message
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'No Year Chosen',
                                        text: 'Please choose a year before filtering.'
                                    });
                                    return;
                                }

                                // Redirect to the index route with the selected year as query parameter
                                window.location.href = "{{ route('analytics') }}?year=" + selectedYear;
                            });

                            // Adjust currentYear if year is filtered
                            var urlParams = new URLSearchParams(window.location.search);
                            var filteredYear = urlParams.get('year');
                            if (filteredYear) {
                                $('#currentYear').text(filteredYear);
                            }
                        });
                    </script>
                </div>
                <!-- end row -->

                @include('analytics.second_row_chart_js')

                <div class="row">

                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-body">
                            <h4 class="card-title mb-4">Hourly Time Record [{{ \Carbon\Carbon::parse($third_date)->format('l, F j, Y') }}]</h4>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" id="hourlydatePicker" placeholder="Select Date">
                                    <button class="btn btn-primary" type="button" id="applyDateFilter">Filter</button> &nbsp;&nbsp;&nbsp;&nbsp;
                                </div>
                                <div id="third_line_chart_datalabel" data-colors='["--bs-success", "--bs-danger"]' class="apex-charts" dir="ltr"></div>
                            </div>
                        </div><!--end card-->
                    </div>

                    <script>
                        $(document).ready(function() {
                            // Initialize datepicker
                            $('#hourlydatePicker').datepicker({
                                format: 'yyyy-mm-dd', // Date format
                                autoclose: true, // Close the datepicker when date is selected
                                todayHighlight: true, // Highlight today's date
                                orientation: 'bottom'
                            });

                            // Apply date filter on button click
                            $('#applyDateFilter').click(function() {
                                var selectedDate = $('#hourlydatePicker').val();

                                // Perform action with selectedDate, e.g., update chart data
                                // You may use AJAX to fetch new data based on the selected date and update the chart accordingly
                                // For simplicity, I'll just redirect to the same page with the selected date as query parameter
                                window.location.href = '{{ route("analytics") }}?date=' + selectedDate;
                            });
                        });
                    </script>

                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Weekly Peak Hours [{{ \Carbon\Carbon::parse($third_startDate)->format('F j, Y') }} - {{ \Carbon\Carbon::parse($third_endDate)->format('F j, Y') }}] </h4>

                                <!-- Weekly date picker -->
                                <div class="input-group mb-2">
                                    <input type="text" id="weekStartDatePicker" class="form-control" placeholder="Select Week Start Date">
                                    <button class="btn btn-primary" id="applyWeekStartDateFilter">Apply</button>
                                </div>

                                <div id="third_line_chart_dashed" data-colors='["--bs-primary", "--bs-danger", "--bs-success"]' class="apex-charts" dir="ltr"></div>
                            </div>
                        </div><!--end card-->
                    </div>

                    <script>
                        $(document).ready(function() {
                            // Initialize date picker for selecting the week start date
                            $('#weekStartDatePicker').datepicker({
                                format: 'yyyy-mm-dd',
                                autoclose: true,
                                todayHighlight: true, // Highlight today's date
                                orientation: 'bottom'
                            });

                            // Apply filter when 'Apply' button for week start date is clicked
                            $('#applyWeekStartDateFilter').click(function() {
                                var selectedStartDate = $('#weekStartDatePicker').datepicker('getDate');

                                // Check if a date is selected
                                if (selectedStartDate === null) {
                                    // If no date is chosen, show SweetAlert message
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'No Date Chosen',
                                        text: 'Please choose a date before filtering.',
                                    });
                                    return;
                                }

                                // Calculate the previous Monday
                                var previousMonday = new Date(selectedStartDate);
                                previousMonday.setDate(previousMonday.getDate() - (previousMonday.getDay() + 6) % 7 + 1);
                                // Calculate the following Sunday
                                var followingSunday = new Date(previousMonday);
                                followingSunday.setDate(followingSunday.getDate() + 6);

                                // Redirect to the index route with the adjusted start and end dates as query parameters
                                window.location.href = "{{ route('analytics') }}?start_date=" + previousMonday.toISOString().slice(0, 10) + "&end_date=" + followingSunday.toISOString().slice(0, 10);
                            });
                        });
                    </script>

                    @include('analytics.third_row_chart_js')

                    <button id="toggleCharts" class="btn btn-primary">Show Other Charts</button>

                    <script>
                        $(document).ready(function() {
                            $('#toggleCharts').click(function() {
                                $('#chartRow').toggle();
                            });
                        });
                    </script>
                    <div id="chartRow" style="display: none;">
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">User Ratio</h4>
                                        <div id="user_chart" data-colors='["--bs-primary", "--bs-secondary", "--bs-success", "--bs-danger", "--bs-warning", "--bs-info", "--bs-purple", "--bs-dark", "--bs-pink", "--bs-cyan", "--bs-teal", "--bs-orange"]' class="apex-charts" dir="ltr"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">Vehicle Registration Ratio</h4>
                                        <div id="vehicle_status_chart" data-colors='["--bs-primary", "--bs-secondary", "--bs-success", "--bs-danger", "--bs-warning", "--bs-info", "--bs-purple", "--bs-dark", "--bs-pink", "--bs-cyan", "--bs-teal", "--bs-orange"]' class="apex-charts" dir="ltr"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xl-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">Role Status Ratio</h4>
                                        <div id="status_chart" data-colors='["--bs-primary", "--bs-secondary", "--bs-success", "--bs-danger", "--bs-warning", "--bs-info", "--bs-purple", "--bs-dark", "--bs-pink", "--bs-cyan", "--bs-teal", "--bs-orange"]' class="apex-charts" dir="ltr"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">Appointment Ratio</h4>
                                
                                        <div id="appointment_chart" data-colors='["--bs-primary", "--bs-secondary", "--bs-success", "--bs-danger", "--bs-warning", "--bs-info", "--bs-purple", "--bs-dark", "--bs-pink", "--bs-cyan", "--bs-teal", "--bs-orange"]' class="apex-charts" dir="ltr"></div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @include('analytics.first_row_chart_js')


                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>



</body>

</html>
@endsection