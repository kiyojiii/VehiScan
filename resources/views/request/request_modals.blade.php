<!-- Edit Modal -->
<div class="modal fade" id="editVehicleModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <div class="col-md-3">
                            <label for="position">Applicant Name</label>
                            <select name="applicant_name" id="applicant_name" class="form-control" onfocus='this.size=3;' onblur='this.size=1;' onchange='this.size=1; this.blur();'>
                                <option value="">Select Applicant</option> <!-- Placeholder option -->
                                @forelse($owners as $owner)
                                <option value="{{ $owner->id }}">{{ $owner->first_name }} {{ $owner->last_name }}</option>
                                @empty
                                <option value="">No Owner Available</option>
                                @endforelse
                            </select>
                        </div>
                        <div class="col-md-3">
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
                        <div class="col-md-4">
                            <label for="plate_number" class="form-label">Plate Number (e.g ABC 123)</label>
                            <input type="text" class="form-control" id="plate_number" name="plate_number">
                        </div>
                        <div class="col-md-4">
                            <label for="vehicle_make" class="form-label">Vehicle Make (e.g Toyota)</label>
                            <input type="text" class="form-control" id="vehicle_make" name="vehicle_make">
                        </div>
                        <div class="col-md-4">
                            <label for="year_model" class="form-label">Year Model (e.g Vios 2023)</label>
                            <input type="text" class="form-control" id="year_model" name="year_model">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-2">
                            <label for="body_type" class="form-label">Body Type (e.g Sedan)</label>
                            <input type="text" class="form-control" id="body_type" name="body_type">
                        </div>
                        <div class="col-md-2">
                            <label for="color" class="form-label">Color (e.g Black)</label>
                            <input type="text" class="form-control" id="color" name="color">
                        </div>
                        <div class="col-md-2">
                            <label for="registration_status">Status</label>
                            <select name="registration_status" class="form-control" id="registration_status" required>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                                <option value="Pending">Pending</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="approval">Approval Status</label>
                            <select name="approval" class="form-control" id="approval_status" required>
                                <option value="Approved">Approved</option>
                                <option value="Rejected">Rejected</option>
                                <option value="Pending">Pending</option>
                            </select>
                        </div>
                        <div class="col-md" id="reasonField">
                            <label for="reason">Reason for Rejection</label>
                            <input type="text" name="reason" id="reason" class="form-control" placeholder="Reason for Rejection">
                        </div>
                    </div>
                    <h5 class="mt-4">Vehicle Documents</h5>
                    <p class="text-danger">If the image doesn't change, please reload the page.</p>
                    <div class="row">
                        <div class="col-md">
                            <label for="official_receipt_image" class="form-label">Official Receipt Image</label>
                            <input type="file" class="form-control" name="official_receipt_image">
                        </div>
                        <div class="my-2 col-md">
                            <div id="official_receipt_image"></div>
                        </div>
                        <div class="col-md">
                            <label for="certificate_of_registration_image" class="form-label">Certificate of Registration Image</label>
                            <input type="file" class="form-control" name="certificate_of_registration_image">
                        </div>
                        <div class="my-2 col-md">
                            <div id="certificate_of_registration_image"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md">
                            <label for="deed_of_sale_image" class="form-label">Deed of Sale Image</label>
                            <input type="file" class="form-control" name="deed_of_sale_image">
                        </div>
                        <div class="my-2 col-md">
                            <div id="deed_of_sale_image"></div>
                        </div>
                        <div class="col-md">
                            <label for="authorization_letter_image" class="form-label">Authorization Letter Image</label>
                            <input type="file" class="form-control" name="authorization_letter_image">
                        </div>
                        <div class="my-2 col-md">
                            <div id="authorization_letter_image"></div>
                        </div>
                    </div>

                    <h5 class="mt-4">Vehicle Images</h5>
                    <p class="text-danger">If the image doesn't change, please reload the page.</p>
                    <div class="row">
                        <div class="col-md">
                            <label for="front_photo" class="form-label">Front Photo</label>
                            <input type="file" class="form-control" name="front_photo">
                        </div>
                        <div class="my-2 col-md">
                            <div class="my-2" id="front_photo"></div>
                        </div>
                        <div class="col-md">
                            <label for="side_photo" class="form-label">Side Photo</label>
                            <input type="file" class="form-control" name="side_photo">
                        </div>
                        <div class="my-2 col-md">
                            <div id="side_photo"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="edit_vehicle_btn" class="btn btn-primary" id="btn-save">Update Vehicle</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<!-- End Modal -->

