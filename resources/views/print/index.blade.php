<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MVIS | {{ $owners->vehicle->plate_number }} - Documents</title>

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

        @media print {
            .page-break {
                page-break-after: always;
                /* Force a page break after this element */
            }
        }
    </style>
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-6 page-break">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <h5 class="fw-semibold me-3">ID Documents</h5>
                                    <div class="d-print-none">
                                        <div class="dropdown">
                                            <a href="javascript:window.print()" class="btn btn-success waves-effect waves-light me-1"><i class="fa fa-print"></i> Print Documents </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="row">
                                        <div class="col">
                                            <h6>Scanned ID:</h6>
                                            <img src="{{ asset('storage/images/' . $owners->scan_or_photo_of_id) ?? 'N/A' }}" alt="scan_or_photo_of_id ID" class="img-thumbnail mx-auto d-block img-modal" style="width: 300px; height: 250px;">
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="row">
                                        @if($owners->vehicle && $owners->vehicle->driver)
                                        <div class="col-6">
                                            <h6>Driver's License:</h6>
                                            <!-- Assuming $driversLicenseImage is retrieved from the database -->
                                            <img src="{{ asset('storage/images/drivers/' . ($owners->vehicle->driver->driver_license_image ?? 'N/A')) }}" alt="Driver's License Image" class="img-thumbnail mx-auto d-block img-modal" style="width: 300px; height: 250px;">
                                        </div>
                                        <div class="col-6">
                                            <h6>Authorized Driver's License:</h6>
                                            <!-- Assuming $authorizedDriversLicenseImage is retrieved from the database -->
                                            <img src="{{ asset('storage/images/drivers/' . ($owners->vehicle->driver->authorized_driver_license_image ?? 'N/A')) }}" alt="No Authorized Driver" class="img-thumbnail mx-auto d-block img-modal" style="width: 300px; height: 250px;">
                                        </div>
                                        @else
                                        <div class="col">
                                            <p>No driver information available</p>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <br>
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
                                </div>
                            </div>
                        </div>

                    </div><!--end col-->
                    <!-- <div class="d-print-none"> -->
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="fw-semibold mb-3">Vehicle Documents:</h5>
                                <div class="row">
                                    <div class="row mb-4">
                                        <div class="row">
                                            @if($owners->vehicle)
                                            <div class="col">
                                                <h6>Official Receipt:</h6>
                                                @if($owners->vehicle->official_receipt_image)
                                                <!-- Assuming $officialReceiptImage is retrieved from the database -->
                                                <img src="{{ asset('storage/images/vehicles/documents/' . $owners->vehicle->official_receipt_image) }}" alt="official_receipt_image ID" class="img-thumbnail mx-auto d-block img-modal" style="width: 325px; height: 400px;">
                                                @else
                                                <p>No official receipt available</p>
                                                @endif
                                            </div>
                                            <div class="col">
                                                <h6>Cert. of Register:</h6>
                                                @if($owners->vehicle->certificate_of_registration_image)
                                                <!-- Assuming $certificateOfRegistrationImage is retrieved from the database -->
                                                <img src="{{ asset('storage/images/vehicles/documents/' . $owners->vehicle->certificate_of_registration_image) }}" alt="certificate_of_registration_image ID" class="img-thumbnail mx-auto d-block img-modal" style="width: 325px; height: 400px;">
                                                @else
                                                <p>No certificate of registration available</p>
                                                @endif
                                            </div>
                                            @else
                                            <p>No vehicle information available</p>
                                            @endif
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="row">
                                            @if($owners->vehicle)
                                            <div class="col">
                                                <h6>Deed of Sale:</h6>
                                                @if($owners->vehicle->deed_of_sale_image)
                                                <!-- Assuming $deedOfSaleImage is retrieved from the database -->
                                                <img src="{{ asset('storage/images/vehicles/documents/' . $owners->vehicle->deed_of_sale_image) }}" alt="deed_of_sale_image ID" class="img-thumbnail mx-auto d-block img-modal" style="width: 325px; height: 400px;">
                                                @else
                                                <p>No deed of sale available</p>
                                                @endif
                                            </div>
                                            <div class="col">
                                                <h6>Authorization:</h6>
                                                @if($owners->vehicle->authorization_letter_image)
                                                <img src="{{ asset('storage/images/vehicles/documents/' . $owners->vehicle->authorization_letter_image) }}" alt="authorization_letter_image" class="img-thumbnail mx-auto d-block img-modal" style="width: 325px; height: 400px;">
                                                @else
                                                <p>No authorization letter available</p>
                                                @endif
                                            </div>
                                            @else
                                            <p>No vehicle information available</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!--end col-->
                    </div><!--end row-->
                    <!-- </div> -->
                </div><!--end main row-->
            </div> <!-- container-fluid -->
        </div><!-- End Page-content -->
    </div><!-- end main content -->

    @include('applicants.show_modals')
    <!-- JS -->
    @include('applicants.show_js')
</body>

</html>
@endsection