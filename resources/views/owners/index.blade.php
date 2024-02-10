<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>VehiScan | Owner</title>

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
                            <h4 class="mb-sm-0 font-size-18">Owner List</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Owner</a></li>
                                    <li class="breadcrumb-item active">Owner List</li>
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
                                    <h5 class="mb-0 card-title flex-grow-1">Owner Lists</h5>
                                    <div class="flex-shrink-0">
                                        <a class="btn btn-success btn-sm my-2" onClick="add()" href="javascript:void(0)"><i class="bi bi-plus-circle"></i> Add Owner</a>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body" id="show_all_owners">
                                <h1 class="text-center text-secondary my-5"> Loading... </h1>
                            </div>

                            <!-- Add Modal -->
                            <div class="modal fade" id="addOwnerModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Add Owner</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>

                                        <div class="modal-body">
                                            <form action="javascript:void(0)" id="add_owner_form" name="add_owner_form" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="col-lg">  
                                                <!-- Personal Info -->
                                                <h5>Personal Info</h5>
                                                <div class="row">
                                                    <div class="col-md">
                                                        <label for="fname">First Name</label>
                                                        <input type="text" name="fname" class="form-control" placeholder="First Name" required>
                                                    </div>
                                                    <div class="col-md">
                                                        <label for="mi">Middle Initial</label>
                                                        <input type="text" name="mi" class="form-control" placeholder="Middle Initial" required>
                                                    </div>
                                                    <div class="col-md">
                                                        <label for="lname">Last Name</label>
                                                        <input type="text" name="lname" class="form-control" placeholder="Last Name" required>
                                                    </div>
                                                </div>

                                                <!-- Contact Info -->
                                                <h5 class="mt-4">Contact Info</h5>
                                                <div class="row">
                                                    <div class="col-md">
                                                        <label for="paddress">Present Address</label>
                                                        <input type="text" name="paddress" class="form-control" placeholder="Present Address" required>
                                                    </div>
                                                    <div class="col-md">
                                                        <label for="email">Email Address</label>
                                                        <input type="text" name="email" class="form-control" placeholder="Email Address" required>
                                                    </div>
                                                    <div class="col-md">
                                                        <label for="contact">Contact Number</label>
                                                        <input type="text" name="contact" class="form-control" placeholder="Contact" required>
                                                    </div>
                                                </div>

                                                <!-- Work Info -->
                                                <h5 class="mt-4">Work Info</h5>
                                                <div class="row">
                                                    <div class="col-md">
                                                        <label for="position">Position & Designation</label>
                                                        <input type="text" name="position" class="form-control" placeholder="Position & Designation" required>     
                                                    </div>

                                                    <div class="col-md">
                                                        <div class="wrapper">
                                                        <label for="position">Appointment</label>
                                                            <select name="appointment" class="form-control" onfocus='this.size=3;' onblur='this.size=1;' onchange='this.size=1; this.blur();'>
                                                                <option value="">Select Appointment</option> <!-- Placeholder option -->
                                                                @forelse($appointments as $appointment)
                                                                    <option value="{{ $appointment->id }}">{{ $appointment->appointment }}</option>
                                                                @empty
                                                                    <option value="">No Appointments Available</option>
                                                                @endforelse
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md">
                                                        <div class="wrapper">
                                                        <label for="role_status">Role Status</label>
                                                            <select name="role_status" class="form-control" onfocus='this.size=3;' onblur='this.size=1;' onchange='this.size=1; this.blur();'>
                                                            <option value="">Select Role Status</option> <!-- Placeholder option -->
                                                                @forelse($role_status as $rs)
                                                                    <option value="{{ $rs->id }}">{{ $rs->applicant_role_status }}</option>
                                                                @empty
                                                                    <option value="">No Role Status Available</option>
                                                                @endforelse
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md">
                                                        <label for="department">Office/Department/Agency</label>
                                                        <input type="text" name="department" class="form-control" placeholder="Office/Department/Agency" required>
                                                    </div>
                                                </div>

                                                <!-- Photo & Approval Status -->
                                                <h5 class="mt-4">Photo & Approval Status</h5>
                                                <div class="row">
                                                    <div class="col-md">
                                                        <label for="scan_or_photo_of_id">Photo</label>
                                                        <input type="file" name="scan_or_photo_of_id" class="form-control" required>
                                                    </div>
                                                    <div class="col-md">
                                                        <label for="approval">Approval Status</label>
                                                        <select name="approval" class="form-control" id="approvalStatus" required>
                                                            <option value="Approved" selected>Approved</option>
                                                            <option value="Rejected">Rejected</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md" id="reasonField" style="display: none;">
                                                        <label for="reason">Reason for Rejection</label>
                                                        <input type="text" name="reason" class="form-control" placeholder="Reason for Rejection">
                                                    </div>
                                                </div>
                                            </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" id="add_owner_btn" class="btn btn-primary" id="btn-save">Add Owner</button>
                                                </div>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- End Modal -->

                            
                            <!-- Edit Modal -->
                            <div class="modal fade" id="editOwnerModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Owner</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>

                                        <div class="modal-body">
                                            <form action="javascript:void(0)" id="edit_owner_form" name="edit_owner_form" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="col-lg">  
                                                <input type="hidden" name="owner_id" id="owner_id">
                                                <input type="hidden" name="owner_photo" id="owner_photo">
                                                <!-- Personal Info -->
                                                <h5>Personal Info</h5>
                                                <div class="row">
                                                    <div class="col-md">
                                                        <label for="fname">First Name</label>
                                                        <input type="text" name="fname" id="fname" class="form-control" placeholder="First Name" required>
                                                    </div>
                                                    <div class="col-md">
                                                        <label for="mi">Middle Initial</label>
                                                        <input type="text" name="mi" id="mi" class="form-control" placeholder="Middle Initial" required>
                                                    </div>
                                                    <div class="col-md">
                                                        <label for="lname">Last Name</label>
                                                        <input type="text" name="lname" id="lname" class="form-control" placeholder="Last Name" required>
                                                    </div>
                                                </div>

                                                <!-- Contact Info -->
                                                <h5 class="mt-4">Contact Info</h5>
                                                <div class="row">
                                                    <div class="col-md">
                                                        <label for="paddress">Present Address</label>
                                                        <input type="text" name="paddress" id="paddress" class="form-control" placeholder="Present Address" required>
                                                    </div>
                                                    <div class="col-md">
                                                        <label for="email">Email Address</label>
                                                        <input type="text" name="email" id="email" class="form-control" placeholder="Email Address" required>
                                                    </div>
                                                    <div class="col-md">
                                                        <label for="contact">Contact Number</label>
                                                        <input type="text" name="contact" id="contact" class="form-control" placeholder="Contact" required>
                                                    </div>
                                                </div>

                                                <!-- Work Info -->
                                                <h5 class="mt-4">Work Info</h5>
                                                <div class="row">
                                                    <div class="col-md">
                                                        <label for="position">Position & Designation</label>
                                                        <input type="text" name="position" id="position" class="form-control" placeholder="Position & Designation" required>     
                                                    </div>

                                                    <div class="col-md">
                                                        <div class="wrapper">
                                                        <label for="position">Appointment</label>
                                                            <select name="appointment" id="appointment" class="form-control" onfocus='this.size=3;' onblur='this.size=1;' onchange='this.size=1; this.blur();'>
                                                                <option value="">Select Appointment</option> <!-- Placeholder option -->
                                                                @forelse($appointments as $appointment)
                                                                    <option value="{{ $appointment->id }}">{{ $appointment->appointment }}</option>
                                                                @empty
                                                                    <option value="">No Appointments Available</option>
                                                                @endforelse
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md">
                                                        <div class="wrapper">
                                                        <label for="role_status">Role Status</label>
                                                            <select name="role_status" id="role_status" class="form-control" onfocus='this.size=3;' onblur='this.size=1;' onchange='this.size=1; this.blur();'>
                                                            <option value="">Select Role Status</option> <!-- Placeholder option -->
                                                                @forelse($role_status as $rs)
                                                                    <option value="{{ $rs->id }}">{{ $rs->applicant_role_status }}</option>
                                                                @empty
                                                                    <option value="">No Role Status Available</option>
                                                                @endforelse
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md">
                                                        <label for="department">Office/Department/Agency</label>
                                                        <input type="text" name="department" id="department" class="form-control" placeholder="Office/Department/Agency" required>
                                                    </div>
                                                </div>

                                                <!-- Photo & Approval Status -->
                                                <h5 class="mt-4">Photo & Approval Status</h5>
                                                <div class="row">
                                                    <div class="col-md">
                                                        <label for="scan_or_photo_of_id">Photo</label>
                                                        <input type="file" name="scan_or_photo_of_id" class="form-control">
                                                    </div>
                                                    <div class="col-md">
                                                        <label for="approval">Approval Status</label>
                                                        <select name="approval" id="approval" class="form-control" required>
                                                            <option value="Approved" selected>Approved</option>
                                                            <option value="Rejected">Rejected</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md" id="reasonField" style="display: none;">
        <label for="reason">Reason for Rejection</label>
        <input type="text" name="reason" id="reason" class="form-control" placeholder="Reason for rejection">
    </div>

