<!-- Edit Driver Ajax -->
<script>
$(function() {
    // edit driver ajax request
    $(document).on('click', '.editIconDriver', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        $.ajax({
            url: '{{ route('owners.edit_driver') }}',
            method: 'get',
            data: {
                id: id,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                $("#dname").val(response.driver_name);
                $("#adname").val(response.authorized_driver_name);
                $("#adaddress").val(response.authorized_driver_address);
                $("#driver_approval_status").val(response.approval_status);
                $("#driver_reason").val(response.reason);
                // Save Data
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
        const fd = new FormData(this);
        $("#edit_driver_btn").text('Updating...');
        $.ajax({
            url: '{{ route('owners.update_driver') }}',
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
                        Swal.fire({
                            title: "Updated",
                            text: "Driver Updated Successfully, Page Will Reload",
                            icon: "success",
                            timer: 3000, // 3 seconds
                            timerProgressBar: true
                        }).then((result) => {
                            // Reload the page after the Swal notification is closed
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
    });
});
</script>
<!-- Edit Vehicle Ajax -->
<script>
$(function() {
    // edit vehicle ajax request
    $(document).on('click', '.editIconVehicle', function(e) {
        e.preventDefault();
        let id = $(this).attr('id'); // Getting the owner ID from the clicked element
        $.ajax({
            url: '{{ route('owners.edit_vehicle') }}',
            method: 'get',
            data: {
                id: id,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                // Vehicle
                $("#owner_address").val(response.owner_address);
                $("#plate_number").val(response.plate_number);
                $("#vehicle_make").val(response.vehicle_make);
                $("#year_model").val(response.year_model);
                $("#color").val(response.color);
                $("#body_type").val(response.body_type);
                $("#registration_status").val(response.registration_status);
                $("#vehicle_approval_status").val(response.approval_status);
                $("#vehicle_reason").val(response.reason);
                // Save Data
                $("#vehicle_id").val(response.id);
                $("#official_receipt_image_photo").val(response.official_receipt_image);
                $("#certificate_of_registration_image_photo").val(response.certificate_of_registration_image);
                $("#deed_of_sale_image_photo").val(response.deed_of_sale_image);
                $("#authorization_letter_image_photo").val(response.authorization_letter_image);
                $("#front_photo_photo").val(response.front_photo);
                $("#side_photo_photo").val(response.side_photo);
                $("#owner_id").val(response.owner_id);
                $("#driver_id").val(response.driver_id);
            },
            error: function(xhr, status, error) {
                // Show error message using SweetAlert if there's an error with the request
                Swal.fire(
                    "Error",
                    "An error occurred while fetching Vehicle data.",
                    "error"
                );
            }
        });
    });

// Update vehicle ajax request
$("#edit_vehicle_form").submit(function(e) {
    e.preventDefault();
    Swal.fire({
        title: 'Are you sure?',
        text: 'Updating this vehicle will change its status to Pending. Do you want to proceed?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            const fd = new FormData(this);
            $("#edit_vehicle_btn").text('Updating...');
            $.ajax({
                url: '{{ route('owners.update') }}',
                method: 'post',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 200) {
                        // Close the modal
                        $("#editVehicleModal").modal('hide');
                        Swal.fire({
                            title: "Vehicle Update Request Submitted",
                            text: "A staff will review it shortly. Please wait while we process your request. Page will reload.",
                            icon: "success",
                            timer: 3000, // 3 seconds
                            timerProgressBar: true
                        }).then((result) => {
                            // Reload the page after the Swal notification is closed
                            location.reload();
                        });
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
        }
    });
});


    });
</script>
<script>
    //EDIT VEHICLE
    function editVehicle() {
        $('#edit_vehicle_form').trigger("reset");
        $('#VehicleModal').html("Edit Vehicle");
        $('#editVehicleModal').modal('show');
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
    document.getElementById('toggleVehicleImagesBtn').addEventListener('click', function() {
        var imagesDiv = document.getElementById('vehicleImages');
        if (imagesDiv.style.display === 'none') {
            imagesDiv.style.display = 'block';
        } else {
            imagesDiv.style.display = 'none';
        }
    });

    document.getElementById('toggleDriverImagesBtn').addEventListener('click', function() {
        var imagesDiv = document.getElementById('driverImages');
        if (imagesDiv.style.display === 'none') {
            imagesDiv.style.display = 'block';
        } else {
            imagesDiv.style.display = 'none';
        }
    });
</script>
<script>
    $(document).on('click', '.download-btn', function() {
        var qrData = $(this).data('qrcode');
        console.log('QR Data:', qrData); // Check the value of qrData
        downloadQR(qrData);
    });

    function downloadQR(qrData) {
        // Create a hidden link element
        var link = document.createElement('a');

        // AJAX request to fetch the plate number
        $.ajax({
            url: '{{ route("getPlateNumber") }}',
            method: 'GET',
            data: {
                qrData: qrData
            },
            success: function(response) {
                if (response.plateNumber) {
                    var plateNumber = response.plateNumber;
                    link.href = '/qrcode/download?qrData=' + qrData;
                    link.download = plateNumber + '.png'; // Set the filename for the downloaded file
                    document.body.appendChild(link);

                    // Trigger the click event on the link
                    link.click();
                    toastr.options = {
                        "progressBar": true,
                        "closeButton": true,
                        "toastClass": "toastr-success" // Use custom class for error messages
                    };
                    toastr.success('QR Code Downloaded Successfully!', {
                        timeOut: 5000
                    });
                } else {
                    // Show error message using Toastr
                    toastr.options = {
                        "progressBar": true,
                        "closeButton": true,
                        "toastClass": "toastr-error" // Use custom class for error messages
                    };
                    toastr.error('Plate number not found', {
                        timeOut: 5000
                    });
                }
            },
            error: function(xhr, status, error) {
                // Show error message using Toastr
                toastr.options = {
                    "progressBar": true,
                    "closeButton": true,
                    "toastClass": "toastr-error" // Use custom class for error messages
                };
                toastr.error('Error fetching plate number', {
                    timeOut: 5000
                });
            }
        });
    }
</script>