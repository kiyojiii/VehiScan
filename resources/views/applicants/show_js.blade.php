<!-- APPROVE JS -->
<script>
        $(function() {
        // approve all ajax request
        $(document).on('click', '.approveAll', function(e) {
    e.preventDefault();
    let ownerId = $(this).data('owner-id');
    let vehicleId = $(this).data('vehicle-id');
    let driverId = $(this).data('driver-id');
    let csrf = '{{ csrf_token() }}';

    Swal.fire({
        title: 'Approve All?',
        text: "Applicant, Vehicle, and Driver will be Approved",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Approve it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '{{ route('applicant.approve_all') }}',
                method: 'post',
                data: {
                    owner_id: ownerId,
                    vehicle_id: vehicleId,
                    driver_id: driverId,
                    _token: csrf
                },
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire(
                            'Approved!',
                            'Applicant, Vehicle and Driver has been approved!',
                            'success'
                        ).then((result) => {
                            // Reload the page after the Swal notification is closed
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
                        'Failed to approve all: ' + error,
                        'error'
                    );
                }
            });
        }
    });
});


        // approve driver ajax request
        $(document).on('click', '.approveDriver', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        let csrf = '{{ csrf_token() }}';
        Swal.fire({
            title: 'Approve Driver?',
            text: "This Driver will be Approved",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Approve it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route('applicant.approve_driver') }}',
                    method: 'post',
                    data: {
                        id: id,
                        _token: csrf
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire(
                                'Approved!',
                                'Driver Has Been Approved!',
                                'success'
                            ).then((result) => {
                            // Reload the page after the Swal notification is closed
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
                            'Failed to approve driver: ' + error,
                            'error'
                        );
                    }
                });
            }
        });
    });

        // approve vehicle ajax request
        $(document).on('click', '.approveVehicle', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        let csrf = '{{ csrf_token() }}';
        Swal.fire({
            title: 'Approve Vehicle?',
            text: "This Vehicle will be Approved",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Approve it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route('applicant.approve_vehicle') }}',
                    method: 'post',
                    data: {
                        id: id,
                        _token: csrf
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire(
                                'Approved!',
                                'Vehicle Has Been Approved!',
                                'success'
                            ).then((result) => {
                            // Reload the page after the Swal notification is closed
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
                            'Failed to approve vehicle: ' + error,
                            'error'
                        );
                    }
                });
            }
        });
    });

        // activate applicant ajax request
        $(document).on('click', '.approveApplicant', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        let csrf = '{{ csrf_token() }}';
        Swal.fire({
            title: 'Approve Applicant?',
            text: "This Applicant will be Approved",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Approve it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route('applicant.approve_applicant') }}',
                    method: 'post',
                    data: {
                        id: id,
                        _token: csrf
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire(
                                'Approved!',
                                'Applicant Has Been Approved!',
                                'success'
                            ).then((result) => {
                            // Reload the page after the Swal notification is closed
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
                            'Failed to approve applicant: ' + error,
                            'error'
                        );
                    }
                });
            }
        });
    });
});
</script>
<!-- REJECT JS -->
<script>
        $(function() {
   // Reject applicant ajax request
$(document).on('click', '.rejectApplicant', function(e) {
    e.preventDefault();
    let id = $(this).attr('id');
    let csrf = '{{ csrf_token() }}';
    Swal.fire({
        title: 'Reject Applicant?',
        html: '<input type="text" id="rejectReason" class="swal2-input" placeholder="Reason for rejection">',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Reject it!'
    }).then((result) => {
        if (result.isConfirmed) {
            let reason = $('#rejectReason').val(); // Get the reason input value
            $.ajax({
                url: '{{ route('applicant.reject_applicant') }}',
                method: 'post',
                data: {
                    id: id,
                    reason: reason, // Pass the reason to the server
                    _token: csrf
                },
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire(
                            'Rejected!',
                            'Applicant Has Been Rejected',
                            'success'
                        ).then((result) => {
                            // Reload the page after the Swal notification is closed
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
                        'Failed to reject applicant: ' + error,
                        'error'
                    );
                }
            });
        }
    });
});

 // Reject vehicle ajax request
 $(document).on('click', '.rejectVehicle', function(e) {
    e.preventDefault();
    let id = $(this).attr('id');
    let csrf = '{{ csrf_token() }}';
    Swal.fire({
        title: 'Reject Vehicle?',
        html: '<input type="text" id="rejectReason" class="swal2-input" placeholder="Reason for rejection">',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Reject it!'
    }).then((result) => {
        if (result.isConfirmed) {
            let reason = $('#rejectReason').val(); // Get the reason input value
            $.ajax({
                url: '{{ route('applicant.reject_vehicle') }}',
                method: 'post',
                data: {
                    id: id,
                    reason: reason, // Pass the reason to the server
                    _token: csrf
                },
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire(
                            'Rejected!',
                            'Vehicle Has Been Rejected',
                            'success'
                        ).then((result) => {
                            // Reload the page after the Swal notification is closed
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
                        'Failed to reject vehicle: ' + error,
                        'error'
                    );
                }
            });
        }
    });
});

 // Reject driver ajax request
 $(document).on('click', '.rejectDriver', function(e) {
    e.preventDefault();
    let id = $(this).attr('id');
    let csrf = '{{ csrf_token() }}';
    Swal.fire({
        title: 'Reject Driver?',
        html: '<input type="text" id="rejectReason" class="swal2-input" placeholder="Reason for rejection">',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Reject it!'
    }).then((result) => {
        if (result.isConfirmed) {
            let reason = $('#rejectReason').val(); // Get the reason input value
            $.ajax({
                url: '{{ route('applicant.reject_driver') }}',
                method: 'post',
                data: {
                    id: id,
                    reason: reason, // Pass the reason to the server
                    _token: csrf
                },
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire(
                            'Rejected!',
                            'Driver Has Been Rejected',
                            'success'
                        ).then((result) => {
                            // Reload the page after the Swal notification is closed
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
                        'Failed to reject driver: ' + error,
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

<!-- Data Manipulation -->
<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
</script>
<!-- Edit Owner Ajax -->
<script>
$(function() {
    // edit applicant ajax request
    $(document).on('click', '.editIconOwner', function(e) {
        e.preventDefault();
        let id = $(this).attr('id'); // Getting the owner ID from the clicked element
        $.ajax({
            url: '{{ route('applicants.edit') }}',
            method: 'get',
            data: {
                id: id,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                // Applicant
                $("#vehicle_details").val(response.vehicle_id);
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
                $("#serial_number").val(response.serial_number);
                $("#id_number").val(response.id_number);
                $("#approval").val(response.approval_status);
                $("#reason").val(response.reason);
                // Save Data
                $("#applicant_id").val(response.id);
                $("#applicant_photo").val(response.scan_or_photo_of_id);
            },
            error: function(xhr, status, error) {
                // Show error message using SweetAlert if there's an error with the request
                Swal.fire(
                    "Error",
                    "An error occurred while fetching Applicant data.",
                    "error"
                );
            }
        });
    });

    // update owner ajax request
    $("#edit_owner_form").submit(function(e) {
            e.preventDefault();
            const fd = new FormData(this);
            $("#edit_owner_btn").text('Updating...');
            $.ajax({
                url: '{{ route('applicants.update') }}',
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
                        Swal.fire({
                            title: "Updated",
                            text: "Owner Updated Successfully",
                            icon: "success",
                            timer: 3000, // 3 seconds
                            timerProgressBar: true
                        }).then((result) => {
                            // Reload the page after the Swal notification is closed
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
            url: '{{ route('applicants.edit_vehicle') }}',
            method: 'get',
            data: {
                id: id,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                // Vehicle
                $("#driver_details").val(response.driver_id);
                $("#owner_name").val(response.owner_name);
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
                    "An error occurred while fetching Vehicle data.",
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
                url: '{{ route('applicants.update_vehicle') }}',
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
                            title: "Updated",
                            text: "Vehicle Updated Successfully",
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
        });

    });
</script>
<!-- Edit Driver Ajax -->
<script>
$(function() {
    // edit driver ajax request
    $(document).on('click', '.editIconDriver', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        $.ajax({
            url: '{{ route('applicants.edit_driver') }}',
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
            url: '{{ route('applicants.update_driver') }}',
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
                            text: "Driver Updated Successfully",
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
<!-- Edit Function -->
<script>
    //EDIT OWNER
    function editOwner() {
        $('#edit_owner_form').trigger("reset");
        $('#OwnerModal').html("Edit Owner");
        $('#editOwnerModal').modal('show');
        $('#id').val('');
    }

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
<!-- Show Owner ID --> 
<script>
    function showOwnerId(ownerId) {
        alert("Owner ID: " + ownerId);
    }
</script>
<!-- Show Vehicle ID --> 
<script>
    function showVehicleId(vehicleId) {
        alert("Vehicle ID: " + vehicleId);
    }
</script>
<!-- Show Driver ID --> 
<script>
    function showDriverId(driverId) {
        alert("Driver ID: " + driverId);
    }
</script>
<!-- Accept Only 11 Numbers in Contact -->
<script>
    document.getElementById('contact').addEventListener('input', function(event) {
        // Remove non-numeric characters
        this.value = this.value.replace(/\D/g, '');

        // Limit input to 11 characters
        if (this.value.length > 11) {
            this.value = this.value.slice(0, 11);
        }
    });
</script>
<!-- Accept Only 1 Letter in MI -->
<script>
    document.getElementById('mi').addEventListener('input', function(event) {
        if (this.value.length > 1) {
            this.value = this.value.slice(0, 1);
        }
    });
</script>
