@forelse($owners as $owner)
<!-- Add Modal -->
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
                            <label for="owner_id" class="form-label">Owner ID</label>
                            <input type="text" class="form-control" id="owner_id" name="owner_id" value="{{ $owners->id ?? 'Null' }}" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="owner_name" class="form-label">Owner Name</label>
                            <input type="text" class="form-control" id="owner_name" name="owner_name" value="{{ $owners->first_name ?? 'Null' }} {{ $owners->middle_initial ?? '' }}. {{ $owners->last_name ?? '' }}" readonly>
                        </div>
                        <div class="col-md-3" style="display: none;">
                            <label for="driver_id" class="form-label">Driver Name</label>
                            <input type="text" class="form-control" id="driver_id" name="driver_id" value="{{ $owners->vehicle->driver->id ?? 'Null' }}" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="driver_name" class="form-label">Driver Name</label>
                            <input type="text" class="form-control" id="driver_name" name="driver_name" value="{{ $owners->vehicle->driver->driver_name ?? 'Null' }}" readonly>
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

<!-- Add Modal -->
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