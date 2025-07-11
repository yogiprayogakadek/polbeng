@forelse ($galleries as $index => $gallery)
    <div class="col-3">
        <div class="card card-modal h-100 shadow-lg rounded-3 overflow-hidden">
            <div class="card-body p-2 d-flex flex-column align-items-center">
                <h6 class="fw-semibold mb-2 text-truncate w-100 text-center">
                    <i class="ti ti-photo-plus me-1"></i> Image {{ $index + 1 }}
                </h6>
                <div class="mb-2 gallery-image-container"
                    style="width: 100%; height: 180px; overflow: hidden; display: flex; align-items: center; justify-content: center; background: #f8f9fa; border-radius: 8px;">
                    <a href="{{ asset('storage/' . $gallery->image_path) }}" class="glightbox"
                        data-gallery="projectGallery" data-title="Image {{ $index + 1 }}">
                        <img src="{{ asset('storage/' . $gallery->image_path) }}"
                            class="img-fluid rounded-3 hover-scale"
                            style="max-height: 100%; max-width: 100%; object-fit: cover;">
                    </a>
                </div>

                <div class="d-flex justify-content-between w-100">
                    <a href="{{ asset('storage/' . $gallery->image_path) }}" download
                        class="btn btn-sm btn-light rounded-pill shadow-sm" data-bs-toggle="tooltip" title="Download">
                        <i class="ti ti-download"></i>
                    </a>

                    <button type="button" class="btn btn-sm btn-danger rounded-pill shadow-sm delete-gallery-btn"
                        data-id="{{ $gallery->id }}" title="Delete">
                        <i class="ti ti-trash"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
@empty
    <div class="col-12 text-center">
        <h5 class="fw-bold text-muted">No galleries available for this project.</h5>
    </div>
@endforelse
