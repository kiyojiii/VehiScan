<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MVIS | Role Status </title>

    <link rel="icon" href="{{ asset('images/seal.png') }}" type="image/x-icon">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body>

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
                            <h4 class="mb-sm-0 font-size-18">Status List</h4>
                            <h4 id="digitalClock" class="clock"></h4>
                            @include('clock_js')
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Status</a></li>
                                    <li class="breadcrumb-item active">Status List</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->


                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body border-bottom">
                                <div class="d-flex align-items-center">
                                    <h5 class="mb-0 card-title flex-grow-1">Role Status Count: {{ $rstotalcount }}</h5>
                                    <div class="flex-shrink-0">
                                    @canany('create-status')
                                        <a class="btn btn-primary my-2" onClick="add()" href="javascript:void(0)"><i class="bi bi-plus-circle"></i> Add Role Status</a>
                                    @endcan   
                                        <a href="javascript:location.reload(true)" class="btn btn-light"><i class="mdi mdi-refresh"></i></a>
                                        <div class="dropdown d-inline-block">

                                            <button type="menu" class="btn btn-success" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical"></i></button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                <li><a class="dropdown-item" href="{{ route('owners.index') }}">Owners</a></li>
                                                <li><a class="dropdown-item" href="{{ route('vehicles.index') }}">Vehicles</a></li>
                                                <li><a class="dropdown-item" href="{{ route('drivers.index') }}">Drivers</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body" id="show_all_role_status">
                                <h1 class="text-center text-secondary my-5"> Loading... </h1>
                            </div>

                            @include('status.status_modals')

                        </div><!--end card-->
                    </div><!--end col-->

                </div><!--end row-->


            </div> <!-- container-fluid -->
        </div><!-- End Page-content -->

    </div>
    <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

    @include('status.status_js')

</body>

</html>
@endsection