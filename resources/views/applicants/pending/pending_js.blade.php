<script>

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
                            PendingApplicants();
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

    
    // fetch all pending ajax request
    PendingApplicants();

    function PendingApplicants() {
        $.ajax({
            url: '{{ route('PendingApplicant') }}',
            method: 'get',
            success: function(response) {
                $("#pending_applicants").html(response);
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