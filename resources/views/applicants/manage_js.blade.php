   <!-- Data Manipulation -->
   <script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

        $(function() {
        // Add new applicant ajax request
        $("#add_applicant_form").submit(function(e) {
            e.preventDefault();

            // Check if any of the required fields are empty
            var mi = $("#add_mi").val();
            var serialNumber = $("#add_serial_number").val();
            var idNumber = $("#add_id_number").val();

            if (!mi || !serialNumber || !idNumber) {
                // Display Swal error message for empty required fields
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please fill out all the required fields!',
                });
            } else {
                const fd = new FormData(this);
                $("#add_applicant_btn").text('Adding...');
                $.ajax({
                    url: '{{ route('applicants.store') }}',
                    method: 'post',
                    data: fd,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 200) {
                            ManageApplicants();
                            // Close the modal
                            $("#addApplicantModal").modal('hide');
                            Swal.fire(
                                "Successful",
                                "Applicant Added Successfully",
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
            }
        });

            // edit applicant ajax request
            $(document).on('click', '.editIcon', function(e) {
                e.preventDefault();
                let id = $(this).attr('id');
                $.ajax({
                    url: '{{ route('applicants.edit') }}',
                    method: 'get',
                    data: {
                        id: id,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        // Applicant
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
                        $("#scan_or_photo_of_id").html(
                            `<img src="storage/images/${response.scan_or_photo_of_id}" width="100" class="img-fluid img-thumbnail">`);
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

            // DELETE APPLICANT
            $(document).ready(function () {
    $(document).on('click', '.deleteApplicant', function (e) {
        e.preventDefault();
        var id = $(this).data('applicant-id');
        var vehicleId = $(this).data('vehicle-id');
        var driverId = $(this).data('driver-id');
        var csrf = '{{ csrf_token() }}';

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
                    url: '{{ route('applicants.delete') }}',
                    method: 'delete',
                    data: {
                        id: id,
                        vehicle_id: vehicleId,
                        driver_id: driverId,
                        _token: csrf
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire(
                                'Deleted!',
                                response.message,
                                'success'
                            );
                            ManageApplicants();
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

// DISPLAY OWNER INFORMATION
$(document).on('click', '.transferApplicant', function() {
    // Get the data attributes from the clicked button
    var currentUser = $(this).data('current-user');
    var applicantID = $(this).data('applicant-id');
    var vehicleID = $(this).data('vehicle-id');
    var driverID = $(this).data('driver-id');

    // Set the input field values with the extracted user ID and name
    $('#current_user').val(currentUser);

    // Extract the user's name from the data attribute and populate the corresponding input field
    var currentUserName = $(this).data('current-user-name');
    $('#current_user_name').val(currentUserName);

    // Set the input field values with the extracted user ID and name
    $('#applicant_id').val(applicantID);
    $('#vehicle_id').val(vehicleID);
    $('#driver_id').val(driverID);

    // Show the modal
    $('#userTransferModal').modal('show');
});

// Display confirmation prompt when form is submitted
$('#transfer_form').submit(function(event) {
    event.preventDefault(); // Prevent the default form submission

    // Get the data attributes from the form inputs
    var currentUser = $('#current_user').val();
    var applicantId = $('#applicant_id').val();
    var vehicleId = $('#vehicle_id').val();
    var driverId = $('#driver_id').val();

    // Display confirmation prompt using SweetAlert
    swal.fire({
        title: 'Are you sure?',
        text: 'Once transferred, ownership cannot be reverted!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, transfer it!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Proceed with the transfer process

            // Get the form data
            var formData = $(this).serialize();

            // Perform AJAX request to update ownership
            $.ajax({
                url: '{{ route('applicant.transfer') }}', // Use the route helper function to get the route URL
                method: 'POST',
                data: formData,
                success: function(response) {
                    // Handle success response
                    swal.fire('Applicant Transferred Successfully', '', 'success');
                    // Reset the chosen user
                    $('#user_id').val('');
                    // Close the modal
                    $('#userTransferModal').modal('hide');
                    // Call ManageApplicants to refresh the table
                    ManageApplicants();
                },
                error: function(xhr, status, error) {
                    // Handle error response (if needed)
                    console.error(xhr.responseText); // Log the error response to the console
                }
            });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            // User clicked cancel, do nothing
            return false;
        }
    });
});




        // fetch all pending ajax request
        ManageApplicants();

        function ManageApplicants() {
            $.ajax({
                url: '{{ route('ManageApplicant') }}',
                method: 'get',
                success: function(response) {
                    $("#manage_all_applicants").html(response);
                    $("table").DataTable({
                        order: [0, 'desc'], // Order by the first column in descending order
                        lengthMenu: [5, 10, 25, 50], // Display options to show 5, 10, 25, or 50 records per page
                        pageLength: 5 // Initially display 5 records per page
                    });
                }
            });
        }
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

    //EDIT
    function edit() {
        $('#edit_applicant_form').trigger("reset");
        $('#ApplicantModal').html("Edit Applicant");
        $('#editApplicantModal').modal('show');
        $('#id').val('');
    }

   //TRANSFER
    function transfer() {
        $('#transfer_form').trigger("reset");
        $('#TransferModal').html("Transfer Applicant");
        $('#userTransferModal').modal('show');
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


