<style>
    .hover-scale {
        transition: transform 0.3s ease;
        cursor: zoom-in;
    }

    .hover-scale:hover {
        transform: scale(1.05);
    }

    .card-modal:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
    }
</style>

<div class="modal fade" id="projectGalleriesModal" tabindex="-1" data-bs-backdrop="static" role="dialog"
    data-project-detail-id="{{ $projectDetailID }}">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content rounded-4 shadow">
            <div class="modal-header">
                <h4 class="modal-title fw-bold">Project Galleries</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div id="projectGalleriesContent" class="row g-4">
                    {{-- Partial view galleries akan dimuat di sini --}}
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary rounded-pill add-photo-btn"
                    data-url="{{ route('project.galleries.add.photo') }}">
                    Add Photo's
                </button>
                <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        $('[data-bs-toggle="tooltip"]').tooltip();
        const lightbox = GLightbox({
            selector: '.glightbox',
            touchNavigation: true,
            loop: true,
            zoomable: true,
        });

        const projectDetailId = $('#projectGalleriesModal').data('project-detail-id');

        function loadGalleries(projectDetailId) {
            $.get(`/admin/project/galleries/${projectDetailId}`, function(response) {
                $('#projectGalleriesContent').html(response.html);
                // Re-init GLightbox
                GLightbox({
                    selector: '.glightbox',
                    touchNavigation: true,
                    loop: true,
                    zoomable: true
                });

                // Re-bind Delete Buttons
                bindDeleteButtons();
            });
        }

        $('#projectGalleriesModal').on('shown.bs.modal', function() {
            loadGalleries(projectDetailId);
        });

        function bindDeleteButtons() {
            $('.delete-gallery-btn').off('click').on('click', function(e) {
                e.preventDefault();
                const id = $(this).data('id');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "This image will be permanently deleted!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, delete it!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/project/galleries/delete/${id}`,
                            type: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                    'content')
                            },
                            success: function(response) {
                                if (response.status === 200) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: response.title,
                                        text: response.message,
                                        timer: 1500,
                                        showConfirmButton: false
                                    });

                                    const projectDetailId = $(
                                        '#projectGalleriesModal').data(
                                        'project-detail-id');
                                    loadGalleries(projectDetailId);
                                } else {
                                    Swal.fire('Error', response.message, 'error');
                                }
                            },
                            error: function() {
                                Swal.fire('Error', 'Failed to delete the image.',
                                    'error');
                            }
                        });
                    }
                });
            });
        }

        // run this event if button add photo clicked
        $('body').on('click', '.add-photo-btn', function() {
            let url = $(this).data('url');
            let button = $(this);
            $.get(url, function(response) {
                $('#projectGalleriesContent').html(response.html);
                button.hide()
            });
        });
    });
</script>
