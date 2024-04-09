<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MVIS | Owner - Show</title>

    <link rel="icon" href="{{ asset('images/seal.png') }}" type="image/x-icon">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

    @extends('layouts.app')

    @section('content')
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Owner</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Owners</a></li>
                                    <li class="breadcrumb-item active">Owner</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-xl-4">
                        <div class="card overflow-hidden">
                            <div class="bg-primary-subtle">
                                <div class="row">
                                    <div class="col-7">
                                        <div class="text-primary p-3">
                                            <h5 class="text-primary">Welcome Back !</h5>
                                            <p>You are an Applicant</p>
                                        </div>
                                    </div>
                                    <div class="col-5 align-self-end">
                                        <img src="assets/images/profile-img.png" alt="" class="img-fluid">
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <div class="row">
                                    <div class="col-sm-5">
                                        <div class="avatar-md profile-user-wid mb-">
                                            @if($owners->scan_or_photo_of_id)
                                            <img src="{{ asset('storage/images/' . $owners->scan_or_photo_of_id) }}" alt="" class="img-thumbnail rounded-circle">
                                            @else
                                            <p>No Photo available</p>
                                            @endif
                                        </div>
                                        <h5 class="font-size-15 text-truncate">{{ $owners->first_name ?? 'N/A' }} {{ $owners->middle_initial ?? 'N/A' }}. {{ $owners->last_name ?? 'N/A' }}</h5>
                                        <p class="text-muted mb-0 text-truncate">{{ $owners->appointment->appointment ?? 'N/A' }}</p>
                                    </div>

                                    <div class="col-sm-7">
                                        <div class="pt-4">
                                            <div class="row">
                                                <div class="col-6">
                                                    <h5 class="font-size-15">{{ $totalTimeIn }}</h5>
                                                    <p class="text-muted mb-0">Time In</p>
                                                </div>
                                                <div class="col-6">
                                                    <h5 class="font-size-15">{{ $totalTimeOut }}</h5>
                                                    <p class="text-muted mb-0">Time out</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end card -->

                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Personal Information</h4>
                                <div class="table-responsive">
                                    <table class="table mb-0">
                                        <tbody>
                                            <tr>
                                                <th scope="row">Full Name :</th>
                                                <td>{{ $owners->first_name }} {{ $owners->middle_initial }}. {{ $owners->last_name }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="col">Serial Number</th>
                                                <td scope="col">{{ $owners->serial_number ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">ID Number</th>
                                                <td>{{ $owners->id_number ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Office / Dept. / Agency</th>
                                                <td>{{ $owners->office_department_agency ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Position / Designation</th>
                                                <td>{{ $owners->position_designation ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Appointment:</h6>
                                                <td>{{ $owners->appointment->appointment ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row"> Role Status:</h6>
                                                <td>{{ $owners->status->applicant_role_status ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Mobile :</th>
                                                <td>{{ $owners->contact_number }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">E-mail :</th>
                                                <td>{{ $owners->email_address }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Address :</th>
                                                <td>{{ $owners->present_address }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Approval:</th>
                                                @if($owners)
                                                @if($owners->approval_status == 'Approved')
                                                <td><span class="badge badge-soft-success">Approved</span></td>
                                                @elseif($owners->approval_status == 'Rejected')
                                                <td><span class="badge badge-soft-danger">Rejected</span></td>
                                                @elseif($owners->approval_status == 'Pending')
                                                <td><span class="badge badge-soft-warning">Pending</span></td>
                                                @else
                                                <td><span class="badge badge-soft-secondary">Unknown</span></td>
                                                @endif
                                                @else
                                                <td><span class="badge badge-soft-secondary">No Vehicle Associated</span></td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="row">Applied Date:</th>
                                                <td>
                                                    @if($owners->vehicle && $owners->vehicle->created_at)
                                                    {{ \Carbon\Carbon::parse($owners->vehicle->created_at)->format('d F, Y') }}
                                                    @else
                                                    N/A
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Reason(If Rejected):</th>
                                                <td>{{ $owners->vehicle->reason ?? 'N/A' }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- end card -->
                    </div>

                    <div class="col-xl-8">

                        <div class="row">
                            <div class="col-md-4">
                                <div class="card mini-stats-wid">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-muted fw-medium mb-2">Total Vehicles</p>
                                                <h4 class="mb-0">{{ $totalVehicles }}</h4>
                                            </div>

                                            <div class="flex-shrink-0 align-self-center">
                                                <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                                    <span class="avatar-title">
                                                        <i class="fas fa-car font-size-24"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card mini-stats-wid">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-muted fw-medium mb-2">Total Violations</p>
                                                <h4 class="mb-0">{{ $totalViolations }}</h4>
                                            </div>

                                            <div class="flex-shrink-0 align-self-center">
                                                <div class="avatar-sm mini-stat-icon rounded-circle bg-primary">
                                                    <span class="avatar-title">
                                                        <i class="fas fa-exclamation-circle font-size-24"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card mini-stats-wid">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-muted fw-medium mb-2">Active Vehicle</p>
                                                <h4 class="mb-0">
                                                    @if ($active_vehicle)
                                                    <h4 class="mb-0">{{ $active_vehicle->plate_number ?? 'N/A' }}</h4>
                                                    @else
                                                    <h4 class="mb-0 text-danger">None</h4>
                                                    @endif
                                                </h4>
                                            </div>

                                            <div class="flex-shrink-0 align-self-center">
                                                <div class="avatar-sm mini-stat-icon rounded-circle bg-primary">
                                                    <span class="avatar-title">
                                                        <i class="bx bx-package font-size-24"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4 class="card-title mb-4">My Vehicles</h4>
                                    <a class="btn btn-sm btn-primary my-2" onClick="addVehicle()" href="javascript:void(0)">
                                        <i class="bi bi-plus-circle"></i> Add Vehicle
                                    </a>
                                </div>

                                <!-- Display Vehicles -->
                                <div class="row" id="vehicleContainer">
                                    @include('owners.vehicles')
                                </div>

                                <!-- Pagination Links -->
                                <div class="row justify-content-center" id="paginationLinks">
                                    {!! $vehicles->links() !!}
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4 class="card-title mb-4">My Driver</h4>
                                </div>

                                <div class="row">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="fw-bold">Driver's Name:</h5>
                                            <p class="mb-1">{{ $owners->vehicle->driver->driver_name ?? 'N/A' }}</p>
                                        </div>
                                        <div class="col">
                                            <h5 class="fw-bold">Authorized Driver's Name:</h5>
                                            <p class="mb-1">{{ $owners->vehicle->driver->authorized_driver_name ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="fw-bold">Driver's Address:</h5>
                                            <p class="mb-1">{{ $owners->vehicle->owner_address ?? 'N/A' }}</p>
                                        </div>
                                        <div class="col">
                                            <h5 class="fw-bold">Authorized Driver's Address:</h5>
                                            <p class="mb-1">{{ $owners->vehicle->driver->authorized_driver_address ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col">
                                            <h5 class="fw-bold">Driver's License Image:</h5>
                                            @if($owners->vehicle && $owners->vehicle->driver && $owners->vehicle->driver->driver_license_image)
                                            <img src="{{ asset('storage/images/drivers/' . $owners->vehicle->driver->driver_license_image) }}" alt="Driver's License Image" class="img-thumbnail mx-auto d-block img-modal" style="width: 300px; height: 200px;">
                                            @else
                                            <p>No driver's license image available</p>
                                            @endif
                                        </div>
                                        <div class="col">
                                            <h5 class="fw-bold">Authorized Driver's License Image:</h5>
                                            @if($owners->vehicle && $owners->vehicle->driver && $owners->vehicle->driver->authorized_driver_license_image)
                                            <img src="{{ asset('storage/images/drivers/' . $owners->vehicle->driver->authorized_driver_license_image) }}" alt="Authorized Driver's License Image" class="img-thumbnail mx-auto d-block img-modal" style="width: 300px; height: 200px;">
                                            @else
                                            <p>No authorized driver's license image available</p>
                                            @endif
                                        </div>
                                    </div>
                                    <br>
                                    <li>
                                        <strong>Applied Date:</strong>
                                        @if($owners->vehicle && $owners->vehicle->driver && $owners->vehicle->driver->created_at)
                                        <span>{{ \Carbon\Carbon::parse($owners->vehicle->driver->created_at)->format('d F, Y') }}</span>
                                        @else
                                        <span>N/A</span>
                                        @endif
                                    </li>
                                    <li>
                                        <strong scope="row">Approval Status</strong>
                                        @if($owners->vehicle->driver && $owners->vehicle->driver->approval_status)
                                        @if($owners->vehicle->driver->approval_status == 'Approved')
                                        <span class="badge badge-soft-success">Approved</span>
                                        @elseif($owners->vehicle->driver->approval_status == 'Rejected')
                                        <span class="badge badge-soft-danger">Rejected</span>
                                        @elseif($owners->vehicle->driver->approval_status == 'Pending')
                                        <span class="badge badge-soft-warning">Pending</span>
                                        @else
                                        <span class="badge badge-soft-secondary">Unknown</span>
                                        @endif
                                        @else
                                        <span class="badge badge-soft-secondary">No Driver Associated</span>
                                        @endif
                                    </li>
                                    <li>
                                        <strong>Reason(If Rejected):</strong> <span>{{ $owners->vehicle->driver->reason ?? 'N/A' }}</span>
                                    </li>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- end row -->

        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->

    <!-- end main content-->

    @include('owners.owner_show_js')
    @include('owners.owner_show_modals')

</body>

</html>
@endsection