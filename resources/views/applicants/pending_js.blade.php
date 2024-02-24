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
            $('#id').val('');
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

    <!-- Data Manipulation -->
    <script>
        $(function() {
            // fetch all pending ajax request
            fetchPendingApplicants();

            function fetchPendingApplicants() {
                $.ajax({
                    url: '{{ route('fetchPendingApplicant') }}',
                    method: 'get',
                    success: function(response) {
                        $("#show_pending_applicants").html(response);
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




    