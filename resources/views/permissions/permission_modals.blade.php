<!-- Add Modal -->
<div class="modal fade" id="addPermissionModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Permission</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form action="javascript:void(0)" id="add_permission_form" name="add_permission_form" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Permission Input -->
                    <div class="form-group">
                        <label for="permission" class="form-label">Permission Name</label>
                        <input type="text" class="form-control" id="permission" name="permission" required>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="add_permission_btn" class="btn btn-primary" id="btn-save">Add Permission</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<!-- End Modal -->

<!-- Edit Modal -->
<div class="modal fade" id="editPermissionModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Permission</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form action="javascript:void(0)" id="edit_permission_form" name="edit_permission_form" method="POST" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="permission_id" id="permission_id">

                    <!-- Permission Input -->
                    <div class="form-group">
                        <label for="edit_permission" class="form-label">Permission Name</label>
                        <input type="text" class="form-control" id="edit_permission" name="edit_permission" required>
                    </div>

                    <div class="my-2" id="scan_or_photo_of_id"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="edit_permission_btn" class="btn btn-primary" id="btn-save">Update Permission</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<!-- End Edit Modal -->