<script>
    // fetch all violation ajax request
    fetchApplicantAudits();

    function fetchApplicantAudits() {
        $.ajax({
            url: '{{ route('fetchApplicantAudit') }}',
            method: 'get',
            success: function(response) {
                $("#show_applicant_audit").html(response);
                initializeDataTable(); // Initialize DataTables after table is loaded
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                // Handle error here
            }
        });
    }

    // Function to initialize DataTable
    function initializeDataTable() {
        $("table").DataTable({
            order: [0, 'desc'],
            pageLength: 5, // Display only 5 rows per page
            lengthMenu: [5, 25, 50, -1], // Custom length menu options
        });
    }
</script>