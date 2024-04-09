<!-- Select2 CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- Select2 JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<!-- Add this style to adjust z-index -->
<style>
    .select2-container--open {
        z-index: 1600 !important;
        /* Adjust the z-index as needed */
    }
</style>

<!-- Add Modal -->
<div class="modal fade" id="addOwnerModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                <label for="position">Main Vehicle (Optional)</label>
                                <br>
                                <select name="vehicle" id="vehicle" class="form-control vehicle-select">
                                    <option value="">Select Vehicle</option> <!-- Placeholder option -->
                                    @forelse($vehicles as $vehicle)
                                    <option value="{{ $vehicle->id }}">{{ $vehicle->plate_number }} - {{ $vehicle->vehicle_make }} - {{ $vehicle->color }}</option>
                                    @empty
                                    <option value="">No Vehicle Available</option>
                                    @endforelse
                                </select>
                            </div>
                            <!-- Include Select2 initialization script -->
                            <script>
                                // Wrap your JavaScript code in a document.ready function
                                $(document).ready(function() {
                                    // Initialize Select2 for the owner dropdown
                                    $('#vehicle').select2({
                                        dropdownParent: $('#addOwnerModal') // Set the dropdown parent if needed
                                    });

                                    // Event listener for modal hidden event
                                    $('#addOwnerModal').on('hidden.bs.modal', function() {
                                        // Clear the Select2 value
                                        $('#vehicle').val(null).trigger('change');
                                    });
                                });
                            </script>

                            <div class="col-md">
                                <label for="serial_number">Serial Number</label>
                                <input type="text" id="add_serial_number" name="serial_number" class="form-control" placeholder="Serial Number">
                            </div>
                            <!-- <script>
                                // JavaScript code to enforce numeric input for the serial number field
                                document.getElementById('add_serial_number').addEventListener('input', function() {
                                    // Remove any non-numeric characters from the input value
                                    this.value = this.value.replace(/\D/g, '');
                                });
                            </script> -->
                            <div class="col-md">
                                <label for="id_number">ID Number</label>
                                <input type="text" id="add_id_number" name="id_number" class="form-control" placeholder="ID Number">
                            </div>
                            <script>
                                // JavaScript code to enforce numeric input for the ID number field
                                document.getElementById('add_id_number').addEventListener('input', function() {
                                    // Remove any characters except numbers and hyphens from the input value
                                    this.value = this.value.replace(/[^\d-]/g, '');
                                });
                            </script>
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

                        <!-- Photo & Approval Status -->
                        <h5 class="mt-4">Photo & Approval Status</h5>
                        <div class="row">
                            <div class="col-md">
                                <label for="scan_or_photo_of_id">Photo</label>
                                <input type="file" name="scan_or_photo_of_id" class="form-control" required>
                            </div>
                            <div class="col-md-2">
                                <label for="approval">Approval Status</label>
                                <select name="approval" class="form-control" id="approvalStatus" required>
                                    <option value="Approved" selected>Approved</option>
                                    <option value="Rejected">Rejected</option>
                                    <option value="Pending">Pending</option>
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
<div class="modal fade" id="editOwnerModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                <label for="position">Main Vehicle</label>
                                <select name="vehicle_details" id="vehicle_details" class="form-control" onfocus='this.size=3;' onblur='this.size=1;' onchange='this.size=1; this.blur();'>
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
                                <input type="text" name="serial_number" id="serial_number" class="form-control" placeholder="Serial Number" required>
                            </div>
                            <!-- <script>
                                // JavaScript code to enforce numeric input for the serial number field
                                document.getElementById('serial_number').addEventListener('input', function() {
                                    // Remove any non-numeric characters from the input value
                                    this.value = this.value.replace(/\D/g, '');
                                });
                            </script> -->
                            <div class="col-md">
                                <label for="id_number">ID Number</label>
                                <input type="text" name="id_number" id="id_number" class="form-control" placeholder="ID Number" required>
                            </div>
                            <script>
                                // JavaScript code to enforce numeric input for the ID number field
                                document.getElementById('id_number').addEventListener('input', function() {
                                    // Remove any characters except numbers and hyphens from the input value
                                    this.value = this.value.replace(/[^\d-]/g, '');
                                });
                            </script>
                        </div> <br>
                        <div class="row">
                            <div class="col-md">
                                <label for="fname">First Name</label>
                                <input type="text" name="fname" id="fname" class="form-control" placeholder="First Name" required>
                            </div>
                            <div class="col-md">
                                <label for="mi">Middle Initial (Letter Only)</label>
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
                                <label for="contact">Contact Number (11 Digits)</label>
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
                                    <label for="appointment">Appointment</label>
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
                            <div class="col-md-4">
                                <label for="scan_or_photo_of_id">Photo</label>
                                <input type="file" name="scan_or_photo_of_id" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <label for="approval">Approval Status</label>
                                <select name="approval" id="approval" class="form-control" required>
                                    <option value="Approved" selected>Approved</option>
                                    <option value="Rejected">Rejected</option>
                                    <option value="Pending">Pending</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="reason">Reason for Rejection</label>
                                <input type="text" name="reason" id="reason" class="form-control" placeholder="Reason for rejection">
                            </div>
                        </div>
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