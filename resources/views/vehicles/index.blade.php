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

                            <div class="card-body" id="show_all_vehicles">
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
                                        <div class="row mb-3">
                                            <h4>Vehicle Information</h4>
                                            <div class="col-md-6">
                                                <label for="driver_id">Driver Name</label>
                                                <select name="driver_id" id="driver_id" class="form-control" onfocus='this.size=3;' onblur='this.size=1;' onchange='this.size=1; this.blur();'>
                                                    <option value="">Select Driver</option> <!-- Placeholder option -->
                                                    @forelse($drivers as $driver)
                                                        <option value="{{ $driver->id }}">{{ $driver->driver_name }}</option>
                                                    @empty
                                                        <option value="">No driver Available</option>
                                                    @endforelse
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="owner_address" class="form-label">Owner Address</label>
                                                <input type="text" class="form-control" name="owner_address">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="plate_number" class="form-label">Plate Number</label>
                                                <input type="text" class="form-control" name="plate_number">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="vehicle_make" class="form-label">Vehicle Make</label>
                                                <input type="text" class="form-control" name="vehicle_make">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="year_model" class="form-label">Year Model</label>
                                                <input type="text" class="form-control" name="year_model">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-2">
                                                <label for="color" class="form-label">Color</label>
                                                <input type="text" class="form-control" name="color">
                                            </div>
                                            <div class="col-md-2">
                                                <label for="body_type" class="form-label">Body Type</label>
                                                <input type="text" class="form-control" name="body_type">
                                            </div>
                                            <div class="col-md-2">
                                                <label for="registration_status">Status</label>
                                                <select name="registration_status" class="form-control">
                                                    <option value="Active" selected>Active</option>
                                                    <option value="Inactive">Inactive</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                                @error('registration_status')   
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-2">
                                                <label for="approval">Approval Status</label>
                                                <select name="approval" class="form-control" id="approvalStatus" required>
                                                    <option value="Approved" selected>Approved</option>
                                                    <option value="Rejected">Rejected</option>
                                                    <option value="Pending">Pending</option>
                                                </select>
                                                @error('approval')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md" id="reasonField" style="display: none;">
                                                <label for="reason">Reason for Rejection</label>
                                                <input type="text" name="reason" class="form-control" placeholder="Reason for Rejection">
                                                @error('reason')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <h4>Vehicle Documents</h4>
                                            <div class="col-md-6">
                                                <label for="official_receipt_image" class="form-label">Official Receipt Image</label>
                                                <input type="file" class="form-control" name="official_receipt_image">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="certificate_of_registration_image" class="form-label">Certificate of Registration Image</label>
                                                <input type="file" class="form-control" name="certificate_of_registration_image">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="deed_of_sale_image" class="form-label">Deed of Sale Image</label>
                                                <input type="file" class="form-control" name="deed_of_sale_image">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="authorization_letter_image" class="form-label">Authorization Letter Image</label>
                                                <input type="file" class="form-control" name="authorization_letter_image">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <h4>Vehicle Images</h4>
                                            <div class="col-md-6">
                                                <label for="front_photo" class="form-label">Front Photo</label>
                                                <input type="file" class="form-control" name="front_photo">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="side_photo" class="form-label">Side Photo</label>
                                                <input type="file" class="form-control" name="side_photo">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" id="add_vehicle_btn" class="btn btn-primary" id="btn-save">Add Vehicle</button>
                                        </div>
                                    </form>
                                </div>

                                    </div>
                                </div>
                            </div>
                            <!-- End Modal -->

                            <!-- Edit Modal -->
                            <div class="modal fade" id="editVehicleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Vehicle</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>

                            <div class="modal-body">
                                    <form action="javascript:void(0)" id="edit_vehicle_form" name="edit_vehicle_form" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="vehicle_id" id="vehicle_id">
                                        <input type="hidden" name="official_receipt_image_photo" id="official_receipt_image_photo">
                                        <input type="hidden" name="certificate_of_registration_image_photo" id="certificate_of_registration_image_photo">
                                        <input type="hidden" name="deed_of_sale_image_photo" id="deed_of_sale_image_photo">
                                        <input type="hidden" name="authorization_letter_image_photo" id="authorization_letter_image_photo">
                                        <input type="hidden" name="front_photo_photo" id="front_photo_photo">
                                        <input type="hidden" name="side_photo_photo" id="side_photo_photo">
                                        <div class="row mb-3">
                                            <h4>Vehicle Information</h4>
                                            <div class="col-md-6">
                                                <label for="position">Driver Name</label>
                                                <select name="driver_name" id="driver_name" class="form-control" onfocus='this.size=3;' onblur='this.size=1;' onchange='this.size=1; this.blur();'>
                                                    <option value="">Select Driver</option> <!-- Placeholder option -->
                                                    @forelse($drivers as $driver)
                                                        <option value="{{ $driver->id }}">{{ $driver->driver_name }}</option>
                                                    @empty
                                                        <option value="">No driver Available</option>
                                                    @endforelse
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="owner_address" class="form-label">Owner Address</label>
                                                <input type="text" class="form-control" id="owner_address" name="owner_address">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="plate_number" class="form-label">Plate Number</label>
                                                <input type="text" class="form-control" id="plate_number" name="plate_number">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="vehicle_make" class="form-label">Vehicle Make</label>
                                                <input type="text" class="form-control" id="vehicle_make" name="vehicle_make">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="year_model" class="form-label">Year Model</label>
                                                <input type="text" class="form-control" id="year_model" name="year_model">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-2">
                                                <label for="color" class="form-label">Color</label>
                                                <input type="text" class="form-control" id="color" name="color">
                                            </div>
                                            <div class="col-md-2">
                                                <label for="body_type" class="form-label">Body Type</label>
                                                <input type="text" class="form-control" id="body_type" name="body_type">
                                            </div>
                                            <div class="col-md-2">
                                                <label for="registration_status">Status</label>
                                                <select name="registration_status" class="form-control" id="registration_status" required>
                                                    <option value="Active">Active</option>
                                                    <option value="Inactive">Inactive</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                                @error('registration_status')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-2">
                                                <label for="approval">Approval Status</label>
                                                <select name="approval" class="form-control" id="approval_status" required>
                                                    <option value="Approved">Approved</option>
                                                    <option value="Rejected">Rejected</option>
                                                    <option value="Pending">Pending</option>
                                                </select>
                                                @error('approval')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md" id="reasonField">
                                                <label for="reason">Reason for Rejection</label>
                                                <input type="text" name="reason" id="reason" class="form-control" placeholder="Reason for Rejection">
                                                @error('reason')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <h4>Vehicle Documents</h4>
                                            <div class="col-md-6">
                                                <label for="official_receipt_image" class="form-label">Official Receipt Image</label>
                                                <input type="file" class="form-control" name="official_receipt_image">
                                            </div>
                                            <div class="my-2" id="official_receipt_image"></div>
                                            <div class="col-md-6">
                                                <label for="certificate_of_registration_image" class="form-label">Certificate of Registration Image</label>
                                                <input type="file" class="form-control" name="certificate_of_registration_image">
                                            </div>
                                            <div class="my-2" id="certificate_of_registration_image"></div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="my-2" id="official_receipt_image"></div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="my-2" id="certificate_of_registration_image"></div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="deed_of_sale_image" class="form-label">Deed of Sale Image</label>
                                                <input type="file" class="form-control" name="deed_of_sale_image">
                                            </div>
                                            <div class="my-2" id="deed_of_sale_image"></div>
                                            <div class="col-md-6">
                                                <label for="authorization_letter_image" class="form-label">Authorization Letter Image</label>
                                                <input type="file" class="form-control" name="authorization_letter_image">
                                            </div>
                                            <div class="my-2" id="authorization_letter_image"></div>
                                        </div>
                                        <div class="row mb-3">
                                            <h4>Vehicle Images</h4>
                                            <div class="col-md-6">
                                                <label for="front_photo" class="form-label">Front Photo</label>
                                                <input type="file" class="form-control" name="front_photo">
                                            </div>
                                            <div class="my-2" id="front_photo"></div>
                                            <div class="col-md-6">
                                                <label for="side_photo" class="form-label">Side Photo</label>
                                                <input type="file" class="form-control" name="side_photo">
                                            </div>
                                            <div class="my-2" id="side_photo"></div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" id="edit_vehicle_btn" class="btn btn-primary" id="btn-save">Edit Vehicle</button>
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

    <!-- Show Reason if Rejected -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const approvalStatus = document.getElementById("approvalStatus");
            const reasonField = document.getElementById("reasonField");

            // Show/hide reason input field based on approval status
            approvalStatus.addEventListener("change", function() {
                if (this.value === "Rejected") {
                    reasonField.style.display = "block";
                } else {
                    reasonField.style.display = "none";
                }
            });
        });
    </script>

    <script>
        $(function() {

            // add new vehicle ajax request
            $("#add_vehicle_form").submit(function(e) {
                e.preventDefault();
                const fd = new FormData(this);
                $("#add_vehicle_btn").text('Adding...');
                $.ajax({
                    url: '{{ route('vehicles.store') }}',
                    method: 'post',
                    data: fd,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 200) {
                            fetchAllVehicles();
                            // Close the modal
                            $("#addVehicleModal").modal('hide');
                            Swal.fire(
                                "Successful",
                                "Vehicle Added Successfully",
                                "success"
                            )
                        } else {
                            // Show error message using SweetAlert
                            Swal.fire(
                                "Error",
                                response.message,
                                "error"
                            )
                        }
                        $("#add_vehicle_btn").text('Add Vehicle');
                        $("#add_vehicle_form")[0].reset();
                    },
                    error: function(xhr, status, error) {
                            // Parse JSON response to extract specific error message and display it using SweetAlert
                            const response = JSON.parse(xhr.responseText);
                            const errorMessage = response.message;
                            Swal.fire(
                                "Error",
                                errorMessage,
                                "error"
                            );
                        $("#add_vehicle_btn").text('Add Vehicle');
                    }
                });
            });

            // edit vehicle ajax request
            $(document).on('click', '.editIcon', function(e) {
                e.preventDefault();
                let id = $(this).attr('id');
                $.ajax({
                    url: '{{ route('vehicles.edit') }}',
                    method: 'get',
                    data: {
                        id: id,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $("#driver_name").val(response.driver_id);
                        $("#owner_address").val(response.owner_address);
                        $("#plate_number").val(response.plate_number);
                        $("#vehicle_make").val(response.vehicle_make);
                        $("#year_model").val(response.year_model);
                        $("#color").val(response.color);
                        $("#body_type").val(response.body_type);
                        $("#registration_status").val(response.registration_status);
                        $("#approval_status").val(response.approval_status);
                        $("#reason").val(response.reason);
                        $("#official_receipt_image").html(
                            `<img src="storage/images/vehicles/documents/${response.official_receipt_image}" width="100" class="img-fluid img-thumbnail">`);
                        $("#certificate_of_registration_image").html(
                            `<img src="storage/images/vehicles/documents/${response.certificate_of_registration_image}" width="100" class="img-fluid img-thumbnail">`);
                        $("#deed_of_sale_image").html(
                            `<img src="storage/images/vehicles/documents/${response.deed_of_sale_image}" width="100" class="img-fluid img-thumbnail">`);
                        $("#authorization_letter_image").html(
                            `<img src="storage/images/vehicles/documents/${response.authorization_letter_image}" width="100" class="img-fluid img-thumbnail">`);
                        $("#front_photo").html(
                            `<img src="storage/images/vehicles/${response.front_photo}" width="100" class="img-fluid img-thumbnail">`);
                        $("#side_photo").html(
                            `<img src="storage/images/vehicles/${response.side_photo}" width="100" class="img-fluid img-thumbnail">`);
                        $("#vehicle_id").val(response.id);
                        $("#official_receipt_image_photo").val(response.official_receipt_image);
                        $("#certificate_of_registration_image_photo").val(response.certificate_of_registration_image)
                        $("#deed_of_sale_image_photo").val(response.deed_of_sale_image);
                        $("#authorization_letter_image_photo").val(response.authorization_letter_image)
                        $("#front_photo_photo").val(response.front_photo);
                        $("#side_photo_photo").val(response.side_photo)
                    },
                    error: function(xhr, status, error) {
                        // Show error message using SweetAlert if there's an error with the request
                        Swal.fire(
                            "Error",
                            "An error occurred while fetching vehicle data.",
                            "error"
                        );
                    }
                });
            });

            // update vehicle ajax request
            $("#edit_vehicle_form").submit(function(e) {
                e.preventDefault();
                const fd = new FormData(this);
                $("#edit_vehicle_btn").text('Updating...');
                $.ajax({
                    url: '{{ route('vehicles.update') }}',
                    method: 'post',
                    data: fd,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 200) {
                            fetchAllVehicles();
                            // Close the modal
                            $("#editVehicleModal").modal('hide');
                            Swal.fire(
                                "Updated",
                                "Vehicle Updated Successfully",
                                "success"
                            );
                        }
                        $("#edit_vehicle_btn").text('Update Vehicle');
                        $("#edit_vehicle_form")[0].reset();
                    },
                    error: function(xhr, status, error) {
                            // Parse JSON response to extract specific error message and display it using SweetAlert
                            const response = JSON.parse(xhr.responseText);
                            const errorMessage = response.message;
                            Swal.fire(
                                "Error",
                                errorMessage,
                                "error"
                            );
                        $("#edit_vehicle_btn").text('Update Vehicle');
                    }
                });
            });

            // delete vehicle ajax request
            $(document).on('click', '.deleteIcon', function(e) {
            e.preventDefault();
            let id = $(this).attr('id');
            let csrf = '{{ csrf_token() }}';
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('vehicles.delete') }}',
                        method: 'delete',
                        data: {
                            id: id,
                            _token: csrf
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                Swal.fire(
                                    'Deleted!',
                                    'Vehicle Deleted Successfully',
                                    'success'
                                );
                                fetchAllVehicles();
                            } else {
                                Swal.fire(
                                    'Error!',
                                    response.message,
                                    'error'
                                );
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire(
                                'Error!',
                                'Failed to delete vehicle: ' + error,
                                'error'
                            );
                        }
                    });
                }
            });
        });

                // Fetch all vehicles via AJAX and initialize DataTable
                fetchAllVehicles();

                function fetchAllVehicles() {
                    $.ajax({
                        url: '{{ route('fetchAllVehicle') }}',
                        method: 'get',
                        success: function(response) {
                            $("#show_all_vehicles").html(response);
                            // Initialize DataTable after data is loaded into the table
                            $("table").DataTable({
                                order: [0, 'desc']
                            });
                        },
                        error: function(xhr, status, error) {
                            // Log the error to the console for debugging
                            console.error("Error fetching vehicles:", error);
                            // Display an error message to the user
                            $("#show_all_vehicles").html("<p>Error fetching data. Please try again later.</p>");
                        }
                    });
                }

        });
    </script>

</body>

</html>
@endsection