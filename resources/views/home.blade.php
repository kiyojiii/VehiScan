<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MVIS | Dashboard</title>

    <link rel="icon" href="{{ asset('images/seal.png') }}" type="image/x-icon">

    <!-- Include Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- apexcharts -->
    <script src="<?php echo url('theme') ?>/dist/assets/libs/apexcharts/apexcharts.min.js"></script>

    <style>
        .comment-item:hover {
            background-color: #f7f7f7;
            cursor: pointer;
        }

        .card-header:hover {
            background-color: #f7f7f7;
            /* Change the background color on hover */
            cursor: pointer;
        }
    </style>

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
                            <h4 class="mb-sm-0 font-size-18">Admin Dashboard</h4>
                            <h4 id="digitalClock" class="clock"></h4>
                            @include('clock_js')
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Home</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0 me-3">
                                                @if ($user->photo)
                                                <img src="{{ asset('images/photos/' . $user->photo) }}" alt="Profile Photo" class="avatar-md rounded-circle img-thumbnail" width="50" height="50">
                                                @else
                                                <div class="no-photo">No Photo</div>
                                                @endif
                                            </div>
                                            <div class="flex-grow-1 align-self-center">
                                                <div class="text-muted">
                                                    <p class="mb-2">Welcome to MVIS</p>
                                                    <h5 class="mb-1">{{ $user->name }}</h5>
                                                    <p class="mb-0">
                                                        @forelse ($user->getRoleNames() as $role)
                                                        {{ $role }}</span>
                                                        @empty
                                                        @endforelse
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 align-self-center">
                                        <div class="text-lg-center mt-4 mt-lg-0">
                                            <div class="row">
                                                <div class="col-3">
                                                    <div>
                                                        <p class="text-muted text-truncate mb-2">Total Vehicles</p>
                                                        <h5 class="mb-0">{{ $totalVehicles }}</h5>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div>
                                                        <p class="text-muted text-truncate mb-2">Active Vehicles</p>
                                                        <h5 class="mb-0">{{ $totalActiveVehicles }}</h5>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div>
                                                        <p class="text-muted text-truncate mb-2">Inactive Vehicles</p>
                                                        <h5 class="mb-0">{{ $totalInactiveVehicles }}</h5>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div>
                                                        <p class="text-muted text-truncate mb-2">Pending Vehicles</p>
                                                        <h5 class="mb-0">{{ $totalPendingVehicles }}</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-2 d-none d-lg-block">
                                        <div class="clearfix mt-4 mt-lg-0">
                                            <div class="dropdown float-end">
                                                <button class="btn btn-primary" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="bx bxs-cog align-middle me-1"></i> Setting
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="{{ route('vehicles.index') }}"> <i class="fas fa-car"></i> Vehicles</a>
                                                    <a class="dropdown-item" href="{{ route('owners.index') }}"> <i class="fas fa-id-badge"></i> Owners</a>
                                                    <a class="dropdown-item" href="{{ route('drivers.index') }}"> <i class="fas fa-address-card"></i> Drivers</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end row -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="row">
                    <div class="col-xl-4">
                        <div class="card bg-primary-subtle">
                            <div>
                                <div class="row">
                                    <div class="col-7">
                                        <div class="text-primary p-3">
                                            <h5 class="text-primary">Welcome Back !</h5>

                                            <ul class="ps-3 mb-0">
                                                <li class="py-1">
                                                    @if($pendingApplicants == 0)
                                                    No Pending Applicants
                                                    @elseif($pendingApplicants == 1)
                                                    {{ $pendingApplicants }} Pending Applicant
                                                    @else
                                                    {{ $pendingApplicants }} Pending Applicants
                                                    @endif
                                                </li>
                                                <li class="py-1">
                                                    @if($pendingVehicles == 0)
                                                    No Pending Vehicles
                                                    @elseif($pendingVehicles == 1)
                                                    {{ $pendingVehicles }} Pending Vehicle
                                                    @else
                                                    {{ $pendingVehicles }} Pending Vehicles
                                                    @endif
                                                </li>
                                                <li class="py-1">
                                                    @if($pendingDrivers == 0)
                                                    No Pending Drivers
                                                    @elseif($pendingDrivers == 1)
                                                    {{ $pendingDrivers }} Pending Driver
                                                    @else
                                                    {{ $pendingDrivers }} Pending Drivers
                                                    @endif
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-5 align-self-end">
                                        <img src="<?php echo url('theme') ?>/dist/assets/images/profile-img.png" alt="" class="img-fluid">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="avatar-xs me-3">
                                                <span class="avatar-title rounded-circle bg-primary-subtle text-primary font-size-18">
                                                    <i class="fas fa-car"></i>
                                                </span>
                                            </div>
                                            <h5 class="font-size-14 mb-0">Active Vehicles</h5>
                                        </div>
                                        <div class="text-muted mt-4">
                                            <h4>{{ $totalActiveApprovedVehicles }}<i class="mdi mdi-chevron-up ms-1 text-success"></i></h4>
                                            <div class="d-flex">
                                                <span class="badge badge-soft-success font-size-12"> + {{ $recentVehicles }} </span> <span class="ms-2 text-truncate"> Recent Vehicles </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="avatar-xs me-3">
                                                <span class="avatar-title rounded-circle bg-primary-subtle text-primary font-size-18">
                                                    <i class="fas fa-sign-in-alt"></i>
                                                </span>
                                            </div>
                                            <h5 class="font-size-14 mb-0">Vehicles Inside</h5>
                                        </div>
                                        <div class="text-muted mt-4">
                                            <h4>{{ $totalVehicleIn}}<i class="mdi mdi-chevron-up ms-1 text-success"></i></h4>
                                            <div class="d-flex">
                                                <span class="badge badge-soft-primary font-size-12"> {{ $VehicleInPercentage }}% </span> <span class="ms-2 text-truncate"> Of Total Vehicles</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="avatar-xs me-3">
                                                <span class="avatar-title rounded-circle bg-primary-subtle text-primary font-size-18">
                                                    <i class="fas fa-sign-out-alt"></i>
                                                </span>
                                            </div>
                                            <h5 class="font-size-14 mb-0">Vehicles Outside </h5>
                                        </div>
                                        <div class="text-muted mt-4">
                                            <h4>{{ $totalVehicleOut }}<i class="mdi mdi-chevron-up ms-1 text-success"></i></h4>

                                            <div class="d-flex">
                                                <span class="badge badge-soft-primary font-size-12"> {{ $VehicleOutPercentage }}% </span> <span class="ms-2 text-truncate"> Of Total Vehicles </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-8">
                        <div class="card">
                            <div class="card-body">
                                <div class="clearfix">
                                    <div class="float-end">
                                        <h6> Month: {{ $livecurrentMonth }} </h6>
                                    </div>
                                    <h4 class="card-title mb-4">Vehicle Visit Per Month</h4>
                                </div>

                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="text-muted">
                                            <div class="mb-4">
                                                <p>This month</p>
                                                <h4>{{$totalTimeCurrentMonth}}</h4>
                                                @php
                                                if ($totalTimePreviousMonth != 0) {
                                                    // Calculate the difference between the current month and previous month total time counts
                                                    $difference = $totalTimeCurrentMonth - $totalTimePreviousMonth;
                                                    // Calculate the percentage difference
                                                    $percentageDifference = ($difference / $totalTimePreviousMonth) * 100;
                                                    // Check if the difference is positive (increase) or negative (decrease)
                                                    if ($difference > 0) {
                                                        $changeType = 'increase';
                                                    } elseif ($difference < 0) {
                                                        $changeType = 'decrease';
                                                    } else {
                                                        $changeType = 'no change';
                                                    }
                                                    // Format the percentage difference
                                                    $formattedPercentageDifference = number_format(abs($percentageDifference), 2) . '% ' . $changeType;

                                                    // Determine badge class based on change type
                                                    switch($changeType) {
                                                        case 'increase':
                                                            $badgeClass = 'badge-soft-success';
                                                            break;
                                                        case 'decrease':
                                                            $badgeClass = 'badge-soft-danger';
                                                            break;
                                                        case 'no change':
                                                            $badgeClass = 'badge-soft-secondary';
                                                            break;
                                                    }
                                                } else {
                                                    // Handle the case where $totalTimePreviousMonth is zero
                                                    $formattedPercentageDifference = 'N/A'; // Or any other appropriate value
                                                    $badgeClass = 'badge-soft-secondary'; // Or any other appropriate class
                                                }
                                                @endphp
                                                <div><span class="badge {{$badgeClass}} font-size-12 me-1">{{$formattedPercentageDifference}}</span> From previous Month</div>
                                            </div>

                                            <div>
                                                <a href="{{ route('analytics') }}" class="btn btn-primary waves-effect waves-light btn-sm">View Details <i class="mdi mdi-chevron-right ms-1"></i></a>
                                            </div>

                                            <div class="mt-4">
                                                <p class="mb-2">Last month</p>
                                                <h5>{{$totalTimePreviousMonth}}</h5>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-lg-8">
                                        <div id="line_chart_dashed" data-colors='["--bs-success", "--bs-danger", "--bs-info"]' class="apex-charts" dir="ltr"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Vehicle - Owner - Driver Ratio</h4>

                                <div class="col-lg-12">
                                    <div id="pie_chart" data-colors='["--bs-danger", "--bs-primary", "--bs-success"]' class="apex-charts" dir="ltr"></div>
                                </div>
                                @include('chart_js')

                                <div class="text-center text-muted">
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="mt-4">
                                                <p class="mb-2 text-truncate"><i class="mdi mdi-circle text-danger me-1"></i> Vehicles</p>
                                                <h5>{{$totalVehicles}}</h5>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="mt-4">
                                                <p class="mb-2 text-truncate"><i class="mdi mdi-circle text-primary me-1"></i> Owners</p>
                                                <h5>{{$totalOwners}}</h5>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="mt-4">
                                                <p class="mb-2 text-truncate"><i class="mdi mdi-circle text-success me-1"></i> Drivers</p>
                                                <h5>{{$totalDrivers}}</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="row">
                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="clearfix">
                                    <!-- <div class="float-end">
                                        <div class="input-group input-group-sm">
                                            <select class="form-select form-select-sm">
                                                <option value="JA" selected>Jan</option>
                                                <option value="DE">Dec</option>
                                                <option value="NO">Nov</option>
                                                <option value="OC">Oct</option>
                                            </select>
                                            <label class="input-group-text">Month</label>
                                        </div>
                                    </div> -->
                                    <h4 class="card-title mb-4">Top Vehicle Visit</h4>
                                </div>

                                <div class="text-muted text-center">
                                    <p class="mb-2">{{ $plateNumber }}</p>
                                    @if($mosttotalVisits > 1) 
                                        <h4>{{ $mosttotalVisits ?? 'No Data' }} visits</h4>
                                    @else
                                        <h4>{{ $mosttotalVisits ?? 'No Data' }} visit</h4>
                                    @endif
                                    <p class="mt-4 mb-0">
                                        <span class="badge badge-soft-success font-size-11 me-2">
                                            {{ number_format($percentage, 2) }}% <i class="mdi mdi-arrow-up"></i>
                                        </span> compared to others
                                    </p>
                                </div>

                                <div class="table-responsive mt-4">
                                    <table class="table align-middle mb-0">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <h5 class="font-size-14 mb-1">Most Violations</h5>
                                                    <p class="text-muted mb-0">{{ $vehiclePlateNumber ?? 'No Data' }}</p>
                                                </td>
                                                <td>
                                                    <div id="radialchart-1" data-colors='["--bs-primary"]' class="apex-charts"></div>
                                                </td>
                                                <td>
                                                    <p class="text-muted mb-1">Violations</p>
                                                    <h5 class="mb-0">{{ $violationCount ?? 'No Data' }}</h5>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <h5 class="font-size-14 mb-1">Most Vehicles</h5>
                                                    <p class="text-muted mb-0">{{ $firstName }} {{ $lastName }}</p>
                                                </td>
                                                <td>
                                                    <div id="radialchart-2" data-colors='["--bs-success"]' class="apex-charts"></div>
                                                </td>
                                                <td>
                                                    <p class="text-muted mb-1">Vehicles</p>
                                                    <h5 class="mb-0">{{ $vehicleCount ?? 'No Data' }}</h5>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <h5 class="font-size-14 mb-1">Longest Stay</h5>
                                                    <p class="text-muted mb-0">{{ $lsplateNumber ?? 'No Data' }}</p>
                                                </td>

                                                <td>
                                                    <div id="radialchart-3" data-colors='["--bs-danger"]' class="apex-charts"></div>
                                                </td>
                                                <td>
                                                    <p class="text-muted mb-1">Duration</p>
                                                    <h5 class="mb-0">@if ($recentLongestStayVehicle)
                                                    {{ $stayDuration }}
                                                    </h5>
                                                    @else
                                                        <p class="text-muted mb-0">No data available</p>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <h5 class="font-size-14 mb-1">Peak Hour</h5>
                                                    <p class="text-muted mb-0">{{ $hour ?? 'No Data' }}</p>
                                                </td>

                                                <td>
                                                    <div id="radialchart-3" data-colors='["--bs-danger"]' class="apex-charts"></div>
                                                </td>
                                                <td>
                                                    <p class="text-muted mb-1">Count</p>
                                                    <h5 class="mb-0">{{ $count ?? 'No Data' }}</h5>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-header bg-transparent border-bottom">
                                <div class="d-flex flex-wrap align-items-start">
                                    <div class="me-2">
                                        <h5 class="card-title mt-1 mb-0">Registered Vehicles</h5>
                                    </div>
                                    <ul class="nav nav-tabs nav-tabs-custom card-header-tabs ms-auto" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-bs-toggle="tab" href="#post-recent" role="tab">
                                                Recent
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="card-body">
                                <div data-simplebar style="max-height: 400px;"> <!-- Increase max-height to accommodate all items -->
                                    <!-- Tab panes -->
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="post-recent" role="tabpanel">
                                            <ul class="list-group list-group-flush">
                                            <ul class="list-group list-group-flush">
                            @foreach($latestVehicles as $vehicle)
                            <li class="list-group-item py-3">
                                <div class="d-flex">
                                    <div class="me-3">
                                        <img src="{{ asset('storage/images/vehicles/' . $vehicle->side_photo) }}" alt="" class="avatar-md h-auto d-block rounded" style="width: 50px; height: 50px;">
                                    </div>

                                    <div class="align-self-center overflow-hidden me-auto">
                                        <div>
                                            <h5 class="font-size-14 text-truncate"><a href="javascript: void(0);" class="text-dark">{{ $vehicle->plate_number }}</a></h5>
                                            <p class="text-muted mb-0">{{ $vehicle->created_at->format('M d, Y') }}</p>
                                        </div>
                                    </div>

                                    <div class="dropdown ms-2">
                                        <a class="text-muted font-size-14" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="mdi mdi-dots-horizontal"></i>
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item" href="{{ route('vehicles.index') }}">Go To Vehicles</a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                                        </div>
                                        <!-- end tab pane -->
                                    </div>
                                    <!-- end tab content -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end col -->

                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Activity Feed</h4>
                                <!-- DISPLAY RECENT VEHICLE ACTIVITY -->
                                <div id="vehicle-record-container" data-simplebar class="mt-2" style="max-height: 390px;">
                                    <ul id="vehicle-record-list" class="verti-timeline list-unstyled">
                                        Loading...
                                    </ul>
                                </div>
                            </div>
                        </div><!--end card-->
                    </div><!--end col-->

                </div>
                <!-- end row -->
                
                <script>
                    // Function to fetch vehicle records via AJAX
                    function fetchVehicleRecords() {
                        $.ajax({
                            url: '{{ route('fetchHomeVehicleRecord') }}',
                            method: 'get',
                            success: function(response) {
                                // Clear existing records
                                $('#vehicle-record-list').empty();

                                // Append new records to the timeline
                                response.forEach(function(record) {
                                    // Format the created_at date
                                    var formattedDate = new Date(record.created_at).toLocaleDateString('en-US', {
                                        month: 'short',
                                        day: 'numeric'
                                    });
                                    // Split the remarks string into words
                                    var words = record.remarks.split(' ');
                                    // Initialize an empty string to store the formatted remarks
                                    var formattedRemarks = '';
                                    // Iterate through the words
                                    for (var i = 0; i < words.length; i++) {
                                        // Determine badge color based on word
                                        var badgeColor = '';
                                        // Check if the word is 'Timed'
                                        if (words[i] === 'Timed') {
                                            // Check if the next word is 'In' or 'Out'
                                            if (i < words.length - 1 && (words[i + 1] === 'In' || words[i + 1] === 'Out')) {
                                                badgeColor = words[i + 1] === 'In' ? 'bg-success' : 'bg-danger';
                                                // Wrap the word with the badge
                                                formattedRemarks += '<span class="badge ' + badgeColor + ' font-size-12">' + words[i] + ' ' + words[i + 1] + '</span> ';
                                                // Skip the next word since it's already included in the badge
                                                i++;
                                            } else {
                                                // If the next word is not 'In' or 'Out', add 'Timed' without badge
                                                formattedRemarks += words[i] + ' ';
                                            }
                                        } else {
                                            // Add other words without badge
                                            formattedRemarks += words[i] + ' ';
                                        }
                                    }

                                    $('#vehicle-record-list').append(
                                        '<li class="event-list">' +
                                        '<div class="event-timeline-dot">' +
                                        '<i class="bx bx-right-arrow-circle font-size-18"></i>' +
                                        '</div>' +
                                        '<div class="d-flex">' +
                                        '<div class="flex-shrink-0 me-3">' +
                                        '<h5 class="font-size-14">' + formattedDate + '<i class="bx bx-right-arrow-alt font-size-16 text-primary align-middle ms-2"></i></h5>' +
                                        '</div>' +
                                        '<div class="flex-grow-1">' +
                                        '<div>' + formattedRemarks + '</div>' +
                                        '</div>' +
                                        '</div>' +
                                        '</li>'
                                    );
                                });
                            },
                            error: function(xhr, status, error) {
                                console.error("Error fetching vehicle records:", error);
                                $('#vehicle-record-list').html("<p>Error fetching data. Please try again later.</p>");
                            }
                        });
                    }

                    // Call the fetchVehicleRecords function when the page loads
                    $(document).ready(function() {
                        fetchVehicleRecords();
                    });
                </script>

            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
    </div>
    <!-- END layout-wrapper -->

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

    @endsection
</body>

</html>