<script>
    $(document).ready(function() {

  // Get the current date
  var currentDate = new Date();

// Get the day, month, and year
var day = ('0' + currentDate.getDate()).slice(-2);
var month = ('0' + (currentDate.getMonth() + 1)).slice(-2);
var year = currentDate.getFullYear();

// Format the current date as 'dd/mm/yyyy'
var formattedDate = day + '/' + month + '/' + year;

// Set the value of the input field to the current date
$('#day_date').val(formattedDate);

// Initialize date picker for the day input field
$('#day_date').datepicker({
    format: 'dd/mm/yyyy', // Show day, month, and year
    autoclose: true,
    orientation: 'bottom',
    todayHighlight: true // Highlight today's date
});

// Apply filter when 'Filter' button is clicked
$('#day_filter').click(function() {
    var selectedDate = $('#day_date').val();

    // Fetch vehicles with selected date
    fetchVehiclesByDay(selectedDate);
});

// Fetch vehicles for the current day on page load
fetchVehiclesByDay(formattedDate);

function fetchVehiclesByDay(selectedDate = '') {
    $.ajax({
        url: '{{ route('fetchTodayVehicle') }}',
        method: 'get',
        data: {
            day_date: selectedDate,
        },
        success: function(response) {
            $("#today_vehicles").html(response);
            // Initialize DataTable after data is loaded into the table
            $("#today_table").DataTable({
                order: [0, 'desc'],
                dom: '<"top"Bflr>t<"bottom"ip>', // Define the layout of DataTable elements
                buttons: ['excel', 'pdf'],
                pageLength: 5, // Set the default page length
                lengthMenu: [
                    [5, 10, 20, -1],
                    [5, 10, 20, 'ALL']
                ]
            });
        },
        error: function(xhr, status, error) {
            // Log the error to the console for debugging
            console.error("Error fetching vehicles:", error);
            // Display an error message to the user
            $("#today_vehicles").html("<p>Error fetching data. Please try again later.</p>");
        }
    });
}


        // Get the current date
        var currentDate = new Date();

        // Get the current month and year
        var currentMonth = currentDate.getMonth() + 1; // Note: JavaScript months are 0-indexed
        var currentYear = currentDate.getFullYear();

        // Format the current month and year
        var formattedCurrentDate = ('0' + currentMonth).slice(-2) + '/' + currentYear;

        // Set the value of the datepicker to the current month and year
        $('#monthly_date').val(formattedCurrentDate);

        // Initialize date picker for the month input field
        $('#monthly_date').datepicker({
            format: 'mm/yyyy', // Show only month and year
            startView: 'months', // Start view at months
            minViewMode: 'months', // Set minimum view mode to months
            autoclose: true,
            orientation: 'bottom',
            todayHighlight: true // Highlight today's date
        });

        // Apply filter when 'Filter' button is clicked
        $('#monthly_filter').click(function() {
            var selectedMonthYear = $('#monthly_date').val();

            // Fetch monthly vehicles with selected month
            fetchMonthlyVehicles(selectedMonthYear);
        });

        // Fetch vehicles for the current month on page load
        fetchMonthlyVehicles(formattedCurrentDate);

        function fetchMonthlyVehicles(selectedMonth) {
            $.ajax({
                url: '{{ route('fetchMonthlyVehicle') }}',
                method: 'get',
                data: {
                    monthly_date: selectedMonth,
                },
                success: function(response) {
                    $("#monthly_vehicles").html(response);
                    // Initialize DataTable after data is loaded into the table
                    $("#monthly_table").DataTable({
                        order: [0, 'desc'],
                        dom: '<"top"Bflr>t<"bottom"ip>', // Define the layout of DataTable elements
                        buttons: ['excel', 'pdf'],
                        pageLength: 5, // Set the default page length
                        lengthMenu: [
                            [5, 10, 20, -1],
                            [5, 10, 20, 'ALL']
                        ]
                    });
                },
                error: function(xhr, status, error) {
                    // Log the error to the console for debugging
                    console.error("Error fetching vehicles:", error);
                    // Display an error message to the user
                    $("#monthly_vehicles").html("<p>Error fetching data. Please try again later.</p>");
                }
            });
        }

    });
</script>

