<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MVIS | Reports</title>

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
                            <h4 class="mb-sm-0 font-size-18">Reports</h4>
                            <h4 id="digitalClock" class="clock"></h4>
                            @include('clock_js')
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item active"><a href="javascript: void(0);">Vehicle Reports</a></li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-sm-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="avatar-xs me-3">
                                        <span class="avatar-title rounded-circle bg-primary-subtle text-primary font-size-18">
                                            <i class="bx bx-calendar"></i>
                                        </span>
                                    </div>
                                    <h5 class="font-size-14 mb-0">Vehicles Previous Month</h5>
                                </div>
                                <div class="text-muted mt-4">
                                    <h4> {{ $totalvehiclespreviousmonthcount }}</h4>
                                    <div class="d-flex">
                                        <span class="badge badge-soft-primary font-size-12">{{ $totalvehiclespreviousmonth }}</span><span class="ms-2 text-truncate">previous month </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="avatar-xs me-3">
                                        <span class="avatar-title rounded-circle bg-primary-subtle text-primary font-size-18">
                                            <i class="bx bx-calendar-minus"></i>
                                        </span>
                                    </div>
                                    <h5 class="font-size-14 mb-0">Vehicles Yesterday</h5>
                                </div>
                                <div class="text-muted mt-4">
                                    @if($totalvehiclespreviousdaycount < $totalvehiclestodaycount) <h4> {{$totalvehiclespreviousdaycount}} <i class="mdi mdi-chevron-down ms-1 text-danger"></i></h4>
                                        @elseif($totalvehiclespreviousdaycount > $totalvehiclestodaycount)
                                        <h4> {{$totalvehiclespreviousdaycount}} <i class="mdi mdi-chevron-up ms-1 text-success"></i></h4>
                                        @else
                                        <h4> {{$totalvehiclespreviousdaycount}}</h4>
                                        @endif
                                        <div class="d-flex">
                                            <span class="badge badge-soft-primary font-size-12"> {{ $totalvehiclespreviousdayformat }} </span> <span class="ms-2 text-truncate"> previous day </span>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="avatar-xs me-3">
                                        <span class="avatar-title rounded-circle bg-primary-subtle text-primary font-size-18">
                                            <i class="bx bx-calendar-check"></i>
                                        </span>
                                    </div>
                                    <h5 class="font-size-14 mb-0">Vehicles Today</h5>
                                </div>
                                <div class="text-muted mt-4">
                                    @if($totalvehiclestodaycount < $totalvehiclespreviousdaycount) <h4> {{$totalvehiclestodaycount}} <i class="mdi mdi-chevron-down ms-1 text-danger"></i></h4>
                                        @elseif($totalvehiclestodaycount > $totalvehiclespreviousdaycount)
                                        <h4> {{$totalvehiclestodaycount}} <i class="mdi mdi-chevron-up ms-1 text-success"></i></h4>
                                        @else
                                        <h4> {{$totalvehiclestodaycount}}</h4>
                                        @endif
                                        <div class="d-flex">
                                            <span class="badge badge-soft-primary font-size-12"> {{ $totalvehiclestodayformat }} </span> <span class="ms-2 text-truncate">Today</span>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-sm-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="avatar-xs me-3">
                                        <span class="avatar-title rounded-circle bg-primary-subtle text-primary font-size-18">
                                            <i class="bx bx-calendar-plus"></i>
                                        </span>
                                    </div>
                                    <h5 class="font-size-14 mb-0">Vehicles Today's Month</h5>
                                </div>
                                <div class="text-muted mt-4">
                                    @if($totalvehiclesthismonthcount < $totalvehiclespreviousmonthcount) <h4> {{$totalvehiclesthismonthcount}} <i class="mdi mdi-chevron-down ms-1 text-danger"></i></h4>
                                        @elseif($totalvehiclesthismonthcount > $totalvehiclespreviousmonthcount)
                                        <h4> {{$totalvehiclesthismonthcount}} <i class="mdi mdi-chevron-up ms-1 text-success"></i></h4>
                                        @else
                                        <h4> {{$totalvehiclesthismonthcount}}</h4>
                                        @endif
                                        <div class="d-flex">
                                            <span class="badge badge-soft-primary font-size-12"> {{ $currentMonthFormat }} </span> <span class="ms-2 text-truncate">Current Month</span>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="row">
                    <div class="col-lg-6">
                        <div class="card">

                            <div class="card-body border-bottom">
                                <div class="d-flex align-items-center">
                                    <h5 class="mb-0 card-title flex-grow-1 text-center">Day Vehicle Record</h5>
                                </div>
                                <br>
                                <form>
                                    <div class="row justify-content-center"> <!-- Center the filters -->
                                        <div class="col-xl col-sm-3">
                                            <div class="mb-3">
                                                <label class="form-label">Day:</label>
                                                <input type="text" class="form-control" id="day_date" placeholder="Select date" data-date-format="dd/MM/yyyy" data-date-orientation="bottom auto" data-provide="datepicker" data-date-autoclose="true">
                                            </div>
                                        </div>

                                        <div class="col-xl col-sm-3 align-self-end">
                                            <div class="mb-3">
                                                <button type="button" class="btn btn-primary w-md" id="day_filter">Filter</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="card-body" id="today_vehicles">
                                <h1 class="text-center text-secondary my-5"> Loading... </h1>
                            </div>

                        </div><!--end card-->
                    </div><!--end col-->

                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body border-bottom">
                                <div class="d-flex align-items-center">
                                    <h5 class="mb-0 card-title flex-grow-1 text-center">Monthly Vehicle Record</h5>
                                </div>
                                <br>
                                <form>
                                    <div class="row justify-content-center"> <!-- Center the filters -->
                                        <div class="col-xl col-sm-3">
                                            <div class="mb-3">
                                                <label class="form-label">Month:</label>
                                                <input type="text" class="form-control" id="monthly_date" placeholder="Select date" data-date-format="MM/yyyy" data-date-orientation="bottom auto" data-provide="datepicker" data-date-autoclose="true">
                                            </div>
                                        </div>

                                        <div class="col-xl col-sm-3 align-self-end">
                                            <div class="mb-3">
                                                <button type="button" class="btn btn-primary w-md" id="monthly_filter">Filter</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="card-body" id="monthly_vehicles">
                                <h1 class="text-center text-secondary my-5"> Loading... </h1>
                            </div>
                        </div><!--end card-->
                    </div><!--end col-->

                </div><!--end row-->

                @include('reports.reports_js')

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