<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MVIS | Applicant - Vehicles</title>

    <link rel="icon" href="{{ asset('images/seal.png') }}" type="image/x-icon">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
                            <h4 class="mb-sm-0 font-size-18">Vehicles</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item active">User Vehicles</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->
                @forelse($owners as $owners)
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body border-bottom">
                                <div class="d-flex align-items-center">
                                    <h5 class="mb-0 card-title flex-grow-1">Vehicle Count: {{ $totalVehicles ?? 'N/A' }}</h5>
                                    <h5 class="mb-0 card-title flex-grow-1">Active Vehicle: <span class="text-success">{{ $activeVehicle->plate_number ?? 'N/A' }} - {{ $activeVehicle->vehicle_make ?? 'N/A' }} </span></h5>
                                    <!-- <div class="flex-shrink-0">
                                        <a class="btn btn-primary my-2" onClick="add()" href="javascript:void(0)"><i class="bi bi-plus-circle"></i> Add Vehicle</a>
                                        <a href="#!" class="btn btn-light"><i class="mdi mdi-refresh"></i></a>
                                        <div class="dropdown d-inline-block">

                                            <button type="menu" class="btn btn-success" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical"></i></button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                <li><a class="dropdown-item" href="#">Action</a></li>
                                                <li><a class="dropdown-item" href="#">Another action</a></li>
                                                <li><a class="dropdown-item" href="#">Something else here</a></li>
                                            </ul>
                                        </div>
                                    </div> -->
                                </div>
                            </div>

                            <div class="card-body" id="show_all_applicant_vehicles">
                                <h1 class="text-center text-secondary my-5"> Loading... </h1>
                            </div>

                            @include('applicant_users.vehicles.vehicle_modals')

                        </div><!--end card-->
                    </div><!--end col-->

                </div><!--end row-->

                @include('applicant_users.vehicles.vehicle_js')

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

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

</body>

</html>
@endsection