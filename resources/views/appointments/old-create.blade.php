<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VehiScan | Create</title>
</head>

<body>

@extends('layouts.app')

@section('content')
    <!-- Page Content -->
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Create New Appointment</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="{{ route('appointments.index') }}">Appointments</a></li>
                                    <li class="breadcrumb-item active">Create New Appointment</li>
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
                                <!-- Your create form content goes here -->
                                <form action="{{ route('appointments.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="mb-3">
                                    <label for="appointment" class="form-label">Appointment</label>
                                    <input type="text" class="form-control" id="appointment" name="appointment" required>
                                </div>

                                <div class="mb-3">
                                    <button   button type="submit" class="btn btn-primary">Create Appointment</button>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div> <!-- container-fluid -->
        </div><!-- End Page-content -->
    </div>
    <!-- end main content-->
@endsection

</body>
</html>
