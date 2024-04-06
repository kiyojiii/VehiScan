@forelse($vehicles as $vehicle)
<div class="col-xl-6 col-md-8">
    <div class="card mb-4">
        <div class="card-body">
            <div class="favorite-icon">
                <a href="javascript:void(0)"><i class="uil uil-heart-alt fs-18"></i></a>
            </div>
            @if($vehicle->front_photo)
            <!-- Assuming $frontPhotoImage is retrieved from the database -->
            <img src="{{ asset('storage/images/vehicles/' . $vehicle->front_photo) }}" alt="front photo" class="img-thumbnail mx-auto d-block img-modal" style="width: 300px; height: 200px;">
            @else
            <p>No front photo available</p>
            @endif
            <h5 class="fs-17 mb-2"><a href="job-details.html" class="text-dark">{{ $vehicle->plate_number ?? 'N/A' }}</a> <small class="text-muted fw-normal">({{ $vehicle->vehicle_code }})</small></h5>
            <ul class="list-inline mb-0">
                <li class="list-inline-item">
                    <p class="text-muted fs-14 mb-1"><i class="fas fa-car"></i> {{ $vehicle->vehicle_make ?? 'N/A' }}</p>
                </li><br>
                <!-- <li class="list-inline-item">
                    <p class="text-muted fs-14 mb-0"><i class="mdi mdi-map-marker"></i> {{ $vehicle->year_make ?? 'N/A'  }}</p>
                </li> -->
                <li class="list-inline-item">
                    <p class="text-muted fs-14 mb-0"><i class="fas fa-info-circle"></i> {{ $vehicle->registration_status ?? 'N/A' }}</p>
                </li>
                <li>
                    <strong scope="row">Approval Status</strong>
                    @if($vehicle)
                    @if($vehicle->approval_status == 'Approved')
                    <strong><span class="badge badge-soft-success">Approved</span></strong>
                    @elseif($vehicle->approval_status == 'Rejected')
                    <strong><span class="badge badge-soft-danger">Rejected</span></strong>
                    @elseif($vehicle->approval_status == 'Pending')
                    <strong><span class="badge badge-soft-warning">Pending</span></strong>
                    @else
                    <strong><span class="badge badge-soft-secondary">Unknown</span></strong>
                    @endif
                    @else
                    <strong><span class="badge badge-soft-secondary">No Vehicle Associated</span></strong>
                    @endif
                </li>
                <li>
                    <strong>Applied Date:</strong>
                    <span>
                        @if($vehicle && $vehicle->created_at)
                        {{ \Carbon\Carbon::parse($vehicle->created_at)->format('d F, Y') }}
                        @else
                        N/A
                        @endif
                    </span>
                </li>
                <li>
                    <strong>Reason(If Rejected):</strong>
                    <span>{{ $vehicle->reason ?? 'N/A' }}</span>
                </li>
            </ul>
            <div class="mt-3 hstack gap-2">
                <span class="badge rounded-1 badge-soft-success">{{ $vehicle->year_model ?? 'N/A' }}</span>
                <span class="badge rounded-1 badge-soft-warning">{{ $vehicle->color ?? 'N/A' }}</span>
                <span class="badge rounded-1 badge-soft-info">{{ $vehicle->body_type ?? 'N/A' }}</span>
            </div>
            <div class="mt-4 hstack gap-2">
                <a href="{{ route('applicant_users.vehicle_information', $vehicle->id) }}" class="btn btn-soft-primary w-100">View</a>
                @if($vehicle->registration_status === 'Active')
                <a href="#" id="{{ $vehicle->id }}" data-bs-toggle="modal" class="btn btn-soft-danger w-100 deleteVehicle">Deactivate</a>
                @else
                <a href="#" id="{{ $vehicle->id }}" data-bs-toggle="modal" class="btn btn-soft-danger w-100 disabled-link">Inactive</a>
                @if($no_active_vehicles)
                @if($has_pending_vehicle)
                <a href="#" id="{{ $vehicle->id }}" class="btn btn-soft-warning w-100 activateVehicle" onClick="showPendingAlert()">Activate</a>
                @else
                <a href="#" id="{{ $vehicle->id }}" class="btn btn-soft-warning w-100 activateVehicle" onClick="activateVehicle()">Activate</a>
                @endif
                @endif
                @endif

            </div>
            <script>
                function showPendingAlert() {
                    // Show SweetAlert message
                    Swal.fire({
                        title: 'Pending Vehicle Exists',
                        text: 'You can only have one Pending Vehicle, Please Wait while a Staff reviews your Pending Vehicle',
                        icon: 'warning'
                    });
                }
            </script>

        </div>
    </div>
</div>
@empty
<div class="col">
    <p>No vehicles found.</p>
</div>
@endforelse
<style>
    .disabled-link {
        color: #6c757d;
        cursor: not-allowed;
        pointer-events: none;
    }
</style>