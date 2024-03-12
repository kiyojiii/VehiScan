<script type="text/javascript">
    //CREATE
    function add() {
        $('#add_appointment_form').trigger("reset");
        $('#AppointmentModal').html("Add Appointment");
        $('#addAppointmentModal').modal('show');
        $('#id').val('');
    }

    //EDIT
    function edit() {
        $('#edit_appointment_form').trigger("reset");
        $('#AppointmentModal').html("Edit Appointment");
        $('#editAppointmentModal').modal('show');
        $('#id').val('');
    }
</script>

<script>
$(function() {
    // Event listener for the form submission
    $("#add_appointment_form").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        $("#add_appointment_btn").text('Adding...');
        $.ajax({
            url: '{{ route('appointments.store') }}',
            method: 'post',
            data: fd,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                if (response.status == 200) {
                    fetchAllAppointments();
                    // Close the modal
                    $("#addAppointmentModal").modal('hide');
                    Swal.fire(
                        "Successful",
                        "Appointment Added Successfully",
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
                $("#add_appointment_btn").text('Add Appointment');
                $("#add_appointment_form")[0].reset();
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
                $("#add_appointment_btn").text('Add Appointment');
            }
        });
        
    });

   //edit appointment ajax request
    $(document).on('click', '.editIcon', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        $.ajax({
            url: '{{ route('appointments.edit') }}',
            method: 'get',
            data: {
                id: id,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                // Set the value of the appointment input
                $("#edit_appointment").val(response.appointment);
                // Set the value of the hidden input for appointment_id
                $("#appointment_id").val(response.id);
                // Show the edit modal
                $('#editAppointmentModal').modal('show');
            },
            error: function(xhr, status, error) {
                // Show error message using SweetAlert if there's an error with the request
                Swal.fire(
                    "Error",
                    "An error occurred while fetching appointment data.",
                    "error"
                );
            }
        });
    });

    // update appointment ajax request
    $("#edit_appointment_form").submit(function(e) {
            e.preventDefault();
            const fd = new FormData(this);
            $("#edit_appointment_btn").text('Updating...');
            $.ajax({
                url: '{{ route('appointments.update') }}',
                method: 'post',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 200) {
                        fetchAllAppointments();
                        // Close the modal
                        $("#editAppointmentModal").modal('hide');
                        Swal.fire(
                            "Updated",
                            "Appointment Updated Successfully",
                            "success"
                        );
                    }
                    $("#edit_appointment_btn").text('Update Appointment');
                    $("#edit_appointment_form")[0].reset();
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
                    $("#edit_appointment_btn").text('Update Appointment');
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
                    url: '{{ route('appointments.delete') }}',
                    method: 'delete',
                    data: {
                        id: id,
                        _token: csrf
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire(
                                'Deleted!',
                                'Appointment Deleted Successfully',
                                'success'
                            );
                            fetchAllAppointments();
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
                            'Failed to delete appointment: ' + error,
                            'error'
                        );
                    }
                });
            }
        });
    });


        // fetch all appointment ajax request
        fetchAllAppointments();

        function fetchAllAppointments() {
            $.ajax({
                url: '{{ route('fetchAllAppointment') }}',
                method: 'get',
                success: function(response) {
                    $("#show_all_appointments").html(response);
                    $("table").DataTable({
                        order:[0, 'desc']
                    });
                }
            });
        }
    });
</script>