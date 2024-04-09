<!-- Add Modal -->
<div class="modal fade" id="addApplicantModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Applicant</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form action="javascript:void(0)" id="add_applicant_form" name="add_applicant_form" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div id="basic-example">
                        <!-- Applicant Details -->
                        <section id="applicantDetailsSection">
                            <!-- Personal Info -->
                            <h5>Personal Info</h5>
                            <div class="row">
                                <div class="col-md">
                                    <label for="serial_number">Serial Number</label>
                                    <input type="text" id="add_serial_number" name="serial_number" class="form-control" placeholder="Serial Number">
                                </div>
                                <!-- <script>
                                    // JavaScript code to enforce numeric input for the serial number field
                                    document.getElementById('add_serial_number').addEventListener('input', function() {
                                        // Remove any non-numeric characters from the input value
                                        this.value = this.value.replace(/[^\d-]/g, '');
                                    });
                                </script> -->
                                <div class="col-md">
                                    <label for="id_number">ID Number</label>
                                    <input type="text" id="add_id_number" name="id_number" class="form-control" placeholder="ID Number">
                                </div>
                                <!-- <script>
                                    // JavaScript code to enforce numeric input for the ID number field
                                    document.getElementById('add_id_number').addEventListener('input', function() {
                                        // Remove any characters except numbers and hyphens from the input value
                                        this.value = this.value.replace(/[^\d-]/g, '');
                                    });
                                </script> -->
                            </div> <br>
                            <div class="row">
                                <div class="col-md">
                                    <label for="fname">First Name</label>
                                    <input type="text" name="fname" class="form-control" placeholder="First Name" required>
                                </div>
                                <div class="col-md">
                                    <label for="mi">Middle Initial (Letter Only)</label>
                                    <input type="text" name="mi" id="add_mi" class="form-control" placeholder="Middle Initial" maxlength="1">
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
                                    <label for="contact">Contact Number (11 Digits)</label>
                                    <input type="text" name="contact" id="add_contact" class="form-control" placeholder="Contact" pattern="[0-9]{11}" title="Please enter 11 numbers only" required>
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

                            <!-- Photo -->
                            <h5 class="mt-4">Photo</h5>
                            <div class="row">
                                <div class="col-md">
                                    <label for="scan_or_photo_of_id">Scan or Photo of ID</label>
                                    <input type="file" name="scan_or_photo_of_id" class="form-control" required>
                                </div>
                            </div>
                            <div class="modal-footer" id="modalFooterButtons">
                                <button type="button" class="btn btn-primary" onclick="nextStep()">Next</button>
                            </div>
                        </section>

                        <!-- Vehicle Details -->
                        <section id="vehicleDetailsSection" style="display: none;">
                            <h5>Vehicle Info</h5>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="owner_name" class="form-label">Owner Name</label>
                                    <input type="text" class="form-control" name="owner_name">
                                </div>
                                <div class="col-md-4">
                                    <label for="owner_address" class="form-label">Owner Address</label>
                                    <input type="text" class="form-control" name="owner_address">
                                </div>
                                <div class="col-md-3">
                                    <label for="plate_number" class="form-label">Plate Number (e.g ABC 123)</label>
                                    <input type="text" class="form-control" name="plate_number">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label for="vehicle_make" class="form-label">Vehicle Make (e.g Toyota)</label>
                                    <input type="text" class="form-control" name="vehicle_make">
                                </div>
                                <div class="col-md-3">
                                    <label for="year_model" class="form-label">Year Model (e.g Vios 2023)</label>
                                    <input type="text" class="form-control" name="year_model">
                                </div>
                                <div class="col-md-2">
                                    <label for="body_type" class="form-label">Body Type (e.g Sedan)</label>
                                    <input type="text" class="form-control" name="body_type">
                                </div>
                                <div class="col-md-2">
                                    <label for="color" class="form-label">Color (e.g Black)</label>
                                    <input type="text" class="form-control" name="color">
                                </div>
                                <div class="col-md-2">
                                    <label for="registration_status">Status</label>
                                    <select name="registration_status" class="form-control">
                                        <option value="">Select Vehicle Status</option>
                                        <option value="Active" selected>Active</option>
                                        <option value="Inactive">Inactive</option>
                                        <option value="Pending">Pending</option>
                                        <option value="Other">Other</option>
                                    </select>
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
                        <!-- Driver Details -->
                        <section id="driverDetailsSection" style="display: none;">
                            <!-- Driver's Info -->
                            <h5>Driver Info</h5>
                            <div class="row">
                                <div class="col-md-5">
                                    <label for="dname">Driver Name</label>
                                    <input type="text" name="dname" class="form-control" placeholder="Driver Name" required>
                                </div>
                                <div class="col-md">
                                    <label for="driver_license_image">Driver's License</label>
                                    <input type="file" name="driver_license_image" class="form-control" required>
                                </div>
                            </div>

                            <!-- Authorized Driver's Info -->
                            <h5 class="mt-4">Authorized Driver's Info</h5>
                            <div class="row">
                                <div class="col-md">
                                    <label for="adname">Authorized Driver Name</label>
                                    <input type="text" name="adname" class="form-control" placeholder="Authorized Driver Name">
                                </div>
                                <div class="col-md">
                                    <label for="adaddress">Authorized Driver Address</label>
                                    <input type="text" name="adaddress" class="form-control" placeholder="Authorized Driver Address">
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md">
                                    <label for="authorized_driver_license_image">Authorized Driver's License</label>
                                    <input type="file" name="authorized_driver_license_image" class="form-control">
                                </div>
                            </div>
                            <div class="modal-footer" id="modalFooterButtons">
                                <button type="button" class="btn btn-secondary" onclick="prevStep()">Back</button>
                                <button type="submit" id="add_applicant_btn" class="btn btn-success" id="btn-save">Add Applicant</button>
                            </div>
                        </section>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->

<!-- Edit Modal -->
<div class="modal fade" id="userTransferModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Transfer Applicant Ownership</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form action="javascript:void(0)" id="transfer_form" name="transfer_form" method="POST" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" class="form-control" id="current_user" name="current_user">
                    <input type="hidden" class="form-control" id="applicant_id" name="applicant_id">
                    <input type="hidden" class="form-control" id="vehicle_id" name="vehicle_id">
                    <input type="hidden" class="form-control" id="driver_id" name="driver_id">

                    <div class="col-md-3">
                        <label for="current_user_name" class="form-label">Current User</label>
                        <input type="text" class="form-control" id="current_user_name" name="current_user_name" readonly>
                    </div>

                    <br>

                    <!-- User Dropdown -->
                    <div class="mb-3">
                        <div class="col-md-3">
                            <label for="user_id" class="form-label">New User</label>
                            <br>
                            <select name="user_id" id="user_id" class="form-select edit-vehicle-select">
                                <option value="">Select User</option> <!-- Placeholder option -->
                                @forelse($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} - {{ $user->email }}</option>
                                @empty
                                <option value="">No Users Available</option>
                                @endforelse
                            </select>
                        </div>


                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" id="edit_violation_btn" class="btn btn-primary" id="btn-save">Transfer Ownership</button>
                        </div>
                </form>
            </div>

        </div>
    </div>
</div>
<!-- End Edit Modal -->