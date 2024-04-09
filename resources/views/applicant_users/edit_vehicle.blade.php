@forelse($owners as $owner)
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
                    <input type="hidden" name="official_receipt_image_photo" id="official_receipt_image_photo">
                    <input type="hidden" name="certificate_of_registration_image_photo" id="certificate_of_registration_image_photo">
                    <input type="hidden" name="deed_of_sale_image_photo" id="deed_of_sale_image_photo">
                    <input type="hidden" name="authorization_letter_image_photo" id="authorization_letter_image_photo">
                    <input type="hidden" name="front_photo_photo" id="front_photo_photo">
                    <input type="hidden" name="side_photo_photo" id="side_photo_photo">
                    <div class="row mb-3">
                        <h4>Vehicle Information</h4>
                        <div class="col-md" style="display: none">
                            <label for="position">Vehicle ID</label>
                            <input type="text" name="vehicle_id" id="vehicle_id" class="form-control" value="{{ $owner->vehicle->id ?? 'N/A' }}" placeholder="Vehicle ID" readonly>
                        </div>
                        <div class="col-md" style="display: none">
                            <label for="position">Driver ID</label>
                            <input type="text" name="driver_id" id="driver_id" class="form-control" value="{{ $owner->vehicle->driver->id ?? 'N/A' }}" placeholder="Driver ID" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="position">Driver Name</label>
                            <input type="text" name="driver_name" id="driver_name" class="form-control" value="{{ $owner->vehicle->driver->driver_name ?? 'N/A' }}" placeholder="Driver Name" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="owner_name" class="form-label">Owner Name</label>
                            <input type="text" class="form-control" id="owner_name" name="owner_name" placeholder="Owner Name">
                        </div>
                        <div class="col-md-3">
                            <label for="owner_address" class="form-label">Owner Address</label>
                            <input type="text" class="form-control" id="owner_address" name="owner_address" placeholder="Owner Address">
                        </div>
                        <div class="col-md-3">
                            <label for="plate_number" class="form-label">Plate Number (e.g ABC 123)</label>
                            <input type="text" class="form-control" id="plate_number" name="plate_number" placeholder="Plate Number">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="vehicle_make" class="form-label">Vehicle Make (e.g Toyota)</label>
                            <input type="text" class="form-control" id="vehicle_make" name="vehicle_make" placeholder="Vehicle Make">
                        </div>
                        <div class="col-md-3">
                            <label for="year_model" class="form-label">Year Model (e.g Vios E 2020)</label>
                            <input type="text" class="form-control" id="year_model" name="year_model" placeholder="Year Model">
                        </div>
                        <div class="col-md-2">
                            <label for="body_type" class="form-label">Body Type (e.g Sedan)</label>
                            <input type="text" class="form-control" id="body_type" name="body_type" placeholder="Body Type">
                        </div>
                        <div class="col-md-2">
                            <label for="color" class="form-label">Color (e.g Black)</label>
                            <input type="text" class="form-control" id="color" name="color" placeholder="Color">
                        </div>
                        <div class="col-md-2">
                            <label for="registration_status">Status</label>
                            <input type="text" class="form-control" name="registration_status" id="registration_status" placeholder="Registration Status" value="Active" readonly>
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
                            @if($owner->vehicle)
                            <img src="{{ asset('storage/images/vehicles/documents/' . $owner->vehicle->official_receipt_image) }}" alt="official_receipt_image" class="img-thumbnail mx-auto d-block" style="width: 300px; height: 200px;">
                            @else
                            <!-- Display a placeholder image or message -->
                            <p>No vehicle associated</p>
                            @endif
                        </div>
                        <!-- Certificate of Registration Image -->
                        <div class="col-md-3">
                            <label for="certificate_of_registration_image" class="form-label">Certificate of Registration Image</label>
                            <input type="file" class="form-control" name="certificate_of_registration_image">
                        </div>
                        <!-- Previous Certificate of Registration Image -->
                        <div class="col-md-3">
                            @if($owner->vehicle)
                            <img src="{{ asset('storage/images/vehicles/documents/' . $owner->vehicle->certificate_of_registration_image) }}" alt="certificate_of_registration_image" class="img-thumbnail mx-auto d-block" style="width: 300px; height: 200px;">
                            @else
                            <!-- Display a placeholder image or message -->
                            <p>No vehicle associated</p>
                            @endif
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
                            @if($owner->vehicle)
                            <img src="{{ asset('storage/images/vehicles/documents/' . $owner->vehicle->deed_of_sale_image) }}" alt="deed_of_sale_image" class="img-thumbnail mx-auto d-block" style="width: 300px; height: 200px;">
                            @else
                            <!-- Display a placeholder image or message -->
                            <p>No vehicle associated</p>
                            @endif
                        </div>
                        <!-- Authorization Letter Image -->
                        <div class="col-md-3">
                            <label for="authorization_letter_image" class="form-label">Authorization Letter Image</label>
                            <input type="file" class="form-control" name="authorization_letter_image">
                        </div>
                        <!-- Previous Authorization Letter Image -->
                        <div class="col-md-3">
                            @if($owner->vehicle)
                            <img src="{{ asset('storage/images/vehicles/documents/' . $owner->vehicle->authorization_letter_image) }}" alt="authorization_letter_image" class="img-thumbnail mx-auto d-block" style="width: 300px; height: 200px;">
                            @else
                            <!-- Display a placeholder image or message -->
                            <p>No vehicle associated</p>
                            @endif
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
                            @if($owner->vehicle)
                            <img src="{{ asset('storage/images/vehicles/' . $owner->vehicle->front_photo) }}" alt="front_photo" class="img-thumbnail mx-auto d-block" style="width: 300px; height: 200px;">
                            @else
                            <!-- Display a placeholder image or message -->
                            <p>No vehicle associated</p>
                            @endif
                        </div>
                        <!-- Side Photo -->
                        <div class="col-md-3">
                            <label for="side_photo" class="form-label">Side Photo</label>
                            <input type="file" class="form-control" name="side_photo">
                        </div>
                        <!-- Previous Side Photo -->
                        <div class="col-md-3">
                            @if($owner->vehicle)
                            <img src="{{ asset('storage/images/vehicles/' . $owner->vehicle->side_photo) }}" alt="side_photo" class="img-thumbnail mx-auto d-block" style="width: 300px; height: 200px;">
                            @else
                            <!-- Display a placeholder image or message -->
                            <p>No vehicle associated</p>
                            @endif
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
@empty

@endforelse