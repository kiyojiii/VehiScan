@forelse($owners as $owner)
<!-- Edit Modal -->
<div class="modal fade" id="editActivateModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Activate Vehicle</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form action="javascript:void(0)" id="edit_activate_form" name="edit_activate_form" method="POST" enctype="multipart/form-data">
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
                        <div class="col-md" style="display: none;">
                            <label for="position">Driver ID</label>
                            <input type="text" name="driver_id" id="driver_id" class="form-control" placeholder="Driver ID" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="position">Driver Name</label>
                            <input type="text" name="driver_name" id="driver_name" class="form-control" value="{{ $driver->driver_name ?? 'N/A' }}" placeholder="Driver Name" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="owner_name" class="form-label">Owner Name</label>
                            <input type="text" class="form-control" id="owner_name" name="owner_name">
                        </div>
                        <div class="col-md-3">
                            <label for="owner_address" class="form-label">Owner Address</label>
                            <input type="text" class="form-control" id="owner_address" name="owner_address">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-2">
                            <label for="plate_number" class="form-label">Plate Number <br> (e.g ABC 123)</label>
                            <input type="text" class="form-control" id="plate_number" name="plate_number">
                        </div>
                        <div class="col-md-2">
                            <label for="vehicle_make" class="form-label">Vehicle Make <br> (e.g Ford)</label>
                            <input type="text" class="form-control" id="vehicle_make" name="vehicle_make">
                        </div>
                        <div class="col-md-2">
                            <label for="vehicle_category" class="form-label">Vehicle Category <br> (e.g Car)</label>
                            <input type="text" class="form-control" id="vehicle_category" name="vehicle_category">
                        </div>
                        <div class="col-md-2">
                            <label for="year_model" class="form-label">Year Model <br> (e.g Everest 2022)</label>
                            <input type="text" class="form-control" id="year_model" name="year_model">
                        </div>
                        <div class="col-md-2">
                            <label for="body_type" class="form-label">Body Type <br> (e.g SUV)</label>
                            <input type="text" class="form-control" id="body_type" name="body_type">
                        </div>
                        <div class="col mb-2">
                            <label for="color" class="form-label">Color <br> (e.g Black)</label>
                            <input type="text" class="form-control" id="color" name="color">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <h4> Vehicle Documents </h4>
                        <p class="text-danger">If the image doesn't change, please reload the page.</p>
                        <!-- Official Receipt Image -->
                        <div class="col-md-3">
                            <label for="official_receipt_image" class="form-label">Official Receipt Image</label>
                            <input type="file" class="form-control" name="official_receipt_image">
                        </div>
                        <!-- Previous Official Receipt Image -->
                        <div class="col-md-3">
                            <div class="my-2" id="official_receipt_image" style="width: 300px; height: 200px;"></div>
                        </div>
                        <!-- Certificate of Registration Image -->
                        <div class="col-md-3">
                            <label for="certificate_of_registration_image" class="form-label">Certificate of Registration Image</label>
                            <input type="file" class="form-control" name="certificate_of_registration_image">
                        </div>
                        <!-- Previous Certificate of Registration Image -->
                        <div class="col-md-3">
                            <div class="my-2" id="certificate_of_registration_image" style="width: 300px; height: 200px;"></div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <!-- Deed of Sale Image -->
                        <div class="col-md-3">
                            <label for="deed_of_sale_image" class="form-label">Deed of Sale Image</label>
                            <input type="file" class="form-control" name="deed_of_sale_image">
                        </div>
                        <!-- Previous Deed of Sale Image -->
                        <div class="col-md-3">
                            <div class="my-2" id="deed_of_sale_image" style="width: 300px; height: 200px;"></div>
                        </div>
                        <!-- Authorization Letter Image -->
                        <div class="col-md-3">
                            <label for="authorization_letter_image" class="form-label">Authorization Letter Image</label>
                            <input type="file" class="form-control" name="authorization_letter_image">
                        </div>
                        <!-- Previous Authorization Letter Image -->
                        <div class="col-md-3">
                            <div class="my-2" id="authorization_letter_image" style="width: 300px; height: 200px;"></div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <h4> Vehicle Images </h4>
                        <p class="text-danger">If the image doesn't change, please reload the page.</p>
                        <!-- Front Photo -->
                        <div class="col-md-3">
                            <label for="front_photo" class="form-label">Front Photo</label>
                            <input type="file" class="form-control" name="front_photo">
                        </div>
                        <!-- Previous Front Photo -->
                        <div class="col-md-3">
                            <div class="my-2" id="front_photo" style="width: 300px; height: 200px;"></div>
                        </div>
                        <!-- Side Photo -->
                        <div class="col-md-3">
                            <label for="side_photo" class="form-label">Side Photo</label>
                            <input type="file" class="form-control" name="side_photo">
                        </div>
                        <!-- Previous Side Photo -->
                        <div class="col-md-3">
                            <div class="my-2" id="side_photo" style="width: 300px; height: 200px;"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="activate_vehicle_btn" class="btn btn-primary" id="btn-save">Activate Vehicle</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<!-- End Modal -->

