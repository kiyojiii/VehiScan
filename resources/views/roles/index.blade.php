<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> MVIS | Roles </title>

    <link rel="icon" href="{{ asset('images/seal.png') }}" type="image/x-icon">

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

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
                            <h4 class="mb-sm-0 font-size-18">Roles List</h4>
                            <h4 id="digitalClock" class="clock"></h4>
                            @include('clock_js')
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Roles</a></li>
                                    <li class="breadcrumb-item active">Roles List</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body border-bottom">
                                <div class="d-flex align-items-center">
                                    <h5 class="mb-0 card-title flex-grow-1">Role Count: {{ $totalrolecount }} </h5>
                                    <div class="flex-shrink-0">
                                    @can('create-role')
                                        <a href="{{ route('roles.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Add New Role</a>
                                    @endcanany 
                                        <button class="btn btn-light" type="button" id="refresh_table"><i class="mdi mdi-refresh"></i></button>
                                        <div class="dropdown d-inline-block">
                                            <button type="menu" class="btn btn-success" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical"></i></button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                <li><a class="dropdown-item" href="#">Action</a></li>
                                                <li><a class="dropdown-item" href="#">Another action</a></li>
                                                <li><a class="dropdown-item" href="#">Something else here</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body border-bottom">
                                <form method="GET" action="/filter">
                                    <div class="row g-3 align-items-center">
                                        <div class="col-xxl-2 col-lg-4">
                                            <label>Search:</label>
                                            <input type="search" name="search" class="form-control" id="searchInput" placeholder="Search for ...">
                                        </div>
                                        <div class="col-sm-2 col-sm-3">
                                            <label>Start Date:</label>
                                            <div class="input-group">
                                                <input type="date" name="start_date" class="form-control" id="start_date">
                                                <button class="btn btn-primary" type="button" id="set_today_start">Today</button>
                                            </div>
                                        </div>
                                        <div class="col-sm-2 col-sm-3">
                                            <label>End Date:</label>
                                            <div class="input-group">
                                                <input type="date" name="end_date" class="form-control" id="end_date">
                                                <button class="btn btn-primary" type="button" id="set_today_end">Today</button>
                                            </div>
                                        </div>
                                        <div class="col-xxl-1 col-lg-1 d-grid">
                                            <label>&nbsp;</label>
                                            <button type="submit" class="btn btn-primary">Filter</button>
                                        </div>
                                        <div class="col-xxl-1 col-lg-1 d-grid">
                                            <label>&nbsp;</label>
                                            <button class="btn btn-secondary" type="button" id="clear_filter">Clear</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="card-body">
                                <div class="table-responsive">
                                    <div class="table-data">
                                        <table class="table table-bordered align-middle nowrap">
                                            @include('roles.role_pagination')
                                        </table>
                                    </div>
                                </div>
                                @include('roles.roles_js')
                            </div><!--end card-->
                        </div><!--end card-->
                    </div><!--end col-->
                </div><!--end row-->

            </div> <!-- container-fluid -->
        </div><!-- End Page-content -->

    </div>
    <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>
    @endsection
</body>

</html>