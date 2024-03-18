<script type="text/javascript">
    //CREATE
    function add() {
        $('#add_permission_form').trigger("reset");
        $('#PermissionModal').html("Add Permission");
        $('#addPermissionModal').modal('show');
        $('#id').val('');
    }

    //EDIT
    function edit() {
        $('#edit_permission_form').trigger("reset");
        $('#PermissionModal').html("Edit Permission");
        $('#editPermissionModal').modal('show');
        $('#id').val('');
    }
</script>

<script>
    $(function() {
        $("#add_permission_form").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        $("#add_permission_btn").text('Adding...');
        $.ajax({
            url: '{{ route('permissions.store') }}',
            method: 'post',
            data: fd,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                if (response.status == 200) {
                    fetchAllPermissions();
                    // Close the modal
                    $("#addPermissionModal").modal('hide');
                    Swal.fire(
                        "Successful",
                        "Permission Added Successfully",
                        "success"
                    )
                } else {
                    // Show error message using SweetAlert
                    Swal.fire(
                        "Error",
                        response.message,
                        "error"
                    )
                }
                $("#add_permission_btn").text('Add Permission');
                $("#add_permission_form")[0].reset();
            },
            error: function(xhr, status, error) {
                // Parse JSON response to extract specific error message and display it using SweetAlert
                const response = JSON.parse(xhr.responseText);
                const errorMessage = response.message;
                Swal.fire(
                    "Error",
                    errorMessage,
                    "error"
                );
                $("#add_permission_btn").text('Add Permission');
            }
        });
        
    });

      //edit permission ajax request
      $(document).on('click', '.editIcon', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        $.ajax({
            url: '{{ route('permissions.edit') }}',
            method: 'get',
            data: {
                id: id,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                // Set the value of the permission input
                $("#edit_permission").val(response.name);
                // Set the value of the hidden input for permission_id
                $("#permission_id").val(response.id);
                // Show the edit modal
                $('#editPermissionModal').modal('show');
            },
            error: function(xhr, status, error) {
                // Show error message using SweetAlert if there's an error with the request
                Swal.fire(
                    "Error",
                    "An error occurred while fetching permission data.",
                    "error"
                );
            }
        });
    });

     // update permission ajax request
     $("#edit_permission_form").submit(function(e) {
            e.preventDefault();
            const fd = new FormData(this);
            $("#edit_permission_btn").text('Updating...');
            $.ajax({
                url: '{{ route('permissions.update') }}',
                method: 'post',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 200) {
                        fetchAllPermissions();
                        // Close the modal
                        $("#editPermissionModal").modal('hide');
                        Swal.fire(
                            "Updated",
                            "Permission Updated Successfully",
                            "success"
                        );
                    }
                    $("#edit_permission_btn").text('Update Permission');
                    $("#edit_permission_form")[0].reset();
                },
                error: function(xhr, status, error) {
                        // Parse JSON response to extract specific error message and display it using SweetAlert
                        const response = JSON.parse(xhr.responseText);
                        const errorMessage = response.message;
                        Swal.fire(
                            "Error",
                            errorMessage,
                            "error"
                        );
                    $("#edit_permission_btn").text('Update Permission');
                }
            });
        });

        // delete permission ajax request
        $(document).on('click', '.deleteIcon', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        let csrf = '{{ csrf_token() }}';
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route('permissions.delete') }}',
                    method: 'delete',
                    data: {
                        id: id,
                        _token: csrf
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire(
                                'Deleted!',
                                'Permission Deleted Successfully',
                                'success'
                            );
                            fetchAllPermissions();
                        } else {
                            Swal.fire(
                                'Error!',
                                response.message,
                                'error'
                            );
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire(
                            'Error!',
                            'Failed to delete permission: ' + error,
                            'error'
                        );
                    }
                });
            }
        });
    });

        // fetch all permission ajax request
        fetchAllPermissions();

        function fetchAllPermissions() {
            $.ajax({
                url: '{{ route('fetchAllPermission') }}',
                method: 'get',
                success: function(response) {
                    $("#show_all_permissions").html(response);
                    $("table").DataTable({
                        order:[0, 'desc']
                    });
                }
            });
        }
    });
</script>
