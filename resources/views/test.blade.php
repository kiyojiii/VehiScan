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
</head>

<body>
    @foreach($applicants as $a)
    {{ $a->first_name }}
    @endforeach

    @foreach($vehicles as $v)
    {{ $v->plate_number }}
    @endforeach

    @foreach($drivers as $d)
    {{ $d->driver_name }}
    @endforeach

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body border-bottom">
                    <div class="card-body" id="test">
                        <h1 class="text-center text-secondary my-5"> Loading... </h1>
                    </div>
                </div>
            </div><!--end card-->
        </div><!--end col-->
    </div><!--end row-->

<script>
    // fetch all violation ajax request
    fetchTests();

    function fetchTests() {
        $.ajax({
            url: '{{ route('fetchTest') }}',
            method: 'get',
            success: function(response) {
                $("#test").html(response);
                initializeDataTable(); // Initialize DataTables after table is loaded
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                // Handle error here
            }
        });
    }

    // Function to initialize DataTable
    function initializeDataTable() {
        $("table").DataTable({
            order: [0, 'desc'],
            pageLength: 5, // Display only 5 rows per page
            lengthMenu: [5, 25, 50, -1], // Custom length menu options
        });
    }
</script>

</body>

</html>