<!-- Edit Driver Modal -->
<div class="modal fade" id="editDriverModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Update Driver</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form action="javascript:void(0)" id="edit_driver_form" name="edit_driver_form" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="dlicense_photo" id="dlicense_photo">
                    <input type="hidden" name="adlicense_photo" id="adlicense_photo">
                    <!-- Driver's Info -->
                    <div class="col-md" style="display: none">
                        <label for="position">Driver ID</label>
                        <input type="text" name="driver_id" id="driver_id" class="form-control" value="{{ $driver->id ?? 'N/A' }}" placeholder="Driver ID" readonly>
                    </div>
                    <h5>Driver's Info</h5>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="dname">Driver Name</label>
                            <input type="text" name="dname" id="dname" class="form-control" placeholder="Driver Name">
                        </div>
                        <div class="col-md-4">
                            <label for="adname">Authorized Driver Name</label>
                            <input type="text" name="adname" id="adname" class="form-control" placeholder="Authorized Driver Name">
                        </div>
                        <div class="col-md-4">
                            <label for="adaddress">Authorized Driver Address</label>
                            <input type="text" name="adaddress" id="adaddress" class="form-control" placeholder="Authorized Driver Address">
                        </div>
                    </div>
                    <br>
                    <h5 class="mt-4"> Driver's Documents</h5>
                    <p class="text-danger">If the image doesn't change, please reload the page.</p>
                    <div class="row">
                        <div class="col-md">
                            <label for="driver_license_image">Driver's License</label>
                            <input type="file" name="driver_license_image" class="form-control">
                        </div>
                        @if($driver)
                        <img src="{{ asset('storage/images/drivers/' . $driver->driver_license_image) }}" alt="driver_license_image" class="img-thumbnail mx-auto d-block" style="width: 300px; height: 200px;">
                        @else
                        <!-- Display a placeholder image or message -->
                        <p>No driver associated</p>
                        @endif
                        <div class="col-md">
                            <label for="authorized_driver_license_image">Authorized Driver's License</label>
                            <input type="file" name="authorized_driver_license_image" class="form-control">
                        </div>
                        @if($driver)
                        <img src="{{ asset('storage/images/drivers/' . $driver->authorized_driver_license_image) }}" alt="authorized_driver_license_image" class="img-thumbnail mx-auto d-block" style="width: 300px; height: 200px;">
                        @else
                        <!-- Display a placeholder image or message -->
                        <p>No driver associated</p>
                        @endif
                    </div>


                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="edit_driver_btn" class="btn btn-primary" id="btn-save">Update Driver</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<!-- End Modal -->

<!-- Edit Owner Modal -->
<div class="modal fade" id="editOwnerModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Update Information</h1>
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
                            <div class="col-md-6">
                                <div class="my-2" id="scan_or_photo_of_id"></div>
                            </div>
                        </div>
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

