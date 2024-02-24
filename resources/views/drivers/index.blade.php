<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>VehiScan | Driver</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

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
                            <h4 class="mb-sm-0 font-size-18">Driver List</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Driver</a></li>
                                    <li class="breadcrumb-item active">Driver List</li>
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
                                    <h5 class="mb-0 card-title flex-grow-1">Driver Lists</h5>
                                    <div class="flex-shrink-0">
                                        <a class="btn btn-success btn-sm my-2" onClick="add()" href="javascript:void(0)"><i class="bi bi-plus-circle"></i> Add Driver</a>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body" id="show_all_drivers">
                                <h1 class="text-center text-secondary my-5"> Loading... </h1>
                            </div>

                            <!-- Add Modal -->
                            <div class="modal fade" id="addDriverModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Add Driver</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>

                                        <div class="modal-body">
                                            <form action="javascript:void(0)" id="add_driver_form" name="add_driver_form" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <!-- Driver's Info -->
                                                <h5>Driver's Info</h5>
                                                <div class="row">
                                                    <div class="col-md">
                                                        <label for="dname">Driver Name</label>
                                                        <input type="text" name="dname" class="form-control" placeholder="Driver Name" required>
                                                        @error('dname')
                                                        <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md">
                                                        <label for="driver_license_image">Driver's License</label>
                                                        <input type="file" name="driver_license_image" class="form-control" required>
                                                        @error('driver_license_image')
                                                        <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <!-- Authorized Driver's Info -->
                                                <h5 class="mt-4">Authorized Driver's Info</h5>
                                                <div class="row">
                                                    <div class="col-md">
                                                        <label for="adname">Authorized Driver Name</label>
                                                        <input type="text" name="adname" class="form-control" placeholder="Authorized Driver Name" required>
                                                        @error('adname')
                                                        <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md">
                                                        <label for="adaddress">Authorized Driver Address</label>
                                                        <input type="text" name="adaddress" class="form-control" placeholder="Authorized Driver Address" required>
                                                        @error('adaddress')
                                                        <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md">
                                                        <label for="authorized_driver_license_image">Authorized Driver's License</label>
                                                        <input type="file" name="authorized_driver_license_image" class="form-control" required>
                                                        @error('authorized_driver_license_image')
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

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" id="add_driver_btn" class="btn btn-primary" id="btn-save">Add Driver</button>
                                                </div>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- End Modal -->

                            <!-- Edit Modal -->
                            <div class="modal fade" id="editDriverModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Driver</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>

                                        <div class="modal-body">
                                            <form action="javascript:void(0)" id="edit_driver_form" name="edit_driver_form" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="driver_id" id="driver_id">
                                                <input type="hidden" name="dlicense_photo" id="dlicense_photo">
                                                <input type="hidden" name="adlicense_photo" id="adlicense_photo">
                                                <!-- Driver's Info -->
                                                <h5>Driver's Info</h5>
                                                <div class="row">
                                                    <div class="col-md">
                                                        <label for="dname">Driver Name</label>
                                                        <input type="text" name="dname" id="dname" class="form-control" placeholder="Driver Name">
                                                        @error('dname')
                                                        <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md">
                                                        <label for="driver_license_image">Driver's License</label>
                                                        <input type="file" name="driver_license_image" class="form-control">
                                                        @error('driver_license_image')
                                                        <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="my-2" id="driver_license_image"></div>
                                                </div>

                                                <!-- Authorized Driver's Info -->
                                                <h5 class="mt-4">Authorized Driver's Info</h5>
                                                <div class="row">
                                                    <div class="col-md">
                                                        <label for="adname">Authorized Driver Name</label>
                                                        <input type="text" name="adname" id="adname" class="form-control" placeholder="Authorized Driver Name">
                                                        @error('adname')
                                                        <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md">
                                                        <label for="adaddress">Authorized Driver Address</label>
                                                        <input type="text" name="adaddress" id="adaddress" class="form-control" placeholder="Authorized Driver Address">
                                                        @error('adaddress')
                                                        <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md">
                                                        <label for="authorized_driver_license_image">Authorized Driver's License</label>
                                                        <input type="file" name="authorized_driver_license_image" class="form-control">
                                                        @error('authorized_driver_license_image')
                                                        <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="my-2" id="authorized_driver_license_image"></div>
                                                    <div class="col-md-2">
                                                        <label for="approval">Approval Status</label>
                                                        <select name="approval" class="form-control" id="approval">
                                                            <option value="Approved" selected>Approved</option>
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

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" id="edit_driver_btn" class="btn btn-primary" id="btn-save">Edit Driver</button>
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
            $('#add_driver_form').trigger("reset");
            $('#DriverModal').html("Add Driver");
            $('#addDriverModal').modal('show');
            $('#id').val('');
        }

        //EDIT
        function edit() {
            $('#edit_driver_form').trigger("reset");
            $('#DriverModal').html("Edit Driver");
            $('#editDriverModal').modal('show');
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

            // add new driver ajax request
            $("#add_driver_form").submit(function(e) {
                e.preventDefault();
                const fd = new FormData(this);
                $("#add_driver_btn").text('Adding...');
                $.ajax({
                    url: '{{ route('drivers.store') }}',
                    method: 'post',
                    data: fd,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 200) {
                            fetchAllDrivers();
                            // Close the modal
                            $("#addDriverModal").modal('hide');
                            Swal.fire(
                                "Successful",
                                "Driver Added Successfully",
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
                        $("#add_driver_btn").text('Add Driver');
                        $("#add_driver_form")[0].reset();
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
                        $("#add_driver_btn").text('Add Driver');
                    }
                });
            });

                // edit driver ajax request
                $(document).on('click', '.editIcon', function(e) {
                e.preventDefault();
                let id = $(this).attr('id');
                $.ajax({
                    url: '{{ route('drivers.edit') }}',
                    method: 'get',
                    data: {
                        id: id,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $("#dname").val(response.driver_name);
                        $("#adname").val(response.authorized_driver_name);
                        $("#adaddress").val(response.authorized_driver_address);
                        $("#approval").val(response.approval_status);
                        $("#reason").val(response.reason);
                        $("#driver_license_image").html(
                            `<img src="storage/images/drivers/${response.driver_license_image}" width="100" class="img-fluid img-thumbnail">`);
                        $("#authorized_driver_license_image").html(
                            `<img src="storage/images/drivers/${response.authorized_driver_license_image}" width="100" class="img-fluid img-thumbnail">`);
                        $("#driver_id").val(response.id);
                        $("#dlicense_photo").val(response.driver_license_image);
                        $("#adlicense_photo").val(response.authorized_driver_license_image)
                    },
                    error: function(xhr, status, error) {
                        // Show error message using SweetAlert if there's an error with the request
                        Swal.fire(
                            "Error",
                            "An error occurred while fetching driver data.",
                            "error"
                        );
                    }
                });
            });

            // update driver ajax request
            $("#edit_driver_form").submit(function(e) {
                e.preventDefault();
                const fd = new FormData(this);
                $("#edit_driver_btn").text('Updating...');
                $.ajax({
                    url: '{{ route('drivers.update') }}',
                    method: 'post',
                    data: fd,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 200) {
                            fetchAllDrivers();
                            // Close the modal
                            $("#editDriverModal").modal('hide');
                            Swal.fire(
                                "Updated",
                                "Driver Updated Successfully",
                                "success"
                            );
                        }
                        $("#edit_driver_btn").text('Update Driver');
                        $("#edit_driver_form")[0].reset();
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
                        $("#edit_driver_btn").text('Update Driver');
                    }
                });
            });

            // delete driver ajax request
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
                        url: '{{ route('drivers.delete') }}',
                        method: 'delete',
                        data: {
                            id: id,
                            _token: csrf
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                Swal.fire(
                                    'Deleted!',
                                    'Driver Deleted Successfully',
                                    'success'
                                );
                                fetchAllDrivers();
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
                                'Failed to delete driver: ' + error,
                                'error'
                            );
                        }
                    });
                }
            });
        });


                // Fetch all drivers via AJAX and initialize DataTable
                fetchAllDrivers();

                function fetchAllDrivers() {
                    $.ajax({
                        url: '{{ route('fetchAllDriver') }}',
                        method: 'get',
                        success: function(response) {
                            $("#show_all_drivers").html(response);
                            // Initialize DataTable after data is loaded into the table
                            $("table").DataTable({
                                order: [0, 'desc']
                            });
                        },
                        error: function(xhr, status, error) {
                            // Log the error to the console for debugging
                            console.error("Error fetching drivers:", error);
                            // Display an error message to the user
                            $("#show_all_drivers").html("<p>Error fetching data. Please try again later.</p>");
                        }
                    });
                }

        });
    </script>

</body>

</html>
@endsection