<script>
    $(document).ready(function() {
        // Fetch all violation ajax request
        fetchAllViolations();

        function fetchAllViolations() {
            $.ajax({
                url: '{{ route('fetchAllApplicantViolation') }}',
                method: 'get',
                success: function(response) {
                    $("#show_all_applicant_violations").html(response);
                    $("table").DataTable({
                        order: [0, 'desc']
                    });
                }
            });
        }
    });
</script>
