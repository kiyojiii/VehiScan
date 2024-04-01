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
    <!-- apexcharts -->
    <script src="<?php echo url('theme') ?>/dist/assets/libs/apexcharts/apexcharts.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- Include DataTables JS -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.6/js/jquery.dataTables.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.6/css/jquery.dataTables.css">
    <!-- Include DataTables library -->
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <!-- Include DataTables Bootstrap 4 integration -->
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>

    <!-- Include Bootstrap Datepicker CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">

    <!-- Include Bootstrap Datepicker JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- Include SweetAlert library -->

    <!-- Include moment.js library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

</head>

<body>
<div class="col-xl-6">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title mb-4" id="chartTitle">Line with Data Labels {{ $third_date }}</h4>
            <div class="input-group mb-3">
                <input type="text" class="form-control" id="datePicker" placeholder="Select Date">
                <button class="btn btn-outline-secondary" type="button" id="applyDateFilter">Filter</button>
            </div>
            <div id="third_line_chart_datalabel" data-colors='["--bs-success", "--bs-danger"]' class="apex-charts" dir="ltr"></div>
        </div>
    </div><!--end card-->
</div>


    <script>
        $(document).ready(function() {
    // Initialize datepicker
    $('#datePicker').datepicker({
        format: 'yyyy-mm-dd', // Date format
        autoclose: true, // Close the datepicker when date is selected
        todayHighlight: true // Highlight today's date
    });

    // Apply date filter on button click
    $('#applyDateFilter').click(function() {
        var selectedDate = $('#datePicker').val();

        // Perform action with selectedDate, e.g., update chart data
        // You may use AJAX to fetch new data based on the selected date and update the chart accordingly
        // For simplicity, I'll just redirect to the same page with the selected date as query parameter
        window.location.href = '{{ route("test") }}?date=' + selectedDate;
    });
});
    </script>
<div class="col-xl-6">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title mb-4">Dashed Line {{ $third_startDate }} - {{ $third_endDate}} </h4>

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
            window.location.href = "{{ route('test') }}?start_date=" + previousMonday.toISOString().slice(0, 10) + "&end_date=" + followingSunday.toISOString().slice(0, 10);
        });
    });
</script>

    @include('test_js')

</html>