<!-- View Modal -->
<div class="modal fade" id="viewVehicleModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">View Vehicle </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form action="javascript:void(0)" id="view_vehicle_form" name="view_vehicle_form" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="view_vehicle_id" id="view_vehicle_id">
                    <input type="hidden" name="view_official_receipt_image_photo" id="view_official_receipt_image_photo">
                    <input type="hidden" name="view_certificate_of_registration_image_photo" id="view_certificate_of_registration_image_photo">
                    <input type="hidden" name="view_deed_of_sale_image_photo" id="view_deed_of_sale_image_photo">
                    <input type="hidden" name="view_authorization_letter_image_photo" id="view_authorization_letter_image_photo">
                    <input type="hidden" name="view_front_photo_photo" id="view_front_photo_photo">
                    <input type="hidden" name="view_side_photo_photo" id="view_side_photo_photo">
                    <div class="row mb-3">
                        <h4>Vehicle Information</h4>
                        <div class="col-md-3">
                            <label for="position">Applicant Name</label>
                            <select name="view_applicant_name" id="view_applicant_name" class="form-control" onfocus='this.size=3;' onblur='this.size=1;' onchange='this.size=1; this.blur();' disabled>
                                <option value="">Select Applicant</option> <!-- Placeholder option -->
                                @forelse($owners as $owner)
                                <option value="{{ $owner->id }}">{{ $owner->first_name }} {{ $owner->last_name }}</option>
                                @empty
                                <option value="">No Owner Available</option>
                                @endforelse
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="position">Driver Name</label>
                            <select name="view_driver_name" id="view_driver_name" class="form-control" onfocus='this.size=3;' onblur='this.size=1;' onchange='this.size=1; this.blur();' disabled>
                                <option value="">Loading Driver</option> <!-- Placeholder option -->
                                @forelse($drivers as $driver)
                                <option value="{{ $driver->id }}">{{ $driver->driver_name }}</option>
                                @empty
                                <option value="">No driver Available</option>
                                @endforelse
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="owner_name" class="form-label">Owner Name</label>
                            <input type="text" class="form-control" id="view_owner_name" name="view_owner_name" disabled>
                        </div>
                        <div class="col-md-3">
                            <label for="owner_address" class="form-label">Owner Address</label>
                            <input type="text" class="form-control" id="view_owner_address" name="view_owner_address" disabled>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="plate_number" class="form-label">Plate Number</label>
                            <input type="text" class="form-control" id="view_plate_number" name="view_plate_number" disabled>
                        </div>
                        <div class="col-md-4">
                            <label for="vehicle_make" class="form-label">Vehicle Make</label>
                            <input type="text" class="form-control" id="view_vehicle_make" name="view_vehicle_make" disabled>
                        </div>
                        <div class="col-md-4">
                            <label for="year_model" class="form-label">Year Model</label>
                            <input type="text" class="form-control" id="view_year_model" name="view_year_model" disabled>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-2">
                            <label for="body_type" class="form-label">Body Type</label>
                            <input type="text" class="form-control" id="view_body_type" name="view_body_type" disabled>
                        </div>
                        <div class="col-md-2">
                            <label for="color" class="form-label">Color</label>
                            <input type="text" class="form-control" id="view_color" name="view_color" disabled>
                        </div>
                        <div class="col-md-2">
                            <label for="registration_status">Status</label>
                            <input name="view_registration_status" class="form-control" id="view_registration_status" disabled>
                        </div>
                        <div class="col-md-2">
                            <label for="approval">Approval Status</label>
                            <input name="view_approval" class="form-control" id="view_approval_status" disabled>
                        </div>
                        <div class="col-md">
                            <label for="reason">Reason for Rejection</label>
                            <input type="text" name="view_reason" id="view_reason" class="form-control" placeholder="Reason for Rejection" disabled>
                        </div>
                    </div>
                    <h5 class="mt-4">Vehicle Documents</h5>
                    <div class="row">
                        <div class="my-2 col-md">
                            <label for="official_receipt_image">Official Receipt Image</label>
                            <div id="view_official_receipt_image"></div>
                        </div>
                        <div class="my-2 col-md">
                            <label for="certificate_of_registration_image">Cert. of Register Image</label>
                            <div id="view_certificate_of_registration_image"></div>
                        </div>
                        <div class="my-2 col-md">
                            <label for="deed_of_sale_image">Deed of Sale Image</label>
                            <div id="view_deed_of_sale_image"></div>
                        </div>
                        <div class="my-2 col-md">
                            <label for="authorization_letter_image">Authorized Letter Image</label>
                            <div id="view_authorization_letter_image"></div>
                        </div>
                        <div class="my-2 col-md">
                            <label for="front_photo">Front Photo</label>
                            <div id="view_front_photo"></div>
                        </div>
                        <div class="my-2 col-md">
                            <label for="side_photo">Side Photo</label>
                            <div id="view_side_photo"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-primary view-btn" data-bs-dismiss="modal">View Full Details</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<!-- End Modal -->

<script>
    // JavaScript code to handle click event on the view button
    document.addEventListener('DOMContentLoaded', function () {
        const viewButton = document.querySelector('.view-btn');
        viewButton.addEventListener('click', function () {
            // Get the ID of the vehicle
            const vehicleId = document.getElementById('view_vehicle_id').value;
            // Redirect to the vehicle's show page using the ID
            window.location.href = '/vehicles/show/' + vehicleId;
        });
    });
</script>

