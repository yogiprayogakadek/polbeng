@extends('template.master')

@section('page-title', 'Project')

@push('css')
    <link rel="stylesheet"
        href="https://bootstrapdemos.adminmart.com/matdash/dist/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">
    <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap5.min.css">
@endpush

@section('content')
    {{-- modal render --}}
    <div class="modal-render"></div>

    {{-- Success Alert --}}
    @if (session('success'))
        <div class="alert customize-alert alert-dismissible text-success alert-light-success bg-success-subtle fade show remove-close-icon"
            role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <div class="d-flex align-items-center  me-3 me-md-0">
                <i class="ti ti-info-circle fs-5 me-2 text-success"></i>
                {{ session('success') }}
            </div>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Project List</h5>
            <table id="table" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th data-priority="1">Thumbnail</th>
                        <th data-priority="1">Project Title</th>
                        <th>Category</th>
                        <th data-priority="2">School Year</th>
                        <th>Semester</th>
                        <th>Detail</th>
                        <th>Galleries</th>
                        <th>Dosen</th>
                        <th>Kaprodi</th>
                        <th data-priority="3">Status</th>
                        <th data-priority="1">Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>

        </div>
    </div>
@endsection

@push('script')
    <script src="https://bootstrapdemos.adminmart.com/matdash/dist/assets/libs/datatables.net/js/jquery.dataTables.min.js">
    </script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap5.min.js"></script>
    <script>
        var table = $('#table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('project.data') }}",
            columns: [{
                    data: 'thumbnail',
                    name: 'thumbnail',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'project_title',
                    name: 'project_title'
                },
                {
                    data: 'category_name',
                    name: 'category_name',
                    orderable: false
                },
                {
                    data: 'school_year',
                    name: 'school_year'
                },
                {
                    data: 'semester',
                    name: 'semester'
                },
                {
                    data: 'project_detail',
                    name: 'project_detail',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'galleries',
                    name: 'galleries',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'dosen_status',
                    name: 'dosen_status',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'kaprodi_status',
                    name: 'kaprodi_status',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'status',
                    name: 'is_active'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            drawCallback: function() {
                // Re-initialize tooltips on every draw (pagination, search, etc.)
                var tooltipTriggerList = [].slice.call(document.querySelectorAll(
                    '[data-bs-toggle="tooltip"]'))
                var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                    return bootstrap.Tooltip.getOrCreateInstance(tooltipTriggerEl)
                })
            }
        });

        $(document).on('click', '.btn-toggle-status', function(e) {
            e.preventDefault();

            const url = $(this).data('url');
            const name = $(this).data('name');
            const status = $(this).data('status'); // 'disable' atau 'activate'
            const text = status === 'disable' ? 'disable' : 'activate';
            const icon = status === 'disable' ? 'warning' : 'question';

            Swal.fire({
                title: 'Are you sure?',
                html: `Want to <strong>${text} <i>"${name}" </i></strong>Project?`,
                icon: icon,
                showCancelButton: true,
                confirmButtonColor: status === 'disable' ? '#d33' : '#3085d6',
                cancelButtonColor: '#aaa',
                confirmButtonText: 'Yes',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'PUT',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire(
                                'Success!',
                                response.message,
                                'success'
                            ).then(() => {
                                table.ajax.reload(null, false);
                            });
                        },
                        error: function() {
                            Swal.fire(
                                'Failed!',
                                'Something went wrong.',
                                'error'
                            );
                        }
                    });
                }
            });
        });

        $(document).on('click', '.btn-delete', function() {
            const name = $(this).data('name');
            const url = $(this).data('url');

            Swal.fire({
                title: 'Are you sure?',
                html: `The <strong><i>"${name}" </i></strong> Project will deleted.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Delete It!',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            _method: 'DELETE'
                        },
                        success: function(response) {
                            Swal.fire('Success!', response.message, 'success').then(() => {
                                table.ajax.reload(null, false);
                            });
                        },
                        error: function(err) {
                            Swal.fire('Failed!', 'Something when wrong.',
                                'error');
                        }
                    });
                }
            });
        });

        // Robust cleanup for any hidden modal
        $(document).on('hidden.bs.modal', '.modal', function() {
            const $this = $(this);
            $this.remove();

            // Force removal of remaining backdrops and style cleanups
            if ($('.modal.show').length === 0) {
                $('.modal-backdrop').remove();
                $('body').removeClass('modal-open').css({
                    'overflow': '',
                    'padding-right': ''
                });
            }
        });

        $('body').on('click', '.modal-btn', function() {
            const $btn = $(this);
            const url = $btn.data('url');
            const modalID = $btn.data('modal-id');

            const startLoading = function() {
                $.get(url, function(response) {
                    let htmlContent = '';
                    if (typeof response === 'object') {
                        htmlContent = response.html || (response.status !== undefined ? response.html :
                            response);
                        if (typeof response === 'object' && !response.html && !response.status) {
                            htmlContent = Object.values(response)[0];
                        }
                    } else {
                        htmlContent = response;
                    }

                    // Pre-cleanup before appending new modal
                    $('.modal-render').empty();
                    $('.modal-render').append(htmlContent);

                    const modalEl = document.getElementById(modalID);
                    if (modalEl) {
                        const modalInstance = bootstrap.Modal.getOrCreateInstance(modalEl);
                        modalInstance.show();
                    }

                    // Re-init plugins
                    if (typeof GLightbox === 'function') {
                        GLightbox({
                            selector: '.glightbox',
                            touchNavigation: true,
                            loop: true,
                            zoomable: true
                        });
                    }
                    if (typeof bindDeleteButtons === 'function') bindDeleteButtons();
                });
            };

            const openModal = $('.modal.show');
            if (openModal.length > 0) {
                const modalInstance = bootstrap.Modal.getInstance(openModal[0]);
                if (modalInstance) {
                    openModal.one('hidden.bs.modal', function() {
                        startLoading();
                    });
                    modalInstance.hide();
                } else {
                    // Fallback cleanup
                    openModal.remove();
                    $('.modal-backdrop').remove();
                    $('body').removeClass('modal-open');
                    startLoading();
                }
            } else {
                startLoading();
            }
        });
    </script>
@endpush