<!-- Accept Only 11 Numbers in Contact -->
<script>
    document.getElementById('contact').addEventListener('input', function(event) {
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
    document.getElementById('mi').addEventListener('input', function(event) {
        if (this.value.length > 1) {
            this.value = this.value.slice(0, 1);
        }
    });
</script>

<!-- Accept Number on ID Number -->
<script>
    document.getElementById('id_number').addEventListener('input', function(event) {
        // Replace any characters that are not numbers or '-' with an empty string
        this.value = this.value.replace(/[^0-9-]/g, '');
    });
</script>


<!-- Add Vehicle Modal -->
<div class="modal fade" id="addVehicleModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <div class="col-md-3" style="display: none;">
                            <label for="owner_id" class="form-label">Applicant ID</label>
                            <input type="text" class="form-control" id="owner_id" name="owner_id" value="{{ $owners->id ?? 'Null' }}" readonly>
                        </div>
                        <div class="col-md-3" style="display: none;">
                            <label for="driver_id" class="form-label">Driver Name</label>
                            <input type="text" class="form-control" id="driver_id" name="driver_id" value="{{ $driver->id ?? 'Null' }}" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="owner_name" class="form-label">Applicant Name</label>
                            <input type="text" class="form-control" id="owner_name" name="owner_name" value="{{ $owners->first_name ?? 'Null' }} {{ $owners->middle_initial ?? '' }}. {{ $owners->last_name ?? '' }}" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="driver_name" class="form-label">Driver Name</label>
                            <input type="text" class="form-control" id="driver_name" name="driver_name" value="{{ $driver->driver_name ?? 'Null' }}" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="real_owner_name" class="form-label">Owner Name</label>
                            <input type="text" class="form-control" name="real_owner_name">
                        </div>
                        <div class="col-md-3">
                            <label for="owner_address" class="form-label">Owner Address</label>
                            <input type="text" class="form-control" name="owner_address">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-2">
                            <label for="plate_number" class="form-label">Plate Number <br> (e.g ABC 123)</label>
                            <input type="text" class="form-control" name="plate_number">
                        </div>
                        <div class="col-md-2">
                            <label for="vehicle_make" class="form-label">Vehicle Make <br> (e.g Ford)</label>
                            <input type="text" class="form-control" name="vehicle_make">
                        </div>
                        <div class="col-md-2">
                            <label for="vehicle_category" class="form-label">Vehicle Category <br> (e.g Car)</label>
                            <input type="text" class="form-control" name="vehicle_category">
                        </div>
                        <div class="col-md-2">
                            <label for="year_model" class="form-label">Year Model <br> (e.g Everest 2022)</label>
                            <input type="text" class="form-control" name="year_model">
                        </div>
                        <div class="col-md-2">
                            <label for="body_type" class="form-label">Body Type <br> (e.g SUV)</label>
                            <input type="text" class="form-control" name="body_type">
                        </div>
                        <div class="col-md-2">
                            <label for="color" class="form-label">Color <br> (e.g Black) </label>
                            <input type="text" class="form-control" name="color">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-2" style="display: none;">
                            <label for="registration_status">Status</label>
                            <input type="text" name="registration_status" class="form-control" value="Pending" readonly>
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

<!-- Add Driver Modal -->
<div class="modal fade" id="addDriverModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        </div>
                    </div>

                    <!-- Authorized Driver's Info -->
                    <h5 class="mt-4">Authorized Driver's Info</h5>
                    <div class="row">
                        <div class="col-md">
                            <label for="adname">Authorized Driver Name</label>
                            <input type="text" name="adname" class="form-control" placeholder="Authorized Driver Name" required>
                        </div>
                        <div class="col-md">
                            <label for="adaddress">Authorized Driver Address</label>
                            <input type="text" name="adaddress" class="form-control" placeholder="Authorized Driver Address" required>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md">
                            <label for="authorized_driver_license_image">Authorized Driver's License</label>
                            <input type="file" name="authorized_driver_license_image" class="form-control" required>
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

@empty
<p>You have not Applied Yet</p>
@endforelse