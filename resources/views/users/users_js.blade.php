<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF=TOKEN': $('meta[name="csrf-token"').attr('content')
        }
    });
</script>
<!-- Primary Function -->
<script>
$(document).ready(function() {
    // Function to handle filtering by date range and selected roles
    function filterData(start_date, end_date, selectedRoles) {
        $.ajax({
            url: "{{ route('filter.user') }}",
            method: "GET",
            data: {
                start_date: start_date,
                end_date: end_date,
                roles: selectedRoles
            },
            success: function(res) {
                $('.table-data').html(res);
            }
        });
    }

    // Function to handle AJAX request for pagination, search, and filtering
    function fetchData(page, search_string, start_date, end_date, selectedRoles, url) {
        $.ajax({
            url: url,
            method: "GET",
            data: {
                page: page,
                search_string: search_string,
                start_date: start_date,
                end_date: end_date,
                roles: selectedRoles
            },
            success: function(res) {
                $('.table-data').html(res);
                // Display "No User Found" message if no results found
                if ($(res).find('tbody tr').length === 0) {
                    $('.table-data').html('<span class="text-danger"><strong>No User Found!</strong></span>');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    }

    // Filter form submission event handler
    $('form').on('submit', function(e) {
        e.preventDefault();
        let start_date = $('#start_date').val();
        let end_date = $('#end_date').val();
        let selectedRoles = $('.role-checkbox:checked').map(function() {
            return this.value;
        }).get();
        filterData(start_date, end_date, selectedRoles);
    });

    // Pagination and search
    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        let page = $(this).attr('href').split('page=')[1];
        let search_string = $('#searchInput').val();
        let start_date = $('#start_date').val();
        let end_date = $('#end_date').val();
        let selectedRoles = $('.role-checkbox:checked').map(function() {
            return this.value;
        }).get();
        
        let url = "/pagination/paginate-data-user?page=" + page;
        url += '&search_string=' + search_string + '&start_date=' + start_date + '&end_date=' + end_date;
        url += '&roles=' + selectedRoles.join(',');
        
        fetchData(page, search_string, start_date, end_date, selectedRoles, url);
    });

    // Live Search
    $(document).on('keyup', '#searchInput', function(e) {
        e.preventDefault();
        let search_string = $(this).val();
        let start_date = $('#start_date').val();
        let end_date = $('#end_date').val();
        let selectedRoles = $('.role-checkbox:checked').map(function() {
            return this.value;
        }).get();
        
        let url = "{{ route('search.user') }}"; // Update the URL to the search route
        fetchData(1, search_string, start_date, end_date, selectedRoles, url);
    });

    // Show Checkboxes Role
    $('#showCheckboxesBtn').on('click', function() {
        var checkboxesSection = $('#checkboxesSection');
        var isVisible = checkboxesSection.is(':visible');

        if (isVisible) {
            checkboxesSection.hide(); // Hide checkboxes section
        } else {
            var roles = {!! json_encode($roles) !!};
            checkboxesSection.empty(); // Clear existing content

            // Wrap each set of 6 checkboxes within a row
            for (var i = 0; i < roles.length; i += 6) {
                var row = $('<div class="row g-3"></div>');

                for (var j = i; j < Math.min(i + 6, roles.length); j++) {
                    var role = roles[j];
                    var checkboxHtml = `
                        <div class="col">
                            <div class="form-check">
                                <input class="form-check-input role-checkbox" type="checkbox" value="${role.id}" id="checkbox${role.id}">
                                <label class="form-check-label" for="checkbox${role.id}">
                                    ${role.name}
                                </label>
                            </div>
                        </div>
                    `;
                    row.append(checkboxHtml);
                }

                checkboxesSection.append(row);
            }

            checkboxesSection.show(); // Show checkboxes section
        }
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
    // Function to clear the filter inputs, checkboxes, and refresh the table
    $('#clear_filter').on('click', function() {
        $('#searchInput').val('');
        $('#start_date').val('');
        $('#end_date').val('');
        $('.role-checkbox').prop('checked', false); // Uncheck all checkboxes
        refreshTable();
    });

    // Function to refresh the table content
    function refreshTable() {
        $.ajax({
            url: "{{ route('paginate.user') }}", // Replaced with the actual route for retrieving the table content
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
                url: "{{ route('paginate.user') }}", // Replaced with the actual route for retrieving the table content
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
        @if (session('user_created_success'))
            // Show SweetAlert success message for user creation
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('user_created_success') }}',
                showConfirmButton: false,
                timer: 3000 // Close the alert after 3 seconds
            });
        @endif

        // Check if the user update success message exists in session
        @if (session('user_updated_success'))
            // Show SweetAlert success message for user update
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('user_updated_success') }}',
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
            title: 'Delete User?',
            text: "This User Will Be Deleted, Are You Sure?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Delete the User'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/users/' + id,
                    method: 'DELETE', // Use DELETE method
                    data: {
                        _token: csrf
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire(
                                'Deleted!',
                                'User has been Deleted',
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
                                'User has been Deleted',
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
