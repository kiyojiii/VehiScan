<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Image Preview</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" class="img-fluid mx-auto d-block" alt="Image">
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.img-modal').click(function() {
            var imageUrl = $(this).attr('src');
            $('#modalImage').attr('src', imageUrl);
            $('#imageModal').modal('show');
        });
    });
</script>