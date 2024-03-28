<!-- Add Modal -->
<div class="modal fade" id="addViolationModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Violation</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form action="javascript:void(0)" id="add_violation_form" name="add_violation_form" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Vehicle Dropdown -->
                    <div class="mb-3">
                        <div class="col-md-6">
                            <label for="vehicle_id" class="form-label">Vehicle</label>
                            <br>
                            <select name="vehicle_id" id="vehicle_id" class="vehicle-select">
                                <option value="">Select Vehicle</option> <!-- Placeholder option -->
                                @forelse($vehicles as $vehicle)
                                <option value="{{ $vehicle->id }}">{{ $vehicle->plate_number }} - {{ $vehicle->vehicle_make }} - {{ $vehicle->color }}</option>
                                @empty
                                <option value="">No Vehicles Available</option>
                                @endforelse
                            </select>
                        </div>
                        <br>
                        <!-- Violation Input -->
                        <div class="col-md-3">
                            <label for="violation" class="form-label">Violation</label>
                            <input type="text" class="form-control" id="violation" name="violation" required>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="add_violation_btn" class="btn btn-primary" id="btn-save">Add Violation</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<!-- End Modal -->

<!-- Edit Modal -->
<div class="modal fade" id="editViolationModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Violation</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form action="javascript:void(0)" id="edit_violation_form" name="edit_violation_form" method="POST" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="violation_id" id="violation_id">

                    <!-- Vehicle Dropdown -->
                    <div class="mb-3">
                        <div class="col-md-6">
                            <label for="edit_vehicle_id" class="form-label">Vehicle</label>
                            <br>
                            <select name="edit_vehicle_id" id="edit_vehicle_id" class="form-select edit-vehicle-select">
                                <option value="">Select Vehicle</option> <!-- Placeholder option -->
                                @forelse($vehicles as $vehicle)
                                <option value="{{ $vehicle->id }}">{{ $vehicle->plate_number }} - {{ $vehicle->vehicle_make }} - {{ $vehicle->color }}</option>
                                @empty
                                <option value="">No Vehicles Available</option>
                                @endforelse
                            </select>
                        </div>
                        <br>
                        <!-- Violation Input -->
                        <div class="col-md-3">
                            <label for="violation" class="form-label">Violation</label>
                            <input type="text" class="form-control" id="edit_violation" name="edit_violation" required>
                        </div>

                        <div class="my-2" id="scan_or_photo_of_id"></div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" id="edit_violation_btn" class="btn btn-primary" id="btn-save">Update Violation</button>
                        </div>
                </form>
            </div>

        </div>
    </div>
</div>
<!-- End Edit Modal -->