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
</script>

<!-- Show Reason if Rejected -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const approvalStatus = document.getElementById("approvalStatus");
        const reasonField = document.getElementById("reasonField");

        // Show/hide reason input field based on approval status
        approvalStatus.addEventListener("change", function() {
            if (this.value === "Rejected") {
                reasonField.style.display = "block";
            } else {
                reasonField.style.display = "none";
            }
        });
    });
</script>

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
                            fetchAllVehicles();
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

            // edit vehicle ajax request
            $(document).on('click', '.editIcon', function(e) {
                e.preventDefault();
                let id = $(this).attr('id');
                $.ajax({
                    url: '{{ route('vehicles.edit') }}',
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
                            `<img src="storage/images/vehicles/documents/${response.official_receipt_image}" width="100" class="img-fluid img-thumbnail">`);
                        $("#certificate_of_registration_image").html(
                            `<img src="storage/images/vehicles/documents/${response.certificate_of_registration_image}" width="100" class="img-fluid img-thumbnail">`);
                        $("#deed_of_sale_image").html(
                            `<img src="storage/images/vehicles/documents/${response.deed_of_sale_image}" width="100" class="img-fluid img-thumbnail">`);
                        $("#authorization_letter_image").html(
                            `<img src="storage/images/vehicles/documents/${response.authorization_letter_image}" width="100" class="img-fluid img-thumbnail">`);
                        $("#front_photo").html(
                            `<img src="storage/images/vehicles/${response.front_photo}" width="100" class="img-fluid img-thumbnail">`);
                        $("#side_photo").html(
                            `<img src="storage/images/vehicles/${response.side_photo}" width="100" class="img-fluid img-thumbnail">`);
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
                    url: '{{ route('vehicles.update') }}',
                    method: 'post',
                    data: fd,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 200) {
                            fetchAllVehicles();
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

            // delete vehicle ajax request
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
                        url: '{{ route('vehicles.delete') }}',
                        method: 'delete',
                        data: {
                            id: id,
                            _token: csrf
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                Swal.fire(
                                    'Deleted!',
                                    'Vehicle Deleted Successfully',
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

            // Fetch all vehicles via AJAX and initialize DataTable
            fetchAllVehicles();

            function fetchAllVehicles() {
                $.ajax({
                    url: '{{ route('fetchAllVehicle') }}',
                    method: 'get',
                    success: function(response) {
                        $("#show_all_vehicles").html(response);
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
                        $("#show_all_vehicles").html("<p>Error fetching data. Please try again later.</p>");
                    }
                });
            }

    });
</script>