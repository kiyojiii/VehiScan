<div class="modal fade" id="viewImageModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">View Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img id="viewImage" src="" class="img-fluid" alt="Image">
            </div>
        </div>
    </div>
</div>

<script>
    // JavaScript/jQuery code
    $(document).ready(function() {
        // Add click event listener to each image element with the class 'viewImage'
        $('.viewImage').on('click', function() {
            // Get the URL of the clicked image from the 'data-image-url' attribute
            var imageUrl = $(this).data('image-url');
            // Set the 'src' attribute of the modal image to the clicked image URL
            $('#viewImage').attr('src', imageUrl);
            // Open the modal
            $('#viewImageModal').modal('show');
        });
    });
</script>

<!-- View Modal -->
<div class="modal fade" id="viewVehicleModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">View Vehicle</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form action="javascript:void(0)" id="view_vehicle_form" name="view_vehicle_form" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="view_vehicle_id" id="view_vehicle_id">
                    <input type="hidden" name="view_official_receipt_image_photo" id="view_official_receipt_image_photo">
                    <input type="hidden" name="view_certificate_of_registration_image_photo" id="view_certificate_of_registration_image_photo">
                    <input type="hidden" name="view_deed_of_sale_image_photo" id="view_deed_of_sale_image_photo">
                    <input type="hidden" name="view_authorization_letter_image_photo" id="view_authorization_letter_image_photo">
                    <input type="hidden" name="view_front_photo_photo" id="view_front_photo_photo">
                    <input type="hidden" name="view_side_photo_photo" id="view_side_photo_photo">
                    <div class="row mb-3">
                        <h4>Vehicle Information</h4>
                        <div class="col-md" style="display: none;">
                            <label for="position">Driver ID</label>
                            <input type="text" name="view_driver_id" id="view_driver_id" class="form-control" placeholder="Driver ID" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="position">Driver Name</label>
                            <input type="text" name="view_driver_name" id="view_driver_name" class="form-control" value="{{ $vehicles->driver->driver_name ?? 'N/A' }}" placeholder="Driver Name" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="owner_name" class="form-label">Owner Name</label>
                            <input type="text" class="form-control" id="view_owner_name" name="view_owner_name" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="owner_address" class="form-label">Owner Address</label>
                            <input type="text" class="form-control" id="view_owner_address" name="view_owner_address" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="plate_number" class="form-label">Plate Number (e.g ABC 123)</label>
                            <input type="text" class="form-control" id="view_plate_number" name="view_plate_number" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-2">
                            <label for="vehicle_make" class="form-label">Vehicle Make <br> (e.g Ford)</label>
                            <input type="text" class="form-control" id="view_vehicle_make" name="view_vehicle_make" readonly>
                        </div>
                        <div class="col-md-2">
                            <label for="vehicle_category" class="form-label">Vehicle Category <br> (e.g Car)</label>
                            <input type="text" class="form-control" id="view_vehicle_category" name="view_vehicle_category" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="year_model" class="form-label">Year Model <br> (e.g Everest 2022)</label>
                            <input type="text" class="form-control" id="view_year_model" name="view_year_model" readonly>
                        </div>
                        <div class="col-md-2">
                            <label for="body_type" class="form-label">Body Type <br> (e.g SUV)</label>
                            <input type="text" class="form-control" id="view_body_type" name="view_body_type" readonly>
                        </div>
                        <div class="col-md-2">
                            <label for="color" class="form-label">Color <br> (e.g Black)</label>
                            <input type="text" class="form-control" id="view_color" name="view_color" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-2">
                            <label for="body_type" class="form-label">Registration Status</label>
                            <input type="text" class="form-control" id="view_registration_status" name="view_registration_status" readonly>
                        </div>
                        <div class="col-md-2">
                            <label for="body_type" class="form-label">Approval Status</label>
                            <input type="text" class="form-control" id="view_approval_status" name="view_approval_status" readonly>
                        </div>
                        <div class="col-md-2">
                            <label for="body_type" class="form-label">Reason</label>
                            <input type="text" class="form-control" id="view_reason" name="view_reason" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <h4> Vehicle Documents </h4>
                        <!-- Front Photo -->
                        <div class="col-md-2">
                            <label for="front_photo" class="form-label">Front Photo</label>
                            <div class="my-2 viewImage" id="view_front_photo" style="width: 300px; height: 200px;"></div>
                        </div>
                        <!-- Side Photo -->
                        <div class="col-md-2">
                            <label for="side_photo" class="form-label">Side Photo</label>
                            <div class="my-2" id="view_side_photo" style="width: 300px; height: 200px;"></div>
                        </div>
                        <!-- Official Receipt Image -->
                        <div class="col-md-2">
                            <label for="official_receipt_image" class="form-label">Official Receipt</label>
                            <div class="my-2" id="view_official_receipt_image" style="width: 300px; height: 200px;"></div>
                        </div>
                        <!-- Certificate of Registration Image -->
                        <div class="col-md-2">
                            <label for="certificate_of_registration_image" class="form-label">Cert. of Registration</label>
                            <div class="my-2" id="view_certificate_of_registration_image" style="width: 300px; height: 200px;"></div>
                        </div>
                        <!-- Deed of Sale Image -->
                        <div class="col-md-2">
                            <label for="deed_of_sale_image" class="form-label">Deed of Sale</label>
                            <div class="my-2" id="view_deed_of_sale_image" style="width: 300px; height: 200px;"></div>
                        </div>
                        <!-- Authorization Letter Image -->
                        <div class="col-md-2">
                            <label for="authorization_letter_image" class="form-label">Authorized Letter</label>
                            <div class="my-2" id="view_authorization_letter_image" style="width: 300px; height: 200px;"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<!-- End Modal -->

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
                        <div class="col-md" style="display: none;">
                            <label for="position">Driver ID</label>
                            <input type="text" name="driver_id" id="driver_id" class="form-control" placeholder="Driver ID" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="position">Driver Name</label>
                            <input type="text" name="driver_name" id="driver_name" class="form-control" value="{{ $vehicles->driver->driver_name ?? 'N/A' }}" placeholder="Driver Name" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="owner_name" class="form-label">Owner Name</label>
                            <input type="text" class="form-control" id="owner_name" name="owner_name">
                        </div>
                        <div class="col-md-3">
                            <label for="owner_address" class="form-label">Owner Address</label>
                            <input type="text" class="form-control" id="owner_address" name="owner_address">
                        </div>
                        <div class="col-md-3">
                            <label for="plate_number" class="form-label">Plate Number (e.g ABC 123)</label>
                            <input type="text" class="form-control" id="plate_number" name="plate_number">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-2">
                            <label for="vehicle_make" class="form-label">Vehicle Make <br> (e.g Ford)</label>
                            <input type="text" class="form-control" id="vehicle_make" name="vehicle_make">
                        </div>
                        <div class="col-md-2">
                            <label for="vehicle_category" class="form-label">Vehicle Category <br> (e.g Car)</label>
                            <input type="text" class="form-control" id="vehicle_category" name="vehicle_category">
                        </div>
                        <div class="col-md-3">
                            <label for="year_model" class="form-label">Year Model <br> (e.g Vios E 2022)</label>
                            <input type="text" class="form-control" id="year_model" name="year_model">
                        </div>
                        <div class="col-md-2">
                            <label for="body_type" class="form-label">Body Type <br> (e.g Sedan)</label>
                            <input type="text" class="form-control" id="body_type" name="body_type">
                        </div>
                        <div class="col-md-2">
                            <label for="color" class="form-label">Color <br> (e.g Black)</label>
                            <input type="text" class="form-control" id="color" name="color">
                        </div>
                        <div class="col-md-2" style="display: none;">
                            <label for="registration_status" class="form-label">Registration Status</label>
                            <input type="text" class="form-control" id="registration_status" name="registration_status">
                        </div>
                        <div class="col-md-2" style="display: none;">
                            <label for="approval_status" class="form-label">Approval Status</label>
                            <input type="text" class="form-control" id="approval_status" name="approval_status">
                        </div>
                        <div class="col-md-2" style="display: none;">
                            <label for="reason" class="form-label">Reason</label>
                            <input type="text" class="form-control" id="reason" name="reason">
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
                        <button type="submit" id="edit_vehicle_btn" class="btn btn-primary" id="btn-save">Edit Vehicle</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<!-- End Modal -->

<!-- QR Code Modal -->
<div class="modal fade" id="qrCodeModal" tabindex="-1" aria-labelledby="qrCodeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="qrCodeModalLabel">QR Code Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- QR code image will be displayed here -->
            </div>
        </div>
    </div>
</div>