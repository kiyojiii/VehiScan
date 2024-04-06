<script>
$(function() {
    // fetch all time request
    fetchActivityFeeds();

    function fetchActivityFeeds() {
        $.ajax({
            url: '{{ route('fetchActivityFeed') }}',
            method: 'get',
            success: function(response) {
                $("#show_activity_feed").html(response);
                $("table").DataTable({
                    order:[0, 'desc']
                });
            }
        });
    }
});
</script>