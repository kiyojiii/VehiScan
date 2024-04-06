<script type="text/javascript">
    //CREATE
    function add() {
        $('#add_rolestatus_form').trigger("reset");
        $('#RoleStatusModal').html("Add RoleStatus");
        $('#addRoleStatusModal').modal('show');
        $('#id').val('');
    }

    //EDIT
    function edit() {
        $('#edit_rolestatus_form').trigger("reset");
        $('#RoleStatusModal').html("Edit RoleStatus");
        $('#editRoleStatusModal').modal('show');
        $('#id').val('');
    }
</script>

<script>
$(function() {
    // fetch all time request
    fetchAllTimes();

    function fetchAllTimes() {
        $.ajax({
            url: '{{ route('fetchAllTime') }}',
            method: 'get',
            success: function(response) {
                $("#show_all_time").html(response);
                $("table").DataTable({
                    order:[0, 'desc']
                });
            }
        });
    }
});
</script>

