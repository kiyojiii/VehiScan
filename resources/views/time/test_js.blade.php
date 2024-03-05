<script>
var typingTimer;
var doneTypingInterval = 250; // .2 second delay

$(document).ready(function() {
    $('#search').on('keyup', function() {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(function() {
            var query = $('#search').val();
            $.ajax({
                url: "search",
                type: "GET",
                data: {
                    'search': query
                },
                success: function(response) {
                    if (response.status === 'timed_in') {
                        fetchVehicleRecords();
                        toastr.options = {
                            "progressBar": true,
                            "closeButton": true,
                            "toastClass": "toastr-success" // Use custom class for success messages
                        };
                        toastr.success('Timed In Successfully!', { timeOut: 5000 });
                    } else if (response.status === 'timed_out') {
                        fetchVehicleRecords();
                        toastr.options = {
                            "progressBar": true,
                            "closeButton": true,
                            "toastClass": "toastr-success" // Use custom class for success messages
                        };
                        toastr.success('Timed Out Successfully!', { timeOut: 5000 });
                    }
                    // Clear the search bar
                    clearSearch();
                },
                error: function(xhr, status, error) {
                        toastr.options = {
                            "progressBar": true,
                            "closeButton": true,            
                        };
                        toastr.error('Vehicle Code Not Found', { timeOut: 5000 });
                    // Clear the search bar
                    clearSearch();
                }
            });
        }, doneTypingInterval);
    });

    // Fetch all records via AJAX and initialize DataTable
    fetchVehicleRecords();

    function fetchVehicleRecords() {
            $.ajax({
                url: '{{ route('fetchVehicleRecord') }}',
                method: 'get',
                success: function(response) {
                    $("#show_vehicle_record").html(response);
                    // Initialize DataTable after data is loaded into the table
                    $("table").DataTable({
                        order: [0, 'desc']
                    });
                },
                error: function(xhr, status, error) {
                    // Log the error to the console for debugging
                    console.error("Error fetching vehicles:", error);
                    // Display an error message to the user
                    $("#show_vehicle_record").html("<p>Error fetching data. Please try again later.</p>");
                }
            });
        }
        
});

function clearSearch() {
    $('#search').val('');
}
</script>
<script>

</script>