<script>
    let scanner = new Instascan.Scanner({
        video: document.getElementById('qr_scanner')
    });

    // Function to display vehicle and applicant data in modal
    function displayVehicleData(vehicleData, applicantData) {
        // APPLICANT
        $('#serial_number').text(applicantData.serial_number);
        $('#id_number').text(applicantData.id_number);
        $('#full_name').text(`${applicantData.first_name} ${applicantData.middle_initial}. ${applicantData.last_name}`);
        $('#appointment').text(applicantData.appointment);
        $('#role_status').text(applicantData.role_status);
        // VEHICLE
        $('#plate_number').text(vehicleData.plate_number);
        $('#owner_name').text(vehicleData.owner_name);
        $('#vehicle_make').text(vehicleData.vehicle_make);
        $('#year_model').text(vehicleData.year_model);
        $('#color').text(vehicleData.color);
        $('#body_type').text(vehicleData.body_type);
        $('#registration_status').text(vehicleData.registration_status);
        $('#approval_status').text(vehicleData.approval_status);
        $('#vehicleModal').modal('show'); // Show the modal
    }

    Instascan.Camera.getCameras().then(function(cameras) {
        if (cameras.length > 0) {
            scanner.start(cameras[0]);
        } else {
            Swal.fire({
                icon: 'error',
                title: 'No Cameras Found',
                text: 'Please make sure you have a camera connected.'
            });
        }
    }).catch(function(error) { // Update the catch block to include the error parameter
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'An error occurred while starting the camera: ' + error.message // Display the error message
        });
    });

    // AJAX request to fetch vehicle data and related applicant data
    scanner.addListener('scan', function(vehicleCode) {
        document.getElementById('record').value = vehicleCode;

        // Make AJAX request to fetch vehicle and applicant data
        $.ajax({
            url: '{{ route('getVehicleData') }}',
            method: 'GET', // Ensure it's a GET request
            data: {
                vehicle_code: vehicleCode
            },
            success: function(response) {
                if (response.success) {
                    // Vehicle and applicant data fetched successfully, display in modal
                    displayVehicleData(response.vehicle, response.applicant);
                } else {
                    console.error("Vehicle not found");
                }
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Vehicle Not Found',
                });
            },
            complete: function() {
                // Clear the input box after the AJAX request is complete
                document.getElementById('record').value = '';
            }
        });
    });
</script>