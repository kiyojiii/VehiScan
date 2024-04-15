<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MVIS | Applicant - Details</title>

    <link rel="icon" href="{{ asset('images/seal.png') }}" type="image/x-icon">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body>

    @extends('layouts.app')

    @section('content')
    <style>
        ul.vstack li {
            display: flex;
            justify-content: space-between;
        }
    </style>
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
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Applicants</a></li>
                                    <li class="breadcrumb-item active">Applicant Details</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-xl-5">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <h5 class="fw-semibold me-3">Overview</h5>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                            Action <i class="fas fa-cog"></i>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <li>
                                                <a class="dropdown-item text-success mx-1 approveAll" href="#" data-owner-id="{{ $owners->id }}" data-vehicle-id="{{ $owners->vehicle->id }}" data-driver-id="{{ $owners->vehicle->driver->id }}">
                                                    <i class="bx bx-check-double"></i> Approve All
                                                </a>
                                            </li>
                                            <li><a class="dropdown-item text-success mx-1 approveApplicant" href="#" id="{{ $owners->id }}"><i class="bx bx-check-circle"></i> Approve Applicant</a></li>
                                            <li><a class="dropdown-item text-success mx-1 approveVehicle" href="#" id="{{ $owners->vehicle->id }}" href="#"><i class="bx bx-check-circle"></i> Approve Vehicle</a></li>
                                            <li><a class="dropdown-item text-success mx-1 approveDriver" href="#" id="{{ $owners->vehicle->driver->id }}" href="#"><i class="bx bx-check-circle"></i> Approve Driver</a></li>
                                            <li><a class="dropdown-item text-danger mx-1 rejectApplicant" href="#" id="{{ $owners->id }}"><i class="bx bx-x-circle"></i> Reject Applicant</a></li>
                                            <li><a class="dropdown-item text-danger mx-1 rejectVehicle" href="#" id="{{ $owners->vehicle->id }}"><i class="bx bx-x-circle"></i> Reject Vehicle</a></li>
                                            <li><a class="dropdown-item text-danger mx-1 rejectDriver" href="#" id="{{ $owners->vehicle->driver->id }}"><i class="bx bx-x-circle"></i> Reject Driver</a></li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <th scope="row">Full Name</th>
                                                <td>{{ $owners->first_name ?? 'N/A' }} {{ $owners->middle_initial ?? 'N/A' }}. {{ $owners->last_name ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="col">Serial Number</th>
                                                <td scope="col">{{ $owners->serial_number ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">ID Number</th>
                                                <td>{{ $owners->id_number ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Office / Dept. / Agency</th>
                                                <td>{{ $owners->office_department_agency ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Position / Designation</th>
                                                <td>{{ $owners->position_designation ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Appointment:</h6>
                                                <td>{{ $owners->appointment->appointment ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row"> Role Status:</h6>
                                                <td>{{ $owners->status->applicant_role_status ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Approval Status</th>
                                                @if($owners->approval_status == 'Approved')
                                                <td><span class="badge badge-soft-success">Approved</span></td>
                                                @elseif($owners->approval_status == 'Rejected')
                                                <td><span class="badge badge-soft-danger">Rejected</span></td>
                                                @elseif($owners->approval_status == 'Pending')
                                                <td><span class="badge badge-soft-warning">Pending</span></td>
                                                @else
                                                <td><span class="badge badge-soft-secondary">Unknown</span></td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="row">Applied Date</th>
                                                <td>{{ \Carbon\Carbon::parse($owners->created_at ?? 'N/A')->format('d F, Y') }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Reason(If Rejected)</th>
                                                <td>{{ $owners->reason ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Scanned Photo or ID</th>
                                                <td>
                                                    <img src="{{ asset('storage/images/' . $owners->scan_or_photo_of_id) ?? 'N/A' }}" alt="scan_or_photo_of_id ID" class="img-thumbnail mx-auto d-block img-modal" style="width: 150px; height: 150px;">
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="text-center">
                                    <h5 class="fw-semibold">Association</h5>
                                    <br>
                                    @if($owners->appointment->appointment != 'Partner/Supplier' && $owners->appointment->appointment != 'Supplier')
                                    <img src="{{ asset('images/seal.png') }}" alt="" height="50" class="mx-auto d-block">
                                    <h5 class="mt-3 mb-1">Mindanao State University - Iligan Institute of Technology</h5>
                                    @else
                                    <img src="{{ asset('images/image.png') }}" alt="" height="50" class="mx-auto d-block">
                                    <h5 class="mt-3 mb-1">Partner/Supplier</h5>
                                    @endif
                                </div>

                                <ul class="list-unstyled mt-4">
                                    <li>
                                        <div class="d-flex">
                                            <i class="bx bx-phone text-primary fs-4"></i>
                                            <div class="ms-3">
                                                <h6 class="fs-14 mb-2">Phone</h6>
                                                <p class="text-muted fs-14 mb-0">{{ $owners->contact_number ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="mt-3">
                                        <div class="d-flex">
                                            <i class="bx bx-mail-send text-primary fs-4"></i>
                                            <div class="ms-3">
                                                <h6 class="fs-14 mb-2">Email</h6>
                                                <p class="text-muted fs-14 mb-0">{{ $owners->email_address ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                    </li>
                                    <!-- <li class="mt-3">
                                        <div class="d-flex">
                                            <i class="bx bx-globe text-primary fs-4"></i>
                                            <div class="ms-3">
                                                <h6 class="fs-14 mb-2">Website</h6>
                                                <p class="text-muted fs-14 text-break mb-0">www.themesbrand.com</p>
                                            </div>
                                        </div>
                                    </li> -->
                                    <li class="mt-3">
                                        <div class="d-flex">
                                            <i class="bx bx-map text-primary fs-4"></i>
                                            <div class="ms-3">
                                                <h6 class="fs-14 mb-2">Present Address</h6>
                                                <p class="text-muted fs-14 mb-0">{{ $owners->present_address ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                                <div class="mt-4">
                                    <a href=" {{ route('owners.show', $owners->id) }}" class="btn btn-soft-primary btn-hover w-100 rounded"><i class="mdi mdi-eye"></i> View Profile</a>
                                </div>
                            </div>
                        </div>
                    </div><!--end col-->
                    <div class="col-xl-7">
                        <div class="card">
                            <div class="card-body border-bottom">
                                <div class="d-flex">
                                    <!-- Assuming $qrCodeBase64 contains the base64-encoded image data -->
                                    <img src="data:image/png;base64,{{ $qrCodeBase64 }}" alt="QR Code" height="50" class="mx-auto d-block img-modal">
                                    <div class="flex-grow-1 ms-3 d-flex justify-content-end">
                                        <h5 class="fw-semibold">Vehicle QR Code <button class="btn btn-primary download-btn" data-qrcode="{{ $owners->vehicle->vehicle_code }} "><i class="fas fa-download"></i> Download QR</button></h5>
                                        <ul class="list-unstyled hstack gap-2 mb-0">
                                            <li>
                                                <button id="{{ $owners->id }}" class="btn btn-success mx-1 editIconOwner" onclick="editOwner('{{ $owners->id }}')">
                                                    <i class="fas fa-user-tie"></i> Edit Owner
                                                </button>
                                            </li>
                                            <li>
                                                <button id="{{ $owners->vehicle ? $owners->vehicle->id : 'null' }}" class="btn btn-primary mx-1 editIconVehicle" onClick="editVehicle('{{ $owners->vehicle ? $owners->vehicle->id : 'null' }}')" {{ $owners->vehicle ? '' : 'disabled' }}>
                                                    <i class="fas fa-car"></i> Edit Vehicle
                                                </button>
                                            </li>
                                            <li>
                                                <button id="{{ $owners->vehicle && $owners->vehicle->driver ? $owners->vehicle->driver->id : 'null' }}" class="btn btn-secondary mx-1 editIconDriver" onClick="editDriver('{{ $owners->vehicle && $owners->vehicle->driver ? $owners->vehicle->driver->id : 'null' }}')">
                                                    <i class="fas fa-address-card"></i> Edit Driver
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <!-- <h5 class="fw-semibold mb-3">Description</h5> -->
                                <!-- <p class="text-muted">We are looking to hire a skilled Magento developer to build and maintain eCommerce websites for our clients. As a Magento developer, you will be responsible for liaising with the design team, setting up Magento 1x and 2x sites, building modules and customizing extensions, testing the performance of each site, and maintaining security and feature updates after the installation is complete.</p> -->

                                <h5 class="fw-semibold mb-3">Vehicle Details:</h5>
                                <ul class="vstack gap-3">
                                    <li>
                                        <strong>Vehicle Code:</strong>
                                        <span>{{ $owners->vehicle->vehicle_code ?? 'N/A' }}</span>
                                    </li>
                                    <li>
                                        <strong>Plate Number:</strong>
                                        <span>{{ $owners->vehicle->plate_number ?? 'N/A' }}</span>
                                    </li>
                                    <li>
                                        <strong>Owner Name:</strong>
                                        <span>{{ $owners->vehicle->owner_name ?? 'N/A' }}</span>
                                    </li>
                                    <li>
                                        <strong>Owner Address:</strong>
                                        <span>{{ $owners->vehicle->owner_address ?? 'N/A' }}</span>
                                    </li>
                                    <li>
                                        <strong>Vehicle Make:</strong>
                                        <span>{{ $owners->vehicle->vehicle_make ?? 'N/A' }}</span>
                                    </li>
                                    <li>
                                        <strong>Vehicle Category:</strong>
                                        <span>{{ $owners->vehicle->vehicle_category ?? 'N/A' }}</span>
                                    </li>
                                    <li>
                                        <strong>Vehicle Year Model:</strong>
                                        <span>{{ $owners->vehicle->year_model ?? 'N/A' }}</span>
                                    </li>
                                    <li>
                                        <strong>Vehicle Color:</strong>
                                        <span>{{ $owners->vehicle->color ?? 'N/A' }}</span>
                                    </li>
                                    <li>
                                        <strong>Vehicle Body Type:</strong>
                                        <span>{{ $owners->vehicle->body_type ?? 'N/A' }}</span>
                                    </li>
                                    <li>
                                        <strong>Vehicle Status:</strong>
                                        <span>{{ $owners->vehicle->registration_status ?? 'N/A' }}</span>
                                    </li>
                                    <li>
                                        <strong scope="row">Approval Status</strong>
                                        @if($owners->vehicle)
                                        @if($owners->vehicle->approval_status == 'Approved')
                                        <strong><span class="badge badge-soft-success">Approved</span></strong>
                                        @elseif($owners->vehicle->approval_status == 'Rejected')
                                        <strong><span class="badge badge-soft-danger">Rejected</span></strong>
                                        @elseif($owners->vehicle->approval_status == 'Pending')
                                        <strong><span class="badge badge-soft-warning">Pending</span></strong>
                                        @else
                                        <strong><span class="badge badge-soft-secondary">Unknown</span></strong>
                                        @endif
                                        @else
                                        <strong><span class="badge badge-soft-secondary">No Vehicle Associated</span></strong>
                                        @endif
                                    </li>
                                    <li>
                                        <strong>Applied Date:</strong>
                                        <span>
                                            @if($owners->vehicle && $owners->vehicle->created_at)
                                            {{ \Carbon\Carbon::parse($owners->vehicle->created_at)->format('d F, Y') }}
                                            @else
                                            N/A
                                            @endif
                                        </span>
                                    </li>
                                    <li>
                                        <strong>Reason(If Rejected):</strong>
                                        <span>{{ $owners->vehicle->reason ?? 'N/A' }}</span>
                                    </li>
                                </ul>

                                <h5 class="fw-semibold mb-3">Vehicle Photos:</h5>
                                <div class="row">
                                    <div class="row">
                                        <div class="col">
                                            <h6>Front Photo:</h6>
                                            @if($owners->vehicle && $owners->vehicle->front_photo)
                                            <!-- Assuming $frontPhotoImage is retrieved from the database -->
                                            <img src="{{ asset('storage/images/vehicles/' . $owners->vehicle->front_photo) }}" alt="front_photo ID" class="img-thumbnail mx-auto d-block img-modal" style="width: 300px; height: 200px;">
                                            @else
                                            <p>No front photo available</p>
                                            @endif
                                        </div>
                                        <div class="col">
                                            <h6>Side Photo:</h6>
                                            @if($owners->vehicle && $owners->vehicle->side_photo)
                                            <!-- Assuming $sidePhotoImage is retrieved from the database -->
                                            <img src="{{ asset('storage/images/vehicles/' . $owners->vehicle->side_photo) }}" alt="side_photo ID" class="img-thumbnail mx-auto d-block img-modal" style="width: 300px; height: 200px;">
                                            @else
                                            <p>No side photo available</p>
                                            @endif
                                        </div>
                                    </div>
                                    <br>
                                    <div class="col">
                                        <br>
                                        <h5 class="fw-semibold mb-3">Vehicle Documents:</h5>
                                        <button id="toggleVehicleImagesBtn" class="btn btn-primary mb-3">Show Documents</button>
                                        <div id="vehicleImages" style="display: none;">
                                            <div class="row">
                                                @if($owners->vehicle)
                                                <div class="col">
                                                    <h6>Official Receipt:</h6>
                                                    @if($owners->vehicle->official_receipt_image)
                                                    <!-- Assuming $officialReceiptImage is retrieved from the database -->
                                                    <img src="{{ asset('storage/images/vehicles/documents/' . $owners->vehicle->official_receipt_image) }}" alt="official_receipt_image ID" class="img-thumbnail mx-auto d-block img-modal" style="width: 300px; height: 200px;">
                                                    @else
                                                    <p>No official receipt available</p>
                                                    @endif
                                                </div>
                                                <div class="col">
                                                    <h6>Cert. of Register:</h6>
                                                    @if($owners->vehicle->certificate_of_registration_image)
                                                    <!-- Assuming $certificateOfRegistrationImage is retrieved from the database -->
                                                    <img src="{{ asset('storage/images/vehicles/documents/' . $owners->vehicle->certificate_of_registration_image) }}" alt="certificate_of_registration_image ID" class="img-thumbnail mx-auto d-block img-modal" style="width: 300px; height: 200px;">
                                                    @else
                                                    <p>No certificate of registration available</p>
                                                    @endif
                                                </div>
                                                <div class="col">
                                                    <h6>Deed of Sale:</h6>
                                                    @if($owners->vehicle->deed_of_sale_image)
                                                    <!-- Assuming $deedOfSaleImage is retrieved from the database -->
                                                    <img src="{{ asset('storage/images/vehicles/documents/' . $owners->vehicle->deed_of_sale_image) }}" alt="deed_of_sale_image ID" class="img-thumbnail mx-auto d-block img-modal" style="width: 300px; height: 200px;">
                                                    @else
                                                    <p>No deed of sale available</p>
                                                    @endif
                                                </div>
                                                <div class="col">
                                                    <h6>Authorization:</h6>
                                                    @if($owners->vehicle->authorization_letter_image)
                                                    <img src="{{ asset('storage/images/vehicles/documents/' . $owners->vehicle->authorization_letter_image) }}" alt="authorization_letter_image ID" class="img-thumbnail mx-auto d-block img-modal" style="width: 300px; height: 200px;">
                                                    @else
                                                    <p>No authorization letter available</p>
                                                    @endif
                                                </div>
                                                @else
                                                <p>No vehicle information available</p>
                                                @endif
                                            </div>
                                        </div>
                                        <br>
                                    </div>
                                    <br>
                                    <h5 class="fw-semibold mb-3">Driver Details:</h5>
                                    <ul class="vstack gap-3">
                                        <li>
                                            <strong>Driver Name:</strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ $owners->vehicle->driver->driver_name ?? 'N/A' }}
                                        </li>
                                        <li>
                                            <strong>Authorized Driver Name:</strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ $owners->vehicle->driver->authorized_driver_name ?? 'N/A' }}
                                        </li>
                                        <li>
                                            <strong>Authorized Driver Address:</strong> &nbsp;&nbsp;&nbsp;&nbsp; {{ $owners->vehicle->driver->authorized_driver_address ?? 'N/A' }}
                                        </li>
                                        <li>
                                            <strong>Applied Date:</strong>
                                            @if($owners->vehicle && $owners->vehicle->driver && $owners->vehicle->driver->created_at)
                                            <span>{{ \Carbon\Carbon::parse($owners->vehicle->driver->created_at)->format('d F, Y') }}</span>
                                            @else
                                            <span>N/A</span>
                                            @endif
                                        </li>
                                        <li>
                                            <strong scope="row">Approval Status</strong>
                                            @if($owners->vehicle->driver)
                                            @if($owners->vehicle->driver->approval_status == 'Approved')
                                            <span class="badge badge-soft-success">Approved</span>
                                            @elseif($owners->vehicle->driver->approval_status == 'Rejected')
                                            <span class="badge badge-soft-danger">Rejected</span>
                                            @elseif($owners->vehicle->driver->approval_status == 'Pending')
                                            <span class="badge badge-soft-warning">Pending</span>
                                            @else
                                            <span class="badge badge-soft-secondary">Unknown</span>
                                            @endif
                                            @else
                                            <span class="badge badge-soft-secondary">No Driver Associated</span>
                                            @endif
                                        </li>
                                        <li>
                                            <strong>Reason(If Rejected):</strong> <span>{{ $owners->vehicle->driver->reason ?? 'N/A' }}</span>
                                        </li>
                                    </ul>

                                    <button id="toggleDriverImagesBtn" class="btn btn-primary mb-3">Show Driver Credentials</button>
                                    <div id="driverImages" style="display: none;">
                                        <div class="row">
                                            @if($owners->vehicle && $owners->vehicle->driver)
                                            <div class="col">
                                                <h6>Driver's License Image:</h6>
                                                <!-- Assuming $driversLicenseImage is retrieved from the database -->
                                                <img src="{{ asset('storage/images/drivers/' . ($owners->vehicle->driver->driver_license_image ?? 'N/A')) }}" alt="Driver's License Image" class="img-thumbnail mx-auto d-block img-modal" style="width: 300px; height: 200px;">
                                            </div>
                                            <div class="col">
                                                <h6>Authorized Driver's License Image:</h6>
                                                <!-- Assuming $authorizedDriversLicenseImage is retrieved from the database -->
                                                <img src="{{ asset('storage/images/drivers/' . ($owners->vehicle->driver->authorized_driver_license_image ?? 'N/A')) }}" alt="Authorized Driver's License Image" class="img-thumbnail mx-auto d-block img-modal" style="width: 300px; height: 200px;">
                                            </div>
                                            @else
                                            <div class="col">
                                                <p>No driver information available</p>
                                            </div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- <div class="mt-4">
                                    <span class="badge badge-soft-warning">PHP</span>
                                    <span class="badge badge-soft-warning">Magento</span>
                                    <span class="badge badge-soft-warning">Marketing</span>
                                    <span class="badge badge-soft-warning">WordPress</span>
                                    <span class="badge badge-soft-warning">Bootstrap</span>
                                </div> -->
                                </div>
                            </div>
                        </div><!--end col-->
                    </div><!--end row-->

                </div> <!-- container-fluid -->
            </div><!-- End Page-content -->

            <!-- Modals -->
            @include('applicants.edit_owner')
            @include('applicants.edit_vehicle')
            @include('applicants.edit_driver')
            @include('applicants.show_modals')

            <!-- JS -->
            @include('applicants.show_js')

</body>

</html>
@endsection