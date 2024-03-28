<!-- Modal -->
<div class="modal fade" id="recordModal" tabindex="-1" aria-labelledby="recordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="recordModalLabel">Record Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modalBody">
                <!-- Data will be loaded here -->
            </div>
        </div>
    </div>
</div>

<script>
    // Event listener for view button click
    $(document).on('click', '.view-button', function() {
        var recordId = $(this).data('pk'); // Get the record id
        var table = $(this).data('table'); // Get the table name

        // AJAX request to fetch data
        $.ajax({
            url: '{{ route('fetchRecordDetails') }}',
            method: 'get',
            data: {
                id: recordId,
                table: table
            },
            success: function(response) {
                // Populate modal with fetched data
                $('#modalBody').html(response);
                // Show modal
                $('#recordModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                // Handle error here
            }
        });
    });
</script>
