<!-- Add Vehicle-->
<script>
    $(function() {
        // add new vehicle ajax request
        $("#add_vehicle_form").submit(function(e) {
            e.preventDefault();
            const fd = new FormData(this);
            $("#add_vehicle_btn").text('Adding...');
            $.ajax({
                url: '{{ route('vehicles.store') }}',
                method: 'post',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 200) {
                        fetchVehicles();
                        // Close the modal
                        $("#addVehicleModal").modal('hide');
                        Swal.fire(
                            "Successful",
                            "Vehicle Added Successfully",
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
                    $("#add_vehicle_btn").text('Add Vehicle');
                    $("#add_vehicle_form")[0].reset();
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
                    $("#add_vehicle_btn").text('Add Vehicle');
                }
            });
        });

            // delete vehicle ajax request
            $(document).on('click', '.deleteVehicle', function(e) {
            e.preventDefault();
            let id = $(this).attr('id');
            let csrf = '{{ csrf_token() }}';
            Swal.fire({
                title: 'Deactivate Vehicle?',
                text: "This Vehicle Will Become Inactive",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Proceed'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('owners.delete_vehicle') }}',
                        method: 'delete',
                        data: {
                            id: id,
                            _token: csrf
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                fetchVehicles();
                                Swal.fire(
                                    'Deleted!',
                                    'Vehicle is now Inactive',
                                    'success'
                                );
                                fetchAllVehicles();
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
                                'Failed to delete vehicle: ' + error,
                                'error'
                            );
                        }
                    });
                }
            });
        });

    });
</script>

<script>
    //CREATE
    function addVehicle() {
        $('#add_vehicle_form').trigger("reset");
        $('#VehicleModal').html("Add Vehicle");
        $('#addVehicleModal').modal('show');
        $('#id').val('');
    }

    //CREATE
    function addDriver() {
        $('#add_driver_form').trigger("reset");
        $('#DriverModal').html("Add Driver");
        $('#addDriverModal').modal('show');
        $('#id').val(''); 
    }

    //EDIT DRIVER
    function editDriver() {
        $('#edit_driver_form').trigger("reset");
        $('#DriverModal').html("Edit Driver");
        $('#editDriverModal').modal('show');
        $('#id').val('');
    }
</script>

<script>
    // Pagination AJAX
    $(document).on('click', '#paginationLinks a', function(event) {
        event.preventDefault();
        var url = $(this).attr('href');
        fetchVehicles(url);
    });

    // Fetch Vehicles Function
    function fetchVehicles(url) {
        $.ajax({
            url: url,
            type: 'get',
            success: function(response) {
                $('#vehicleContainer').html($(response).find('#vehicleContainer').html());
                $('#paginationLinks').html($(response).find('#paginationLinks').html());
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }
</script>