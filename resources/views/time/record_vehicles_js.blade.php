<script>
    $(document).ready(function() {
        // Focus on the input box when the page loads
        $('#record').focus();

        // Prevent cursor from leaving the input box
        $('#record').on('keydown', function(e) {
            if (e.keyCode === 9) { // Tab key
                e.preventDefault();
            }
        });

        // Allow cursor to leave the input box when the Escape key is pressed
        $(document).on('keydown', function(e) {
            if (e.keyCode === 27) { // Escape key
                $('#record').blur();
            }
        });
    });
</script>

<script>
    var typingTimer;
    var doneTypingInterval = 250; // .2 second delay

    $(document).ready(function() {
        $('#record').on('keyup', function() {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(function() {
            // Get the input value
            var query = $('#record').val();
            // Remove any non-numeric characters from the input
            query = query.replace(/\D/g, ''); // Replace non-digits with an empty string
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
                            toastr.success('Timed In Successfully!', {
                                timeOut: 5000
                            });
                        } else if (response.status === 'timed_out') {
                            fetchVehicleRecords();
                            toastr.options = {
                                "progressBar": true,
                                "closeButton": true,
                            };
                            toastr.success('Timed Out Successfully!', {
                                timeOut: 5000
                            });
                        }
                        // Clear the record bar
                        clearRecord();
                    },
                    error: function(xhr, status, error) {
                        if (xhr.responseJSON && xhr.responseJSON.error) {
                            toastr.options = {
                                "progressBar": true,
                                "closeButton": true,
                            };
                            toastr.warning(xhr.responseJSON.error, {
                                timeOut: 5000
                            });
                        } else {
                            toastr.options = {
                                "progressBar": true,
                                "closeButton": true,
                            };
                            toastr.error('Vehicle Code Not Found', {
                                timeOut: 5000
                            });
                        }
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
                        var formattedDate = new Date(record.created_at).toLocaleDateString('en-US', {
                            month: 'short',
                            day: 'numeric'
                        });
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
                                    // Wrap the word with the anchor tag
                                    // Modify the PHP code to encode the vehicle ID in a data attribute
                                    formattedRemarks += '<span class="badge ' + badgeColor + ' font-size-12 vehicle-link" data-vehicle-id="' + record.vehicle_id + '">' + words[i] + ' ' + words[i + 1] + '</span>';
                                    // Add a space after "Time In" or "Time Out"
                                    formattedRemarks += ' ';
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
                            '<h5 class="font-size-14">' +  formattedDate  + '<i class="bx bx-right-arrow-alt font-size-16 text-primary align-middle ms-2"></i></h5>' +
                            '</div>' +
                            '<div class="flex-grow-1">' +
                            '<div>' +  formattedRemarks  + '</div>' +
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
<script>
    // Event listener for clicking on vehicle links
$(document).on('click', '.vehicle-link', function() {
    // Get the vehicle ID from the data attribute
    var vehicleId = $(this).data('vehicle-id');
    // Construct the URL using the vehicle ID
    var url = '{{ route('vehicles.show', ':vehicleId') }}';
    url = url.replace(':vehicleId', vehicleId);
    // Navigate to the constructed URL
    window.location.href = url;
});
</script>
<script>
    $(document).ready(function() {
    $('#record').on('input', function() {
        // Remove any characters except numbers from the input value
        this.value = this.value.replace(/[^\d]/g, '');
        // Trim leading and trailing whitespace
        this.value = this.value.trim();
        // Get the index of the first space character
        var spaceIndex = this.value.indexOf(' ');
        // If a space exists, extract the substring before it
        if (spaceIndex !== -1) {
            this.value = this.value.substring(0, spaceIndex);
        }
    });
});
</script>
<style>
    .badge.vehicle-link {
    cursor: pointer;
}
</style>