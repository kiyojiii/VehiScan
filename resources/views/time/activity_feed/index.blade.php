<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MVIS | Time Record </title>

    <link rel="icon" href="{{ asset('images/seal.png') }}" type="image/x-icon">

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
                            <h4 class="mb-sm-0 font-size-18">Activity Feed</h4>
                            <h4 id="digitalClock" class="clock"></h4>
                            @include('clock_js')
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Time</a></li>
                                    <li class="breadcrumb-item active">Activity Feed</li>
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
                                    <h5 class="mb-0 card-title flex-grow-1">Activity Feed Count: {{ $totalactivityfeed }}</h5>
                                    <div class="flex-shrink-0">
                                        <a href="javascript:location.reload(true)" class="btn btn-light"><i class="mdi mdi-refresh"></i></a>
                                        <div class="dropdown d-inline-block">

                                            <button type="menu" class="btn btn-success" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical"></i></button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                <li><a class="dropdown-item" href="{{ route('owners.index') }}">Owners</a></li>
                                                <li><a class="dropdown-item" href="{{ route('vehicles.index') }}">Vehicles</a></li>
                                                <li><a class="dropdown-item" href="{{ route('drivers.index') }}">Drivers</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body border-bottom">
                                <!-- Your filter form -->
                                <!-- <form>
                                    <div class="row justify-content-center"> 
                                        <div class="col-xl col-sm-6">
                                            <div class="mb-3">
                                                <label class="form-label">Date :</label>
                                                <input type="text" class="form-control" id="orderid-input" placeholder="Select date" data-date-format="dd M, yyyy" data-date-orientation="bottom auto" data-provide="datepicker" data-date-autoclose="true">
                                            </div>
                                        </div>

                                        <div class="col-xl col-sm-6">
                                            <div class="mb-3">
                                                <label class="form-label">Coin :</label>
                                                <select class="form-control select2-search-disable">
                                                    <option value="BTC" selected>Bitcoin</option>
                                                    <option value="ETH">Ethereum</option>
                                                    <option value="LTC">litecoin</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-xl col-sm-6">
                                            <div class="mb-3">
                                                <label class="form-label">Type :</label>
                                                <select class="form-control select2-search-disable">
                                                    <option value="BU" selected>Buy</option>
                                                    <option value="SE">Sell</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-xl col-sm-6">
                                            <div class="mb-3">
                                                <label class="form-label">Status :</label>
                                                <select class="form-control select2-search-disable">
                                                    <option value="CO" selected>Completed</option>
                                                    <option value="PE">Pending</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-xl col-sm-6 align-self-end">
                                            <div class="mb-3">
                                                <button type="button" class="btn btn-primary w-md">Add Order</button>
                                            </div>
                                        </div>
                                    </div>
                                </form> -->

                                <!-- Table or content to be displayed when filter is applied -->
                                <div class="card-body" id="show_activity_feed">
                                    <h1 class="text-center text-secondary my-5">Loading...</h1>
                                </div>
                            </div>

                            @include('time.time_modals')

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

    @include('time.activity_feed.activity_feed_js')

</body>

</html>
@endsection