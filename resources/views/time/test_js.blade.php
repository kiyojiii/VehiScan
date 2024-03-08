<script>
var typingTimer;
var doneTypingInterval = 250; // .2 second delay

$(document).ready(function() {
    $('#record').on('keyup', function() {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(function() {
            var query = $('#record').val();
            $.ajax({
                url: "record",
                type: "GET",
                data: {
                    'record': query
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
                        };
                        toastr.error('Timed Out Successfully!', { timeOut: 5000 });
                    }
                    // Clear the record bar
                    clearRecord();
                },
                error: function(xhr, status, error) {
                        toastr.options = {
                            "progressBar": true,
                            "closeButton": true,            
                        };
                        toastr.warning('Vehicle Code Not Found', { timeOut: 5000 });
                    // Clear the record bar
                    clearRecord();
                }
            });
        }, doneTypingInterval);
    });

// Function to fetch vehicle records via AJAX
function fetchVehicleRecords() {
    $.ajax({
        url: '{{ route('fetchVehicleRecord') }}',
        method: 'get',
        success: function(response) {
            // Clear existing records
            $('#vehicle-record-list').empty();
            
            // Append new records to the timeline
            response.forEach(function(record) {
                // Format the created_at date
                var formattedDate = new Date(record.created_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
                // Split the remarks string into words
                var words = record.remarks.split(' ');
                // Initialize an empty string to store the formatted remarks
                var formattedRemarks = '';
                // Iterate through the words
                for (var i = 0; i < words.length; i++) {
                    // Determine badge color based on word
                    var badgeColor = '';
                    // Check if the word is 'Timed'
                    if (words[i] === 'Timed') {
                        // Check if the next word is 'In' or 'Out'
                        if (i < words.length - 1 && (words[i + 1] === 'In' || words[i + 1] === 'Out')) {
                            badgeColor = words[i + 1] === 'In' ? 'bg-success' : 'bg-danger';
                            // Wrap the word with the badge
                            formattedRemarks += '<span class="badge ' + badgeColor + ' font-size-12">' + words[i] + ' ' + words[i + 1] + '</span> ';
                            // Skip the next word since it's already included in the badge
                            i++;
                        } else {
                            // If the next word is not 'In' or 'Out', add 'Timed' without badge
                            formattedRemarks += words[i] + ' ';
                        }
                    } else {
                        // Add other words without badge
                        formattedRemarks += words[i] + ' ';
                    }
                }

                $('#vehicle-record-list').append(
                    '<li class="event-list">' +
                        '<div class="event-timeline-dot">' +
                            '<i class="bx bx-right-arrow-circle font-size-18"></i>' +
                        '</div>' +
                        '<div class="d-flex">' +
                            '<div class="flex-shrink-0 me-3">' +
                                '<h5 class="font-size-14">' + formattedDate + '<i class="bx bx-right-arrow-alt font-size-16 text-primary align-middle ms-2"></i></h5>' +
                            '</div>' +
                            '<div class="flex-grow-1">' +
                                '<div>' + formattedRemarks + '</div>' +
                            '</div>' +
                        '</div>' +
                    '</li>'
                );
            });
        },
        error: function(xhr, status, error) {
            console.error("Error fetching vehicle records:", error);
            $('#vehicle-record-list').html("<p>Error fetching data. Please try again later.</p>");
        }
    });
}

// Call the fetchVehicleRecords function when the page loads
$(document).ready(function() {
    fetchVehicleRecords();
});

// Function to call fetchVehicleRecords when a new record is added
function addNewRecord() {
    fetchVehicleRecords();
}

        
});

function clearRecord() {
    $('#record').val('');
}
</script>
