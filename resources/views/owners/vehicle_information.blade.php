<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>VehiScan | Vehicle - Details</title>

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
                            <h4 class="mb-sm-0 font-size-18">Vehicle Information</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Owners</a></li>
                                    <li class="breadcrumb-item">Vehicle Information</li>
                                    <li class="breadcrumb-item active">{{ $vehicles->plate_number }}</li>
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
                                <h5 class="fw-semibold">Overview</h5>

                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <th scope="row">Full Name</th>
                                                <td>{{ $vehicles->owner->first_name ?? 'N/A' }} {{ $vehicles->owner->middle_initial ?? 'N/A' }}. {{ $vehicles->owner->last_name ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="col">Serial Number</th>
                                                <td scope="col">{{ $vehicles->owner->serial_number ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">ID Number</th>
                                                <td>{{ $vehicles->owner->id_number ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Office / Dept. / Agency</th>
                                                <td>{{ $vehicles->owner->office_department_agency ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Position / Designation</th>
                                                <td>{{ $vehicles->owner->position_designation ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Appointment:</h6>
                                                <td>{{ $vehicles->owner->appointment->appointment ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row"> Role Status:</h6>
                                                <td>{{ $vehicles->owner->status->applicant_role_status ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Approval Status</th>
                                                @if($vehicles->owner->approval_status == 'Approved')
                                                <td><span class="badge badge-soft-success">{{ $vehicles->owner->approval_status }}</span></td>
                                                @elseif($vehicles->owner->approval_status == 'Rejected')
                                                <td><span class="badge badge-soft-danger">Rejected</span></td>
                                                @else
                                                <td><span class="badge badge-soft-secondary">Unknown</span></td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="row">Applied Date</th>
                                                <td>{{ \Carbon\Carbon::parse($vehicles->owner->created_at ?? 'N/A')->format('d F, Y') }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Reason(If Rejected)</th>
                                                <td>{{ $vehicles->owner->reason ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Scanned Photo or ID</th>
                                                <td>
                                                    <img src="{{ asset('storage/images/' . $vehicles->owner->scan_or_photo_of_id) ?? 'N/A' }}" alt="scan_or_photo_of_id ID" class="img-thumbnail mx-auto d-block img-modal" style="width: 150px; height: 150px;">
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
                                    @if($vehicles->owner->appointment->appointment != 'Partner/Supplier' && $vehicles->owner->appointment->appointment != 'Supplier')
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
                                                <p class="text-muted fs-14 mb-0">{{ $vehicles->owner->contact_number ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="mt-3">
                                        <div class="d-flex">
                                            <i class="bx bx-mail-send text-primary fs-4"></i>
                                            <div class="ms-3">
                                                <h6 class="fs-14 mb-2">Email</h6>
                                                <p class="text-muted fs-14 mb-0">{{ $vehicles->owner->email_address ?? 'N/A' }}</p>
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
                                                <p class="text-muted fs-14 mb-0">{{ $vehicles->owner->present_address ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                                <div class="mt-4">
                                    <a href=" {{ route('owners.show', $vehicles->owner->id) }}" class="btn btn-soft-danger btn-hover w-100 rounded"><i class="mdi mdi-keyboard-return"></i> Go Back</a>
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
                                        <h5 class="fw-semibold">Vehicle QR Code <button class="btn btn-primary download-btn" data-qrcode="{{ $vehicles->vehicle_code }} "><i class="fas fa-download"></i> Download QR</button></h5>
                                        <ul class="list-unstyled hstack gap-2 mb-0">
                                            <li>
                                                <button id="{{ $vehicles->id }}" class="btn btn-primary mx-1 editIconVehicle" onClick="editVehicle('{{ $vehicles->id }}')">
                                                    <i class="fas fa-car"></i> Edit Vehicle
                                                </button>
                                            </li>
                                            <li>
                                                <button id="{{ $vehicles && $vehicles->driver ? $vehicles->driver->id : 'null' }}" class="btn btn-secondary mx-1 editIconDriver" onClick="editDriver('{{ $vehicles && $vehicles->driver ? $vehicles->driver->id : 'null' }}')">
                                                    <i class="fas fa-address-card"></i> Edit Driver
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <!-- <h5 class="fw-semibold mb-3">Description</h5>
                                <p class="text-muted">We are looking to hire a skilled Magento developer to build and maintain eCommerce websites for our clients. As a Magento developer, you will be responsible for liaising with the design team, setting up Magento 1x and 2x sites, building modules and customizing extensions, testing the performance of each site, and maintaining security and feature updates after the installation is complete.</p> -->

                                <h5 class="fw-semibold mb-3">Vehicle Details:</h5>
                                <ul class="vstack gap-3">
                                    <li>
                                        <strong>Plate Number:</strong>
                                        <span>{{ $vehicles->plate_number ?? 'N/A' }}</span>
                                    </li>
                                    <li>
                                        <strong>Owner Address:</strong>
                                        <span>{{ $vehicles->owner_address ?? 'N/A' }}</span>
                                    </li>
                                    <li>
                                        <strong>Vehicle Make:</strong>
                                        <span>{{ $vehicles->vehicle_make ?? 'N/A' }}</span>
                                    </li>
                                    <li>
                                        <strong>Vehicle Year Model:</strong>
                                        <span>{{ $vehicles->year_model ?? 'N/A' }}</span>
                                    </li>
                                    <li>
                                        <strong>Vehicle Color:</strong>
                                        <span>{{ $vehicles->color ?? 'N/A' }}</span>
                                    </li>
                                    <li>
                                        <strong>Vehicle Body Type:</strong>
                                        <span>{{ $vehicles->body_type ?? 'N/A' }}</span>
                                    </li>
                                    <li>
                                        <strong>Vehicle Status:</strong>
                                        <span>{{ $vehicles->registration_status ?? 'N/A' }}</span>
                                    </li>
                                    <li>
                                        <strong scope="row">Approval Status</strong>
                                        @if($vehicles)
                                        @if($vehicles->approval_status == 'Approved')
                                        <strong><span class="badge badge-soft-success">{{ $vehicles->approval_status }}</span></strong>
                                        @elseif($vehicles->approval_status == 'Rejected')
                                        <strong><span class="badge badge-soft-danger">Rejected</span></strong>
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
                                            @if($vehicles && $vehicles->created_at)
                                            {{ \Carbon\Carbon::parse($vehicles->created_at)->format('d F, Y') }}
                                            @else
                                            N/A
                                            @endif
                                        </span>
                                    </li>
                                    <li>
                                        <strong>Reason(If Rejected):</strong>
                                        <span>{{ $vehicles->reason ?? 'N/A' }}</span>
                                    </li>
                                </ul>

                                <h5 class="fw-semibold mb-3">Vehicle Photos:</h5>
                                <div class="row">
                                    <div class="row">
                                        <div class="col">
                                            <h6>Front Photo:</h6>
                                            @if($vehicles && $vehicles->front_photo)
                                            <!-- Assuming $frontPhotoImage is retrieved from the database -->
                                            <img src="{{ asset('storage/images/vehicles/' . $vehicles->front_photo) }}" alt="front_photo ID" class="img-thumbnail mx-auto d-block img-modal" style="width: 300px; height: 200px;">
                                            @else
                                            <p>No front photo available</p>
                                            @endif
                                        </div>
                                        <div class="col">
                                            <h6>Side Photo:</h6>
                                            @if($vehicles && $vehicles->side_photo)
                                            <!-- Assuming $sidePhotoImage is retrieved from the database -->
                                            <img src="{{ asset('storage/images/vehicles/' . $vehicles->side_photo) }}" alt="side_photo ID" class="img-thumbnail mx-auto d-block img-modal" style="width: 300px; height: 200px;">
                                            @else
                                            <p>No side photo available</p>
                                            @endif
                                        </div>
                                    </div>
                                    <br>
                                    <div class="col">
                                        <br>
                                        <h5 class="fw-semibold mb-3">Vehicle Documents:</h5>
                                        <button id="toggleVehicleImagesBtn" class="btn btn-primary mb-3">Show Vehicle Documents</button>
                                        <div id="vehicleImages" style="display: none;">
                                            <div class="row">
                                                @if($vehicles)
                                                <div class="col">
                                                    <h6>Official Receipt:</h6>
                                                    @if($vehicles->official_receipt_image)
                                                    <!-- Assuming $officialReceiptImage is retrieved from the database -->
                                                    <img src="{{ asset('storage/images/vehicles/documents/' . $vehicles->official_receipt_image) }}" alt="official_receipt_image ID" class="img-thumbnail mx-auto d-block img-modal" style="width: 300px; height: 200px;">
                                                    @else
                                                    <p>No official receipt available</p>
                                                    @endif
                                                </div>
                                                <div class="col">
                                                    <h6>Cert. of Register:</h6>
                                                    @if($vehicles->certificate_of_registration_image)
                                                    <!-- Assuming $certificateOfRegistrationImage is retrieved from the database -->
                                                    <img src="{{ asset('storage/images/vehicles/documents/' . $vehicles->certificate_of_registration_image) }}" alt="certificate_of_registration_image ID" class="img-thumbnail mx-auto d-block img-modal" style="width: 300px; height: 200px;">
                                                    @else
                                                    <p>No certificate of registration available</p>
                                                    @endif
                                                </div>
                                                <div class="col">
                                                    <h6>Deed of Sale:</h6>
                                                    @if($vehicles->deed_of_sale_image)
                                                    <!-- Assuming $deedOfSaleImage is retrieved from the database -->
                                                    <img src="{{ asset('storage/images/vehicles/documents/' . $vehicles->deed_of_sale_image) }}" alt="deed_of_sale_image ID" class="img-thumbnail mx-auto d-block img-modal" style="width: 300px; height: 200px;">
                                                    @else
                                                    <p>No deed of sale available</p>
                                                    @endif
                                                </div>
                                                <div class="col">
                                                    <h6>Authorization:</h6>
                                                    @if($vehicles->authorization_letter_image)
                                                    <img src="{{ asset('storage/images/vehicles/documents/' . $vehicles->authorization_letter_image) }}" alt="authorization_letter_image ID" class="img-thumbnail mx-auto d-block img-modal" style="width: 300px; height: 200px;">
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
                                            <strong>Driver Name:</strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ $vehicles->driver->driver_name ?? 'N/A' }}
                                        </li>
                                        <li>
                                            <strong>Authorized Driver Name:</strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ $vehicles->driver->authorized_driver_name ?? 'N/A' }}
                                        </li>
                                        <li>
                                            <strong>Authorized Driver Address:</strong> &nbsp;&nbsp;&nbsp;&nbsp; {{ $vehicles->driver->authorized_driver_address ?? 'N/A' }}
                                        </li>
                                        <li>
                                            <strong>Applied Date:</strong>
                                            @if($vehicles && $vehicles->driver && $vehicles->driver->created_at)
                                            <span>{{ \Carbon\Carbon::parse($vehicles->driver->created_at)->format('d F, Y') }}</span>
                                            @else
                                            <span>N/A</span>
                                            @endif
                                        </li>
                                        <li>
                                            <strong scope="row">Approval Status</strong>
                                            @if($vehicles && $vehicles->driver->approval_status)
                                            @if($vehicles->driver->approval_status == 'Approved')
                                            <span class="badge badge-soft-success">{{ $vehicles->driver->approval_status }}</span>
                                            @elseif($vehicles->driver->approval_status == 'Rejected')
                                            <span class="badge badge-soft-danger">{{ $vehicles->driver->approval_status }}</span>
                                            @else
                                            <span class="badge badge-soft-secondary">{{ $vehicles->driver->approval_status }}</span>
                                            @endif
                                            @else
                                            <span class="badge badge-soft-secondary">No Driver Associated</span>
                                            @endif
                                        </li>
                                        <li>
                                            <strong>Reason(If Rejected):</strong> <span>{{ $vehicles->driver->reason ?? 'N/A' }}</span>
                                        </li>
                                    </ul>

                                    <h5 class="fw-semibold mb-3">Driver Credentials:</h5>
                                    <button id="toggleDriverImagesBtn" class="btn btn-primary mb-3">Show Driver Credentials</button>
                                    <div id="driverImages" style="display: none;">
                                        <div class="row">
                                            @if($vehicles && $vehicles->driver)
                                            <div class="col">
                                                <h6>Driver's License Image:</h6>
                                                <!-- Assuming $driversLicenseImage is retrieved from the database -->
                                                <img src="{{ asset('storage/images/drivers/' . ($vehicles->driver->driver_license_image ?? 'N/A')) }}" alt="Driver's License Image" class="img-thumbnail mx-auto d-block img-modal" style="width: 300px; height: 200px;">
                                            </div>
                                            <div class="col">
                                                <h6>Authorized Driver's License Image:</h6>
                                                <!-- Assuming $authorizedDriversLicenseImage is retrieved from the database -->
                                                <img src="{{ asset('storage/images/drivers/' . ($vehicles->driver->authorized_driver_license_image ?? 'N/A')) }}" alt="Authorized Driver's License Image" class="img-thumbnail mx-auto d-block img-modal" style="width: 300px; height: 200px;">
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

            @include('owners.vehicle_information_js')
            @include('applicants.show_modals')
            @include('owners.edit_vehicle')
            @include('owners.edit_driver')
</body>

</html>
@endsection