<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>VehiScan | Vehicle</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body>

    <style>
        .wrapper {
            width: 100%;
            /* Adjust width as needed */
            padding: 0;
            /* Remove padding */
            height: auto;
            /* Auto height */
        }
    </style>

    <style>
        /* Customize the Toastr message color */
        .toastr-success {
            background-color: #5cb85c !important; /* Green color */
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
                            <h4 class="mb-sm-0 font-size-18">Record Vehicle Time</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Time</a></li>
                                    <li class="breadcrumb-item active">Record Vehicle Time</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->

                @if(auth()->check())
                <p>Authenticated User ID: {{ auth()->id() }}</p>
                @else
                <p>User not authenticated</p>
                @endif            


                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body border-bottom">
                                <div class="d-flex align-items-center">
                                    <h5 class="mb-0 card-title flex-grow-1">Record Vehicle Time</h5>
                                    <!-- <div class="flex-shrink-0">
                                        <a class="btn btn-success btn-sm my-2" onClick="add()" href="javascript:void(0)"><i class="bi bi-plus-circle"></i> Add Vehicle</a>
                                    </div> -->
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <hr>
                                <div class="form-group">
                                    <h4>Type Vehicle Code</h4>
                                    <input type="text" name="search" id="search" placeholder="Enter search name" class="form-control" onfocus="this.value=''">
                                </div>
                                <div id="search_list"></div>

                                <div class="card-body" id="show_vehicle_record">
                                    <h1 class="text-center text-secondary my-5"> Loading... </h1>
                                </div>
                            </div>

                        </div><!--end card-->
                    </div><!--end col-->

                </div><!--end row-->

            <!-- JS -->
            @include('time.test_js')

            </div> <!-- container-fluid -->       
        </div><!-- End Page-content -->

    </div>
    <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

</body>

</html>
@endsection