<script>
    // Function to toggle visibility of reason input field based on selected approval status
    $(document).ready(function() {
        // Check the initial approval status when the page loads
        toggleReasonField($('#approval').val());

        // Listen for changes in the approval status dropdown
        $('#approval').on('change', function() {
            // Toggle the visibility of reason input field based on the selected approval status
            toggleReasonField($(this).val());
        });

        // Function to toggle the visibility of reason input field
        function toggleReasonField(approvalStatus) {
            if (approvalStatus === 'Rejected') {
                $('#reasonField').show();
            } else {
                $('#reasonField').hide();
            }
        }
    });
</script>

                                            </div>
                                                <div class="my-2" id="scan_or_photo_of_id"></div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" id="edit_owner_btn" class="btn btn-primary" id="btn-save">Update Owner</button>
                                                </div>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- End Edit Modal -->

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

    <script type="text/javascript">
        //CREATE
        function add() {
            $('#add_owner_form').trigger("reset");
            $('#OwnerModal').html("Add Owner");
            $('#addOwnerModal').modal('show');
            $('#id').val('');
        }

        //EDIT
        function edit() {
            $('#edit_owner_form').trigger("reset");
            $('#OwnerModal').html("Edit Owner");
            $('#editOwnerModal').modal('show');
            $('#id').val('');
        }
    </script>

    <script>
        $(function() {

            // add new owner ajax request
            $("#add_owner_form").submit(function(e) {
                e.preventDefault();
                const fd = new FormData(this);
                $("#add_owner_btn").text('Adding...');
                $.ajax({
                    url: '{{ route('owners.store') }}',
                    method: 'post',
                    data: fd,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(response){
                        if (response.status == 200){
                            fetchAllOwners();
                            // Close the modal
                            $("#addOwnerModal").modal('hide');
                            Swal.fire(
                                "Successful",
                                "Owner Added Successfully",
                                "success"
                            )
                        } 
                        $("#add_owner_btn").text('Add Owner');
                        $("#add_owner_form")[0].reset();
                    }
                });
            });

            // edit owner ajax request
            $(document).on('click', '.editIcon', function(e){
                e.preventDefault();
                let id = $(this).attr('id');
                $.ajax({
                    url: '{{ route('owners.edit') }}',
                    method: 'get',
                    data: {
                        id: id,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response){
                        $("#fname").val(response.first_name);
                        $("#mi").val(response.middle_initial);
                        $("#lname").val(response.last_name);
                        $("#paddress").val(response.present_address);
                        $("#email").val(response.email_address);
                        $("#contact").val(response.contact_number);
                        $("#appointment").val(response.appointment_id);
                        $("#role_status").val(response.status_id);
                        $("#department").val(response.office_department_agency);
                        $("#position").val(response.position_designation);
                        $("#approval").val(response.approval_status);
                        $("#scan_or_photo_of_id").html(
                            `<img src="storage/images/${response.scan_or_photo_of_id}" width="100" class="img-fluid img-thumbnail">`);
                        $("#owner_id").val(response.id);
                        $("#owner_photo").val(response.scan_or_photo_of_id);
                    }
                });
            });
            
            // update owner ajax request
            $("#edit_owner_form").submit(function(e){
                e.preventDefault();
                const fd = new FormData(this);
                $("#edit_owner_btn").text('Updating...');
                $.ajax({
                url: '{{ route('owners.update') }}',
                method: 'post',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response){
                    if (response.status == 200){
                        fetchAllOwners();
                        // Close the modal
                        $("#editOwnerModal").modal('hide');
                        Swal.fire(
                            "Updated",
                            "Owner Updated Successfully",
                            "success"
                        )
                    }
                    $("#edit_owner_btn").text('Update Owner');
                    $("#edit_owner_form")[0].reset();
                    }
                });
            });

            // delete employee ajax request
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
                        url: '{{ route('owners.delete') }}',
                        method: 'delete',
                        data: {
                            id: id,
                            _token: csrf
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                Swal.fire(
                                    'Deleted!',
                                    'Your file has been deleted.',
                                    'success'
                                );
                                fetchAllOwners();
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
                                'Failed to delete owner: ' + error,
                                'error'
                            );
                        }
                    });
                }
            });
        });


            // fetch all owner ajax request
            fetchAllOwners();

            function fetchAllOwners() {
                $.ajax({
                    url: '{{ route('fetchAll') }}',
                    method: 'get',
                    success: function(response) {
                        $("#show_all_owners").html(response);
                        $("table").DataTable({
                            order:[0, 'desc']
                        });
                    }
                });
            }
        });
    </script>

</body>

</html>
@endsection