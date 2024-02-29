<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>VehiScan | Applicant - Show</title>

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
                            <h4 class="mb-sm-0 font-size-18">Applicant Details</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Applicant</a></li>
                                    <li class="breadcrumb-item active">Applicant Details</li>
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
                                                Applicant: {{ $owners->id }}
                                                Vehicle: {{ $owners->vehicle->id }}
                                                Driver: {{ $owners->vehicle->driver->id }}
                                                <div class="text-center">
                                                    <button id="{{ $owners->id }}" class="btn btn-success mx-1 editIconOwner" onclick="editOwner({{ $owners->id }})">
                                                        <i class="bi-pencil-square"></i> Edit Owner
                                                    </button>
                                                    <button id="{{ $owners->vehicle->id }}" class="btn btn-primary mx-1 editIconVehicle" onClick="editVehicle('{{ $owners->vehicle->id }}')">
                                                    <i class="bi-pencil-square"></i> Edit Vehicle
                                                    </button>


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
                                                                <p class="text-muted mb-2"><i class="fas fa-ad"></i> Plate Number</p>
                                                                <h5 class="font-size-15">{{ $owners->vehicle->plate_number ?? 'N/A' }}</h5>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="mt-4 mt-sm-0">
                                                                <p class="text-muted mb-2"><i class="fas fa-car"></i> Vehicle Model</p>
                                                                <h5 class="font-size-15">{{ $owners->vehicle->vehicle_make ?? 'N/A' }}</h5>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="mt-4 mt-sm-0">
                                                                <p class="text-muted mb-2"><i class="fas fa-adjust"></i> Vehicle Year & Color</p>
                                                                <h5 class="font-size-15">{{ $owners->vehicle->year_model ?? 'N/A' }} & {{ $owners->vehicle->color ?? 'N/A' }}</h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="mt-4">
                                                    <div class="text-muted font-size-14">
                                                        <!-- Work Information -->
                                                        <h4>Work Information</h4>
                                                        <!-- Row 5: Appointment and Role Status -->
                                                        <div class="row">
                                                            <div class="col">
                                                                <h6><i class="far fa-calendar-alt"></i> Appointment:</h6>
                                                                <p>{{ $owners->appointment->appointment ?? 'N/A' }}</p>
                                                            </div>
                                                            <div class="col">
                                                                <h6><i class="fas fa-check-square"></i> Role Status:</h6>
                                                                <p>{{ $owners->status->applicant_role_status ?? 'N/A' }}</p>
                                                            </div>
                                                        </div>
                                                        <!-- Row 6: Position & Designation and Office/Department/Agency -->
                                                        <div class="row">
                                                            <div class="col">
                                                                <h6><i class="fas fa-user-tie"></i> Position & Designation:</h6>
                                                                <p>{{ $owners->position_designation }}</p>
                                                            </div>
                                                            <div class="col">
                                                                <h6><i class="fas fa-city"></i> Office/Department/Agency:</h6>
                                                                <p>{{ $owners->office_department_agency }}</p>
                                                            </div>
                                                        </div>

                                                        <!-- Vehicle Information -->
                                                        <h4>Vehicle Information</h4>
                                                        <!-- Row 7: Driver Name, Owner Address -->
                                                        <div class="row">
                                                            <div class="col">
                                                                <h6><i class="fas fa-address-card"></i> Driver Name:</h6>
                                                                <p>{{ $owners->vehicle->driver->driver_name ?? 'N/A' }}</p>
                                                            </div>
                                                            <div class="col">
                                                                <h6><i class="fas fa-home"></i> Owner Address:</h6>
                                                                <p>{{ $owners->present_address }}</p>
                                                            </div>
                                                        </div>
                                                        <!-- Row 8: Plate Number, Vehicle Make, Year Model, Color, Body Type, Approval Status -->
                                                        <div class="row">
                                                            <div class="col">
                                                                <h6><i class="fas fa-ad"></i> Plate Number:</h6>
                                                                <p>{{ $owners->vehicle->plate_number ?? 'N/A' }}</p>
                                                            </div>
                                                            <div class="col">
                                                                <h6><i class="fas fa-car"></i> Vehicle Make:</h6>
                                                                <p>{{ $owners->vehicle->vehicle_make ?? 'N/A' }}</p>
                                                            </div>
                                                            <div class="col">
                                                                <h6><i class="fas fa-calendar-day"></i> Year Model:</h6>
                                                                <p>{{ $owners->vehicle->year_model ?? 'N/A' }}</p>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col">
                                                                <h6><i class="fas fa-adjust"></i> Color:</h6>
                                                                <p>{{ $owners->vehicle->color ?? 'N/A' }}</p>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <h6><i class="fas fa-car-side"></i> Body Type:</h6>
                                                                <!-- Assuming $bodyType is retrieved from the database -->
                                                                <p>{{ $owners->vehicle->body_type ?? 'N/A' }}</p>
                                                            </div>
                                                            <div class="col">
                                                                <h6><i class="fas fa-clipboard-check"></i> Approval Status:</h6>
                                                                <!-- Assuming $approvalStatus is retrieved from the database -->
                                                                <p>{{ $owners->vehicle->approval_status ?? 'N/A' }}</p>
                                                            </div>
                                                        </div>
                                                        <!-- Vehicle Documents -->
                                                        <h4>Vehicle Documents</h4>
                                                        <!-- Row 9: Official Receipt Image, Certificate of Registration Image, Deed of Sale Image, Authorization Letter Image -->
                                                        <div class="row">
                                                            <div class="col">
                                                                <h6>Official Receipt:</h6>
                                                                <!-- Assuming $officialReceiptImage is retrieved from the database -->
                                                                <img src="{{ asset('storage/images/vehicles/documents/' . $owners->vehicle->official_receipt_image) }}" alt="official_receipt_image ID" class="img-thumbnail mx-auto d-block" style="width: 300px; height: 200px;">
                                                            </div>
                                                            <div class="col">
                                                                <h6>Cert. of Registration:</h6>
                                                                <!-- Assuming $certificateOfRegistrationImage is retrieved from the database -->
                                                                <img src="{{ asset('storage/images/vehicles/documents/' . $owners->vehicle->certificate_of_registration_image) }}" alt="certificate_of_registration_image ID" class="img-thumbnail mx-auto d-block" style="width: 300px; height: 200px;">
                                                            </div>
                                                            <div class="col">
                                                                <h6>Deed of Sale:</h6>
                                                                <!-- Assuming $deedOfSaleImage is retrieved from the database -->
                                                                <img src="{{ asset('storage/images/vehicles/documents/' . $owners->vehicle->deed_of_sale_image) }}" alt="certificate_of_registration_image ID" class="img-thumbnail mx-auto d-block" style="width: 300px; height: 200px;">
                                                            </div>
                                                            <div class="col">
                                                                <h6>Authorization Letter:</h6>
                                                                <img src="{{ asset('storage/images/vehicles/documents/' . $owners->vehicle->authorization_letter_image) }}" alt="authorization_letter_image ID" class="img-thumbnail mx-auto d-block" style="width: 300px; height: 200px;">
                                                            </div>
                                                        </div>

                                                        <!-- Vehicle Images -->
                                                        <h4>Vehicle Images</h4>
                                                        <!-- Row 10: Front Photo, Side Photo -->
                                                        <div class="row">
                                                            <div class="col">
                                                                <h6>Front Photo:</h6>
                                                                <!-- Assuming $frontPhotoImage is retrieved from the database -->
                                                                <img src="{{ asset('storage/images/vehicles/' . $owners->vehicle->front_photo) }}" alt="authorization_letter_image ID" class="img-thumbnail mx-auto d-block" style="width: 300px; height: 200px;">
                                                            </div>
                                                            <div class="col">
                                                                <h6>Side Photo:</h6>
                                                                <!-- Assuming $sidePhotoImage is retrieved from the database -->
                                                                <img src="{{ asset('storage/images/vehicles/' . $owners->vehicle->side_photo) }}" alt="side_photo ID" class="img-thumbnail mx-auto d-block" style="width: 300px; height: 200px;">
                                                            </div>
                                                        </div>
                                                        <!-- Driver Information -->
                                                        <h4>Driver Information</h4>
                                                        <!-- Driver's License Image, Authorized Driver's License Image -->
                                                        <div class="row">
                                                            <div class="col">
                                                                <h6>Driver's License Image:</h6>
                                                                <!-- Assuming $driversLicenseImage is retrieved from the database -->
                                                                <img src="{{ asset('storage/images/drivers/' . ($owners->vehicle->driver->driver_license_image ?? 'N/A')) }}" alt="Driver's License Image" class="img-thumbnail mx-auto d-block" style="width: 300px; height: 200px;">
                                                            </div>
                                                            <div class="col">
                                                                <h6>Authorized Driver's License Image:</h6>
                                                                <!-- Assuming $authorizedDriversLicenseImage is retrieved from the database -->
                                                                <img src="{{ asset('storage/images/drivers/' . ($owners->vehicle->driver->authorized_driver_license_image ?? 'N/A')) }}" alt="Authorized Driver's License Image" class="img-thumbnail mx-auto d-block" style="width: 300px; height: 200px;">
                                                            </div>
                                                        </div>
                                                        <!-- Full Name, Authorized Driver's Full Name, Authorized Driver's Address -->
                                                        <div class="row">
                                                            <div class="col">
                                                                <h6>Full Name:</h6>
                                                                <!-- Assuming $fullName is retrieved from the database -->
                                                                <p>{{ $owners->vehicle->driver->driver_name ?? 'N/A' }}</p>
                                                            </div>
                                                            <div class="col">
                                                                <h6>Authorized Driver's Full Name:</h6>
                                                                <!-- Assuming $authorizedDriversFullName is retrieved from the database -->
                                                                <p>{{ $owners->vehicle->driver->authorized_driver_name ?? 'N/A' }}</p>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col">
                                                                <h6>Driver's Address:</h6>
                                                                <!-- Assuming $authorizedDriversAddress is retrieved from the database -->
                                                                <p>{{ $owners->present_address ?? 'N/A' }}</p>
                                                            </div>
                                                            <div class="col">
                                                                <h6>Authorized Driver's Address:</h6>
                                                                <!-- Assuming $authorizedDriversAddress is retrieved from the database -->
                                                                <p>{{ $owners->vehicle->driver->authorized_driver_address ?? 'N/A' }}</p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <blockquote class="p-4 border-light border rounded mb-4">
                                                        <div class="d-flex">
                                                            <div class="me-3">
                                                                <i class="bx bxs-quote-alt-left text-dark font-size-24"></i>
                                                            </div>
                                                            <div class="row">
                                                                <!-- Reason for Rejection -->
                                                                <div class="col">
                                                                    <h6>Reason for Rejection:</h6>
                                                                </div>
                                                                <!-- Applicant Reason -->
                                                                <div class="col">
                                                                    <div class="col">
                                                                        <h6>Applicant:</h6>
                                                                        <p>
                                                                            @if($owners->approval_status == 'Approved')
                                                                            <span class="badge bg-success">{{ $owners->reason ?? 'N/A' }}</span>
                                                                            @elseif($owners->approval_status == 'Rejected')
                                                                            <span class="badge bg-danger">{{ $owners->reason ?? 'N/A' }}</span>
                                                                            @else
                                                                            <!-- If approval status is 'Pending', set reason to 'Pending' -->
                                                                            <span class="badge bg-warning">Pending</span>
                                                                            @endif
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                                <!-- Vehicle Reason -->
                                                                <div class="col">
                                                                    <h6>Vehicle:</h6>
                                                                    <p>
                                                                        @if($owners->vehicle->approval_status == 'Approved')
                                                                        <span class="badge bg-success badge-lg">{{ $owners->vehicle->reason ?? 'N/A' }}</span>
                                                                        @elseif($owners->vehicle->approval_status == 'Rejected')
                                                                        <span class="badge bg-danger">{{ $owners->vehicle->reason ?? 'N/A' }}</span>
                                                                        @else
                                                                        <!-- If approval status is 'Pending', set reason to 'Pending' -->
                                                                        <span class="badge bg-warning">Pending</span>
                                                                        @endif
                                                                    </p>
                                                                </div>
                                                                <!-- Driver Reason -->
                                                                <div class="col">
                                                                    <h6>Driver:</h6>
                                                                    <p>
                                                                        @if($owners->vehicle->driver->approval_status == 'Approved')
                                                                        <span class="badge bg-success">{{ $owners->vehicle->driver->reason ?? 'N/A' }}</span>
                                                                        @elseif($owners->vehicle->driver->approval_status == 'Rejected')
                                                                        <span class="badge bg-danger">{{ $owners->vehicle->driver->reason ?? 'N/A' }}</span>
                                                                        @else
                                                                        <!-- If approval status is 'Pending', set reason to 'Pending' -->
                                                                        <span class="badge bg-warning">Pending</span>
                                                                        @endif
                                                                    </p>
                                                                </div>
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

                                                <!-- Modals -->
                                                @include('applicants.edit_owner')
                                                @include('applicants.edit_vehicle')


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

        @include('applicants.show_js')
</body>

</html>
@endsection