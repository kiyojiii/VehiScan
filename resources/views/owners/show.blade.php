<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>VehiScan | Owner - Show</title>

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
                            <h4 class="mb-sm-0 font-size-18">Owner Details</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Owner</a></li>
                                    <li class="breadcrumb-item active">Owner Details</li>
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
                                                        @if($owners->approval_status == 'Approved')
                                                        <a href="javascript:void(0);" class="badge bg-success font-size-12">
                                                            <i class="bx bx-purchase-tag-alt align-middle text-white me-1"></i> {{ $owners->approval_status }}
                                                        </a>
                                                        @elseif($owners->approval_status == 'Rejected')
                                                        <a href="javascript:void(0);" class="badge bg-danger font-size-12">
                                                            <i class="bx bx-purchase-tag-alt align-middle text-white me-1"></i> {{ $owners->approval_status }}
                                                        </a>
                                                        @else
                                                        <a href="javascript:void(0);" class="badge bg-light font-size-12">
                                                            <i class="bx bx-purchase-tag-alt align-middle text-muted me-1"></i> {{ $owners->approval_status }}
                                                        </a>
                                                        @endif
                                                    </div>

                                                    <h4>{{ $owners->first_name}} {{ $owners->middle_initial}}. {{ $owners->last_name}} </h4>
                                                    <p class="text-muted mb-4">Date Registered:<i class="mdi mdi-calendar me-1"></i>{{ \Carbon\Carbon::parse($owners->created_at)->isoFormat('D MMM, YYYY [at] h:mm A') }}</p>
                                                </div>

                                                <hr>
                                                <div class="text-center">
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <div>
                                                                <p class="text-muted mb-2">Last Name</p>
                                                                <h5 class="font-size-15">{{ $owners->last_name}}</h5>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="mt-4 mt-sm-0">
                                                                <p class="text-muted mb-2">Middle Initial</p>
                                                                <h5 class="font-size-15">{{ $owners->middle_initial}}.</h5>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="mt-4 mt-sm-0">
                                                                <p class="text-muted mb-2">First Name</p>
                                                                <h5 class="font-size-15">{{ $owners->first_name}}</h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="mt-4">
                                                    <div class="text-muted font-size-14">
                                                        <!-- Row 1: Contact Information -->
                                                        <h4>Contact Information</h4>
                                                        <!-- Row 2: Present Address -->
                                                        <h6>Present Address:</h6>
                                                        <p>{{ $owners->present_address }}</p>
                                                        <!-- Row 3: Email Address and Contact Number -->
                                                        <div class="row">
                                                            <div class="col">
                                                                <h6>Email Address:</h6>
                                                                <p>{{ $owners->email_address }}</p>
                                                            </div>
                                                            <div class="col">
                                                                <h6>Contact Number:</h6>
                                                                <p>{{ $owners->contact_number }}</p>
                                                            </div>
                                                        </div>
                                                        <!-- Row 4: Work Information -->
                                                        <h4>Work Information</h4>
                                                        <!-- Row 5: Appointment and Role Status -->
                                                        <div class="row">
                                                            <div class="col">
                                                                <h6>Appointment:</h6>
                                                                @php
                                                                $appointment = App\Models\Appointment::find($owners->appointment_id);
                                                                @endphp
                                                                @if($appointment)
                                                                <p>{{ $appointment->appointment }}</p>
                                                                @else
                                                                <p>No appointment found</p>
                                                                @endif
                                                            </div>
                                                            <div class="col">
                                                                <h6>Role Status:</h6>
                                                                @php
                                                                $role_status = App\Models\Statuses::find($owners->status_id);
                                                                @endphp
                                                                @if($role_status)
                                                                <p>{{ $role_status->applicant_role_status }}</p>
                                                                @else
                                                                <p>No Role Status found</p>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <!-- Row 6: Position & Designation and Office/Department/Agency -->
                                                        <div class="row">
                                                            <div class="col">
                                                                <h6>Position & Designation:</h6>
                                                                <p>{{ $owners->position_designation }}</p>
                                                            </div>
                                                            <div class="col">
                                                                <h6>Office/Department/Agency:</h6>
                                                                <p>{{ $owners->office_department_agency }}</p>
                                                            </div>
                                                        </div>
                                                    </div>      
                                                        <blockquote class="p-4 border-light border rounded mb-4">
                                                            <div class="d-flex">
                                                                <div class="me-3">
                                                                    <i class="bx bxs-quote-alt-left text-dark font-size-24"></i>
                                                                </div>
                                                                <div>
                                                                    <p class="mb-0"> <h6>Reason for Rejection:</h6> {{ $owners->reason }}</p>
                                                                </div>
                                                            </div>                        
                                                        </blockquote>
                                                    <hr>
                                                    <!-- Row 11: Photo ID -->
                                                    <div class="my-5">
                                                        <h4>Scan/Photo of ID</h4>
                                                        <img src="{{ asset('storage/images/' . $owners->scan_or_photo_of_id) }}" alt="Photo ID" class="img-thumbnail mx-auto d-block" style="width: 300px; height: 200px;">
                                                    </div>
                                                    <hr>
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