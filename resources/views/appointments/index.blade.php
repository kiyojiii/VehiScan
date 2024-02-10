<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>VehiScan | Appointment</title>

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
                            <h4 class="mb-sm-0 font-size-18">Appointment List</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Appointment</a></li>
                                    <li class="breadcrumb-item active">Appointment List</li>
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
                                    <h5 class="mb-0 card-title flex-grow-1">Appoinment Lists</h5>
                                    <div class="flex-shrink-0">
                                        <a class="btn btn-success btn-sm my-2" onClick="add()" href="javascript:void(0)"><i class="bi bi-plus-circle"></i> Add Appointment</a>
                                    </div>
                                </div>
                            </div>

                            @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                <p>{{ $message }}</p>
                            </div>
                            @endif

                            <div class="card-body">
                                <table class="table table-bordered" id="appointment-datatable">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Appointment</th>
                                            <th>Created at</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="appointment-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Appointment</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>

                                        <div class="modal-body">
                                            <form action="javascript:void(0)" id="AppointmentForm" name="AppointmentForm" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="id" id="id">
                                                <div class="form-group">
                                                    <label for="appointment" class="form-label">Appointment</label>
                                                    <input type="text" class="form-control" id="appointment" name="appointment" required>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary" id="btn-save">Save changes</button>
                                                </div>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- End Modal -->

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

    <script type="text/javascript">
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // DISPLAY
            $('#appointment-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ url('appointments') }}",
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'appointment', name: 'appointment' },
                    { 
                        data: 'created_at', 
                        name: 'created_at',
                        render: function(data) {
                            // Convert data to JavaScript Date object
                            var date = new Date(data);

                            // Get hours, minutes, and AM/PM
                            var hours = date.getHours() > 12 ? date.getHours() - 12 : date.getHours();
                            var minutes = date.getMinutes();
                            var ampm = date.getHours() >= 12 ? 'PM' : 'AM';

                            // Add leading zero if needed
                            hours = hours < 10 ? '0' + hours : hours;
                            minutes = minutes < 10 ? '0' + minutes : minutes;

                            // Get month, day, and year
                            var month = date.toLocaleString('default', { month: 'long' });
                            var day = date.getDate();
                            var year = date.getFullYear();

                            // Format the date
                            var formattedDate = month + ' ' + day + ', ' + year + ' at ' + hours + ':' + minutes + ' ' + ampm;
                            return formattedDate;
                        }
                    },
                    { data: 'action', name: 'action', orderable: false },
                ],

                order: [[0, 'desc']]
            });
        });

        //CREATE
        function add() {
            $('#AppointmentForm').trigger("reset");
            $('#AppointmentModal').html("Add Appointment");
            $('#appointment-modal').modal('show');
            $('#id').val('');
        }

        //UPDATE / EDIT
        function editFunc(id){
            $.ajax({
                type:"POST",
                url: "{{ url('appointments/edit') }}",
                data: { id: id },
                dataType: 'json',
                success: function(res){
                    $('#AppointmentModal').html("Edit Appointment");
                    $('#appointment-modal').modal('show');
                    $('#id').val(res.id);
                    $('#appointment').val(res.appointment);
                }
            });
        }

        //DELETE
        function deleteFunc(id){
            if (confirm("Delete Record?") == true) {
                var id = id;
                // ajax
                $.ajax({
                    type:"POST",
                    url: "{{ url('appointments/delete') }}",
                    data: { id: id },
                    dataType: 'json',
                    success: function(res){
                        var oTable = $('#appointment-datatable').dataTable();
                        oTable.fnDraw(false);
                    }
                });
            }
        }

        $('#AppointmentForm').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type: "POST",
                url: "{{ url('appointments/store') }}",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: (data) => {
                    console.log(data);
                    $("#appointment-modal").modal('hide');
                    var oTable = $('#appointment-datatable').dataTable();
                    oTable.fnDraw(false);
                    $("#btn-save").html('Submit');
                    $("#btn-save").attr("disabled", false);
                },
                error: function(data) {
                    console.log(data);
                }
            });
        });
    </script>


</body>

</html>
@endsection