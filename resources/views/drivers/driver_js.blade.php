<script type="text/javascript">
    //CREATE
    function add() {
        $('#add_driver_form').trigger("reset");
        $('#DriverModal').html("Add Driver");
        $('#addDriverModal').modal('show');
        $('#id').val('');
    }

    //EDIT
    function edit() {
        $('#edit_driver_form').trigger("reset");
        $('#DriverModal').html("Edit Driver");
        $('#editDriverModal').modal('show');
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

        // add new driver ajax request
        $("#add_driver_form").submit(function(e) {
            e.preventDefault();
            const fd = new FormData(this);
            $("#add_driver_btn").text('Adding...');
            $.ajax({
                url: '{{ route('drivers.store') }}',
                method: 'post',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 200) {
                        fetchAllDrivers();
                        // Close the modal
                        $("#addDriverModal").modal('hide');
                        Swal.fire(
                            "Successful",
                            "Driver Added Successfully",
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
                    $("#add_driver_btn").text('Add Driver');
                    $("#add_driver_form")[0].reset();
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
                    $("#add_driver_btn").text('Add Driver');
                }
            });
        });

            // edit driver ajax request
            $(document).on('click', '.editIcon', function(e) {
            e.preventDefault();
            let id = $(this).attr('id');
            $.ajax({
                url: '{{ route('drivers.edit') }}',
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
            const fd = new FormData(this);
            $("#edit_driver_btn").text('Updating...');
            $.ajax({
                url: '{{ route('drivers.update') }}',
                method: 'post',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 200) {
                        fetchAllDrivers();
                        // Close the modal
                        $("#editDriverModal").modal('hide');
                        Swal.fire(
                            "Updated",
                            "Driver Updated Successfully",
                            "success"
                        );
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
                    url: '{{ route('drivers.delete') }}',
                    method: 'delete',
                    data: {
                        id: id,
                        _token: csrf
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire(
                                'Deleted!',
                                'Driver Deleted Successfully',
                                'success'
                            );
                            fetchAllDrivers();
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
                            'Failed to delete driver: ' + error,
                            'error'
                        );
                    }
                });
            }
        });
    });


            // Fetch all drivers via AJAX and initialize DataTable
            fetchAllDrivers();

            function fetchAllDrivers() {
                $.ajax({
                    url: '{{ route('fetchAllDriver') }}',
                    method: 'get',
                    success: function(response) {
                        $("#show_all_drivers").html(response);
                        // Initialize DataTable after data is loaded into the table
                        $("table").DataTable({
                            order: [0, 'desc']
                        });
                    },
                    error: function(xhr, status, error) {
                        // Log the error to the console for debugging
                        console.error("Error fetching drivers:", error);
                        // Display an error message to the user
                        $("#show_all_drivers").html("<p>Error fetching data. Please try again later.</p>");
                    }
                });
            }

    });
</script>