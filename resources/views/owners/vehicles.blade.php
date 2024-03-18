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
            <h5 class="fs-17 mb-2"><a href="job-details.html" class="text-dark">{{ $vehicle->plate_number ?? 'N/A' }}</a> <small class="text-muted fw-normal">(0-2 Yrs Exp.)</small></h5>
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
                    @if($owners->vehicle)
                    @if($owners->vehicle->approval_status == 'Approved')
                    <strong><span class="badge badge-soft-success">{{ $owners->vehicle->approval_status }}</span></strong>
                    @elseif($owners->vehicle->approval_status == 'Rejected')
                    <strong><span class="badge badge-soft-danger">Rejected</span></strong>
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
                        @if($owners->vehicle && $owners->vehicle->created_at)
                        {{ \Carbon\Carbon::parse($owners->vehicle->created_at)->format('d F, Y') }}
                        @else
                        N/A
                        @endif
                    </span>
                </li>
                <li>
                    <strong>Reason(If Rejected):</strong>
                    <span>{{ $owners->vehicle->reason ?? 'N/A' }}</span>
                </li>
            </ul>
            <div class="mt-3 hstack gap-2">
                <span class="badge rounded-1 badge-soft-success">{{ $vehicle->year_model ?? 'N/A' }}</span>
                <span class="badge rounded-1 badge-soft-warning">{{ $vehicle->color ?? 'N/A' }}</span>
                <span class="badge rounded-1 badge-soft-info">{{ $vehicle->body_type ?? 'N/A' }}</span>
            </div>
            <div class="mt-4 hstack gap-2">
                <a href="{{ route('owners.vehicle_information', $vehicle->id) }}" class="btn btn-soft-success w-100">View Profile</a>
                <a href="#" id="{{ $vehicle->id }}" data-bs-toggle="modal" class="btn btn-soft-danger w-100 deleteVehicle">Delete Vehicle</a>
            </div>
        </div>
    </div>
</div>
@empty
<div class="col">
    <p>No vehicles found.</p>
</div>
@endforelse
