<!-- Add Modal -->
<div class="modal fade" id="addAppointmentModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Appointment</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form action="javascript:void(0)" id="add_appointment_form" name="add_appointment_form" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="col-md-3">
                        <label for="appointment" class="form-label">Appointment</label>
                        <input type="text" class="form-control" id="appointment" name="appointment" required>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="add_appointment_btn" class="btn btn-primary" id="btn-save">Add Appointment</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<!-- End Modal -->

<!-- Edit Modal -->
<div class="modal fade" id="editAppointmentModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Appointment</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form action="javascript:void(0)" id="edit_appointment_form" name="edit_appointment_form" method="POST" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="appointment_id" id="appointment_id">

                    <div class="col-md-3">
                        <label for="edit_appointment" class="form-label">Appointment</label>
                        <input type="text" class="form-control" id="edit_appointment" name="edit_appointment" required>
                    </div>

                    <div class="my-2" id="scan_or_photo_of_id"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="edit_appointment_btn" class="btn btn-primary" id="btn-save">Update Appointment</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<!-- End Edit Modal -->