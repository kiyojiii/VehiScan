<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>VehiScan | Vehicle</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

    <style>
        .wrapper {
            width: 100%; /* Adjust width as needed */
            padding: 0; /* Remove padding */
            height: auto; /* Auto height */
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
                            <h4 class="mb-sm-0 font-size-18">Vehicle List</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Vehicle</a></li>
                                    <li class="breadcrumb-item active">Vehicle List</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->

                @if(auth()->check())
                    <p>Authenticated User ID: {{ auth()->id() }}</p>
                @else
                    <p>User not authenticated</p>
                @endif

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body border-bottom">
                                <div class="d-flex align-items-center">
                                    <h5 class="mb-0 card-title flex-grow-1">Vehicle Lists</h5>
                                    <div class="flex-shrink-0">
                                        <a class="btn btn-success btn-sm my-2" onClick="add()" href="javascript:void(0)"><i class="bi bi-plus-circle"></i> Add Vehicle</a>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body" id="show_all_owners">
                                <h1 class="text-center text-secondary my-5"> Loading... </h1>
                            </div>

                            <!-- Add Modal -->
                            <div class="modal fade" id="addVehicleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Add Vehicle</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>

                                        <div class="modal-body">
                                            <form action="javascript:void(0)" id="add_vehicle_form" name="add_vehicle_form" method="POST" enctype="multipart/form-data">
                                            @csrf
ddd
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" id="add_owner_btn" class="btn btn-primary" id="btn-save">Add Vehicle</button>
                                                </div>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- End Modal -->

         

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

    <script type="text/javascript">
        //CREATE
        function add() {
            $('#add_vehicle_form').trigger("reset");
            $('#VehicleModal').html("Add Vehicle");
            $('#addVehicleModal').modal('show');
            $('#id').val('');
        }

        //EDIT
        function edit() {
            $('#edit_vehicle_form').trigger("reset");
            $('#VehicleModal').html("Edit Vehicle");
            $('#editVehicleModal').modal('show');
            $('#id').val('');
        }
    </script>


</body>

</html>
@endsection