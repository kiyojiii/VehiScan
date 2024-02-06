<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>VehiScan | Status</title>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
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
                            <h4 class="mb-sm-0 font-size-18">Status List</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Status</a></li>
                                    <li class="breadcrumb-item active">Status List</li>
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
                                    <h5 class="mb-0 card-title flex-grow-1">Status Lists</h5>
                                    <div class="flex-shrink-0">
                                        <a class="btn btn-success btn-sm my-2" onClick="add()" href="javascript:void(0)"><i class="bi bi-plus-circle"></i> Add Status</a>
                                    </div>
                                </div>
                            </div>

                            @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                <p>{{ $message }}</p>
                            </div>
                            @endif

                            <div class="card-body">
                                <table class="table table-bordered" id="status-datatable">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Status</th>
                                            <th>Created at</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="status-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Status</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>

                                        <div class="modal-body">
                                            <form action="javascript:void(0)" id="StatusForm" name="StatusForm" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="id" id="id">
                                                
                                                <div class="form-group">
                                                    <label for="status" class="form-label">Status</label>
                                                    <input type="text" class="form-control" id="applicant_role_status" name="applicant_role_status" required>
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
            $('#status-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ url('status') }}",
                columns: [
                    { data: 'id',name: 'id' },
                    { data: 'applicant_role_status', name: 'applicant_role_status' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'action', name: 'action', orderable: false },
                ],
                order: [[0, 'desc']]
            });
        });

        //CREATE
        function add() {
            $('#StatusForm').trigger("reset");
            $('#StatusModal').html("Add Status");
            $('#status-modal').modal('show');
            $('#id').val('');
        }

        //UPDATE / EDIT
        function editFunc(id){
            $.ajax({
                type:"POST",
                url: "{{ url('status/edit') }}",
                data: { id: id },
                dataType: 'json',
                success: function(res){
                    $('#StatusModal').html("Edit Status");
                    $('#status-modal').modal('show');
                    $('#id').val(res.id);
                    $('#applicant_role_status').val(res.applicant_role_status);
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
                    url: "{{ url('status/delete') }}",
                    data: { id: id },
                    dataType: 'json',
                    success: function(res){
                        var oTable = $('#status-datatable').dataTable();
                        oTable.fnDraw(false);
                    }
                });
            }
        }

  
        $('#StatusForm').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type: "POST",
                url: "{{ url('status/store') }}",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: (data) => {
                    console.log(data);
                    $("#status-modal").modal('hide');
                    var oTable = $('#status-datatable').dataTable();
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