<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MVIS | Driver - Show</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                            <h4 class="mb-sm-0 font-size-18">Driver Details</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Driver</a></li>
                                    <li class="breadcrumb-item active">Driver Details</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="pt-3">
                                    <div class="row justify-content-center">
                                        <div class="col-xl-8">
                                            <div>
                                                <div class="text-center">
                                                    <div class="mb-4">
                                                        Approval Status:
                                                        @if($drivers->approval_status == 'Approved')
                                                        <a href="javascript:void(0);" class="badge bg-success font-size-12">
                                                            <i class="bx bx-purchase-tag-alt align-middle text-white me-1"></i> {{ $drivers->approval_status }}
                                                        </a>
                                                        @elseif($drivers->approval_status == 'Rejected')
                                                        <a href="javascript:void(0);" class="badge bg-danger font-size-12">
                                                            <i class="bx bx-purchase-tag-alt align-middle text-white me-1"></i> {{ $drivers->approval_status }}
                                                        </a>
                                                        @else
                                                        <a href="javascript:void(0);" class="badge bg-light font-size-12">
                                                            <i class="bx bx-purchase-tag-alt align-middle text-muted me-1"></i> {{ $drivers->approval_status }}
                                                        </a>
                                                        @endif
                                                    </div>

                                                    <h4>{{ $drivers->driver_name}}</h4>
                                                    <p class="text-muted mb-4">Date Registered:<i class="mdi mdi-calendar me-1"></i>{{ \Carbon\Carbon::parse($drivers->created_at)->isoFormat('D MMM, YYYY [at] h:mm A') }}</p>
                                                </div>

                                                <hr>

                                                <div class="mt-4">
                                                    <div class="text-muted font-size-14">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <h4>Driver Information</h4>
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <h5>Driver's License Image</h5>
                                                                        <img src="{{ asset('storage/images/drivers/' . $drivers->driver_license_image) }}" alt="DL Image" class="img-thumbnail mx-auto d-block" style="width: 300px; height: 200px;">
                                                                    </div>
                                                                </div>
                                                                <br>
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <h5>Full Name:</h5>
                                                                        <p>{{ $drivers->driver_name }}</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <h4>Authorized Driver Information</h4>
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <h5>Authorized Driver's License Image</h5>
                                                                        <img src="{{ asset('storage/images/drivers/' . $drivers->authorized_driver_license_image) }}" alt="Authorized DL Image" class="img-thumbnail mx-auto d-block" style="width: 300px; height: 200px;">
                                                                    </div>
                                                                </div>
                                                                <br>
                                                                <div class="row">
                                                                    <div class="col-md-12   ">
                                                                        <h5>Authorized Full Name</h5>
                                                                        <p>{{ $drivers->authorized_driver_name }}</p>
                                                                        <h5>Authorized Address</h5>
                                                                        <p>{{ $drivers->authorized_driver_address }}</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->

                <!-- <blockquote class="p-4 border-light border rounded mb-4">
                    <div class="d-flex">
                        <div class="me-3">
                            <i class="bx bxs-quote-alt-left text-dark font-size-24"></i>
                        </div>
                        <div>
                            <p class="mb-0"> At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium deleniti atque corrupti quos dolores et quas molestias excepturi sint quidem rerum facilis est</p>
                        </div>
                    </div>                        
                </blockquote> -->

            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->


</body>

</html>
@endsection