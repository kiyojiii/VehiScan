<!-- Add Modal -->
<div class="modal fade" id="addRoleStatusModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Role Status</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form action="javascript:void(0)" id="add_rolestatus_form" name="add_rolestatus_form" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- RoleStatus Input -->
                    <div class="col-md-3">
                        <label for="status" class="form-label">Role Status</label>
                        <input type="text" class="form-control" id="applicant_role_status" name="applicant_role_status" required>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="add_rolestatus_btn" class="btn btn-primary" id="btn-save">Add Role Status</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<!-- End Modal -->

<!-- Edit Modal -->
<div class="modal fade" id="editRoleStatusModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Role Status</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form action="javascript:void(0)" id="edit_rolestatus_form" name="edit_rolestatus_form" method="POST" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="rolestatus_id" id="rolestatus_id">

                    <!-- RoleStatus Input -->
                    <div class="col-md-3">
                        <label for="status" class="form-label">Role Status</label>
                        <input type="text" class="form-control" id="edit_applicant_role_status" name="edit_applicant_role_status" required>
                    </div>

                    <div class="my-2" id="scan_or_photo_of_id"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="edit_rolestatus_btn" class="btn btn-primary" id="btn-save">Update Role Status</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<!-- End Edit Modal -->