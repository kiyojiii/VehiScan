<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>VehiScan | Applicant Dashboard </title>

    <!-- Include Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- apexcharts -->
    <script src="<?php echo url('theme') ?>/dist/assets/libs/apexcharts/apexcharts.min.js"></script>
</head>

<body>

    <!-- Loader -->
    <div id="preloader">
        <div id="status">
            <div class="spinner-chase">
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
            </div>
        </div>
    </div>

    @extends('layouts.app2')

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
                            <h4 class="mb-sm-0 font-size-18">Dashboard</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item active"><a href="javascript: void(0);">User Dashboard</a></li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->
                @forelse($owners as $owners)
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
                                    <!-- <div class="col-5 align-self-end">
                                        <img src="assets/images/profile-img.png" alt="" class="img-fluid">
                                    </div> -->
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <div class="row">
                                    <div class="col-sm-5">
                                        <div class="avatar-md profile-user-wid mb-">
                                            @if($owners->scan_or_photo_of_id)
                                            <img src="{{ asset('storage/images/' . $owners->scan_or_photo_of_id) }}" alt="" class="img-thumbnail rounded-circle" style="width: 70px; height: 70px;">
                                            @else
                                            <p>No Scan or Photo of ID available</p>
                                            @endif
                                        </div>
                                        <h5 class="font-size-15 text-truncate">{{ $owners->first_name }} {{ $owners->middle_initial }}. {{ $owners->last_name }}</h5>
                                        <p class="text-muted mb-0 text-truncate">{{ $owners->appointment->appointment ?? 'N/A' }}</p>

                                    </div>

                                    <div class="col-sm-7">
                                        <div class="pt-4">
                                            <div class="row">
                                                <div class="col-6">
                                                    <h5 class="font-size-15">{{ $totalTimeIn ?? 'N/A' }}</h5>
                                                    <p class="text-muted mb-0">Time In</p>
                                                </div>
                                                <div class="col-6">
                                                    <h5 class="font-size-15">{{ $totalTimeOut ?? 'N/A' }}</h5>
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
                                                <td><span class="badge badge-soft-success">{{ $owners->approval_status }}</span></td>
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
                                                    @if($owners && $owners->created_at)
                                                    {{ \Carbon\Carbon::parse($owners->created_at)->format('d F, Y') }}
                                                    @else
                                                    N/A
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Reason(If Rejected):</th>
                                                <td>{{ $owners->reason ?? 'N/A' }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <br>
                                    <div style="text-align: center;">
                                        <a href="javascript:void(0)" id="{{ $owners->id }}" class="btn btn-success editOwner" onClick="editOwner()">
                                            <i class="bx bx-edit"></i> Update <i class="bx bx-user"></i>
                                        </a>
                                        <a href="javascript:void(0)" id="{{ $driver->id }}" class="btn btn-warning editDriver" onClick="editDriver()">
                                            <i class="bx bx-edit"></i> Update Driver
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end card -->
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-5">Vehicle Activity</h4>
                                <div class="">
                                    <ul class="verti-timeline list-unstyled">

                                        <li class="event-list">
                                            <div class="event-timeline-dot">
                                                <i class="bx bx-right-arrow-circle"></i>
                                            </div>
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <i class="bx bx-code h4 text-primary"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div>
                                                        @foreach($allRemarks as $ar)
                                                        @php
                                                        $remarks = str_contains($ar->remarks, 'at') ? strstr($ar->remarks, 'at', true) : $ar->remarks;
                                                        $badgeClass = str_contains($ar->remarks, 'Timed In') ? 'bg-success' : (str_contains($ar->remarks, 'Timed Out') ? 'bg-danger' : '');
                                                        @endphp
                                                        <div class="d-flex justify-content-start align-items-center">

                                                            <div>
                                                                <h5 class="font-size-15">
                                                                    @if (!empty($badgeClass))
                                                                    <span class="badge {{ $badgeClass }} rounded-circle" style="width: 10px; height: 10px; display: inline-flex; justify-content: center; align-items: center;"></span> &nbsp;&nbsp;&nbsp; <a href="javascript: void(0);" class="text-dark">{{ $remarks }}</a>
                                                                    @endif
                                                                </h5>
                                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="text-primary">{{ \Carbon\Carbon::parse($ar->created_at)->format('M, d, Y \a\t h:i A') }}</span>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
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
                                                <h4 class="mb-0">{{ $totalVehicles ?? 'N/A' }}</h4>
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
                                                <h4 class="mb-0">{{ $totalViolations ?? 'N/A' }}</h4>
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
                                                @if ($active_vehicle)
                                                <h4 class="mb-0">{{ $active_vehicle->plate_number }}</h4>
                                                @else
                                                <h4 class="mb-0 text-danger">None</h4>
                                                @endif
                                            </div>

                                            <div class="flex-shrink-0 align-self-center">
                                                <div class="avatar-sm mini-stat-icon rounded-circle bg-primary">
                                                    <span class="avatar-title">
                                                        <i class="bx bx-check-double font-size-24"></i>
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
                                <h4 class="card-title mb-4">Time Count per Day</h4>
                                <div id="user_column_chart" data-colors='["--bs-success","--bs-primary", "--bs-danger"]' class="apex-charts" dir="ltr"></div>
                            </div>
                            @include('applicant_users.chart_js')
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4 class="card-title mb-3">My Vehicles</h4>
                                    @if($hasActiveVehicle)
                                    <a id="addVehicleBtn" class="btn btn-sm btn-primary my-2" href="javascript:void(0)" onClick="showAlert()">
                                        <i class="bi bi-plus-circle"></i> Add Vehicle
                                    </a>
                                    @else
                                    <a id="addVehicleBtn" class="btn btn-sm btn-primary my-2" href="javascript:void(0)" onClick="addVehicle()">
                                        <i class="bi bi-plus-circle"></i> Add Vehicle
                                    </a>
                                    @endif
                                </div>

                                <script>
                                    function showAlert() {
                                        // Show SweetAlert message
                                        Swal.fire({
                                            title: 'Active or Pending Vehicle Exists',
                                            text: 'Please Deactivate the Active Vehicle First, You can only have one Active Vehicle',
                                            icon: 'warning'
                                        });
                                    }
                                </script>


                                <!-- Display Vehicles -->
                                <div class="row" id="vehicleContainer">
                                    @include('applicant_users.vehicles')
                                </div>

                                <!-- Pagination Links -->
                                <!-- Pagination Links -->
                                <div class="row justify-content-center" id="paginationLinks">
                                    {!! $vehicles->links() !!}
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4 class="card-title mb-3">My Driver</h4>
                                    <!-- <a class="btn btn-sm btn-primary my-2" onClick="addDriver()" href="javascript:void(0)">
                                        <i class="bi bi-plus-circle"></i> Add Driver
                                    </a> -->
                                </div>

                                <div class="row">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="fw-bold">Driver's Name:</h5>
                                            <p class="mb-1">{{ $driver->driver_name ?? 'N/A' }}</p>
                                        </div>
                                        <div class="col">
                                            <h5 class="fw-bold">Authorized Driver's Name:</h5>
                                            <p class="mb-1">{{ $driver->authorized_driver_name ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="fw-bold">Driver's Address:</h5>
                                            <p class="mb-1">{{ $owners->present_address ?? 'N/A' }}</p>
                                        </div>
                                        <div class="col">
                                            <h5 class="fw-bold">Authorized Driver's Address:</h5>
                                            <p class="mb-1">{{ $driver->authorized_driver_address ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col">
                                            <h5 class="fw-bold">Driver's License Image:</h5>
                                            @if($driver && $driver->driver_license_image)
                                            <img src="{{ asset('storage/images/drivers/' . $driver->driver_license_image) }}" alt="Driver's License Image" class="img-thumbnail mx-auto d-block img-modal" style="width: 300px; height: 200px;">
                                            @else
                                            <p>No driver's license image available</p>
                                            @endif
                                        </div>
                                        <div class="col">
                                            <h5 class="fw-bold">Authorized Driver's License Image:</h5>
                                            @if($driver && $driver->authorized_driver_license_image)
                                            <img src="{{ asset('storage/images/drivers/' . $driver->authorized_driver_license_image) }}" alt="Authorized Driver's License Image" class="img-thumbnail mx-auto d-block img-modal" style="width: 300px; height: 200px;">
                                            @else
                                            <p>No authorized driver's license image available</p>
                                            @endif
                                        </div>
                                    </div>
                                    <br>
                                    <li>
                                        <strong>Applied Date:</strong>
                                        @if($driver && $driver->created_at)
                                        <span>{{ \Carbon\Carbon::parse($driver->created_at)->format('d F, Y') }}</span>
                                        @else
                                        <span>N/A</span>
                                        @endif
                                    </li>
                                    <li>
                                        <strong scope="row">Approval Status</strong>
                                        @if($driver && $driver->approval_status)
                                        @if($driver->approval_status == 'Approved')
                                        <span class="badge badge-soft-success">Approved</span>
                                        @elseif($driver->approval_status == 'Rejected')
                                        <span class="badge badge-soft-danger">Rejected</span>
                                        @elseif($driver->approval_status == 'Pending')
                                        <span class="badge badge-soft-warning">Pending</span>
                                        @else
                                        <span class="badge badge-soft-secondary">Unknown</span>
                                        @endif
                                        @else
                                        <span class="badge badge-soft-secondary">No Driver Associated</span>
                                        @endif
                                    </li>
                                    <li>
                                        <strong>Reason(If Rejected):</strong> <span>{{ $driver->reason ?? 'N/A' }}</span>
                                    </li>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <h1 class="text-center text-danger my-5"><i class="bx bx-error"></i> You Have Not Applied Yet </h1>
                    <div class="text-center">
                        <a href="{{ route('applicant_users.applicant_apply') }}" class="btn btn-primary">
                            Apply Now
                        </a>
                    </div>
                    @endforelse
                </div>
            </div>
            <!-- container-fluid -->

        </div> <!-- End Page-content -->
    </div>
    <!-- end main content-->

    @include('applicant_users.applicant_users_js')
    @include('applicant_users.applicant_users_modals')

</body>

</html>
@endsection