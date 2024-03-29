<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF=TOKEN': $('meta[name="csrf-token"').attr('content')
        }
    });s
</script>
<!-- Primary Function -->
<script>
    $(document).ready(function() {
        // Function to handle filtering by date range
        function filterByDateRange(start_date, end_date) {
            // Validate start date and end date
            if (!start_date || !end_date) {
                alert("Please enter both start date and end date");
                return;
            }
            if (start_date > end_date) {
                alert("Start date cannot be later than end date");
                return;
            }

            $.ajax({
                url: "{{ route('filter.permission') }}",
                method: "GET",
                data: {
                    start_date: start_date,
                    end_date: end_date
                },
                success: function(res) {
                    $('.table-data').html(res);
                }
            });
        }

        // Function to handle AJAX request for pagination, search, and filtering
        function permission(page, search_string, start_date, end_date) {
            $.ajax({
                url: "/pagination/paginate-data-permission?page=" + page,
                data: {
                    search_string: search_string,
                    start_date: start_date,
                    end_date: end_date
                },
                success: function(res) {
                    $('.table-data').html(res);
                }
            });
        }

        // Filter form submission event handler
        $('form').on('submit', function(e) {
            e.preventDefault(); // Prevent the default form submission behavior
            let start_date = $('#start_date').val();
            let end_date = $('#end_date').val();
            filterByDateRange(start_date, end_date);
        });

        // Pagination and search
        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            let page = $(this).attr('href').split('page=')[1];
            let search_string = $('#searchInput').val();
            let start_date = $('#start_date').val();
            let end_date = $('#end_date').val();
            // Modify the pagination link to include filter parameters
            let url = $(this).attr('href') + '&start_date=' + start_date + '&end_date=' + end_date;
            permission(page, search_string, start_date, end_date);
        });

        $(document).on('keyup', '#searchInput', function(e) {
            e.preventDefault();
            let search_string = $(this).val();
            let start_date = $('#start_date').val();
            let end_date = $('#end_date').val();
            permission(1, search_string, start_date, end_date);
        });
    });
</script>
<!-- Today Button -->
<script>
    $(document).ready(function() {
        // Function to set today's date in the start date input field
        $('#set_today_start').on('click', function() {
            let today = new Date().toISOString().split('T')[0];
            $('#start_date').val(today);
        });

        // Function to set today's date in the end date input field
        $('#set_today_end').on('click', function() {
            let today = new Date().toISOString().split('T')[0];
            $('#end_date').val(today);
        });
    });
</script>
<!-- Clear Filter -->
<script>
    $(document).ready(function() {
    // Function to clear the filter inputs and refresh the table
    $('#clear_filter').on('click', function() {
        $('#searchInput').val('');
        $('#start_date').val('');
        $('#end_date').val('');
        refreshTable();
    });

    // Function to refresh the table content
    function refreshTable() {
        $.ajax({
            url: "{{ route('paginate.permission') }}", // Replaced with the actual route for retrieving the table content
            method: "GET",
            success: function(res) {
                $('.table-data').html(res);
            }
        });
    }
});
</script>
<!-- Refresh Button -->
<script>
    $(document).ready(function() {
    // Function to refresh the table
    $('#refresh_table').on('click', function() {
        refreshTable();
    });

    // Function to refresh the table content
    function refreshTable() {
        $.ajax({
            url: "{{ route('paginate.permission') }}", // Replaced with the actual route for retrieving the table content
            method: "GET",
            success: function(res) {
                $('.table-data').html(res);
            }
        });
    }
});
</script>

<script>
    // This code will execute when the page is loaded
    document.addEventListener('DOMContentLoaded', function() {
        // Check if the user creation success message exists in session
        @if (session('permission_created_success'))
            // Show SweetAlert success message for user creation
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('permission_created_success') }}',
                showConfirmButton: false,
                timer: 3000 // Close the alert after 3 seconds
            });
        @endif

        // Check if the user update success message exists in session
        @if (session('permission_created_success'))
            // Show SweetAlert success message for user update
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('permission_created_success') }}',
                showConfirmButton: false,
                timer: 3000 // Close the alert after 3 seconds
            });
        @endif
    });
</script>

<script>
    // delete user ajax request
    $(document).on('click', '.delete-btn', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        let csrf = '{{ csrf_token() }}';
        Swal.fire({
            title: 'Delete Permission?',
            text: "This Permission Will Be Deleted, Are You Sure?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Delete this Permission'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/permissions/' + id,
                    method: 'DELETE', // Use DELETE method
                    data: {
                        _token: csrf
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire(
                                'Deleted!',
                                'Permission has been Deleted',
                                'success'
                            ).then(() => {
                                location.reload(); // Reload page after successful deletion
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
                                'Deleted!',
                                'Permission has been Deleted',
                                'success'
                            ).then(() => {
                                location.reload(); // Reload page after successful deletion
                            });
                    }
                });
            }
        });
    });
</script>
