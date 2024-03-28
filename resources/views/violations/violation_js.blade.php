<script type="text/javascript">
    //CREATE
    function add() {
        $('#add_violation_form').trigger("reset");
        $('#ViolationModal').html("Add Violation");
        $('#addViolationModal').modal('show');
        $('#id').val('');
    }

    //EDIT
    function edit() {
        $('#edit_violation_form').trigger("reset");
        $('#ViolationModal').html("Edit Violation");
        $('#editViolationModal').modal('show');
        $('#id').val('');
    }
</script>

<script>
$(function() {
    // Event listener for the form submission
    $("#add_violation_form").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        $("#add_violation_btn").text('Adding...');
        $.ajax({
            url: '{{ route('violations.store') }}',
            method: 'post',
            data: fd,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                if (response.status == 200) {
                    fetchAllViolations();
                    // Close the modal
                    $("#addViolationModal").modal('hide');
                    Swal.fire(
                        "Successful",
                        "Violation Added Successfully",
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
                $("#add_violation_btn").text('Add Violation');
                $("#add_violation_form")[0].reset();
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
                $("#add_violation_btn").text('Add Violation');
            }
        });
        
    });

   //edit violation ajax request
    $(document).on('click', '.editIcon', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        $.ajax({
            url: '{{ route('violations.edit') }}',
            method: 'get',
            data: {
                id: id,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                // Check if response contains valid data
                if (response && response.vehicle_id) {
                    // Set the value of the vehicle dropdown
                    $('#edit_vehicle_id').val(response.vehicle_id).trigger('change');
                }
                // Set the value of the violation input
                $("#edit_violation").val(response.violation);
                // Set the value of the hidden input for violation_id
                $("#violation_id").val(response.id);
                // Show the edit modal
                $('#editViolationModal').modal('show');
            },
            error: function(xhr, status, error) {
                // Show error message using SweetAlert if there's an error with the request
                Swal.fire(
                    "Error",
                    "An error occurred while fetching violation data.",
                    "error"
                );
            }
        });
    });

    // update violation ajax request
    $("#edit_violation_form").submit(function(e) {
            e.preventDefault();
            const fd = new FormData(this);
            $("#edit_violation_btn").text('Updating...');
            $.ajax({
                url: '{{ route('violations.update') }}',
                method: 'post',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 200) {
                        fetchAllViolations();
                        // Close the modal
                        $("#editViolationModal").modal('hide');
                        Swal.fire(
                            "Updated",
                            "Violation Updated Successfully",
                            "success"
                        );
                    }
                    $("#edit_violation_btn").text('Update Violation');
                    $("#edit_violation_form")[0].reset();
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
                    $("#edit_violation_btn").text('Update Violation');
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
                    url: '{{ route('violations.delete') }}',
                    method: 'delete',
                    data: {
                        id: id,
                        _token: csrf
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire(
                                'Deleted!',
                                'Violation Deleted Successfully',
                                'success'
                            );
                            fetchAllViolations();
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
                            'Failed to delete violation: ' + error,
                            'error'
                        );
                    }
                });
            }
        });
    });


        // fetch all violation ajax request
        fetchAllViolations();

        function fetchAllViolations() {
            $.ajax({
                url: '{{ route('fetchAllViolation') }}',
                method: 'get',
                success: function(response) {
                    $("#show_all_violations").html(response);
                    $("table").DataTable({
                        order:[0, 'desc']
                    });
                }
            });
        }
    });
</script>

<!-- Include Select2 initialization script -->
<script>
    $(document).ready(function() {
        // Initialize Select2 for the vehicle dropdown
        $('.vehicle-select').select2({
            theme: 'bootstrap-5',
            selectionCssClass: "select2--small",
    dropdownCssClass: "select2--small",
            dropdownParent: $('#addViolationModal')
        });

        // Event listener for modal hidden event
        $('#addViolationModal').on('hidden.bs.modal', function() {
            // Clear the Select2 value
            $('.vehicle-select').val(null).trigger('change');
        });
    });
</script>
<script>
    $(document).ready(function() {
        // Initialize Select2 for the vehicle dropdown
        $('.edit-vehicle-select').select2({
            dropdownParent: $('#editViolationModal')
        });

        // Event listener for modal hidden event
        $('#editViolationModal').on('hidden.bs.modal', function() {
            // Clear the Select2 value
            $('.edit-vehicle-select').val(null).trigger('change');
        });
    });
</script>