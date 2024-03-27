<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>VehiScan | Applicant </title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                            <h4 class="mb-sm-0 font-size-18">Application</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Applicant</a></li>
                                    <li class="breadcrumb-item active">Apply</li>
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
                                <div class="invoice-title">
                                    @forelse($owners as $owner)
                                    <h4 class="float-end font-size-16">Application ID: {{ $owner->id ?? 'N/A'}}</h4>
                                    @empty
                                    <h4 class="float-end font-size-16">Application ID: None</h4>
                                    @endforelse
                                    @if($owners->isEmpty())
                                    <a class="btn btn-sm btn-primary my-2" onClick="add()" href="javascript:void(0)"><i class="bi bi-plus-circle"></i> Apply For an Application</a>
                                    @else
                                    <button class="btn btn-sm btn-danger my-2" disabled><i class="bx bx-minus-circle"></i> Already Applied </button>
                                    @endif
                                </div>
                                <hr>
                                <!-- Edit Modals -->
                                @include('applicant_users.edit_owner')
                                @include('applicant_users.edit_vehicle')
                                @include('applicant_users.edit_driver')
                                @include('applicant_users.apply_modals')

                                @forelse($owners as $owner)
                                <div class="row">
                                    <div class="col-sm-6 mt-3">
                                        <address>
                                            <strong>Applicant Info:</strong><br>
                                            Name: {{ auth()->user()->name }}<br>
                                            Email: {{ auth()->user()->email }}
                                        </address>
                                    </div>
                                    <div class="col-sm-6 mt-3 text-sm-end">
                                        <address>
                                            <strong>Application Date:</strong><br>
                                            {{ isset($owner->created_at) ? \Carbon\Carbon::parse($owner->created_at)->format('F j, Y') : 'N/A' }}
                                            <br><br>
                                        </address>
                                    </div>
                                </div>
                                <div class="py-2 mt-3">
                                    <h3 class="font-size-15 fw-bold">Application Summary</h3>
                                </div>
                            </div>
                            <div class="table-responsive" id="applicant_details">
                                <h1 class="text-center text-secondary my-5"> Loading... </h1>
                            </div>
                            @empty
                            <h4 class="float-end font-size-16">No Application Yet</h4>
                            @endforelse

                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->


        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->

    </div>
    <!-- end main content-->


    @include('applicant_users.apply_js')
</body>

</html>
@endsection