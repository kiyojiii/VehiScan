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
                            <h4 class="mb-sm-0 font-size-18">Violations</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Violation</a></li>
                                    <li class="breadcrumb-item active">Violation List</li>
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

                                <div class="card-body" id="show_all_applicant_violations">
                                    <h1 class="text-center text-secondary my-5"> Loading... </h1>
                                </div>

                            </div>

                        </div><!--end card-->
                    </div><!--end col-->

                </div><!--end row-->

                <script>
                           // fetch all violation ajax request
        fetchAllViolations();

function fetchAllViolations() {
    $.ajax({
        url: '{{ route('fetchAllApplicantViolation') }}',
        method: 'get',
        success: function(response) {
            $("#show_all_applicant_violations").html(response);
            $("table").DataTable({
                order:[0, 'desc']
            });
        }
    });
}
                </script>

            </div> <!-- container-fluid -->
        </div><!-- End Page-content -->

    </div>
    <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

</body>

</html>
@endsection