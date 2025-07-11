<form enctype="multipart/form-data" method="POST" id="form">
    <div class="row pt-3">
        <div class="col-md-12">
            <div class="mb-3">
                <label for="galleries" class="form-label">Galleries</label>
                <div class="dropzone" id="galleryDropzone"></div>
                <input type="file" name="galleries[]" id="realGalleriesInput" multiple hidden>
                {{-- <div id="galleriesInputs"></div> --}}
                @error('galleries')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    <div class="form-actions">
        <button type="button" class="btn btn-primary" id="submitGalleryBtn">
            Save
        </button>
        <button type="button" class="btn btn-danger ms-3 cancel-btn">
            Cancel
        </button>
    </div>
</form>

<script>
    projectDetailId = $('#projectGalleriesModal').data('project-detail-id');

    function loadGalleries(projectDetailId) {
        $.get(`/project/galleries/${projectDetailId}`, function(response) {
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

    Dropzone.autoDiscover = false;

    realInput = document.getElementById('realGalleriesInput');
    myDropzone = new Dropzone("#galleryDropzone", {
        url: "#", // Not used since we don't upload via Dropzone
        autoProcessQueue: false,
        addRemoveLinks: true,
        maxFiles: 10,
        acceptedFiles: 'image/*',
        init: function() {
            this.on("addedfile", function(file) {
                updateRealInput(this.files);
                toastr.success(`"${file.name}" file added successfully`, 'Upload Success', {
                    closeButton: true,
                    progressBar: true,
                    timeOut: 3000
                });
            });

            this.on("removedfile", function(file) {
                updateRealInput(this.files);

                toastr.success(`File "${file.name}" file deleted successfully`, 'Remove Success', {
                    closeButton: true,
                    progressBar: true,
                    timeOut: 3000
                });
            });
        }
    });

    function updateRealInput(files) {
        const dataTransfer = new DataTransfer();

        for (let i = 0; i < files.length; i++) {
            dataTransfer.items.add(files[i]);
        }

        realInput.files = dataTransfer.files;
    }

    $('#submitGalleryBtn').on('click', function(e) {
        e.preventDefault();

        let form = $('#form')[0];
        let formData = new FormData(form);
        let projectDetailId = $('#projectGalleriesModal').data('project-detail-id');
        formData.append('projectDetailID', projectDetailId);

        $.ajax({
            url: "{{ route('project.galleries.store') }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function() {
                $('#submitGalleryBtn').prop('disabled', true).text('Saving...');
            },
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Photos uploaded successfully!',
                    timer: 1500,
                    showConfirmButton: false
                });

                // Erase all data on Dropzone
                myDropzone.removeAllFiles();
                realInput.value = '';

                // call reload modal galleries function
                loadGalleries(projectDetailId)
                $('.add-photo-btn').show()

                $('#submitGalleryBtn').prop('disabled', false).text('Save');
            },
            error: function(xhr) {
                Swal.fire('Error', 'Failed to upload photos.', 'error');
                $('#submitGalleryBtn').prop('disabled', false).text('Save');
            }
        });
    });

    $('body').on('click', '.cancel-btn', function() {
        loadGalleries(projectDetailId);
        $('.add-photo-btn').show()
    })
</script>
