<!-- Fetch Details -->
<script>
        ApplicantDetails();

        function ApplicantDetails() {
            $.ajax({
                url: '{{ route('fetchAllApplicantDetails') }}',
                method: 'get',
                success: function(response) {
                    $("#applicant_details").html(response);
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

    $(function() {
        // add new applicant ajax request
        $("#add_applicant_form").submit(function(e) {
            e.preventDefault();
            const fd = new FormData(this);
            $("#add_applicant_btn").text('Adding...');
            $.ajax({
                url: '{{ route('applicant.store') }}',
                method: 'post',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 200) {
                        // Reload the page
                        window.location.reload();

                        // Close the modal
                        $("#addApplicantModal").modal('hide');
                        Swal.fire(
                            "Applicant Submitted Successfully",
                            "A Staff will evaluate your Application",
                            "success"
                        );
                    } else {
                        // Show error message using SweetAlert
                        Swal.fire(
                            "Error",
                            response.message,
                            "error"
                        )
                    }
                    $("#add_applicant_btn").text('Add Applicant');
                    $("#add_applicant_form")[0].reset();
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
                    $("#add_applicant_btn").text('Add Applicant');
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
                url: '{{ route('applicant.delete') }}',
                method: 'delete',
                data: {
                    id: id,
                    _token: csrf
                },
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire(
                            'Deleted!',
                            'Applicant Deleted Successfully',
                            'success'
                        );
                        fetchAllApplicants();
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
                        'Failed to delete applicant: ' + error,
                        'error'
                    );
                }
            });
        }
    });
});

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
            url: '{{ route('applicant.edit') }}',
            method: 'get',
            data: {
                id: id,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                // Applicant
                $("#vehicle_details").val(response.vehicle_id);
                $("#driver_details").val(response.driver_id);
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
                url: '{{ route('applicant.update') }}',
                method: 'post',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 200) {
                        ApplicantDetails();
                        // Close the modal
                        $("#editOwnerModal").modal('hide');
                        Swal.fire({
                            title: "Updated",
                            text: "Owner Updated Successfully",
                            icon: "success",
                            timer: 3000, // 3 seconds
                            timerProgressBar: true
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
            url: '{{ route('applicant.edit_vehicle') }}',
            method: 'get',
            data: {
                id: id,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                // Vehicle
                $("#driver_id").val(response.driver_id);
                $("#owner_name").val(response.owner_name);
                $("#owner_address").val(response.owner_address);
                $("#plate_number").val(response.plate_number);
                $("#vehicle_make").val(response.vehicle_make);
                $("#vehicle_category").val(response.vehicle_category);
                $("#year_model").val(response.year_model);
                $("#color").val(response.color);
                $("#body_type").val(response.body_type);
                $("#registration_status").val(response.registration_status);
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
                url: '{{ route('applicant.update_vehicle') }}',
                method: 'post',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 200) {
                        ApplicantDetails();
                        // Close the modal
                        $("#editVehicleModal").modal('hide');
                        Swal.fire({
                            title: "Updated",
                            text: "Vehicle Updated Successfully",
                            icon: "success",
                            timer: 3000, // 3 seconds
                            timerProgressBar: true
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
            url: '{{ route('applicant.edit_driver') }}',
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
            url: '{{ route('applicant.update_driver') }}',
            method: 'post',
            data: fd,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                if (response.status == 200) {
                    ApplicantDetails();
                        // Close the modal
                        $("#editDriverModal").modal('hide');
                        Swal.fire({
                            title: "Updated",
                            text: "Driver Updated Successfully",
                            icon: "success",
                            timer: 3000, // 3 seconds
                            timerProgressBar: true
                        })
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
<!-- Add Modal -->
<script>
    var currentStep = 0;
    var inputValues = {}; // Object to store input values

    // Show initial step
    showStep(currentStep);

    // Reset modal and step when closed
    $('#addApplicantModal').on('hidden.bs.modal', function(e) {
        currentStep = 0;
        showStep(currentStep);
    });

    // Reset step when modal is opened
    $('#addApplicantModal').on('show.bs.modal', function(e) {
        currentStep = 0;
        showStep(currentStep);
    });

    // Reset modal and step when closed
    $('#editApplicantModal').on('hidden.bs.modal', function(e) {
        currentStep = 0;
        showStep(currentStep);
    });

    // Reset step when modal is opened
    $('#editApplicantModal').on('show.bs.modal', function(e) {
        currentStep = 0;
        showStep(currentStep);
    });


    // Store input values when navigating to the next step
    function nextStep() {
        saveInputs();
        currentStep++;
        showStep(currentStep);
    }

    // Store input values when navigating to the previous step
    function prevStep() {
        saveInputs();
        currentStep--;
        showStep(currentStep);
    }

    // Display the current step
    function showStep(stepIndex) {
        var steps = document.querySelectorAll("section");
        for (var i = 0; i < steps.length; i++) {
            if (i === stepIndex) {
                steps[i].style.display = "block";
            } else {
                steps[i].style.display = "none";
            }
        }
    }

    // Save input values to the object
    function saveInputs() {
        var inputFields = document.querySelectorAll("input, select");
        inputFields.forEach(function(input) {
            inputValues[input.name] = input.value;
        });
    }

    function submitForm() {
        // Add form submission logic here
        alert("Form submitted successfully!");
    }

    //CREATE
    function add() {
        $('#add_applicant_form').trigger("reset");
        $('#ApplicantModal').html("Add Applicant");
        $('#addApplicantModal').modal('show');
        currentStep = 0; // Reset step to the initial one
        showStep(currentStep);
        restoreInputs(); // Restore input values when opening the modal
    }
</script>
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
<!-- Accept Only 11 Numbers in Contact -->
<script>
    document.getElementById('add_contact').addEventListener('input', function(event) {
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