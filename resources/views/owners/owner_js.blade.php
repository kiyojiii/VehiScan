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

<script type="text/javascript">
    //CREATE
    function add() {
        $('#add_owner_form').trigger("reset");
        $('#OwnerModal').html("Add Owner");
        $('#addOwnerModal').modal('show');
        $('#id').val('');
    }

    //EDIT
    function edit() {
        $('#edit_owner_form').trigger("reset");
        $('#OwnerModal').html("Edit Owner");
        $('#editOwnerModal').modal('show');
        $('#id').val('');
    }
</script>

<script>
    $(function() {

// Add new owner ajax request
$("#add_owner_form").submit(function(e) {
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
        $("#add_owner_btn").text('Adding...');
        $.ajax({
            url: '{{ route('owners.store') }}',
            method: 'post',
            data: fd,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                if (response.status == 200) {
                    fetchAllOwners();
                    // Close the modal
                    $("#addOwnerModal").modal('hide');
                    Swal.fire(
                        "Successful",
                        "Owner Added Successfully",
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
                $("#add_owner_btn").text('Add Owner');
                $("#add_owner_form")[0].reset();
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
                $("#add_owner_btn").text('Add Owner');
            }
        });
    }
});


        // edit owner ajax request
        $(document).on('click', '.editIcon', function(e) {
            e.preventDefault();
            let id = $(this).attr('id');
            $.ajax({
                url: '{{ route('owners.edit') }}',
                method: 'get',
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
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
                    $("#approval").val(response.approval_status);
                    $("#reason").val(response.reason);
                    $("#serial_number").val(response.serial_number);
                    $("#id_number").val(response.id_number);
                    $("#scan_or_photo_of_id").html(
                        `<img src="storage/images/${response.scan_or_photo_of_id}" width="100" class="img-fluid img-thumbnail">`);
                    $("#owner_id").val(response.id);
                    $("#owner_photo").val(response.scan_or_photo_of_id);
                },
                error: function(xhr, status, error) {
                    // Show error message using SweetAlert if there's an error with the request
                    Swal.fire(
                        "Error",
                        "An error occurred while fetching owner data.",
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
                url: '{{ route('owners.update') }}',
                method: 'post',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 200) {
                        fetchAllOwners();
                        // Close the modal
                        $("#editOwnerModal").modal('hide');
                        Swal.fire(
                            "Updated",
                            "Owner Updated Successfully",
                            "success"
                        );
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
                    url: '{{ route('owners.delete') }}',
                    method: 'delete',
                    data: {
                        id: id,
                        _token: csrf
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire(
                                'Deleted!',
                                'Owner Deleted Successfully',
                                'success'
                            );
                            fetchAllOwners();
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
                            'Failed to delete owner: ' + error,
                            'error'
                        );
                    }
                });
            }
        });
    });


        // fetch all owner ajax request
        fetchAllOwners();

        function fetchAllOwners() {
            $.ajax({
                url: '{{ route('fetchAllOwner') }}',
                method: 'get',
                success: function(response) {
                    $("#show_all_owners").html(response);
                    $("table").DataTable({
                        order:[0, 'desc']
                    });
                }
            });
        }
    });
</script>
