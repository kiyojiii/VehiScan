<!-- Edit Modal -->
<div class="modal fade" id="editDriverModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Driver</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form action="javascript:void(0)" id="edit_driver_form" name="edit_driver_form" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="driver_id" id="driver_id">
                    <input type="hidden" name="dlicense_photo" id="dlicense_photo">
                    <input type="hidden" name="adlicense_photo" id="adlicense_photo">
                    <!-- Driver's Info -->
                    <h5>Driver's Info</h5>
                    <div class="row">
                        <div class="col-md">
                            <label for="dname">Driver Name</label>
                            <input type="text" name="dname" id="dname" class="form-control" placeholder="Driver Name">
                        </div>
                        <div class="col-md">
                            <label for="driver_license_image">Driver's License</label>
                            <input type="file" name="driver_license_image" class="form-control">
                        </div>
                        <img src="{{ asset('storage/images/drivers/' . $owners->vehicle->driver->driver_license_image) }}" alt="driver_license_image" class="img-thumbnail mx-auto d-block" style="width: 300px; height: 200px;">
                    </div>

                    <!-- Authorized Driver's Info -->
                    <h5 class="mt-4">Authorized Driver's Info</h5>
                    <div class="row">
                        <div class="col-md">
                            <label for="adname">Authorized Driver Name</label>
                            <input type="text" name="adname" id="adname" class="form-control" placeholder="Authorized Driver Name">
                        </div>
                        <div class="col-md">
                            <label for="adaddress">Authorized Driver Address</label>
                            <input type="text" name="adaddress" id="adaddress" class="form-control" placeholder="Authorized Driver Address">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                    <div class="col-md-2">
                            <label for="approval">Approval Status</label>
                            <select name="driver_approval_status" class="form-control" id="driver_approval_status">
                                <option value="Approved" selected>Approved</option>
                                <option value="Rejected">Rejected</option>
                                <option value="Pending">Pending</option>
                            </select>
                        </div>
                        <div class="col-md">
                            <label for="driver_reason">Reason for Rejection</label>
                            <input type="text" name="driver_reason" id="driver_reason" class="form-control" placeholder="Reason for Rejection">
                        </div>
                        <div class="col-md">
                            <label for="authorized_driver_license_image">Authorized Driver's License</label>
                            <input type="file" name="authorized_driver_license_image" class="form-control">
                        </div>
                        <img src="{{ asset('storage/images/drivers/' . $owners->vehicle->driver->authorized_driver_license_image) }}" alt="authorized_driver_license_image" class="img-thumbnail mx-auto d-block" style="width: 300px; height: 200px;">     
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