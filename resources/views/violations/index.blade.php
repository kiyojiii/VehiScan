<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> MVIS | Violations </title>

    <link rel="icon" href="{{ asset('images/seal.png') }}" type="image/x-icon">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- Select2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Select2 JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <!-- SWAL -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                            <h4 class="mb-sm-0 font-size-18">Violation List</h4>
                            <h4 id="digitalClock" class="clock"></h4>
                            @include('clock_js')
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Violation</a></li>
                                    <li class="breadcrumb-item active">Violation List</li>
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
                                    <h5 class="mb-0 card-title flex-grow-1">Violation Count: {{ $totalviolations }}</h5>
                                    <div class="flex-shrink-0">
                                        @canany('create-violation')
                                        <a class="btn btn-primary my-2" onClick="add()" href="javascript:void(0)"><i class="bi bi-plus-circle"></i> Add Violation</a>
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

                            <div class="card-body border-bottom">
                                <form>
                                    <div class="row justify-content-center"> <!-- Center the filters -->
                                        <div class="col-xl col-sm-3">
                                            <div class="mb-3">
                                                <label class="form-label">Start Date:</label>
                                                <input type="text" class="form-control" id="start_date" placeholder="Select date" data-date-format="dd M, yyyy" data-date-orientation="bottom auto" data-provide="datepicker" data-date-autoclose="true">
                                            </div>
                                        </div>

                                        <div class="col-xl col-sm-3">
                                            <div class="mb-3">
                                                <label class="form-label">End Date:</label>
                                                <input type="text" class="form-control" id="end_date" placeholder="Select date" data-date-format="dd M, yyyy" data-date-orientation="bottom auto" data-provide="datepicker" data-date-autoclose="true">
                                            </div>
                                        </div>

                                        <div class="col-xl col-sm-3">
                                            <div class="mb-3">
                                                <label class="form-label">Plate Number:</label>
                                                <select class="form-control select2-search" id="plate-number-select">
                                                    <option value="">Select Vehicle</option>
                                                    @foreach($vehicles as $v)
                                                    <option value="{{ $v->plate_number }}">{{ $v->plate_number }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-xl col-sm-6 align-self-end">
                                            <div class="mb-3">
                                                <button type="button" class="btn btn-primary w-md" id="filter_violation">Filter</button>
                                                <button type="button" class="btn btn-secondary w-md" id="clear_filter">Clear</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <div class="card-body" id="show_all_violations">
                                    <h1 class="text-center text-secondary my-5"> Loading... </h1>
                                </div>

                            </div>

                            @include('violations.violation_modals')

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

    @include('violations.violation_js')

</body>

</html>
@endsection