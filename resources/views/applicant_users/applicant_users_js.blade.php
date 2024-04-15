

<script>
    $(function() {
            // edit vehicle ajax request
            $(document).on('click', '.activateVehicle', function(e) {
            e.preventDefault();
            let id = $(this).attr('id');
            $.ajax({
                url: '{{ route('applicant_vehicle.activate_vehicle') }}',
                method: 'get',
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $("#driver_id").val(response.driver_id);
                    $("#owner_name").val(response.owner_name);
                    $("#owner_address").val(response.owner_address);
                    $("#plate_number").val(response.plate_number);
                    $("#vehicle_make").val(response.vehicle_make);
                    $("#vehicle_category").val(response.vehicle_category);
                    $("#year_model").val(response.year_model);
                    $("#color").val(response.color);
                    $("#body_type").val(response.body_type);
                    $("#official_receipt_image").html(
                        `<img src="storage/images/vehicles/documents/${response.official_receipt_image}" width="150" height="100" class="img-fluid img-thumbnail">`);
                    $("#certificate_of_registration_image").html(
                        `<img src="storage/images/vehicles/documents/${response.certificate_of_registration_image}" width="150" height="100" class="img-fluid img-thumbnail">`);
                    $("#deed_of_sale_image").html(
                        `<img src="storage/images/vehicles/documents/${response.deed_of_sale_image}" width="150" height="100" class="img-fluid img-thumbnail">`);
                    $("#authorization_letter_image").html(
                        `<img src="storage/images/vehicles/documents/${response.authorization_letter_image}" width="150" height="100" class="img-fluid img-thumbnail">`);
                    $("#front_photo").html(
                        `<img src="storage/images/vehicles/${response.front_photo}" width="150" height="100" class="img-fluid img-thumbnail">`);
                    $("#side_photo").html(
                        `<img src="storage/images/vehicles/${response.side_photo}" width="150" height="100" class="img-fluid img-thumbnail">`);
                    $("#vehicle_id").val(response.id);
                    $("#official_receipt_image_photo").val(response.official_receipt_image);
                    $("#certificate_of_registration_image_photo").val(response.certificate_of_registration_image)
                    $("#deed_of_sale_image_photo").val(response.deed_of_sale_image);
                    $("#authorization_letter_image_photo").val(response.authorization_letter_image)
                    $("#front_photo_photo").val(response.front_photo);
                    $("#side_photo_photo").val(response.side_photo)
                },
                error: function(xhr, status, error) {
                    // Show error message using SweetAlert if there's an error with the request
                    Swal.fire(
                        "Error",
                        "An error occurred while fetching vehicle data.",
                        "error"
                    );
                }
            });
        });

                // update vehicle ajax request
$("#edit_activate_form").submit(function(e) {
    e.preventDefault();

    // Show confirmation dialog before submitting the form
    Swal.fire({
        title: 'Activate Vehicle',
        text: 'Activating this vehicle will change your vehicle status to Pending, Proceed?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Proceed'
    }).then((result) => {
        if (result.isConfirmed) {
            // Proceed with updating the vehicle
            const fd = new FormData(this);
            $("#activate_vehicle_btn").text('Updating...');
            $.ajax({
                url: '{{ route('applicant_vehicle.activate_vehicle_submit') }}',
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
                        $("#editActivateModal").modal('hide');
                        Swal.fire(
                            'Vehicle Activation Request',
                            'A staff will evaluate your request, please keep in touch.',
                            'success'
                        ).then(() => {
                                // Reload the page
                                location.reload();
                            });
                    }
                    $("#activate_vehicle_btn").text('Activate Vehicle');
                    $("#edit_activate_form")[0].reset();
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
                    $("#activate_vehicle_btn").text('Activate Vehicle');
                }
            });
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
                text: "This Vehicle's Status Will Become Inactive",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Deactivate it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('applicant_vehicle.delete') }}',
                        method: 'delete',
                        data: {
                            id: id,
                            _token: csrf
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                fetchVehicles();
                                Swal.fire(
                                    'Deactivated!',
                                    'Vehicle is now Inactive',
                                    'success'
                                ).then(() => {
                                // Reload the page
                                location.reload();
                            });
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
                                'Failed to deactivate vehicle: ' + error,
                                'error'
                            );
                        }
                    });
                }
            });
        });

         // edit driver ajax request
         $(document).on('click', '.editDriver', function(e) {
            e.preventDefault();
            let id = $(this).attr('id');
            $.ajax({
                url: '{{ route('applicant_users.edit_driver') }}',
                method: 'get',
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $("#dname").val(response.driver_name);
                    $("#adname").val(response.authorized_driver_name);
                    $("#adaddress").val(response.authorized_driver_address);
                    $("#approval").val(response.approval_status);
                    $("#reason").val(response.reason);
                    $("#driver_license_image").html(
                        `<img src="storage/images/drivers/${response.driver_license_image}" width="100" class="img-fluid img-thumbnail">`);
                    $("#authorized_driver_license_image").html(
                        `<img src="storage/images/drivers/${response.authorized_driver_license_image}" width="100" class="img-fluid img-thumbnail">`);
                    $("#driver_id").val(response.id);
                    $("#dlicense_photo").val(response.driver_license_image);
                    $("#adlicense_photo").val(response.authorized_driver_license_image)
                },
                error: function(xhr, status, error) {
                    // Show error message using SweetAlert if there's an error with the request
                    Swal.fire(
                        "Error",
                        "An error occurred while fetching driver data.",
                        "error"
                    );
                }
            });
        });

        // update driver ajax request
