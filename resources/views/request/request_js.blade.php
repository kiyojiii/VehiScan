<script>
     $(function() {

        // edit vehicle ajax request
        $(document).on('click', '.editVehicle', function(e) {
                e.preventDefault();
                let id = $(this).attr('id');
                $.ajax({
                    url: '{{ route('user_request.edit') }}',
                    method: 'get',
                    data: {
                        id: id,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $("#driver_name").val(response.driver_id);
                        $("#owner_address").val(response.owner_address);
                        $("#plate_number").val(response.plate_number);
                        $("#vehicle_make").val(response.vehicle_make);
                        $("#year_model").val(response.year_model);
                        $("#color").val(response.color);
                        $("#body_type").val(response.body_type);
                        $("#registration_status").val(response.registration_status);
                        $("#approval_status").val(response.approval_status);
                        $("#reason").val(response.reason);
                        $("#official_receipt_image").html(
                            `<img src="storage/images/vehicles/documents/${response.official_receipt_image}" width="150" class="img-fluid img-thumbnail">`);
                        $("#certificate_of_registration_image").html(
                            `<img src="storage/images/vehicles/documents/${response.certificate_of_registration_image}" width="150" class="img-fluid img-thumbnail">`);
                        $("#deed_of_sale_image").html(
                            `<img src="storage/images/vehicles/documents/${response.deed_of_sale_image}" width="150" class="img-fluid img-thumbnail">`);
                        $("#authorization_letter_image").html(
                            `<img src="storage/images/vehicles/documents/${response.authorization_letter_image}" width="150" class="img-fluid img-thumbnail">`);
                        $("#front_photo").html(
                            `<img src="storage/images/vehicles/${response.front_photo}" width="150" class="img-fluid img-thumbnail">`);
                        $("#side_photo").html(
                            `<img src="storage/images/vehicles/${response.side_photo}" width="150" class="img-fluid img-thumbnail">`);
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
            $("#edit_vehicle_form").submit(function(e) {
                e.preventDefault();
                const fd = new FormData(this);
                $("#edit_vehicle_btn").text('Updating...');
                $.ajax({
                    url: '{{ route('user_request.update') }}',
                    method: 'post',
                    data: fd,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 200) {
                            fetchUserRequests();
                            // Close the modal
                            $("#editVehicleModal").modal('hide');
                            Swal.fire(
                                "Updated",
                                "Vehicle Updated Successfully",
                                "success"
                            );
                        }
                        $("#edit_vehicle_btn").text('Update Vehicle');
                        $("#edit_vehicle_form")[0].reset();
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
                        $("#edit_vehicle_btn").text('Update Vehicle');
                    }
                });
            });

                    // view vehicle ajax request
        $(document).on('click', '.viewVehicle', function(e) {
                e.preventDefault();
                let id = $(this).attr('id');
                $.ajax({
                    url: '{{ route('user_request.view') }}',
                    method: 'get',
                    data: {
                        id: id,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $("#view_driver_name").val(response.driver_id);
                        $("#view_owner_address").val(response.owner_address);
                        $("#view_plate_number").val(response.plate_number);
                        $("#view_vehicle_make").val(response.vehicle_make);
                        $("#view_year_model").val(response.year_model);
                        $("#view_color").val(response.color);
                        $("#view_body_type").val(response.body_type);
                        $("#view_registration_status").val(response.registration_status);
                        $("#view_approval_status").val(response.approval_status);
                        $("#view_reason").val(response.reason);
                        $("#view_official_receipt_image").html(
                            `<img src="storage/images/vehicles/documents/${response.official_receipt_image}" width="150" class="img-fluid img-thumbnail">`);
                        $("#view_certificate_of_registration_image").html(
                            `<img src="storage/images/vehicles/documents/${response.certificate_of_registration_image}" width="150" class="img-fluid img-thumbnail">`);
                        $("#view_deed_of_sale_image").html(
                            `<img src="storage/images/vehicles/documents/${response.deed_of_sale_image}" width="150" class="img-fluid img-thumbnail">`);
                        $("#view_authorization_letter_image").html(
                            `<img src="storage/images/vehicles/documents/${response.authorization_letter_image}" width="150" class="img-fluid img-thumbnail">`);
                        $("#view_front_photo").html(
                            `<img src="storage/images/vehicles/${response.front_photo}" width="150" class="img-fluid img-thumbnail">`);
                        $("#view_side_photo").html(
                            `<img src="storage/images/vehicles/${response.side_photo}" width="150" class="img-fluid img-thumbnail">`);
                        $("#view_vehicle_id").val(response.id);
                        $("#view_official_receipt_image_photo").val(response.official_receipt_image);
                        $("#view_certificate_of_registration_image_photo").val(response.certificate_of_registration_image)
                        $("#view_deed_of_sale_image_photo").val(response.deed_of_sale_image);
                        $("#view_authorization_letter_image_photo").val(response.authorization_letter_image)
                        $("#view_front_photo_photo").val(response.front_photo);
                        $("#view_side_photo_photo").val(response.side_photo)
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

            // Fetch all vehicles via AJAX and initialize DataTable
            fetchUserRequests();

            function fetchUserRequests() {
                $.ajax({
                    url: '{{ route('fetchUserRequest') }}',
                    method: 'get',
                    success: function(response) {
                        $("#show_all_user_request").html(response);
                        // Initialize DataTable after data is loaded into the table
                        $("table").DataTable({
                            order: [0, 'desc'],
                            pageLength : 5,
                            lengthMenu: [[5, 10, 20, -1], [5, 10, 20, 'ALL']]
                        });
                    },
                    error: function(xhr, status, error) {
                        // Log the error to the console for debugging
                        console.error("Error fetching vehicles:", error);
                        // Display an error message to the user
                        $("#show_all_user_request").html("<p>Error fetching data. Please try again later.</p>");
                    }
                });
            }

        });
</script>

<script type="text/javascript">
    //CREATE
    function add() {
        $('#add_vehicle_form').trigger("reset");
        $('#VehicleModal').html("Add Vehicle");
        $('#addVehicleModal').modal('show');
        $('#id').val('');
    }

    //EDIT
    function edit() {
        $('#edit_vehicle_form').trigger("reset");
        $('#VehicleModal').html("Edit Vehicle");
        $('#editVehicleModal').modal('show');
        $('#id').val('');
    }

      //VIEW
      function view() {
        $('#view_vehicle_form').trigger("reset");
        $('#VehicleModal').html("View Vehicle");
        $('#viewVehicleModal').modal('show');
        $('#id').val('');
    }
</script>