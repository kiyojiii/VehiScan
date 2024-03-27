<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

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
                                                    <p class="mb-2">Welcome to VehiScan Dashboard</p>
                                                    <h5 class="mb-1">{{ $user->name }}</h5>
                                                    <p class="mb-0">UI / UX Designer</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 align-self-center">
                                        <div class="text-lg-center mt-4 mt-lg-0">
                                            <div class="row">
                                                <div class="col-4">
                                                    <div>
                                                        <p class="text-muted text-truncate mb-2">Total Users</p>
                                                        <h5 class="mb-0">{{ $totalVehicles }}</h5>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div>
                                                        <p class="text-muted text-truncate mb-2">Time In's</p>
                                                        <h5 class="mb-0">{{ $totalTimeIn }}</h5>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div>
                                                        <p class="text-muted text-truncate mb-2">Time Out's</p>
                                                        <h5 class="mb-0">{{ $totalTimeOut }}</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 d-none d-lg-block">
                                        <div class="clearfix mt-4 mt-lg-0">
                                            <div class="dropdown float-end">
                                                <button class="btn btn-primary" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="bx bxs-cog align-middle me-1"></i> Setting
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="#">Action</a>
                                                    <a class="dropdown-item" href="#">Another action</a>
                                                    <a class="dropdown-item" href="#">Something else</a>
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
                                            <p>Skote Saas Dashboard</p>

                                            <ul class="ps-3 mb-0">
                                                <li class="py-1">7 + Layouts</li>
                                                <li class="py-1">Multiple apps</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-5 align-self-end">
                                        <img src="assets/images/profile-img.png" alt="" class="img-fluid">
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
                                            <h5 class="font-size-14 mb-0">Total Vehicles</h5>
                                        </div>
                                        <div class="text-muted mt-4">
                                            <h4>{{ $totalVehicles }}<i class="mdi mdi-chevron-up ms-1 text-success"></i></h4>
                                            <div class="d-flex">
                                                <span class="badge badge-soft-success font-size-12"> + 0.2% </span> <span class="ms-2 text-truncate">From previous month</span>
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
                                                    <i class="fas fa-id-badge"></i>
                                                </span>
                                            </div>
                                            <h5 class="font-size-14 mb-0">Total Owners</h5>
                                        </div>
                                        <div class="text-muted mt-4">
                                            <h4>{{ $totalOwners}}<i class="mdi mdi-chevron-up ms-1 text-success"></i></h4>
                                            <div class="d-flex">
                                                <span class="badge badge-soft-success font-size-12"> + 0.2% </span> <span class="ms-2 text-truncate">From previous period</span>
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
                                                    <i class="fas fa-address-card"></i>
                                                </span>
                                            </div>
                                            <h5 class="font-size-14 mb-0">Total Drivers</h5>
                                        </div>
                                        <div class="text-muted mt-4">
                                            <h4>{{ $totalDrivers }}<i class="mdi mdi-chevron-up ms-1 text-success"></i></h4>

                                            <div class="d-flex">
                                                <span class="badge badge-soft-warning font-size-12"> 0% </span> <span class="ms-2 text-truncate">From previous period</span>
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
                                        <div class="input-group input-group-sm">
                                            <select class="form-select form-select-sm">
                                                <option value="JA" selected>Jan</option>
                                                <option value="DE">Dec</option>
                                                <option value="NO">Nov</option>
                                                <option value="OC">Oct</option>
                                            </select>
                                            <label class="input-group-text">Month</label>
                                        </div>
                                    </div>
                                    <h4 class="card-title mb-4">Vehicle Per Day</h4>
                                </div>

                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="text-muted">
                                            <div class="mb-4">
                                                <p>This month</p>
                                                <h4>{{$totalTimeCurrentMonth}}</h4>
                                                @php
                                                // Calculate the absolute difference between the current month and previous month total time counts
                                                $absoluteDifference = abs($totalTimeCurrentMonth - $totalTimePreviousMonth);

                                                // Calculate the percentage difference
                                                if ($totalTimePreviousMonth != 0) {
                                                $percentageDifference = ($absoluteDifference / $totalTimeCurrentMonth) * 100;
                                                } else {
                                                $percentageDifference = 0;
                                                }

                                                // Format the percentage difference
                                                $formattedPercentageDifference = number_format($percentageDifference, 2) . '%';
                                                @endphp

                                                <div><span class="badge badge-soft-success font-size-12 me-1">{{$formattedPercentageDifference}}</span> From previous period</div>
                                            </div>

                                            <div>
                                                <a href="javascript: void(0);" class="btn btn-primary waves-effect waves-light btn-sm">View Details <i class="mdi mdi-chevron-right ms-1"></i></a>
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
                                <h4 class="card-title mb-4">Vehicle Owner Driver Ratio</h4>

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
                                    <div class="float-end">
                                        <div class="input-group input-group-sm">
                                            <select class="form-select form-select-sm">
                                                <option value="JA" selected>Jan</option>
                                                <option value="DE">Dec</option>
                                                <option value="NO">Nov</option>
                                                <option value="OC">Oct</option>
                                            </select>
                                            <label class="input-group-text">Month</label>
                                        </div>
                                    </div>
                                    <h4 class="card-title mb-4">Top Selling product</h4>
                                </div>

                                <div class="text-muted text-center">
                                    <p class="mb-2">Product A</p>
                                    <h4>$ 6385</h4>
                                    <p class="mt-4 mb-0"><span class="badge badge-soft-success font-size-11 me-2"> 0.6% <i class="mdi mdi-arrow-up"></i> </span> From previous period</p>
                                </div>

                                <div class="table-responsive mt-4">
                                    <table class="table align-middle mb-0">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <h5 class="font-size-14 mb-1">Product A</h5>
                                                    <p class="text-muted mb-0">Neque quis est</p>
                                                </td>

                                                <td>
                                                    <div id="radialchart-1" data-colors='["--bs-primary"]' class="apex-charts"></div>
                                                </td>
                                                <td>
                                                    <p class="text-muted mb-1">Sales</p>
                                                    <h5 class="mb-0">37 %</h5>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <h5 class="font-size-14 mb-1">Product B</h5>
                                                    <p class="text-muted mb-0">Quis autem iure</p>
                                                </td>

                                                <td>
                                                    <div id="radialchart-2" data-colors='["--bs-success"]' class="apex-charts"></div>
                                                </td>
                                                <td>
                                                    <p class="text-muted mb-1">Sales</p>
                                                    <h5 class="mb-0">72 %</h5>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <h5 class="font-size-14 mb-1">Product C</h5>
                                                    <p class="text-muted mb-0">Sed aliquam mauris.</p>
                                                </td>

                                                <td>
                                                    <div id="radialchart-3" data-colors='["--bs-danger"]' class="apex-charts"></div>
                                                </td>
                                                <td>
                                                    <p class="text-muted mb-1">Sales</p>
                                                    <h5 class="mb-0">54 %</h5>
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
                            <div class="card-body">
                                <h4 class="card-title mb-4">Tasks</h4>

                                <ul class="nav nav-pills bg-light rounded">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="#">In Process</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">Upcoming</a>
                                    </li>
                                </ul>

                                <div class="mt-4">
                                    <div data-simplebar style="max-height: 250px;">

                                        <div class="table-responsive">
                                            <table class="table table-nowrap align-middle table-hover mb-0">
                                                <tbody>
                                                    <tr>
                                                        <td style="width: 50px;">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" id="tasklistCheck01">
                                                                <label class="form-check-label" for="tasklistCheck01"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <h5 class="text-truncate font-size-14 mb-1"><a href="javascript: void(0);" class="text-dark">Skote Saas Dashboard</a></h5>
                                                            <p class="text-muted mb-0">Assigned to Mark</p>
                                                        </td>
                                                        <td style="width: 90px;">
                                                            <div>
                                                                <ul class="list-inline mb-0 font-size-16">
                                                                    <li class="list-inline-item">
                                                                        <a href="javascript: void(0);" class="text-success p-1"><i class="bx bxs-edit-alt"></i></a>
                                                                    </li>
                                                                    <li class="list-inline-item">
                                                                        <a href="javascript: void(0);" class="text-danger p-1"><i class="bx bxs-trash"></i></a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" id="tasklistCheck02">
                                                                <label class="form-check-label" for="tasklistCheck02"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <h5 class="text-truncate font-size-14 mb-1"><a href="javascript: void(0);" class="text-dark">New Landing UI</a></h5>
                                                            <p class="text-muted mb-0">Assigned to Team A</p>
                                                        </td>
                                                        <td>
                                                            <div>
                                                                <ul class="list-inline mb-0 font-size-16">
                                                                    <li class="list-inline-item">
                                                                        <a href="javascript: void(0);" class="text-success p-1"><i class="bx bxs-edit-alt"></i></a>
                                                                    </li>
                                                                    <li class="list-inline-item">
                                                                        <a href="javascript: void(0);" class="text-danger p-1"><i class="bx bxs-trash"></i></a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" id="tasklistCheck02">
                                                                <label class="form-check-label" for="tasklistCheck02"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <h5 class="text-truncate font-size-14 mb-1"><a href="javascript: void(0);" class="text-dark">Brand logo design</a></h5>
                                                            <p class="text-muted mb-0">Assigned to Janis</p>
                                                        </td>
                                                        <td>
                                                            <div>
                                                                <ul class="list-inline mb-0 font-size-16">
                                                                    <li class="list-inline-item">
                                                                        <a href="javascript: void(0);" class="text-success p-1"><i class="bx bxs-edit-alt"></i></a>
                                                                    </li>
                                                                    <li class="list-inline-item">
                                                                        <a href="javascript: void(0);" class="text-danger p-1"><i class="bx bxs-trash"></i></a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" id="tasklistCheck04">
                                                                <label class="form-check-label" for="tasklistCheck04"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <h5 class="text-truncate font-size-14 mb-1"><a href="javascript: void(0);" class="text-dark">Blog Template UI</a></h5>
                                                            <p class="text-muted mb-0">Assigned to Dianna</p>
                                                        </td>
                                                        <td>
                                                            <div>
                                                                <ul class="list-inline mb-0 font-size-16">
                                                                    <li class="list-inline-item">
                                                                        <a href="javascript: void(0);" class="text-success p-1"><i class="bx bxs-edit-alt"></i></a>
                                                                    </li>
                                                                    <li class="list-inline-item">
                                                                        <a href="javascript: void(0);" class="text-danger p-1"><i class="bx bxs-trash"></i></a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" id="tasklistCheck05">
                                                                <label class="form-check-label" for="tasklistCheck05"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <h5 class="text-truncate font-size-14 mb-1"><a href="javascript: void(0);" class="text-dark">Multipurpose Landing</a></h5>
                                                            <p class="text-muted mb-0">Assigned to Team B</p>
                                                        </td>
                                                        <td>
                                                            <div>
                                                                <ul class="list-inline mb-0 font-size-16">
                                                                    <li class="list-inline-item">
                                                                        <a href="javascript: void(0);" class="text-success p-1"><i class="bx bxs-edit-alt"></i></a>
                                                                    </li>
                                                                    <li class="list-inline-item">
                                                                        <a href="javascript: void(0);" class="text-danger p-1"><i class="bx bxs-trash"></i></a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" id="tasklistCheck06">
                                                                <label class="form-check-label" for="tasklistCheck06"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <h5 class="text-truncate font-size-14 mb-1"><a href="javascript: void(0);" class="text-dark">Redesign - Landing page</a></h5>
                                                            <p class="text-muted mb-0">Assigned to Jerry</p>
                                                        </td>
                                                        <td>
                                                            <div>
                                                                <ul class="list-inline mb-0 font-size-16">
                                                                    <li class="list-inline-item">
                                                                        <a href="javascript: void(0);" class="text-success p-1"><i class="bx bxs-edit-alt"></i></a>
                                                                    </li>
                                                                    <li class="list-inline-item">
                                                                        <a href="javascript: void(0);" class="text-danger p-1"><i class="bx bxs-trash"></i></a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" id="tasklistCheck07">
                                                                <label class="form-check-label" for="tasklistCheck07"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <h5 class="text-truncate font-size-14 mb-1"><a href="javascript: void(0);" class="text-dark">Skote Crypto Dashboard</a></h5>
                                                            <p class="text-muted mb-0">Assigned to Eric</p>
                                                        </td>
                                                        <td>
                                                            <div>
                                                                <ul class="list-inline mb-0 font-size-16">
                                                                    <li class="list-inline-item">
                                                                        <a href="javascript: void(0);" class="text-success p-1"><i class="bx bxs-edit-alt"></i></a>
                                                                    </li>
                                                                    <li class="list-inline-item">
                                                                        <a href="javascript: void(0);" class="text-danger p-1"><i class="bx bxs-trash"></i></a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer bg-transparent border-top">
                                <div class="text-center">
                                    <a href="javascript: void(0);" class="btn btn-primary waves-effect waves-light"> Add new Task</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-body border-bottom">
                                <div class="row">
                                    <div class="col-md-4 col-9">
                                        <h5 class="font-size-15 mb-1">Steven Franklin</h5>
                                        <p class="text-muted mb-0"><i class="mdi mdi-circle text-success align-middle me-1"></i> Active now</p>
                                    </div>
                                    <div class="col-md-8 col-3">
                                        <ul class="list-inline user-chat-nav text-end mb-0">
                                            <li class="list-inline-item d-none d-sm-inline-block">
                                                <div class="dropdown">
                                                    <button class="btn nav-btn" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="bx bx-search-alt-2"></i>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end py-0 dropdown-menu-md">
                                                        <form class="p-3">
                                                            <div class="form-group m-0">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" placeholder="Search ..." aria-label="Recipient's username">

                                                                    <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-inline-item  d-none d-sm-inline-block">
                                                <div class="dropdown">
                                                    <button class="btn nav-btn" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="bx bx-cog"></i>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a class="dropdown-item" href="#">View Profile</a>
                                                        <a class="dropdown-item" href="#">Clear chat</a>
                                                        <a class="dropdown-item" href="#">Muted</a>
                                                        <a class="dropdown-item" href="#">Delete</a>
                                                    </div>
                                                </div>
                                            </li>

                                            <li class="list-inline-item">
                                                <div class="dropdown">
                                                    <button class="btn nav-btn" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="bx bx-dots-horizontal-rounded"></i>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a class="dropdown-item" href="#">Action</a>
                                                        <a class="dropdown-item" href="#">Another action</a>
                                                        <a class="dropdown-item" href="#">Something else</a>
                                                    </div>
                                                </div>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pb-0">
                                <div>
                                    <div class="chat-conversation">
                                        <ul class="list-unstyled" data-simplebar style="max-height: 260px;">
                                            <li>
                                                <div class="chat-day-title">
                                                    <span class="title">Today</span>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="conversation-list">
                                                    <div class="dropdown">

                                                        <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="bx bx-dots-vertical-rounded"></i>
                                                        </a>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" href="#">Copy</a>
                                                            <a class="dropdown-item" href="#">Save</a>
                                                            <a class="dropdown-item" href="#">Forward</a>
                                                            <a class="dropdown-item" href="#">Delete</a>
                                                        </div>
                                                    </div>
                                                    <div class="ctext-wrap">
                                                        <div class="conversation-name">Steven Franklin</div>
                                                        <p>
                                                            Hello!
                                                        </p>
                                                        <p class="chat-time mb-0"><i class="bx bx-time-five align-middle me-1"></i> 10:00</p>
                                                    </div>

                                                </div>
                                            </li>

                                            <li class="right">
                                                <div class="conversation-list">
                                                    <div class="dropdown">

                                                        <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="bx bx-dots-vertical-rounded"></i>
                                                        </a>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" href="#">Copy</a>
                                                            <a class="dropdown-item" href="#">Save</a>
                                                            <a class="dropdown-item" href="#">Forward</a>
                                                            <a class="dropdown-item" href="#">Delete</a>
                                                        </div>
                                                    </div>
                                                    <div class="ctext-wrap">
                                                        <div class="conversation-name">Henry Wells</div>
                                                        <p>
                                                            Hi, How are you? What about our next meeting?
                                                        </p>

                                                        <p class="chat-time mb-0"><i class="bx bx-time-five align-middle me-1"></i> 10:02</p>
                                                    </div>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="conversation-list">
                                                    <div class="dropdown">

                                                        <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="bx bx-dots-vertical-rounded"></i>
                                                        </a>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" href="#">Copy</a>
                                                            <a class="dropdown-item" href="#">Save</a>
                                                            <a class="dropdown-item" href="#">Forward</a>
                                                            <a class="dropdown-item" href="#">Delete</a>
                                                        </div>
                                                    </div>
                                                    <div class="ctext-wrap">
                                                        <div class="conversation-name">Steven Franklin</div>
                                                        <p>
                                                            Yeah everything is fine
                                                        </p>

                                                        <p class="chat-time mb-0"><i class="bx bx-time-five align-middle me-1"></i> 10:06</p>
                                                    </div>

                                                </div>
                                            </li>

                                            <li class="last-chat">
                                                <div class="conversation-list">
                                                    <div class="dropdown">

                                                        <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="bx bx-dots-vertical-rounded"></i>
                                                        </a>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" href="#">Copy</a>
                                                            <a class="dropdown-item" href="#">Save</a>
                                                            <a class="dropdown-item" href="#">Forward</a>
                                                            <a class="dropdown-item" href="#">Delete</a>
                                                        </div>
                                                    </div>
                                                    <div class="ctext-wrap">
                                                        <div class="conversation-name">Steven Franklin</div>
                                                        <p>& Next meeting tomorrow 10.00AM</p>
                                                        <p class="chat-time mb-0"><i class="bx bx-time-five align-middle me-1"></i> 10:06</p>
                                                    </div>

                                                </div>
                                            </li>

                                            <li class="right">
                                                <div class="conversation-list">
                                                    <div class="dropdown">

                                                        <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="bx bx-dots-vertical-rounded"></i>
                                                        </a>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" href="#">Copy</a>
                                                            <a class="dropdown-item" href="#">Save</a>
                                                            <a class="dropdown-item" href="#">Forward</a>
                                                            <a class="dropdown-item" href="#">Delete</a>
                                                        </div>
                                                    </div>
                                                    <div class="ctext-wrap">
                                                        <div class="conversation-name">Henry Wells</div>
                                                        <p>
                                                            Wow that's great
                                                        </p>

                                                        <p class="chat-time mb-0"><i class="bx bx-time-five align-middle me-1"></i> 10:07</p>
                                                    </div>
                                                </div>
                                            </li>


                                        </ul>
                                    </div>

                                </div>
                            </div>

                            <div class="p-3 chat-input-section">
                                <div class="row">
                                    <div class="col">
                                        <div class="position-relative">
                                            <input type="text" class="form-control rounded chat-input" placeholder="Enter Message...">
                                            <div class="chat-input-links">
                                                <ul class="list-inline mb-0">
                                                    <li class="list-inline-item"><a href="javascript: void(0);"><i class="mdi mdi-emoticon-happy-outline"></i></a></li>
                                                    <li class="list-inline-item"><a href="javascript: void(0);"><i class="mdi mdi-file-image-outline"></i></a></li>
                                                    <li class="list-inline-item"><a href="javascript: void(0);"><i class="mdi mdi-file-document-outline"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-primary chat-send w-md waves-effect waves-light"><span class="d-none d-sm-inline-block me-2">Send</span> <i class="mdi mdi-send"></i></button>
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
    </div>
    <!-- END layout-wrapper -->

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

    @endsection
</body>

</html>