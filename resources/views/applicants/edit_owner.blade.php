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
                    <input type="hidden" name="applicant_id" id="applicant_id">
                    <input type="hidden" name="applicant_photo" id="applicant_photo">
                    <!-- Personal Info -->
                    <h5>Personal Info</h5>
                    <div class="row">
                        <div class="col-md">
                            <label for="position">Vehicle</label>
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
                        <div class="col-md">
                            <label for="id_number">ID Number</label>
                            <input type="text" name="id_number" id="id_number" class="form-control" placeholder="ID Number" required>
                        </div>
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
                <div class="my-5">
                    <h4>Scan/Photo of ID</h4>
                    <img src="{{ asset('storage/images/' . $owners->scan_or_photo_of_id) }}" alt="Photo ID" class="img-thumbnail mx-auto d-block" style="width: 300px; height: 200px;">
                </div>
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