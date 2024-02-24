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
    $('#addOwnerModal').on('hidden.bs.modal', function(e) {
        currentStep = 0;
        showStep(currentStep);
    });

    // Reset step when modal is opened
    $('#addOwnerModal').on('show.bs.modal', function(e) {
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

    // Restore input values from the object
    function restoreInputs() {
        var inputFields = document.querySelectorAll("input, select");
        inputFields.forEach(function(input) {
            if (input.name in inputValues) {
                input.value = inputValues[input.name];
            } else {
                input.value = "";
            }
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
        $('#edit_owner_form').trigger("reset");
        $('#OwnerModal').html("Edit Owner");
        $('#editOwnerModal').modal('show');
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
    document.getElementById('add_mi').addEventListener('input', function(event) {
        if (this.value.length > 1) {
            this.value = this.value.slice(0, 1);
        }
    });
</script>

<!-- Show Reason if Applicant Rejected -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const approvalApplicantStatus = document.getElementById("approvalApplicantStatus");
        const reasonApplicantField = document.getElementById("reasonApplicantField");

        // Show/hide reason input field based on approval status
        approvalApplicantStatus.addEventListener("change", function() {
            if (this.value === "Rejected") {
                reasonApplicantField.style.display = "block";
            } else {
                reasonApplicantField.style.display = "none";
            }
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const approvalVehicleStatus = document.getElementById("approvalVehicleStatus");
        const reasonVehicleField = document.getElementById("reasonVehicleField");

        // Show/hide reason input field based on approval status
        approvalVehicleStatus.addEventListener("change", function() {
            if (this.value === "Rejected") {
                reasonVehicleField.style.display = "block";
            } else {
                reasonVehicleField.style.display = "none";
            }
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const approvalDriverStatus = document.getElementById("approvalDriverStatus");
        const reasonDriverField = document.getElementById("reasonDriverField");

        // Show/hide reason input field based on approval status
        approvalDriverStatus.addEventListener("change", function() {
            if (this.value === "Rejected") {
                reasonDriverField.style.display = "block";
            } else {
                reasonDriverField.style.display = "none";
            }
        });
    });
</script>
