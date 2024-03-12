<script type="text/javascript">
    //CREATE
    function add() {
        $('#add_rolestatus_form').trigger("reset");
        $('#RoleStatusModal').html("Add RoleStatus");
        $('#addRoleStatusModal').modal('show');
        $('#id').val('');
    }

    //EDIT
    function edit() {
        $('#edit_rolestatus_form').trigger("reset");
        $('#RoleStatusModal').html("Edit RoleStatus");
        $('#editRoleStatusModal').modal('show');
        $('#id').val('');
    }
</script>

<script>
$(function() {
    // Event listener for the form submission
    $("#add_rolestatus_form").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        $("#add_rolestatus_btn").text('Adding...');
        $.ajax({
            url: '{{ route('status.store') }}',
            method: 'post',
            data: fd,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                if (response.status == 200) {
                    fetchAllRoleStatuses();
                    // Close the modal
                    $("#addRoleStatusModal").modal('hide');
                    Swal.fire(
                        "Successful",
                        "Role Status Added Successfully",
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
                $("#add_rolestatus_btn").text('Add Role Status');
                $("#add_rolestatus_form")[0].reset();
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
                $("#add_rolestatus_btn").text('Add Role Status');
            }
        });
        
    });

   //edit rolestatus ajax request
    $(document).on('click', '.editIcon', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        $.ajax({
            url: '{{ route('status.edit') }}',
            method: 'get',
            data: {
                id: id,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                // Set the value of the rolestatus input
                $("#edit_applicant_role_status").val(response.applicant_role_status);
                // Set the value of the hidden input for rolestatus_id
                $("#rolestatus_id").val(response.id);
                // Show the edit modal
                $('#editRoleStatusModal').modal('show');
            },
            error: function(xhr, status, error) {
                // Show error message using SweetAlert if there's an error with the request
                Swal.fire(
                    "Error",
                    "An error occurred while fetching role status data.",
                    "error"
                );
            }
        });
    });

    // update rolestatus ajax request
    $("#edit_rolestatus_form").submit(function(e) {
            e.preventDefault();
            const fd = new FormData(this);
            $("#edit_rolestatus_btn").text('Updating...');
            $.ajax({
                url: '{{ route('status.update') }}',
                method: 'post',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 200) {
                        fetchAllRoleStatuses();
                        // Close the modal
                        $("#editRoleStatusModal").modal('hide');
                        Swal.fire(
                            "Updated",
                            "Role Status Updated Successfully",
                            "success"
                        );
                    }
                    $("#edit_rolestatus_btn").text('Update Role Status');
                    $("#edit_rolestatus_form")[0].reset();
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
                    $("#edit_rolestatus_btn").text('Update Role Status');
                }
            });
        });
        
        // delete driver ajax request
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
                    url: '{{ route('status.delete') }}',
                    method: 'delete',
                    data: {
                        id: id,
                        _token: csrf
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire(
                                'Deleted!',
                                'Role Status Deleted Successfully',
                                'success'
                            );
                            fetchAllRoleStatuses();
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
                            'Failed to delete role status: ' + error,
                            'error'
                        );
                    }
                });
            }
        });
    });


        // fetch all role ajax request
        fetchAllRoleStatuses();

        function fetchAllRoleStatuses() {
            $.ajax({
                url: '{{ route('fetchAllRoleStatus') }}',
                method: 'get',
                success: function(response) {
                    $("#show_all_role_status").html(response);
                    $("table").DataTable({
                        order:[0, 'desc']
                    });
                }
            });
        }
    });
</script>
