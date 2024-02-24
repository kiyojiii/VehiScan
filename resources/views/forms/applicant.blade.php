<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>VehiScan | Applicant</title>

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
                            <h4 class="mb-sm-0 font-size-18">Applicant List</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Applicant</a></li>
                                    <li class="breadcrumb-item active">Applicant List</li>
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
                                    <h5 class="mb-0 card-title flex-grow-1">Applicant Lists</h5>
                                    <div class="flex-shrink-0">
                                        <a class="btn btn-success btn-sm my-2" onClick="add()" href="javascript:void(0)"><i class="bi bi-plus-circle"></i> Add Applicant</a>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body" id="show_all_applicants">
                                <h1 class="text-center text-secondary my-5"> Loading... </h1>
                            </div>

                            <!-- Add Modal -->
<div class="modal fade" id="addOwnerModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Ossswner</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form action="javascript:void(0)" id="add_owner_form" name="add_owner_form" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- Basic Wizard -->
                    <div id="basic-example">
                        <!-- Seller Details -->
                        <section id="sellerDetailsSection">
                        <div class="col-lg">  
                                                <!-- Personal Info -->
                                                <h5>Personal Info</h5>
                                                <div class="row">
                                                        <div class="col-md">
                                                        <label for="position">Vehicle</label>
                                                        <select name="vehicle" id="vehicle" class="form-control" onfocus='this.size=3;' onblur='this.size=1;' onchange='this.size=1; this.blur();'>
                                                            <option value="">Select Vehicle</option> <!-- Placeholder option -->
                                                            @forelse($vehicles as $vehicle)
                                                                <option value="{{ $vehicle->id }}">{{ $vehicle->plate_number }} - {{ $vehicle->vehicle_make }} - {{ $vehicle->color }}</option>
                                                            @empty
                                                                <option value="">No Vehicle Available</option>
                                                            @endforelse
                                                        </select>
                                                    </div>
                                                    <div class="col-md">
                                                        <label for="serial_number">Serial Number</label>
                                                        <input type="text" name="serial_number" class="form-control" placeholder="Serial Number" required>
                                                        @error('serial_number')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md">
                                                        <label for="id_number">ID Number</label>
                                                        <input type="text" name="id_number" class="form-control" placeholder="ID Number" required>
                                                        @error('id_number')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div> <br>
                                                <div class="row">
                                                    <div class="col-md">
                                                        <label for="fname">First Name</label>
                                                        <input type="text" name="fname" class="form-control" placeholder="First Name" required>
                                                        @error('fname')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md">
                                                        <label for="mi">Middle Initial (Letter Only)</label>
                                                        <input type="text" name="mi" id="add_mi" class="form-control" placeholder="Middle Initial" maxlength="1" required>
                                                        @error('mi')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <div class="col-md">
                                                        <label for="lname">Last Name</label>
                                                        <input type="text" name="lname" class="form-control" placeholder="Last Name" required>
                                                        @error('lname')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <!-- Contact Info -->
                                                <h5 class="mt-4">Contact Info</h5>
                                                <div class="row">
                                                    <div class="col-md">
                                                        <label for="paddress">Present Address</label>
                                                        <input type="text" name="paddress" class="form-control" placeholder="Present Address" required>
                                                        @error('paddress')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md">
                                                        <label for="email">Email Address</label>
                                                        <input type="text" name="email" class="form-control" placeholder="Email Address" required>
                                                        @error('email')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md">
                                                        <label for="contact">Contact Number (11 Digits)</label>
                                                        <input type="text" name="contact" id="add_contact" class="form-control" placeholder="Contact" pattern="[0-9]{11}" title="Please enter 11 numbers only" required>
                                                        @error('contact')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <!-- Work Info -->
                                                <h5 class="mt-4">Work Info</h5>
                                                <div class="row">
                                                    <div class="col-md">
                                                        <label for="position">Position & Designation</label>
                                                        <input type="text" name="position" class="form-control" placeholder="Position & Designation" required>     
                                                        @error('position')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
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
                                                        @error('appointment')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
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
                                                        @error('role_status')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <div class="col-md">
                                                        <label for="department">Office/Department/Agency</label>
                                                        <input type="text" name="department" class="form-control" placeholder="Office/Department/Agency" required>
                                                        @error('department')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>              
                                                </div>

                                                <!-- Photo & Approval Status -->
                                                <h5 class="mt-4">Photo & Approval Status</h5>
                                                <div class="row">
                                                    <div class="col-md">
                                                        <label for="scan_or_photo_of_id">Photo</label>
                                                        <input type="file" name="scan_or_photo_of_id" class="form-control" required>
                                                        @error('scan_or_photo_of_id')
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
                                            </div>
                            <div class="modal-footer" id="modalFooterButtons">
                            <button type="button" class="btn btn-primary" onclick="nextStep()">Next</button>
                            </div>                          
                        </section>

                        <!-- Company Document -->
                        <section id="companyDocumentSection" style="display: none;">
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
                                                <label for="status">Status</label>
                                                <select name="status" class="form-control">
                                                    <option value="Active" selected>Active</option>
                                                    <option value="Inactive">Inactive</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                                @error('status')
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
                            <div class="modal-footer" id="modalFooterButtons">
                            <button type="button" class="btn btn-secondary" onclick="prevStep()">Back</button>
                            <button type="button" class="btn btn-primary" onclick="nextStep()">Next</button>
                            </div>       
                        </section>

                        <!-- Bank Details -->
                        <section id="bankDetailsSection" style="display: none;">
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
                            <div class="modal-footer" id="modalFooterButtons">
                            <button type="button" class="btn btn-secondary" onclick="prevStep()">Back</button>
                            <button type="button" class="btn btn-primary" onclick="nextStep()">Next</button>
                            </div>   
                        </section>

                        <!-- Confirm Details -->
                        <section id="confirmDetailsSection" style="display: none;">
                            <!-- Confirm Details Form -->
                            <h3>Confirm Details</h3>
                            <!-- Your Confirm Details Form Inputs -->
                            <div class="modal-footer" id="modalFooterButtons">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" id="add_owner_btn" class="btn btn-primary" id="btn-save">Add Owner</button>
                            </div>   
                        </section>
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

    <script>
    var currentStep = 0;
    var inputValues = {}; // Object to store input values

    // Show initial step
    showStep(currentStep);

    // Reset modal and step when closed
    $('#addOwnerModal').on('hidden.bs.modal', function (e) {
        currentStep = 0;
        showStep(currentStep);
    });

    // Reset step when modal is opened
    $('#addOwnerModal').on('show.bs.modal', function (e) {
        currentStep = 0;
        showStep(currentStep);
    });

    // Store input values when navigating to the next step
    function nextStep() {
        saveInputs();
        currentStep++;
        showStep(currentStep);
    }

    // Store input values when navigating to the previous step
    function prevStep() {
        saveInputs();
        currentStep--;
        showStep(currentStep);
    }

    // Display the current step
    function showStep(stepIndex) {
        var steps = document.querySelectorAll("section");
        for (var i = 0; i < steps.length; i++) {
            if (i === stepIndex) {
                steps[i].style.display = "block";
            } else {
                steps[i].style.display = "none";
            }
        }
    }

    // Save input values to the object
    function saveInputs() {
        var inputFields = document.querySelectorAll("input, select");
        inputFields.forEach(function (input) {
            inputValues[input.name] = input.value;
        });
    }

    // Restore input values from the object
    function restoreInputs() {
        var inputFields = document.querySelectorAll("input, select");
        inputFields.forEach(function (input) {
            if (input.name in inputValues) {
                input.value = inputValues[input.name];
            } else {
                input.value = "";
            }
        });
    }

    function submitForm() {
        // Add form submission logic here
        alert("Form submitted successfully!");
    }

    //CREATE
    function add() {
        $('#add_owner_form').trigger("reset");
        $('#OwnerModal').html("Add Owner");
        $('#addOwnerModal').modal('show');
        currentStep = 0; // Reset step to the initial one
        showStep(currentStep);
        restoreInputs(); // Restore input values when opening the modal
    }

    //EDIT
    function edit() {
        $('#edit_owner_form').trigger("reset");
        $('#OwnerModal').html("Edit Owner");
        $('#editOwnerModal').modal('show');
        $('#id').val('');
    }
</script>




    <!-- Accept Only 11 Numbers in Contact -->
    <script>
        document.getElementById('add_contact').addEventListener('input', function(event) {
            // Remove non-numeric characters
            this.value = this.value.replace(/\D/g, '');

            // Limit input to 11 characters
            if (this.value.length > 11) {
                this.value = this.value.slice(0, 11);
            }
        });
    </script>

    <!-- Accept Only 1 Letter in MI -->
    <script>
        document.getElementById('add_mi').addEventListener('input', function(event) {
            if (this.value.length > 1) {
                this.value = this.value.slice(0, 1);
            }
        });
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
            // fetch all owner ajax request
            fetchAllApplicants();

            function fetchAllApplicants() {
                $.ajax({
                    url: '{{ route('fetchAllApplicant') }}',
                    method: 'get',
                    success: function(response) {
                        $("#show_all_applicants").html(response);
                        $("table").DataTable({
                        order: [0, 'desc'], // Order by the first column in descending order
                        lengthMenu: [5, 10, 25, 50], // Display options to show 5, 10, 25, or 50 records per page
                        pageLength: 5 // Initially display 5 records per page
                    });
                    }
                });
            }
        });
    </script>
</body>

</html>
@endsection