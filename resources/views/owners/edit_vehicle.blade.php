<!-- Edit Modal -->
<div class="modal fade" id="editVehicleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
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
                        <div class="col-md-3" style="display: none;">
                            <label for="owner_id" class="form-label">Owner ID</label>
                            <input type="text" class="form-control" id="owner_id" name="owner_id" value="{{ $vehicles->owner->id ?? 'Null' }}" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="owner_name" class="form-label">Owner Name</label>
                            <input type="text" class="form-control" id="owner_name" name="owner_name" value="{{ $vehicles->owner->first_name ?? 'Null' }} {{ $vehicles->owner->middle_initial ?? '' }}. {{ $vehicles->owner->last_name ?? '' }}" readonly>
                        </div>
                        <div class="col-md-3" style="display: none;">
                            <label for="driver_id" class="form-label">Driver Name</label>
                            <input type="text" class="form-control" id="driver_id" name="driver_id" value="{{ $vehicles->driver->id ?? 'Null' }}" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="driver_name" class="form-label">Driver Name</label>
                            <input type="text" class="form-control" id="driver_name" name="driver_name" value="{{ $vehicles->driver->driver_name ?? 'Null' }}" readonly>
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
                            <select name="registration_status" class="form-control" id="registration_status">
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
                            <select name="vehicle_approval_status" class="form-control" id="vehicle_approval_status" required>
                                <option value="Approved">Approved</option>
                                <option value="Rejected">Rejected</option>
                                <option value="Pending">Pending</option>
                            </select>
                            @error('approval')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md">
                            <label for="reason">Reason for Rejection</label>
                            <input type="text" name="vehicle_reason" id="vehicle_reason" class="form-control" placeholder="Reason for Rejection">
                        </div>
                    </div>
                         <div class="row mb-3">
                        <h4>Vehicle Documents</h4>
                        <div class="col-md-6">
                            <label for="official_receipt_image" class="form-label">Official Receipt Image</label>
                            <input type="file" class="form-control" name="official_receipt_image">
                        </div>
                        @if($vehicles)
                        <img src="{{ asset('storage/images/vehicles/documents/' . $vehicles->official_receipt_image) }}" alt="official_receipt_image" class="img-thumbnail mx-auto d-block" style="width: 300px; height: 200px;">
                        @else
                        <!-- Display a placeholder image or message -->
                        <p>No vehicle associated</p>
                        @endif
                        <div class="col-md-6">
                            <label for="certificate_of_registration_image" class="form-label">Certificate of Registration Image</label>
                            <input type="file" class="form-control" name="certificate_of_registration_image">
                        </div>
                        @if($vehicles)
                        <img src="{{ asset('storage/images/vehicles/documents/' . $vehicles->certificate_of_registration_image) }}" alt="certificate_of_registration_image" class="img-thumbnail mx-auto d-block" style="width: 300px; height: 200px;">
                        @else
                        <!-- Display a placeholder image or message -->
                        <p>No vehicle associated</p>
                        @endif
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="deed_of_sale_image" class="form-label">Deed of Sale Image</label>
                            <input type="file" class="form-control" name="deed_of_sale_image">
                        </div>
                        @if($vehicles)
                        <img src="{{ asset('storage/images/vehicles/documents/' . $vehicles->deed_of_sale_image) }}" alt="deed_of_sale_image" class="img-thumbnail mx-auto d-block" style="width: 300px; height: 200px;">
                        @else
                        <!-- Display a placeholder image or message -->
                        <p>No vehicle associated</p>
                        @endif
                        <div class="col-md-6">
                            <label for="authorization_letter_image" class="form-label">Authorization Letter Image</label>
                            <input type="file" class="form-control" name="authorization_letter_image">
                        </div>
                        @if($vehicles)
                        <img src="{{ asset('storage/images/vehicles/documents/' . $vehicles->authorization_letter_image) }}" alt="authorization_letter_image" class="img-thumbnail mx-auto d-block" style="width: 300px; height: 200px;">
                        @else
                        <!-- Display a placeholder image or message -->
                        <p>No vehicle associated</p>
                        @endif
                    </div>
                    <div class="row mb-3">
                        <h4>Vehicle Images</h4>
                        <div class="col-md-6">
                            <label for="front_photo" class="form-label">Front Photo</label>
                            <input type="file" class="form-control" name="front_photo">
                        </div>
                        @if($vehicles)
                        <img src="{{ asset('storage/images/vehicles/' . $vehicles->front_photo) }}" alt="front_photo" class="img-thumbnail mx-auto d-block" style="width: 300px; height: 200px;">
                        @else
                        <!-- Display a placeholder image or message -->
                        <p>No vehicle associated</p>
                        @endif
                        <div class="col-md-6">
                            <label for="side_photo" class="form-label">Side Photo</label>
                            <input type="file" class="form-control" name="side_photo">
                        </div>
                        @if($vehicles)
                        <img src="{{ asset('storage/images/vehicles/' . $vehicles->side_photo) }}" alt="side_photo" class="img-thumbnail mx-auto d-block" style="width: 300px; height: 200px;">
                        @else
                        <!-- Display a placeholder image or message -->
                        <p>No vehicle associated</p>
                        @endif
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