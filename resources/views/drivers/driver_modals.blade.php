<!-- Add Modal -->
<div class="modal fade" id="addDriverModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                            @error('driver_license_image')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Authorized Driver's Info -->
                    <h5 class="mt-4">Authorized Driver's Info</h5>
                    <div class="row">
                        <div class="col-md">
                            <label for="adname">Authorized Driver Name</label>
                            <input type="text" name="adname" class="form-control" placeholder="Authorized Driver Name" required>
                            @error('adname')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md">
                            <label for="adaddress">Authorized Driver Address</label>
                            <input type="text" name="adaddress" class="form-control" placeholder="Authorized Driver Address" required>
                            @error('adaddress')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md">
                            <label for="authorized_driver_license_image">Authorized Driver's License</label>
                            <input type="file" name="authorized_driver_license_image" class="form-control" required>
                            @error('authorized_driver_license_image')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-2">
                            <label for="approval">Approval Status</label>
                            <select name="approval" class="form-control" id="approvalStatus" required>
                                <option value="Approved" selected>Approved</option>
                                <option value="Rejected">Rejected</option>
                                <option value="Pending">Pending</option>
                            </select>
                            @error('approval')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md" id="reasonField" style="display: none;">
                            <label for="reason">Reason for Rejection</label>
                            <input type="text" name="reason" class="form-control" placeholder="Reason for Rejection">
                            @error('reason')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
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

<!-- Edit Modal -->
<div class="modal fade" id="editDriverModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                            @error('dname')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md">
                            <label for="driver_license_image">Driver's License</label>
                            <input type="file" name="driver_license_image" class="form-control">
                            @error('driver_license_image')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="my-2" id="driver_license_image"></div>
                    </div>

                    <!-- Authorized Driver's Info -->
                    <h5 class="mt-4">Authorized Driver's Info</h5>
                    <div class="row">
                        <div class="col-md">
                            <label for="adname">Authorized Driver Name</label>
                            <input type="text" name="adname" id="adname" class="form-control" placeholder="Authorized Driver Name">
                            @error('adname')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md">
                            <label for="adaddress">Authorized Driver Address</label>
                            <input type="text" name="adaddress" id="adaddress" class="form-control" placeholder="Authorized Driver Address">
                            @error('adaddress')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md">
                            <label for="authorized_driver_license_image">Authorized Driver's License</label>
                            <input type="file" name="authorized_driver_license_image" class="form-control">
                            @error('authorized_driver_license_image')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="my-2" id="authorized_driver_license_image"></div>
                        <div class="col-md-2">
                            <label for="approval">Approval Status</label>
                            <select name="approval" class="form-control" id="approval">
                                <option value="Approved" selected>Approved</option>
                                <option value="Rejected">Rejected</option>
                                <option value="Pending">Pending</option>
                            </select>
                            @error('approval')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md" id="reasonField">
                            <label for="reason">Reason for Rejection</label>
                            <input type="text" name="reason" id="reason" class="form-control" placeholder="Reason for Rejection">
                            @error('reason')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="edit_driver_btn" class="btn btn-primary" id="btn-save">Edit Driver</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<!-- End Modal -->