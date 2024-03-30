<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>VehiScan | Analytics</title>

    <!-- JQUERY -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

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
                                    <button class="btn btn-primary" id="applyWeekFilter">Filter</button>
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
                                orientation: 'bottom'
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

                                // Set start date to previous Monday
                                startDate.setDate(startDate.getDate() - (startDate.getDay() + 6) % 7);
                                // Set end date to next Sunday
                                endDate.setDate(endDate.getDate() + (7 - endDate.getDay()));

                                // Format the start and end dates
                                var formattedStartDate = startDate.toLocaleDateString('en-US', {
                                    month: 'long',
                                    day: 'numeric',
                                    year: 'numeric'
                                });
                                var formattedEndDate = endDate.toLocaleDateString('en-US', {
                                    month: 'long',
                                    day: 'numeric',
                                    year: 'numeric'
                                });

                                // Redirect to the index route with the selected week dates as query parameters
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
                                orientation: 'bottom'
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
                                    <div id="user_chart" data-colors='["--bs-primary", "--bs-secondary", "--bs-success", "--bs-danger", "--bs-warning", "--bs-info", "--bs-dark"]' class="apex-charts" dir="ltr"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Appointment Ratio</h4>
                                    <div id="appointment_chart" data-colors='["--bs-primary", "--bs-secondary", "--bs-success", "--bs-danger", "--bs-warning", "--bs-info", "--bs-light", "--bs-dark"]' class="apex-charts" dir="ltr"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Role Status Ratio</h4>
                                    <div id="status_chart" data-colors='["--bs-primary", "--bs-secondary", "--bs-success", "--bs-danger", "--bs-warning", "--bs-info", "--bs-light", "--bs-dark"]' class="apex-charts" dir="ltr"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Vehicle Registration Ratio</h4>
                                    <div id="vehicle_status_chart" data-colors='["--bs-primary", "--bs-secondary", "--bs-success", "--bs-danger", "--bs-warning", "--bs-info", "--bs-light", "--bs-dark"]' class="apex-charts" dir="ltr"></div>
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