<script>
    // fetch all violation ajax request
    fetchAllApplicantTimes();

    function fetchAllApplicantTimes() {
        $.ajax({
            url: '{{ route('fetchAllApplicantTime') }}',
            method: 'get',
            success: function(response) {
                $("#show_all_applicant_time").html(response);
                $("table").DataTable({
                    order: [0, 'desc']
                });
            }
        });
    }
</script>