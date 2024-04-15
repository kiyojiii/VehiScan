<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> MVIS | Scratch </title>

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

    <!-- Additional Script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/3.3.3/adapter.min.js" integrity="sha512-FZkQmTcqSzV2aNpWszYA/pPUISx6QjI60lKGwnIsfNFCGqUB7gcobQ9StH3hQCKFN92md3fCaXLzzSpoFat57A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.min.js" integrity="sha512-0iiTIkY3h448LMfv6vcOAgwsnSIQ4QYgSyAbyWDtqrig7Xc8PAukJjyXCeYxVGncMyIbd6feVBRwoRayeEvmJQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
</head>

<body>

    <!-- Add this style to adjust z-index -->
    <style>
        .select2-container--open {
            z-index: 1600 !important;
            /* Adjust the z-index as needed */
        }
    </style>

    @extends('layouts.app4')

    @section('content')
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <video id="qr_scanner" width="100%"></video>
                        </div>
                        <div class="col-md-3">
                            QR SCANNED DATA
                            <input name="record" id="record" class="form-control" placeholder="" onfocus="this.value=''" readonly></input>
                        </div>
                    </div>
                </div>

                <!-- Include the Bootstrap modal in your HTML -->
                <div class="modal fade" id="vehicleModal" tabindex="-1" role="dialog" aria-labelledby="vehicleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="vehicleModalLabel">Vehicle Information</h5>
                                <button type="button" class="close" aria-label="Close" onclick="closeVehicleModal()">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <span>
                                    <h4> Applicant Information </h4>
                                </span>
                                <p><strong>Serial Number:</strong> <span id="serial_number"></span></p>
                                <p><strong>ID Number:</strong> <span id="id_number"></span></p>
                                <p><strong>Name:</strong> <span id="full_name"></span></p>
                                <br>
                                <span>
                                    <h4> Vehicle Details </h4>
                                </span>
                                <p><strong>Plate Number:</strong> <span id="plate_number"></span></p>
                                <p><strong>Owner Name:</strong> <span id="owner_name"></span></p>
                                <p><strong>Vehicle Make:</strong> <span id="vehicle_make"></span></p>
                                <p><strong>Year Model:</strong> <span id="year_model"></span></p>
                                <p><strong>Body Type:</strong> <span id="body_type"></span></p>
                                <p><strong>Color:</strong> <span id="color"></span></p>
                                <p><strong>Registration Status:</strong> <span id="registration_status"></span></p>
                                <p><strong>Approval Status:</strong> <span id="approval_status"></span></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeVehicleModal()">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    // Function to close the modal manually
                    function closeVehicleModal() {
                        $('#vehicleModal').modal('hide');
                    }
                </script>

            </div> <!-- container-fluid -->
        </div><!-- End Page-content -->

    </div>
    <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

    @include('test_js')

</body>

</html>
@endsection