$("#edit_driver_form").submit(function(e) {
    e.preventDefault();

    // Show Swal confirmation alert
    Swal.fire({
        title: 'Update Driver',
        text: 'Are you sure you want to update your driver information?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, update it!'
    }).then((result) => {
        if (result.isConfirmed) {
            const fd = new FormData(this);
            $("#edit_driver_btn").text('Updating...');
            $.ajax({
                url: '{{ route('applicant_users.update_driver') }}',
                method: 'post',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 200) {
                        // Close the modal
                        $("#editDriverModal").modal('hide');
                        Swal.fire(
                            'Updated!',
                            'Your driver information has been updated successfully.',
                            'success'
                        ).then(() => {
                            // Reload the page
                            location.reload();
                        });
                    }
                    $("#edit_driver_btn").text('Update Driver');
                    $("#edit_driver_form")[0].reset();
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
                    $("#edit_driver_btn").text('Update Driver');
                }
            });
        }
    });
});


    // edit owner ajax request
        $(document).on('click', '.editOwner', function(e) {
            e.preventDefault();
            let id = $(this).attr('id');
            $.ajax({
                url: '{{ route('applicant_users.edit_owner') }}',
                method: 'get',
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $("#fname").val(response.first_name);
                    $("#mi").val(response.middle_initial);
                    $("#lname").val(response.last_name);
                    $("#paddress").val(response.present_address);
                    $("#email").val(response.email_address);
                    $("#contact").val(response.contact_number);
                    $("#appointment").val(response.appointment_id);
                    $("#role_status").val(response.status_id);
                    $("#department").val(response.office_department_agency);
                    $("#position").val(response.position_designation);
                    $("#approval").val(response.approval_status);
                    $("#reason").val(response.reason);
                    $("#serial_number").val(response.serial_number);
                    $("#id_number").val(response.id_number);
                    $("#scan_or_photo_of_id").html(
                        `<img src="storage/images/${response.scan_or_photo_of_id}" width="100" class="img-fluid img-thumbnail">`);
                    $("#owner_id").val(response.id);
                    $("#owner_photo").val(response.scan_or_photo_of_id);
                },
                error: function(xhr, status, error) {
                    // Show error message using SweetAlert if there's an error with the request
                    Swal.fire(
                        "Error",
                        "An error occurred while fetching owner data.",
                        "error"
                    );
                }
            });
        });

        // update owner ajax request
        $("#edit_owner_form").submit(function(e) {
            e.preventDefault();

            // Show Swal confirmation alert
            Swal.fire({
                title: 'Update Information',
                text: 'Are you sure you want to update your information?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Proceed'
            }).then((result) => {
                if (result.isConfirmed) {
                    const fd = new FormData(this);
                    $("#edit_owner_btn").text('Updating...');
                    $.ajax({
                        url: '{{ route('applicant_users.update_owner') }}',
                        method: 'post',
                        data: fd,
                        cache: false,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        success: function(response) {
                            if (response.status == 200) {
                                // Close the modal
                                $("#editOwnerModal").modal('hide');
                                Swal.fire(
                                    'Updated!',
                                    'Your information has been updated successfully.',
                                    'success'
                                ).then(() => {
                                    // Reload the page
                                    location.reload();
                                });
                            }
                            $("#edit_owner_btn").text('Update Owner');
                            $("#edit_owner_form")[0].reset();
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
                            $("#edit_owner_btn").text('Update Owner');
                        }
                    });
                }
            });
        });


        // add new vehicle ajax request
        $("#add_vehicle_form").submit(function(e) {
            e.preventDefault();
            const fd = new FormData(this);
            $("#add_vehicle_btn").text('Adding...');
            $.ajax({
                url: '{{ route('applicant_users.store') }}',
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

    });
</script>

<script>
    //ACTIVATE VEHICLE
    function activateVehicle() {
        $('#edit_activate_form').trigger("reset");
        $('#ActivateModal').html("Activate Vehicle");
        $('#editActivateModal').modal('show');
        $('#id').val('');
    }

    //EDIT
    function editOwner() {
        $('#edit_owner_form').trigger("reset");
        $('#OwnerModal').html("Edit Owner");
        $('#editOwnerModal').modal('show');
        $('#id').val('');
    }

    //EDIT DRIVER
    function editDriver() {
        $('#edit_driver_form').trigger("reset");
        $('#DriverModal').html("Edit Driver");
        $('#editDriverModal').modal('show');
        $('#id').val('');
    }

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

